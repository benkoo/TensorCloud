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
 * Representation of an OAuth consumer request
 */
class MWOAuthConsumer extends MWOAuthDAO {
	/** @var array Backwards-compatibility grant mappings */
	public static $mapBackCompatGrants = [
		'useoauth' => 'basic',
		'authonly' => 'mwoauth-authonly',
		'authonlyprivate' => 'mwoauth-authonlyprivate',
	];

	/** @var int Unique ID */
	protected $id;
	/** @var string Hex token */
	protected $consumerKey;
	/** @var string Name of connected application */
	protected $name;
	/** @var int Publisher's central user ID. $wgMWOAuthSharedUserIDs defines which central ID
	 *    provider to use. */
	protected $userId;
	/** @var string Version used for handshake breaking changes */
	protected $version;
	/** @var string OAuth callback URL for authorization step*/
	protected $callbackUrl;
	/**
	 * @var int OAuth callback URL is a prefix and we allow all URLs which
	 *   have callbackUrl as the prefix
	 */
	protected $callbackIsPrefix;
	/** @var string Application description */
	protected $description;
	/** @var string Publisher email address */
	protected $email;
	/** @var string TS_MW timestamp of when email address was confirmed */
	protected $emailAuthenticated;
	/** @var int User accepted the developer agreement */
	protected $developerAgreement;
	/** @var int Consumer is for use by the owner only */
	protected $ownerOnly;
	/** @var string Wiki ID the application can be used on (or "*" for all) */
	protected $wiki;
	/** @var string TS_MW timestamp of proposal */
	protected $registration;
	/** @var string Secret HMAC key */
	protected $secretKey;
	/** @var string Public RSA key */
	protected $rsaKey;
	/** @var array List of grants */
	protected $grants;
	/** @var \\MWRestrictions IP restrictions */
	protected $restrictions;
	/** @var int MWOAuthConsumer::STAGE_* constant */
	protected $stage;
	/** @var string TS_MW timestamp of last stage change */
	protected $stageTimestamp;
	/** @var int Indicates (if non-zero) this consumer's information is suppressed */
	protected $deleted;

	/* Stages that registered consumer takes (stored in DB) */
	const STAGE_PROPOSED = 0;
	const STAGE_APPROVED = 1;
	const STAGE_REJECTED = 2;
	const STAGE_EXPIRED  = 3;
	const STAGE_DISABLED = 4;

	/**
	 * Maps stage ids to human-readable names which describe them as a state
	 * @var array
	 */
	public static $stageNames = [
		self::STAGE_PROPOSED => 'proposed',
		self::STAGE_REJECTED => 'rejected',
		self::STAGE_EXPIRED  => 'expired',
		self::STAGE_APPROVED => 'approved',
		self::STAGE_DISABLED => 'disabled',
	];

	/**
	 * Maps stage ids to human-readable names which describe them as an action (which would result
	 * in that stage)
	 * @var array
	 */
	public static $stageActionNames = [
		self::STAGE_PROPOSED => 'propose',
		self::STAGE_REJECTED => 'reject',
		self::STAGE_EXPIRED  => 'propose',
		self::STAGE_APPROVED => 'approve',
		self::STAGE_DISABLED => 'disable',
	];

	protected static function getSchema() {
		return [
			'table'          => 'oauth_registered_consumer',
			'fieldColumnMap' => [
				'id'                 => 'oarc_id',
				'consumerKey'        => 'oarc_consumer_key',
				'name'               => 'oarc_name',
				'userId'             => 'oarc_user_id',
				'version'            => 'oarc_version',
				'callbackUrl'        => 'oarc_callback_url',
				'callbackIsPrefix'   => 'oarc_callback_is_prefix',
				'description'        => 'oarc_description',
				'email'              => 'oarc_email',
				'emailAuthenticated' => 'oarc_email_authenticated',
				'developerAgreement' => 'oarc_developer_agreement',
				'ownerOnly'          => 'oarc_owner_only',
				'wiki'               => 'oarc_wiki',
				'grants'             => 'oarc_grants',
				'registration'       => 'oarc_registration',
				'secretKey'          => 'oarc_secret_key',
				'rsaKey'             => 'oarc_rsa_key',
				'restrictions'       => 'oarc_restrictions',
				'stage'              => 'oarc_stage',
				'stageTimestamp'     => 'oarc_stage_timestamp',
				'deleted'            => 'oarc_deleted'
			],
			'idField'        => 'id',
			'autoIncrField'  => 'id',
		];
	}

