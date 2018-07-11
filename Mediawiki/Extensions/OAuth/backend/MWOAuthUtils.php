<?php

namespace MediaWiki\Extensions\OAuth;

use EchoEvent;
use Hooks;
use User;
use Wikimedia\Rdbms\DBConnRef;
use Wikimedia\Rdbms\IDatabase;

/**
 * Static utility functions for OAuth
 *
 * @file
 * @ingroup OAuth
 */
class MWOAuthUtils {
	/**
	 * @return bool
	 */
	public static function isCentralWiki() {
		global $wgMWOAuthCentralWiki;

		return ( wfWikiId() === $wgMWOAuthCentralWiki );
	}

	/**
	 * @param int $index DB_MASTER/DB_REPLICA
	 * @return DBConnRef
	 */
	public static function getCentralDB( $index ) {
		global $wgMWOAuthCentralWiki, $wgMWOAuthReadOnly;

		$db = wfGetLB( $wgMWOAuthCentralWiki )->getLazyConnectionRef(
			$index, [], $wgMWOAuthCentralWiki );
		$db->daoReadOnly = $wgMWOAuthReadOnly;
		return $db;
	}
	/**
	 * @return \BagOStuff
	 */
	public static function getSessionCache() {
		global $wgSessionCacheType;

		return \ObjectCache::getInstance( $wgSessionCacheType );
	}

	/**
	 * @param DBConnRef $db
	 * @return array
	 */
	public static function getConsumerStateCounts( DBConnRef $db ) {
		$res = $db->select( 'oauth_registered_consumer',
			[ 'oarc_stage', 'count' => 'COUNT(*)' ],
			[],
			__METHOD__,
			[ 'GROUP BY' => 'oarc_stage' ]
		);
		$table = [
			MWOAuthConsumer::STAGE_APPROVED => 0,
			MWOAuthConsumer::STAGE_DISABLED => 0,
			MWOAuthConsumer::STAGE_EXPIRED  => 0,
			MWOAuthConsumer::STAGE_PROPOSED => 0,
			MWOAuthConsumer::STAGE_REJECTED => 0,
		];
		foreach ( $res as $row ) {
			$table[(int)$row->oarc_stage] = (int)$row->count;
		}
		return $table;
	}

	/**
	 * Sanitize the output of apache_request_headers because
	 * we always want the keys to be Cased-Like-This and arh()
	 * returns the headers in the same case as they are in the
	 * request
	 * @return Array of apache headers and their values
	 */
	public static function getHeaders() {
		$request = \RequestContext::getMain()->getRequest();
		$headers = $request->getAllHeaders();

		$out = [];
		foreach ( $headers as $key => $value ) {
			$key = str_replace(
				" ",
				"-",
				ucwords( strtolower( str_replace( "-", " ", $key ) ) )
			);
			$out[$key] = $value;
		}
		return $out;
	}

	/**
	 * Test this request for an OAuth Authorization header
	 * @param \WebRequest $request the MediaWiki request
	 * @return bool true if a header was found
	 */
	public static function hasOAuthHeaders( \WebRequest $request ) {
		$header = $request->getHeader( 'Authorization' );
		if ( $header !== false && substr( $header, 0, 6 ) == 'OAuth ' ) {
			return true;
		}
		return false;
	}

	/**
	 * Make a cache key for the given arguments, that (hopefully) won't clash with
	 * anything else in your cache
	 * @return string
	 */
	public static function getCacheKey( /* varags */ ) {
		global $wgMWOAuthCentralWiki;

		$args = func_get_args();
		return "OAUTH:$wgMWOAuthCentralWiki:" . implode( ':', $args );
	}

	/**
	 * @param DBConnRef $dbw
	 * @return void
	 */
	public static function runAutoMaintenance( DBConnRef $dbw ) {
		global $wgMWOAuthRequestExpirationAge;

		if ( $wgMWOAuthRequestExpirationAge <= 0 ) {
			return;
		}

		$cutoff = time() - $wgMWOAuthRequestExpirationAge;
		\DeferredUpdates::addUpdate(
			new \AutoCommitUpdate(
				$dbw,
				__METHOD__,
				function ( IDatabase $dbw ) use ( $cutoff ) {
					$dbw->update(
						'oauth_registered_consumer',
						[
							'oarc_stage' => MWOAuthConsumer::STAGE_EXPIRED,
							'oarc_stage_timestamp' => $dbw->timestamp()
						],
						[
							'oarc_stage' => MWOAuthConsumer::STAGE_PROPOSED,
							'oarc_stage_timestamp < ' .
								$dbw->addQuotes( $dbw->timestamp( $cutoff ) )
						],
						__METHOD__
					);
				}
			)
		);
	}

