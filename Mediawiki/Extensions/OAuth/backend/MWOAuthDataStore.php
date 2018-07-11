<?php

namespace MediaWiki\Extensions\OAuth;

use MediaWiki\Logger\LoggerFactory;
use Wikimedia\Rdbms\DBConnRef;

class MWOAuthDataStore extends OAuthDataStore {
	/** @var DBConnRef DB for the consumer/grant registry */
	protected $centralSlave;
	/** @var DBConnRef|null Master DB for repeated lookup in case of replication lag problems;
	 *    null if there is no separate master and slave DB */
	protected $centralMaster;
	/** @var \BagOStuff Cache for Tokens and Nonces */
	protected $cache;

	/** @var \\Psr\\Log\\LoggerInterface */
	protected $logger;

	/**
	 * @param DBConnRef $centralSlave Central DB slave
	 * @param DBConnRef|null $centralMaster Central DB master (if different)
	 * @param \BagOStuff $cache
	 */
	public function __construct( DBConnRef $centralSlave, $centralMaster, \BagOStuff $cache ) {
		if ( $centralMaster !== null && !( $centralMaster instanceof DBConnRef ) ) {
			throw new \InvalidArgumentException(
				__METHOD__ . ': $centralMaster must be a DB or null'
			);
		}
		$this->centralSlave = $centralSlave;
		$this->centralMaster = $centralMaster;
		$this->cache = $cache;
		$this->logger = LoggerFactory::getInstance( 'OAuth' );
	}

	/**
	 * Get an MWOAuthConsumer from the consumer's key
	 *
	 * @param String $consumerKey the string value of the Consumer's key
	 * @return MWOAuthConsumer|bool
	 */
	public function lookup_consumer( $consumerKey ) {
		return MWOAuthConsumer::newFromKey( $this->centralSlave, $consumerKey );
	}

	/**
	 * Get either a request or access token from the data store
	 *
	 * @param OAuthConsumer|MWOAuthConsumer $consumer
	 * @param string $token_type
	 * @param string $token String the token
	 * @throws MWOAuthException
	 * @return MWOAuthToken
	 */
	public function lookup_token( $consumer, $token_type, $token ) {
		$this->logger->debug( __METHOD__ . ": Looking up $token_type token '$token'" );

		if ( $token_type === 'request' ) {
			$returnToken = $this->cache->get( MWOAuthUtils::getCacheKey(
				'token',
				$consumer->key,
				$token_type,
				$token
			) );
			if ( $returnToken === '**USED**' ) {
				throw new MWOAuthException( 'mwoauthdatastore-request-token-already-used', [
					\Message::rawParam( \Linker::makeExternalLink(
						'https://www.mediawiki.org/wiki/Help:OAuth/Errors#E009',
						'E009',
						true
					) )
				] );
			}
			if ( $token === null || !( $returnToken instanceof MWOAuthToken ) ) {
				throw new MWOAuthException( 'mwoauthdatastore-request-token-not-found', [
					\Message::rawParam( \Linker::makeExternalLink(
						'https://www.mediawiki.org/wiki/Help:OAuth/Errors#E004',
						'E004',
						true
					) )
				] );
			}
		} elseif ( $token_type === 'access' ) {
			$cmra = MWOAuthConsumerAcceptance::newFromToken( $this->centralSlave, $token );
			if ( !$cmra && $this->centralMaster ) {
				// try master in case there is replication lag T124942
				$cmra = MWOAuthConsumerAcceptance::newFromToken( $this->centralMaster, $token );
			}
			if ( !$cmra ) {
				throw new MWOAuthException( 'mwoauthdatastore-access-token-not-found' );
			}

			// Ensure the cmra's consumer matches the expected consumer (T103023)
			$mwconsumer = ( $consumer instanceof MWOAuthConsumer )
				? $consumer : $this->lookup_consumer( $consumer->key );
			if ( !$mwconsumer || $mwconsumer->get( 'id' ) !== $cmra->get( 'consumerId' ) ) {
				throw new MWOAuthException( 'mwoauthdatastore-access-token-not-found' );
			}

			$secret = MWOAuthUtils::hmacDBSecret( $cmra->get( 'accessSecret' ) );
			$returnToken = new MWOAuthToken( $cmra->get( 'accessToken' ), $secret );
		} else {
			throw new MWOAuthException( 'mwoauthdatastore-invalid-token-type' );
		}

		return $returnToken;
	}

	/**
	 * Check that nonce has not been seen before. Add it on check, so we don't repeat it.
	 * Note, timestamp has already been checked, so this should be a fresh nonce.
	 *
	 * @param MWOAuthConsumer|OAuthConsumer $consumer
	 * @param String $token
	 * @param String $nonce
	 * @param int $timestamp
	 * @return bool
	 */
	public function lookup_nonce( $consumer, $token, $nonce, $timestamp ) {
		$key = MWOAuthUtils::getCacheKey( 'nonce', $consumer->key, $token, $nonce );
		// Do an add for the key associated with this nonce to check if it was already used.
		// Set timeout 5 minutes in the future of the timestamp as OAuthServer does. Use the
		// timestamp so the client can also expire their nonce records after 5 mins.
		if ( !$this->cache->add( $key, 1, $timestamp + 300 ) ) {
			$this->logger->info( "$key exists, so nonce has been used by this consumer+token" );
			return true;
		}
		return false;
	}

