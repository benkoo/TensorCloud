<?php

namespace MediaWiki\Extensions\OAuth;

use Wikimedia\Rdbms\DBConnRef;

/**
 * (c) Aaron Schulz 2013, GPL
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

/**
 * This handles the core logic of approving/disabling consumers
 * from using particular user accounts
 *
 * This control can only be used on the management wiki
 *
 * @TODO: improve error messages
 */
class MWOAuthConsumerSubmitControl extends MWOAuthSubmitControl {
	/**
	 * Names of the actions that can be performed on a consumer. These are the same as the
	 * options in getRequiredFields().
	 * @var array
	 */
	public static $actions = [ 'propose', 'update', 'approve', 'reject', 'disable', 'reenable' ];

	/** @var DBConnRef */
	protected $dbw;

	/**
	 * @param \IContextSource $context
	 * @param array $params
	 * @param DBConnRef $dbw Result of MWOAuthUtils::getCentralDB( DB_MASTER )
	 */
	public function __construct( \IContextSource $context, array $params, DBConnRef $dbw ) {
		parent::__construct( $context, $params );
		$this->dbw = $dbw;
	}

	protected function getRequiredFields() {
		$validateRsaKey = function ( $s ) {
			if ( trim( $s ) === '' ) {
				return true;
			}
			$key = openssl_pkey_get_public( $s );
			if ( $key === false ) {
				return false;
			}
			$info = openssl_pkey_get_details( $key );
			if ( $info['type'] !== OPENSSL_KEYTYPE_RSA ) {
				return false;
			}
			return true;
		};

		return [
			// Proposer (application administrator) actions:
			'propose'     => [
				'name'         => '/^.{1,128}$/',
				'version'      => '/^\d{1,3}(\.\d{1,2}){0,2}(-(dev|alpha|beta))?$/',
				'callbackUrl'  => function ( $s, $vals ) {
					return $vals['ownerOnly'] || wfParseUrl( $s ) !== false;
				},
				'description'  => '/^.*$/s',
				'email'        => function ( $s ) {
					return \Sanitizer::validateEmail( $s );
				},
				'wiki'         => function ( $s ) {
					global $wgConf;
					return ( $s === '*'
						|| in_array( $s, $wgConf->getLocalDatabases() )
						|| array_search( $s, MWOAuthUtils::getAllWikiNames() ) !== false
					);
				},
				'granttype'    => '/^(authonly|authonlyprivate|normal)$/',
				'grants'       => function ( $s ) {
					$grants = \FormatJson::decode( $s, true );
					return is_array( $grants ) && MWOAuthUtils::grantsAreValid( $grants );
				},
				'rsaKey'       => $validateRsaKey,
				'agreement'    => function ( $s ) {
					return ( $s == true );
				},
			],
			'update'      => [
				'consumerKey'  => '/^[0-9a-f]{32}$/',
				'rsaKey'       => $validateRsaKey,
				'resetSecret'  => function ( $s ) {
					return is_bool( $s );
				},
				'reason'       => '/^.{0,255}$/',
				'changeToken'  => '/^[0-9a-f]{40}$/'
			],
			// Approver (project administrator) actions:
			'approve'     => [
				'consumerKey'  => '/^[0-9a-f]{32}$/',
				'reason'       => '/^.{0,255}$/',
				'changeToken'  => '/^[0-9a-f]{40}$/'
			],
			'reject'      => [
				'consumerKey'  => '/^[0-9a-f]{32}$/',
				'reason'       => '/^.{0,255}$/',
				'suppress'     => '/^[01]$/',
				'changeToken'  => '/^[0-9a-f]{40}$/'
			],
			'disable'     => [
				'consumerKey'  => '/^[0-9a-f]{32}$/',
				'reason'       => '/^.{0,255}$/',
				'suppress'     => '/^[01]$/',
				'changeToken'  => '/^[0-9a-f]{40}$/'
			],
			'reenable'    => [
				'consumerKey'  => '/^[0-9a-f]{32}$/',
				'reason'       => '/^.{0,255}$/',
				'changeToken'  => '/^[0-9a-f]{40}$/'
			]
		];
	}

