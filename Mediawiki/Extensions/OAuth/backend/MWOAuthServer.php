<?php

namespace MediaWiki\Extensions\OAuth;

class MWOAuthServer extends OAuthServer {
	/** @var MWOAuthDataStore */
	protected $data_store;

	/**
	 * Return a consumer key associated with the given request token.
	 *
	 * @param MWOAuthToken $requestToken the request token
	 * @return string|false the consumer key or false if nothing is stored for the request token
	 */
	public function getConsumerKey( $requestToken ) {
		return $this->data_store->getConsumerKey( $requestToken );
	}

	/**
	 * Process a request_token request returns the request token on success. This
	 * also checks the IP restriction, which the OAuthServer method did not.
	 *
	 * @param MWOAuthRequest &$request the request
	 * @return MWOAuthToken
	 * @throws MWOAuthException
	 */
	public function fetch_request_token( &$request ) {
		$this->get_version( $request );

		$consumer = $this->get_consumer( $request );

		// Consumer must not be owner-only
		if ( $consumer->get( 'ownerOnly' ) ) {
			throw new MWOAuthException( 'mwoauthserver-consumer-owner-only', [
				$consumer->get( 'name' ),
				\SpecialPage::getTitleFor(
					'OAuthConsumerRegistration', 'update/' . $consumer->get( 'consumerKey' )
				),
				\Message::rawParam( \Linker::makeExternalLink(
					'https://www.mediawiki.org/wiki/Help:OAuth/Errors#E010',
					'E010',
					true
				) )
			] );
		}

		// Consumer must have a key for us to verify
		if ( !$consumer->get( 'secretKey' ) && !$consumer->get( 'rsaKey' ) ) {
			throw new MWOAuthException( 'mwoauthserver-consumer-no-secret', [
				\Message::rawParam( \Linker::makeExternalLink(
					'https://www.mediawiki.org/wiki/Help:OAuth/Errors#E011',
					'E011',
					true
				) )
			] );
		}

		$this->checkSourceIP( $consumer, $request );

		// no token required for the initial token request
		$token = null;

		$this->check_signature( $request, $consumer, $token );

		$callback = $request->get_parameter( 'oauth_callback' );

		$this->checkCallback( $consumer, $callback );

		$new_token = $this->data_store->new_request_token( $consumer, $callback );
		$new_token->oauth_callback_confirmed = 'true';
		return $new_token;
	}

	/**
	 * Ensure the callback is "oob" or that the registered callback is a valid
	 * prefix of the supplied callback. It throws an exception if callback is
	 * invalid.
	 *
	 * In MediaWiki, we require the callback to be established at
	 * registration. OAuth 1.0a (rfc5849, section 2.1) specifies that
	 * oauth_callback is required for the temporary credentials, and "If the
	 * client is unable to receive callbacks or a callback URI has been
	 * established via other means, the parameter value MUST be set to "oob"
	 * (case sensitive), to indicate an out-of-band configuration." Otherwise,
	 * client can provide a callback and the configured callback must be
	 * a prefix of the supplied callback. The matching performed here is based
	 * on parsed URL components rather than strict string matching. Protocol
	 * upgrades from http to https are also allowed.
	 *
	 * @param MWOAuthConsumer $consumer
	 * @param string $callback
	 * @return void
	 * @throws MWOAuthException
	 */
	private function checkCallback( $consumer, $callback ) {
		if ( !$consumer->get( 'callbackIsPrefix' ) ) {
			if ( $callback !== 'oob' ) {
				throw new MWOAuthException( 'mwoauth-callback-not-oob' );
			}

			return;
		}

		if ( !$callback ) {
			throw new MWOAuthException( 'mwoauth-callback-not-oob-or-prefix' );
		}
		if ( $callback === 'oob' ) {
			return;
		}

		$reqCallback = wfParseUrl( $callback );
		if ( $reqCallback === false ) {
			throw new MWOAuthException( 'mwoauth-callback-not-oob-or-prefix' );
		}

		$knownCallback = wfParseUrl( $consumer->get( 'callbackUrl' ) );
		$exactPath = array_key_exists( 'query', $knownCallback );

		$match =
			// Protocol can be upgraded from http to http
			self::looseSchemeMatch( $knownCallback['scheme'], $reqCallback['scheme'] ) &&
			// Host must match exactly
			$knownCallback['host'] === $reqCallback['host'] &&
			// Port must be either missing from both or an exact match
			static::getOrNull( 'port', $knownCallback ) ===
				static::getOrNull( 'port', $reqCallback ) &&
			// Path must be an exact match if query is provided in the
			// registered callback. Otherwise it must be a prefix match if
			// provided in the registered callback or anything if no path was
			// included in the registered callback at all.
			static::componentMatches( 'path', $knownCallback, $reqCallback, $exactPath ) &&
			// Query string must be aprefix match if provided in the
			// registered callback.
			static::componentMatches( 'query', $knownCallback, $reqCallback );

		if ( !$match ) {
			throw new MWOAuthException( 'mwoauth-callback-not-oob-or-prefix' );
		}
	}