	protected static function getFieldPermissionChecks() {
		return [
			'name'             => 'userCanSee',
			'userId'           => 'userCanSee',
			'version'          => 'userCanSee',
			'callbackUrl'      => 'userCanSee',
			'callbackIsPrefix' => 'userCanSee',
			'description'      => 'userCanSee',
			'rsaKey'           => 'userCanSee',
			'email'            => 'userCanSeeEmail',
			'secretKey'        => 'userCanSeeSecret',
			'restrictions'     => 'userCanSeePrivate',
		];
	}

	/**
	 * @param DBConnRef $db
	 * @param string $key
	 * @param int $flags MWOAuthConsumer::READ_* bitfield
	 * @return MWOAuthConsumer|bool
	 */
	public static function newFromKey( DBConnRef $db, $key, $flags = 0 ) {
		$row = $db->selectRow( static::getTable(),
			array_values( static::getFieldColumnMap() ),
			[ 'oarc_consumer_key' => (string)$key ],
			__METHOD__,
			( $flags & self::READ_LOCKING ) ? [ 'FOR UPDATE' ] : []
		);

		if ( $row ) {
			$consumer = new self();
			$consumer->loadFromRow( $db, $row );
			return $consumer;
		} else {
			return false;
		}
	}

	/**
	 * @param DBConnRef $db
	 * @param string $name
	 * @param string $version
	 * @param int $userId Central user ID
	 * @param int $flags MWOAuthConsumer::READ_* bitfield
	 * @return MWOAuthConsumer|bool
	 */
	public static function newFromNameVersionUser(
		DBConnRef $db, $name, $version, $userId, $flags = 0
	) {
		$row = $db->selectRow( static::getTable(),
			array_values( static::getFieldColumnMap() ),
			[
				'oarc_name' => (string)$name,
				'oarc_version' => (string)$version,
				'oarc_user_id' => (int)$userId
			],
			__METHOD__,
			( $flags & self::READ_LOCKING ) ? [ 'FOR UPDATE' ] : []
		);

		if ( $row ) {
			$consumer = new self();
			$consumer->loadFromRow( $db, $row );
			return $consumer;
		} else {
			return false;
		}
	}

	/**
	 * @return array
	 */
	public static function newGrants() {
		return [];
	}

	/**
	 * @return array
	 */
	public static function getAllStages() {
		return [
			self::STAGE_PROPOSED,
			self::STAGE_REJECTED,
			self::STAGE_EXPIRED,
			self::STAGE_APPROVED,
			self::STAGE_DISABLED,
		];
	}

	/**
	 * @param MWOAuthDataStore $dataStore
	 * @param string $verifyCode verification code
	 * @param string $requestKey original request key from /initiate
	 * @return string the url for redirection
	 */
	public function generateCallbackUrl( $dataStore, $verifyCode, $requestKey ) {
		$callback = $dataStore->getCallbackUrl( $this->key, $requestKey );

		if ( $callback === 'oob' ) {
		  $callback = $this->get( 'callbackUrl' );
		}

		return wfAppendQuery( $callback, [
			'oauth_verifier' => $verifyCode,
			'oauth_token'    => $requestKey
		] );
	}

	/**
	 * Check if the consumer is usable by $user
	 *
	 * "Usable by $user" includes:
	 * - Approved for multi-user use
	 * - Approved for owner-only use and is owned by $user
	 * - Still pending approval and is owned by $user
	 *
	 * @param \User $user
	 * @return bool
	 */
	public function isUsableBy( \User $user ) {
		if ( $this->stage === self::STAGE_APPROVED && !$this->get( 'ownerOnly' ) ) {
			return true;
		} elseif ( $this->stage === self::STAGE_PROPOSED || $this->stage === self::STAGE_APPROVED ) {
			$centralId = MWOAuthUtils::getCentralIdFromLocalUser( $user );
			return ( $centralId && $this->userId === $centralId );
		}
		return false;
	}