	protected function checkBasePermissions() {
		global $wgBlockDisablesLogin;
		$user = $this->getUser();
		if ( !$user->getID() ) {
			return $this->failure( 'not_logged_in', 'badaccess-group0' );
		} elseif ( $user->isLocked() || $wgBlockDisablesLogin && $user->isBlocked() ) {
			return $this->failure( 'user_blocked', 'badaccess-group0' );
		} elseif ( wfReadOnly() ) {
			return $this->failure( 'readonly', 'readonlytext', wfReadOnlyReason() );
		} elseif ( !MWOAuthUtils::isCentralWiki() ) { // sanity
			// This logs consumer changes to the local logging table on the central wiki
			throw new \MWException( "This can only be used from the OAuth management wiki." );
		}
		return $this->success();
	}

	protected function processAction( $action ) {
		$context = $this->getContext();
		$user = $this->getUser(); // proposer or admin
		$dbw = $this->dbw; // convenience

		$centralUserId = MWOAuthUtils::getCentralIdFromLocalUser( $user );
		if ( !$centralUserId ) { // sanity
			return $this->failure( 'permission_denied', 'badaccess-group0' );
		}

		switch ( $action ) {
		case 'propose':
			if ( !$user->isAllowed( 'mwoauthproposeconsumer' ) ) {
				return $this->failure( 'permission_denied', 'badaccess-group0' );
			} elseif ( !$user->isEmailConfirmed() ) {
				return $this->failure( 'email_not_confirmed', 'mwoauth-consumer-email-unconfirmed' );
			} elseif ( $user->getEmail() !== $this->vals['email'] ) {
				// @TODO: allow any email and don't set emailAuthenticated below
				return $this->failure( 'email_mismatched', 'mwoauth-consumer-email-mismatched' );
			}

			if ( MWOAuthConsumer::newFromNameVersionUser(
				$dbw, $this->vals['name'], $this->vals['version'], $centralUserId ) ) {
				return $this->failure( 'consumer_exists', 'mwoauth-consumer-alreadyexists' );
			}

			$wikiNames = MWOAuthUtils::getAllWikiNames();
			$dbKey = array_search( $this->vals['wiki'], $wikiNames );
			if ( $dbKey !== false ) {
				$this->vals['wiki'] = $dbKey;
			}

			$curVer = $dbw->selectField( 'oauth_registered_consumer',
				'oarc_version',
				[ 'oarc_name' => $this->vals['name'], 'oarc_user_id' => $centralUserId ],
				__METHOD__,
				[ 'ORDER BY' => 'oarc_registration DESC', 'FOR UPDATE' ]
			);
			if ( $curVer !== false && version_compare( $curVer, $this->vals['version'], '>=' ) ) {
				return $this->failure( 'consumer_exists',
					'mwoauth-consumer-alreadyexistsversion', $curVer );
			}

			// Handle owner-only mode
			if ( $this->vals['ownerOnly'] ) {
				$this->vals['callbackUrl'] = \SpecialPage::getTitleFor( 'OAuth', 'verified' )
					->getLocalUrl();
				$this->vals['callbackIsPrefix'] = '';
				$stage = MWOAuthConsumer::STAGE_APPROVED;
			} else {
				$stage = MWOAuthConsumer::STAGE_PROPOSED;
			}

			// Handle grant types
			$grants = [];
			switch ( $this->vals['granttype'] ) {
				case 'authonly':
					$grants = [ 'mwoauth-authonly' ];
					break;
				case 'authonlyprivate':
					$grants = [ 'mwoauth-authonlyprivate' ];
					break;
				case 'normal':
					$grants = array_unique( array_merge(
						\MWGrants::getHiddenGrants(), // implied grants
						\FormatJson::decode( $this->vals['grants'], true )
					) );
					break;
			}

			$now = wfTimestampNow();
			$cmr = MWOAuthConsumer::newFromArray(
				[
					'id'                 => null, // auto-increment
					'consumerKey'        => \MWCryptRand::generateHex( 32 ),
					'userId'             => $centralUserId,
					'email'              => $user->getEmail(),
					'emailAuthenticated' => $now, // see above
					'developerAgreement' => 1,
					'secretKey'          => \MWCryptRand::generateHex( 32 ),
					'registration'       => $now,
					'stage'              => $stage,
					'stageTimestamp'     => $now,
					'grants'             => $grants,
					'restrictions'       => $this->vals['restrictions'],
					'deleted'            => 0
				] + $this->vals
			);
			$cmr->save( $dbw );

			if ( $cmr->get( 'ownerOnly' ) ) {
				$this->makeLogEntry(
					$dbw, $cmr, 'create-owner-only', $user, $this->vals['description']
				);
			} else {
				$this->makeLogEntry( $dbw, $cmr, $action, $user, $this->vals['description'] );
				$this->notify( $cmr, $user, $action,  null );
			}

			// If it's owner-only, automatically accept it for the user too.
			$cmra = null;
			if ( $cmr->get( 'ownerOnly' ) ) {
				$accessToken = MWOAuthDataStore::newToken();
				$cmra = MWOAuthConsumerAcceptance::newFromArray( [
					'id'           => null,
					'wiki'         => $cmr->get( 'wiki' ),
					'userId'       => $centralUserId,
					'consumerId'   => $cmr->get( 'id' ),
					'accessToken'  => $accessToken->key,
					'accessSecret' => $accessToken->secret,
					'grants'       => $cmr->get( 'grants' ),
					'accepted'     => $now,
				] );
				$cmra->save( $dbw );
			}

			return $this->success( [ 'consumer' => $cmr, 'acceptance' => $cmra ] );
		case 'update':
			if ( !$user->isAllowed( 'mwoauthupdateownconsumer' ) ) {
				return $this->failure( 'permission_denied', 'badaccess-group0' );
			}

			$cmr = MWOAuthConsumer::newFromKey( $dbw, $this->vals['consumerKey'] );
			if ( !$cmr ) {
				return $this->failure( 'invalid_consumer_key', 'mwoauth-invalid-consumer-key' );
			} elseif ( $cmr->get( 'userId' ) !== $centralUserId ) {
				return $this->failure( 'permission_denied', 'badaccess-group0' );
			} elseif ( $cmr->get( 'stage' ) !== MWOAuthConsumer::STAGE_APPROVED
				&& $cmr->get( 'stage' ) !== MWOAuthConsumer::STAGE_PROPOSED ) {
				return $this->failure( 'permission_denied', 'badaccess-group0' );
			} elseif ( $cmr->get( 'deleted' ) && !$user->isAllowed( 'mwoauthsuppress' ) ) {
				return $this->failure( 'permission_denied', 'badaccess-group0' ); // sanity
			} elseif ( !$cmr->checkChangeToken( $context, $this->vals['changeToken'] ) ) {
				return $this->failure( 'change_conflict', 'mwoauth-consumer-conflict' );
			}

			$cmr->setFields( [
				'rsaKey'       => $this->vals['rsaKey'],
				'restrictions' => $this->vals['restrictions'],
				'secretKey'    => $this->vals['resetSecret']
					? \MWCryptRand::generateHex( 32 )
					: $cmr->get( 'secretKey' )
			] );

			// Log if something actually changed
			if ( $cmr->save( $dbw ) ) {
				$this->makeLogEntry( $dbw, $cmr, $action, $user, $this->vals['reason'] );
				$this->notify( $cmr, $user, $action,  $this->vals['reason'] );
			}

			$cmra = null;
			if ( $cmr->get( 'ownerOnly' ) && $this->vals['resetSecret'] ) {
				$accessToken = MWOAuthDataStore::newToken();
				$fields = [
					'wiki'         => $cmr->get( 'wiki' ),
					'userId'       => $centralUserId,
					'consumerId'   => $cmr->get( 'id' ),
					'accessSecret' => $accessToken->secret,
					'grants'       => $cmr->get( 'grants' ),
				];

				$oauthServer = MWOAuthUtils::newMWOAuthServer();
				$cmra = $oauthServer->getCurrentAuthorization( $user, $cmr, wfWikiId() );
				if ( $cmra ) {
					$cmra->setFields( $fields );
				} else {
					$cmra = MWOAuthConsumerAcceptance::newFromArray( $fields + [
						'id'           => null,
						'accessToken'  => $accessToken->key,
						'accepted'     => wfTimestampNow(),
					] );
				}
				$cmra->save( $dbw );
			}

			return $this->success( [ 'consumer' => $cmr, 'acceptance' => $cmra ] );
		case 'approve':
			if ( !$user->isAllowed( 'mwoauthmanageconsumer' ) ) {
				return $this->failure( 'permission_denied', 'badaccess-group0' );
			}

			$cmr = MWOAuthConsumer::newFromKey( $dbw, $this->vals['consumerKey'] );
			if ( !$cmr ) {
				return $this->failure( 'invalid_consumer_key', 'mwoauth-invalid-consumer-key' );
			} elseif ( !in_array( $cmr->get( 'stage' ), [
				MWOAuthConsumer::STAGE_PROPOSED,
				MWOAuthConsumer::STAGE_EXPIRED,
				MWOAuthConsumer::STAGE_REJECTED ] ) ) {
				return $this->failure( 'not_proposed', 'mwoauth-consumer-not-proposed' );
			} elseif ( $cmr->get( 'deleted' ) && !$user->isAllowed( 'mwoauthsuppress' ) ) {
				return $this->failure( 'permission_denied', 'badaccess-group0' );
			} elseif ( !$cmr->checkChangeToken( $context, $this->vals['changeToken'] ) ) {
				return $this->failure( 'change_conflict', 'mwoauth-consumer-conflict' );
			}

			$cmr->setFields( [
				'stage'          => MWOAuthConsumer::STAGE_APPROVED,
				'stageTimestamp' => wfTimestampNow(),
				'deleted'        => 0 ] );

			// Log if something actually changed
			if ( $cmr->save( $dbw ) ) {
				$this->makeLogEntry( $dbw, $cmr, $action, $user, $this->vals['reason'] );
				$this->notify( $cmr, $user, $action,  $this->vals['reason'] );
			}

			return $this->success( $cmr );
		case 'reject':
			if ( !$user->isAllowed( 'mwoauthmanageconsumer' ) ) {
				return $this->failure( 'permission_denied', 'badaccess-group0' );
			}

			$cmr = MWOAuthConsumer::newFromKey( $dbw, $this->vals['consumerKey'] );
			if ( !$cmr ) {
				return $this->failure( 'invalid_consumer_key', 'mwoauth-invalid-consumer-key' );
			} elseif ( $cmr->get( 'stage' ) !== MWOAuthConsumer::STAGE_PROPOSED ) {
				return $this->failure( 'not_proposed', 'mwoauth-consumer-not-proposed' );
			} elseif ( $cmr->get( 'deleted' ) && !$user->isAllowed( 'mwoauthsuppress' ) ) {
				return $this->failure( 'permission_denied', 'badaccess-group0' );
			} elseif ( $this->vals['suppress'] && !$user->isAllowed( 'mwoauthsuppress' ) ) {
				return $this->failure( 'permission_denied', 'badaccess-group0' );
			} elseif ( !$cmr->checkChangeToken( $context, $this->vals['changeToken'] ) ) {
				return $this->failure( 'change_conflict', 'mwoauth-consumer-conflict' );
			}

			$cmr->setFields( [
				'stage'          => MWOAuthConsumer::STAGE_REJECTED,
				'stageTimestamp' => wfTimestampNow(),
				'deleted'        => $this->vals['suppress'] ] );

			// Log if something actually changed
			if ( $cmr->save( $dbw ) ) {
				$this->makeLogEntry( $dbw, $cmr, $action, $user, $this->vals['reason'] );
				$this->notify( $cmr, $user, $action,  $this->vals['reason'] );
			}

			return $this->success( $cmr );
		case 'disable':
			if ( !$user->isAllowed( 'mwoauthmanageconsumer' ) ) {
				return $this->failure( 'permission_denied', 'badaccess-group0' );
			} elseif ( $this->vals['suppress'] && !$user->isAllowed( 'mwoauthsuppress' ) ) {
				return $this->failure( 'permission_denied', 'badaccess-group0' );
			}

			$cmr = MWOAuthConsumer::newFromKey( $dbw, $this->vals['consumerKey'] );
			if ( !$cmr ) {
				return $this->failure( 'invalid_consumer_key', 'mwoauth-invalid-consumer-key' );
			} elseif ( $cmr->get( 'stage' ) !== MWOAuthConsumer::STAGE_APPROVED
				&& $cmr->get( 'deleted' ) == $this->vals['suppress'] ) {
				return $this->failure( 'not_approved', 'mwoauth-consumer-not-approved' );
			} elseif ( $cmr->get( 'deleted' ) && !$user->isAllowed( 'mwoauthsuppress' ) ) {
				return $this->failure( 'permission_denied', 'badaccess-group0' );
			} elseif ( !$cmr->checkChangeToken( $context, $this->vals['changeToken'] ) ) {
				return $this->failure( 'change_conflict', 'mwoauth-consumer-conflict' );
			}

			$cmr->setFields( [
				'stage'          => MWOAuthConsumer::STAGE_DISABLED,
				'stageTimestamp' => wfTimestampNow(),
				'deleted'        => $this->vals['suppress'] ] );

			// Log if something actually changed
			if ( $cmr->save( $dbw ) ) {
				$this->makeLogEntry( $dbw, $cmr, $action, $user, $this->vals['reason'] );
				$this->notify( $cmr, $user, $action,  $this->vals['reason'] );
			}

			return $this->success( $cmr );
		case 'reenable':
			if ( !$user->isAllowed( 'mwoauthmanageconsumer' ) ) {
				return $this->failure( 'permission_denied', 'badaccess-group0' );
			}

			$cmr = MWOAuthConsumer::newFromKey( $dbw, $this->vals['consumerKey'] );
			if ( !$cmr ) {
				return $this->failure( 'invalid_consumer_key', 'mwoauth-invalid-consumer-key' );
			} elseif ( $cmr->get( 'stage' ) !== MWOAuthConsumer::STAGE_DISABLED ) {
				return $this->failure( 'not_disabled', 'mwoauth-consumer-not-disabled' );
			} elseif ( $cmr->get( 'deleted' ) && !$user->isAllowed( 'mwoauthsuppress' ) ) {
				return $this->failure( 'permission_denied', 'badaccess-group0' );
			} elseif ( !$cmr->checkChangeToken( $context, $this->vals['changeToken'] ) ) {
				return $this->failure( 'change_conflict', 'mwoauth-consumer-conflict' );
			}

			$cmr->setFields( [
				'stage'          => MWOAuthConsumer::STAGE_APPROVED,
				'stageTimestamp' => wfTimestampNow(),
				'deleted'        => 0 ] );

			// Log if something actually changed
			if ( $cmr->save( $dbw ) ) {
				$this->makeLogEntry( $dbw, $cmr, $action, $user, $this->vals['reason'] );
				$this->notify( $cmr, $user, $action,  $this->vals['reason'] );
			}

			return $this->success( $cmr );
		}
	}