	/**
	 * Compare URL schemes for a match.
	 *
	 * Allows 'https' to match an expected 'http' value.
	 *
	 * @param string $want
	 * @param string $got
	 * @return bool
	 */
	private static function looseSchemeMatch( $want, $got ) {
		if ( $want === 'http' ) {
			return in_array( $got, [ 'http', 'https' ], true );
		} else {
			return $want === $got;
		}
	}

	/**
	 * Get a named value from an array or return null if the key does not
	 * exist.
	 *
	 * @param string $key
	 * @param array $arr
	 * @return mixed
	 */
	private static function getOrNull( $key, $arr ) {
		return array_key_exists( $key, $arr ) ? $arr[$key] : null;
	}

	/**
	 * Check that a callback URL component matches the expected value.
	 *
	 * @param string $part URL component name
	 * @param array $expect Expected URL components
	 * @param array $got Posted URl components
	 * @param bool $exact Perform exact match instead of prefix match
	 * @return bool
	 */
	private static function componentMatches(
		$part, $expect, $got, $exact = false
	) {
		$match = false;
		if ( !array_key_exists( $part, $expect ) ) {
			// Anything in the request is ok if we do not have the URL part in
			// the expected values
			$match = true;
		} elseif ( !array_key_exists( $part,  $got ) ) {
			$match = false;
		} elseif ( $exact ) {
			$match = $expect[$part] === $got[$part];
		} else {
			$want = (string)$expect[$part];
			$have = (string)$got[$part];
			$len = strlen( $want );
			$match = $want === substr( $have, 0, $len );
		}
		return $match;
	}

	/**
	 * process an access_token request
	 * returns the access token on success
	 *
	 * @param MWOAuthRequest &$request the request
	 * @return MWOAuthToken
	 * @throws MWOAuthException
	 */
	public function fetch_access_token( &$request ) {
		$this->get_version( $request );

		$consumer = $this->get_consumer( $request );

		// Consumer must not be owner-only
		if ( $consumer->get( 'ownerOnly' ) ) {
			throw new MWOAuthException( 'mwoauthserver-consumer-owner-only', [
				$consumer->get( 'name' ),
				\SpecialPage::getTitleFor(
					'OAuthConsumerRegistration', 'update/' . $consumer->get( 'consumerKey' )
				),
				\Message::rawParam( \Linker::makeExternalLink(
					'https://www.mediawiki.org/wiki/Help:OAuth/Errors#E010',
					'E010',
					true
				) )
			] );
		}

		// Consumer must have a key for us to verify
		if ( !$consumer->get( 'secretKey' ) && !$consumer->get( 'rsaKey' ) ) {
			throw new MWOAuthException( 'mwoauthserver-consumer-no-secret', [
				\Message::rawParam( \Linker::makeExternalLink(
					'https://www.mediawiki.org/wiki/Help:OAuth/Errors#E011',
					'E011',
					true
				) )
			] );
		}

		$this->checkSourceIP( $consumer, $request );

		// requires authorized request token
		$token = $this->get_token( $request, $consumer, 'request' );

		if ( !$token->secret ) {
			// This token has a blank secret.. something is wrong
			throw new MWOAuthException( 'mwoauthdatastore-bad-token' );
		}

		$this->check_signature( $request, $consumer, $token );

		// Rev A change
		$verifier = $request->get_parameter( 'oauth_verifier' );
		$this->logger->debug( __METHOD__ . ": verify code is '$verifier'" );
		$new_token = $this->data_store->new_access_token( $token, $consumer, $verifier );

		return $new_token;
	}