	/**
	 * Helper function to generate and return an MWOAuthToken. MWOAuthToken can be used as a
	 * request or access token.
	 * TODO: put in Utils?
	 * @return MWOAuthToken
	 */
	public static function newToken() {
		return new MWOAuthToken(
			\MWCryptRand::generateHex( 32, false ), // the key doesn't need to be unpredictable
			\MWCryptRand::generateHex( 32, true )
		);
	}

	/**
	 * Generate a new token (attached to this consumer), save it in the cache, and return it
	 *
	 * @param MWOAuthConsumer|OAuthConsumer $consumer
	 * @param string $callback
	 * @return MWOAuthToken
	 */
	public function new_request_token( $consumer, $callback = 'oob' ) {
		$token = self::newToken();
		$cacheConsumerKey = MWOAuthUtils::getCacheKey( 'consumer', 'request', $token->key );
		$cacheTokenKey = MWOAuthUtils::getCacheKey(
			'token', $consumer->key, 'request', $token->key
		);
		$cacheCallbackKey = MWOAuthUtils::getCacheKey(
			'callback', $consumer->key, 'request', $token->key
		);
		$this->cache->add( $cacheConsumerKey, $consumer->key, 600 ); // 10 minutes. Kindof arbitray.
		$this->cache->add( $cacheTokenKey, $token, 600 ); // 10 minutes. Kindof arbitray.
		$this->cache->add( $cacheCallbackKey, $callback, 600 ); // 10 minutes. Kindof arbitray.
		$this->logger->debug( __METHOD__ .
			": New request token {$token->key} for {$consumer->key} with callback {$callback}" );
		return $token;
	}

	/**
	 * Return a consumer key associated with the given request token.
	 *
	 * @param MWOAuthToken $requestToken the request token
	 * @return string|false the consumer key or false if nothing is stored for the request token
	 */
	public function getConsumerKey( $requestToken ) {
		$cacheKey = MWOAuthUtils::getCacheKey( 'consumer', 'request', $requestToken );
		$consumerKey = $this->cache->get( $cacheKey );
		return $consumerKey;
	}

	/**
	 * Return a stored callback URL parameter given by the consumer in /initiate.
	 * It throws an exception if callback URL parameter does not exist in the cache.
	 * A stored callback URL parameter is deleted from the cache once read for the first
	 * time.
	 *
	 * @param string $consumerKey the consumer key
	 * @param string $requestKey original request key from /initiate
	 * @throws MWOAuthException
	 * @return string|false the stored callback URL parameter
	 */
	public function getCallbackUrl( $consumerKey, $requestKey ) {
		$cacheKey = MWOAuthUtils::getCacheKey( 'callback', $consumerKey, 'request', $requestKey );
		$callback = $this->cache->get( $cacheKey );
		if ( $callback === null || !is_string( $callback ) ) {
			throw new MWOAuthException( 'mwoauthdatastore-callback-not-found' );
		}
		$this->cache->delete( $cacheKey );
		return $callback;
	}

	/**
	 * Return a new access token attached to this consumer for the user associated with this
	 * token if the request token is authorized. Should also invalidate the request token.
	 *
	 * @param MWOAuthToken $token the request token that started this
	 * @param OAuthConsumer $consumer
	 * @param int|null $verifier
	 * @throws MWOAuthException
	 * @return MWOAuthToken the access token
	 */
	public function new_access_token( $token, $consumer, $verifier = null ) {
		$this->logger->debug( __METHOD__ .
			": Getting new access token for token {$token->key}, consumer {$consumer->key}" );

		if ( !$token->getVerifyCode() || !$token->getAccessKey() ) {
			throw new MWOAuthException( 'mwoauthdatastore-bad-token' );
		} elseif ( $token->getVerifyCode() !== $verifier ) {
			throw new MWOAuthException( 'mwoauthdatastore-bad-verifier' );
		}

		$cacheKey = MWOAuthUtils::getCacheKey( 'token',
			$consumer->get( 'consumerKey' ), 'request', $token->key );
		$accessToken = $this->lookup_token( $consumer, 'access', $token->getAccessKey() );
		$this->cache->set( $cacheKey, '**USED**', 600 );
		$this->logger->debug( __METHOD__ .
			": New access token {$accessToken->key} for {$consumer->key}" );
		return $accessToken;
	}

	/**
	 * Update a request token. The token probably already exists, but had another attribute added.
	 *
	 * @param MWOAuthToken $token the token to store
	 * @param MWOAuthConsumer|OAuthConsumer $consumer
	 */
	public function updateRequestToken( $token, $consumer ) {
		$cacheKey = MWOAuthUtils::getCacheKey( 'token', $consumer->key, 'request', $token->key );
		$this->cache->set( $cacheKey, $token, 600 ); // 10 more minutes. Kindof arbitray.
	}

	/**
	 * Return the string representing the Consumer's public RSA key
	 *
	 * @param String $consumerKey the string value of the Consumer's key
	 * @return String|null
	 */
	public function getRSAKey( $consumerKey ) {
		$cmr = MWOAuthConsumer::newFromKey( $this->centralSlave, $consumerKey );
		return $cmr ? $cmr->get( 'rsaKey' ) : null;
	}
}