	/**
	 * Get the pretty name of an OAuth wiki ID restriction value
	 *
	 * @param string $wikiId A wiki ID or '*'
	 * @return string
	 */
	public static function getWikiIdName( $wikiId ) {
		if ( $wikiId === '*' ) {
			return wfMessage( 'mwoauth-consumer-allwikis' )->text();
		} else {
			$host = \WikiMap::getWikiName( $wikiId );
			if ( strpos( $host, '.' ) ) {
				return $host; // e.g. "en.wikipedia.org"
			} else {
				return $wikiId;
			}
		}
	}

	/**
	 * Get the pretty names of all local wikis
	 *
	 * @return array associative array of local wiki names indexed by wiki ID
	 */
	public static function getAllWikiNames() {
		global $wgConf;
		$wikiNames = [];
		foreach ( $wgConf->getLocalDatabases() as $dbname ) {
			$name = self::getWikiIdName( $dbname );
			if ( $name != $dbname ) {
				$wikiNames[$dbname] = $name;
			}
		}
		return $wikiNames;
	}

	/**
	 * Quickly get a new server with all the default configurations
	 *
	 * @return MWOAuthServer with default configurations
	 */
	public static function newMWOAuthServer() {
		$dbr = self::getCentralDB( DB_REPLICA );
		$dbw = wfGetLB()->getServerCount() > 1 ? self::getCentralDB( DB_MASTER ) : null;
		$store = new MWOAuthDataStore( $dbr, $dbw, self::getSessionCache() );
		$server = new MWOAuthServer( $store );
		$server->add_signature_method( new OAuthSignatureMethod_HMAC_SHA1() );
		$server->add_signature_method( new MWOAuthSignatureMethod_RSA_SHA1( $store ) );

		return $server;
	}

	/**
	 * Given a central wiki user ID, get a central user name
	 *
	 * @param int $userId
	 * @param bool|\User $audience show hidden names based on this user, or false for public
	 * @throws \MWException
	 * @return string|bool User name, false if not found, empty string if name is hidden
	 */
	public static function getCentralUserNameFromId( $userId, $audience = false ) {
		global $wgMWOAuthSharedUserIDs, $wgMWOAuthSharedUserSource;

		if ( $wgMWOAuthSharedUserIDs ) { // global ID required via hook
			$lookup = \CentralIdLookup::factory( $wgMWOAuthSharedUserSource );
			$name = $lookup->nameFromCentralId( $userId, $audience ?: \CentralIdLookup::AUDIENCE_PUBLIC );
			if ( $name === null ) {
				$name = false;
			}
		} else {
			$name = '';
			$user = \User::newFromId( $userId );
			if ( !$user->isHidden()
				|| ( $audience instanceof \User && $audience->isAllowed( 'hideuser' ) )
			) {
				$name = $user->getName();
			}
		}

		return $name;
	}

	/**
	 * Given a central wiki user ID, get a local User object
	 *
	 * @param int $userId
	 * @throws \MWException
	 * @return \User|bool User or false if not found
	 */
	public static function getLocalUserFromCentralId( $userId ) {
		global $wgMWOAuthSharedUserIDs, $wgMWOAuthSharedUserSource;

		if ( $wgMWOAuthSharedUserIDs ) { // global ID required via hook
			$lookup = \CentralIdLookup::factory( $wgMWOAuthSharedUserSource );
			$user = $lookup->localUserFromCentralId( $userId );
			if ( $user === null || !$lookup->isAttached( $user ) ) {
				$user = false;
			}
		} else {
			$user = \User::newFromId( $userId );
		}

		return $user;
	}

	/**
	 * Given a local User object, get the user ID for that user on the central wiki
	 *
	 * @param \User $user
	 * @throws \MWException
	 * @return int|bool ID or false if not found
	 */
	public static function getCentralIdFromLocalUser( \User $user ) {
		global $wgMWOAuthSharedUserIDs, $wgMWOAuthSharedUserSource;

		if ( $wgMWOAuthSharedUserIDs ) { // global ID required via hook
			if ( isset( $user->oAuthUserData['centralId'] ) ) {
				$id = $user->oAuthUserData['centralId'];
			} else {
				$lookup = \CentralIdLookup::factory( $wgMWOAuthSharedUserSource );
				if ( !$lookup->isAttached( $user ) ) {
					$id = false;
				} else {
					$id = $lookup->centralIdFromLocalUser( $user );
					if ( $id === 0 ) {
						$id = false;
					}
				}
				// Process cache the result to avoid queries
				$user->oAuthUserData['centralId'] = $id;
			}
		} else {
			$id = $user->getId();
		}

		return $id;
	}