	/**
	 * Wrap the call to the parent function and check that the source IP of
	 * the request is allowed by this consumer's restrictions.
	 * @param MWOAuthRequest &$request
	 * @return array
	 */
	public function verify_request( &$request ) {
		list( $consumer, $token ) = parent::verify_request( $request );
		$this->checkSourceIP( $consumer, $request );
		return [ $consumer, $token ];
	}

	/**
	 * Ensure the request comes from an approved IP address, if IP restriction has been
	 * setup by the Consumer. It throws an exception if IP address is invalid.
	 *
	 * @param MWOAuthConsumer $consumer
	 * @param MWOAuthRequest $request
	 * @throws MWOAuthException
	 */
	private function checkSourceIP( $consumer, $request ) {
		$restrictions = $consumer->get( 'restrictions' );
		if ( !$restrictions->checkIP( $request->getSourceIP() ) ) {
			throw new MWOAuthException( 'mwoauthdatastore-bad-source-ip' );
		}
	}

	/**
	 * The user has authorized the request by this consumer, with this request token. Update
	 * everything so that the consumer can swap the request token for an access token. Then
	 * generate the callback URL where we will redirect our user back to the consumer.
	 * @param String $consumerKey
	 * @param String $requestTokenKey
	 * @param \User $mwUser user authorizing the request (local user)
	 * @param bool $update update the grants/wiki to those requested by consumer
	 * @return String the callback URL to redirect the user
	 * @throws MWOAuthException
	 */
	public function authorize( $consumerKey, $requestTokenKey, \User $mwUser, $update ) {
		global $wgBlockDisablesLogin;

		// Check that user and consumer are in good standing
		if ( $mwUser->isLocked() || $wgBlockDisablesLogin && $mwUser->isBlocked() ) {
			throw new MWOAuthException( 'mwoauthserver-insufficient-rights', [
				\Message::rawParam( \Linker::makeExternalLink(
					'https://www.mediawiki.org/wiki/Help:OAuth/Errors#E007',
					'E007',
					true
				) )
			] );
		}
		$consumer = $this->data_store->lookup_consumer( $consumerKey );
		if ( !$consumer || $consumer->get( 'deleted' ) ) {
			throw new MWOAuthException( 'mwoauthserver-bad-consumer-key', [
				\Message::rawParam( \Linker::makeExternalLink(
					'https://www.mediawiki.org/wiki/Help:OAuth/Errors#E006',
					'E006',
					true
				) )
			] );
		} elseif ( !$consumer->isUsableBy( $mwUser ) ) {
			$owner = MWOAuthUtils::getCentralUserNameFromId(
				$consumer->get( 'userId' ),
				$mwUser
			);
			throw new MWOAuthException(
				'mwoauthserver-bad-consumer',
				[ $consumer->get( 'name' ), MWOAuthUtils::getCentralUserTalk( $owner ), \Message::rawParam(
					\Linker::makeExternalLink(
						'https://www.mediawiki.org/wiki/Help:OAuth/Errors#E005',
						'E005',
						true
					)
				) ]
			);
		} elseif ( $consumer->get( 'ownerOnly' ) ) {
			throw new MWOAuthException( 'mwoauthserver-consumer-owner-only', [
				$consumer->get( 'name' ),
				\SpecialPage::getTitleFor(
					'OAuthConsumerRegistration', 'update/' . $consumer->get( 'consumerKey' )
				),
				\Message::rawParam( \Linker::makeExternalLink(
					'https://www.mediawiki.org/wiki/Help:OAuth/Errors#E010',
					'E010',
					true
				) )
			] );
		}

		// Generate and Update the tokens:
		// * Generate a new Verification code, and add it to the request token
		// * Either add or update the authorization
		// ** Generate a new access token if this is a new authorization
		// * Resave request token with the access token

		$verifyCode = \MWCryptRand::generateHex( 32, true );
		$requestToken = $this->data_store->lookup_token( $consumer, 'request', $requestTokenKey );
		if ( !$requestToken || !( $requestToken instanceof MWOAuthToken ) ) {
			throw new MWOAuthException( 'mwoauthserver-invalid-request-token' );
		}
		$requestToken->addVerifyCode( $verifyCode );

		// CentralAuth may abort here if there is no global account for this user
		$centralUserId = MWOAuthUtils::getCentralIdFromLocalUser( $mwUser );
		if ( !$centralUserId ) {
			$userMsg = MWOAuthUtils::getSiteMessage( 'mwoauthserver-invalid-user' );
			throw new MWOAuthException( $userMsg, [ $consumer->get( 'name' ), \Message::rawParam(
				\Linker::makeExternalLink(
					'https://www.mediawiki.org/wiki/Help:OAuth/Errors#E008',
					'E008',
					true
				)
			) ] );
		}

		// Authorization Token
		$dbw = MWOAuthUtils::getCentralDB( DB_MASTER );

		// Check if this authorization exists
		$cmra = $this->getCurrentAuthorization( $mwUser, $consumer, wfWikiId() );

		if ( $update ) {
			// This should be an update to an existing authorization
			if ( !$cmra ) {
				// update requested, but no existing key
				throw new MWOAuthException( 'mwoauthserver-invalid-request' );
			}
			$cmra->setFields( [
				'wiki'   => $consumer->get( 'wiki' ),
				'grants' => $consumer->get( 'grants' )
			] );
			$cmra->save( $dbw );
			$accessToken = new MWOAuthToken( $cmra->get( 'accessToken' ), '' );
		} elseif ( !$cmra ) {
			// Add the Authorization to the database
			$accessToken = MWOAuthDataStore::newToken();
			$cmra = MWOAuthConsumerAcceptance::newFromArray( [
				'id'           => null,
				'wiki'         => $consumer->get( 'wiki' ),
				'userId'       => $centralUserId,
				'consumerId'   => $consumer->get( 'id' ),
				'accessToken'  => $accessToken->key,
				'accessSecret' => $accessToken->secret,
				'grants'       => $consumer->get( 'grants' ),
				'accepted'     => wfTimestampNow()
			] );
			$cmra->save( $dbw );
		} else {
			// Authorization exists, no updates requested, so no changes to the db
			$accessToken = new MWOAuthToken( $cmra->get( 'accessToken' ), '' );
		}

		$requestToken->addAccessKey( $accessToken->key );
		$this->data_store->updateRequestToken( $requestToken, $consumer );
		$this->logger->debug( "Verification code {$requestToken->getVerifyCode()} for " .
			"$requestTokenKey (client: $consumerKey)" );
		return $consumer->generateCallbackUrl(
			$this->data_store, $requestToken->getVerifyCode(), $requestTokenKey
		);
	}