	/**
	 * @param DBConnRef $db
	 * @param int $userId
	 * @return \Title
	 */
	protected function getLogTitle( DBConnRef $db, $userId ) {
		$name = MWOAuthUtils::getCentralUserNameFromId( $userId );
		return \Title::makeTitleSafe( NS_USER, $name );
	}

	/**
	 * @param DBConnRef $dbw
	 * @param MWOAuthConsumer $cmr
	 * @param string $action
	 * @param \User $performer
	 * @param string $comment
	 */
	protected function makeLogEntry(
		$dbw, MWOAuthConsumer $cmr, $action, \User $performer, $comment
	) {
		$logEntry = new \ManualLogEntry( 'mwoauthconsumer', $action );
		$logEntry->setPerformer( $performer );
		$logEntry->setTarget( $this->getLogTitle( $dbw, $cmr->get( 'userId' ) ) );
		$logEntry->setComment( $comment );
		$logEntry->setParameters( [ '4:consumer' => $cmr->get( 'consumerKey' ) ] );
		$logEntry->setRelations( [
			'OAuthConsumer' => [ $cmr->get( 'consumerKey' ) ]
		] );
		$logEntry->insert( $dbw );
	}

	/**
	 * @param MWOAuthConsumer $cmr Consumer which was the subject of the action
	 * @param \User $user User who performed the action
	 * @param string $actionType Action type
	 * @param string $comment
	 * @throws \MWException
	 */
	protected function notify( $cmr, $user, $actionType, $comment ) {
		if ( !in_array( $actionType, self::$actions, true ) ) {
			throw new \MWException( "Invalid action type: $actionType" );
		} elseif ( !class_exists( '\EchoEvent' ) ) {
			return;
		} elseif ( !MWOAuthUtils::isCentralWiki() ) {
			# sanity; should never get here on a slave wiki
			return;
		}

		\EchoEvent::create( [
			'type' => 'oauth-app-' . $actionType,
			'agent' => $user,
			'extra' => [
				'action' => $actionType,
				'app-key' => $cmr->get( 'consumerKey' ),
				'owner-id' => $cmr->get( 'userId' ),
				'comment' => $comment,
			],
		] );
	}
}