	protected function normalizeValues() {
		// Keep null values since we're constructing w/ them to auto-increment
		$this->id = is_null( $this->id ) ? null : (int)$this->id;
		$this->userId = (int)$this->userId;
		$this->registration = wfTimestamp( TS_MW, $this->registration );
		$this->stage = (int)$this->stage;
		$this->stageTimestamp = wfTimestamp( TS_MW, $this->stageTimestamp );
		$this->emailAuthenticated = wfTimestamp( TS_MW, $this->emailAuthenticated );
		$this->deleted = (int)$this->deleted;
		$this->grants = (array)$this->grants; // sanity
	}

	protected function encodeRow( DBConnRef $db, $row ) {
		// For compatibility with other wikis in the farm, un-remap some grants
		foreach ( self::$mapBackCompatGrants as $old => $new ) {
			while ( ( $i = array_search( $new, $row['oarc_grants'], true ) ) !== false ) {
				$row['oarc_grants'][$i] = $old;
			}
		}

		$row['oarc_registration'] = $db->timestamp( $row['oarc_registration'] );
		$row['oarc_stage_timestamp'] = $db->timestamp( $row['oarc_stage_timestamp'] );
		$row['oarc_restrictions'] = $row['oarc_restrictions']->toJson();
		$row['oarc_grants'] = \FormatJson::encode( $row['oarc_grants'] );
		$row['oarc_email_authenticated'] =
			$db->timestampOrNull( $row['oarc_email_authenticated'] );
		return $row;
	}

	protected function decodeRow( DBConnRef $db, $row ) {
		$row['oarc_registration'] = wfTimestamp( TS_MW, $row['oarc_registration'] );
		$row['oarc_stage_timestamp'] = wfTimestamp( TS_MW, $row['oarc_stage_timestamp'] );
		$row['oarc_restrictions'] = \MWRestrictions::newFromJson( $row['oarc_restrictions'] );
		$row['oarc_grants'] = \FormatJson::decode( $row['oarc_grants'], true );
		$row['oarc_email_authenticated'] =
			wfTimestampOrNull( TS_MW, $row['oarc_email_authenticated'] );

		// For backwards compatibility, remap some grants
		foreach ( self::$mapBackCompatGrants as $old => $new ) {
			while ( ( $i = array_search( $old, $row['oarc_grants'], true ) ) !== false ) {
				$row['oarc_grants'][$i] = $new;
			}
		}

		return $row;
	}

	/**
	 * Magic method so that $consumer->secret and $consumer->key work.
	 * This allows MWOAuthConsumer to be a replacement for OAuthConsumer
	 * in lib/OAuth.php without inheriting.
	 * @param mixed $prop
	 * @return mixed
	 */
	public function __get( $prop ) {
		if ( $prop === 'key' ) {
			return $this->consumerKey;
		} elseif ( $prop === 'secret' ) {
			return MWOAuthUtils::hmacDBSecret( $this->secretKey );
		} else {
			return $this->$prop;
		}
	}

	protected function userCanSee( $name, \RequestContext $context ) {
		if ( $this->get( 'deleted' )
			&& !$context->getUser()->isAllowed( 'mwoauthviewsuppressed' ) ) {
			return $context->msg( 'mwoauth-field-hidden' );
		} else {
			return true;
		}
	}

	protected function userCanSeePrivate( $name, \RequestContext $context ) {
		if ( !$context->getUser()->isAllowed( 'mwoauthviewprivate' ) ) {
			return $context->msg( 'mwoauth-field-private' );
		} else {
			return $this->userCanSee( $name, $context );
		}
	}

	protected function userCanSeeEmail( $name, \RequestContext $context ) {
		if ( !$context->getUser()->isAllowed( 'mwoauthmanageconsumer' ) ) {
			return $context->msg( 'mwoauth-field-private' );
		} else {
			return $this->userCanSee( $name, $context );
		}
	}

	protected function userCanSeeSecret( $name, \RequestContext $context ) {
		return $context->msg( 'mwoauth-field-private' );
	}
}