	/**
	 * Attempts to find an authorization by this user for this consumer. Since a user can
	 * accept a consumer multiple times (once for "*" and once for each specific wiki),
	 * there can several access tokens per-wiki (with varying grants) for a consumer.
	 * This will choose the most wiki-specific access token. The precedence is:
	 * a) The acceptance for wiki X if the consumer is applicable only to wiki X
	 * b) The acceptance for wiki $wikiId (if the consumer is applicable to it)
	 * c) The acceptance for wikis "*" (all wikis)
	 *
	 * Users might want more grants on some wikis than on "*". Note that the reverse would not
	 * make sense, since the consumer could just use the "*" acceptance if it has more grants.
	 *
	 * @param \User $mwUser (local wiki user) User who may or may not have authorizations
	 * @param MWOAuthConsumer $consumer
	 * @param string $wikiId
	 * @throws MWOAuthException
	 * @return MWOAuthConsumerAcceptance
	 */
	public function getCurrentAuthorization( \User $mwUser, $consumer, $wikiId ) {
		$dbr = MWOAuthUtils::getCentralDB( DB_REPLICA );

		$centralUserId = MWOAuthUtils::getCentralIdFromLocalUser( $mwUser );
		if ( !$centralUserId ) {
			$userMsg = MWOAuthUtils::getSiteMessage( 'mwoauthserver-invalid-user' );
			throw new MWOAuthException( $userMsg, [ $consumer->get( 'name' ), \Message::rawParam(
				\Linker::makeExternalLink(
					'https://www.mediawiki.org/wiki/Help:OAuth/Errors#E008',
					'E008',
					true
				)
			) ] );
		}

		$checkWiki = $consumer->get( 'wiki' ) !== '*' ? $consumer->get( 'wiki' ) : $wikiId;

		$cmra = MWOAuthConsumerAcceptance::newFromUserConsumerWiki(
			$dbr,
			$centralUserId,
			$consumer,
			$checkWiki
		);
		if ( !$cmra ) {
			$cmra = MWOAuthConsumerAcceptance::newFromUserConsumerWiki(
				$dbr,
				$centralUserId,
				$consumer,
				'*'
			);
		}
		return $cmra;
	}
}