	/**
	 * Given a username, get the user ID for that user on the central wiki.
	 * @param string $username
	 * @throws \MWException
	 * @return int|bool ID or false if not found
	 */
	public static function getCentralIdFromUserName( $username ) {
		global $wgMWOAuthSharedUserIDs, $wgMWOAuthSharedUserSource;

		if ( $wgMWOAuthSharedUserIDs ) { // global ID required via hook
			$lookup = \CentralIdLookup::factory( $wgMWOAuthSharedUserSource );
			$id = $lookup->centralIdFromName( $username );
			if ( $id === 0 ) {
				$id = false;
			}
		} else {
			$id = false;
			$user = \User::newFromName( $username );
			if ( $user instanceof \User && $user->getId() > 0 ) {
				$id = $user->getId();
			}
		}

		return $id;
	}

	/**
	 * Get the effective secret key/token to use for OAuth purposes.
	 *
	 * For example, the "secret key" and "access secret" values that are
	 * used for authenticating request should be the result of applying this
	 * function to the respective values stored in the DB. This means that
	 * a leak of DB values is not enough to impersonate consumers.
	 *
	 * @param string $secret
	 * @return string
	 */
	public static function hmacDBSecret( $secret ) {
		global $wgOAuthSecretKey;

		return $wgOAuthSecretKey ? hash_hmac( 'sha1', $secret, $wgOAuthSecretKey ) : $secret;
	}

	/**
	 * Run hook to override a message keys that might need to be changed
	 * across all sites in this cluster.
	 * @param string $msgKey the Message key
	 * @return string the Message key to use
	 */
	public static function getSiteMessage( $msgKey ) {
		Hooks::run( 'OAuthReplaceMessage', [ &$msgKey ] );
		return $msgKey;
	}

	/**
	 * Get a link to the central wiki's user talk page of a user.
	 *
	 * @param string $username the username of the User Talk link
	 * @return string the (proto-relative, urlencoded) url of the central wiki's user talk page
	 */
	public static function getCentralUserTalk( $username ) {
		global $wgMWOAuthCentralWiki, $wgMWOAuthSharedUserIDs;

		if ( $wgMWOAuthSharedUserIDs ) {
			$url = \WikiMap::getForeignURL(
				$wgMWOAuthCentralWiki,
				"User_talk:$username"
			);
		} else {
			$url = \Title::makeTitleSafe( NS_USER_TALK, $username )->getFullURL();
		}
		return $url;
	}

	/**
	 * @param array $grants
	 * @return bool
	 */
	public static function grantsAreValid( array $grants ) {
		// Remove our special grants before calling the core method
		$grants = array_diff( $grants, [ 'mwoauth-authonly', 'mwoauth-authonlyprivate' ] );
		return \MWGrants::grantsAreValid( $grants );
	}

	/**
	 * Given an OAuth consumer stage change event, find out who needs to be notified.
	 * Will be used as an EchoAttributeManager::ATTR_LOCATORS callback.
	 * @param EchoEvent $event
	 * @return User[]
	 */
	public static function locateUsersToNotify( EchoEvent $event ) {
		$agent = $event->getAgent();
		$owner = self::getLocalUserFromCentralId( $event->getExtraParam( 'owner-id' ) );

		$users = [];
		switch ( $event->getType() ) {
			case 'oauth-app-propose':
				// notify OAuth admins about new proposed apps
				$oauthAdmins = self::getOAuthAdmins();
				foreach ( $oauthAdmins as $admin ) {
					if ( $admin->equals( $owner ) ) {
						continue;
					}
					$users[$admin->getId()] = $admin;
				}
				break;
			case 'oauth-app-update':
			case 'oauth-app-approve':
			case 'oauth-app-reject':
			case 'oauth-app-disable':
			case 'oauth-app-reenable':
				// notify owner if someone else changed the status of the app
				if ( !$owner->equals( $agent ) ) {
					$users[$owner->getId()] = $owner;
				}
				break;
		}
		return $users;
	}

	/**
	 * Return a list of all OAuth admins (or the first 5000 in the unlikely case that there is more
	 * than that).
	 * Should be called on the central OAuth wiki.
	 * @return User[]
	 */
	protected static function getOAuthAdmins() {
		global $wgOAuthGroupsToNotify;

		if ( !$wgOAuthGroupsToNotify ) {
			return [];
		}

		return iterator_to_array( User::findUsersByGroup( $wgOAuthGroupsToNotify ) );
	}
}
