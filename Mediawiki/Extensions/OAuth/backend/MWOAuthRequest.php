<?php

namespace MediaWiki\Extensions\OAuth;

use MediaWiki\Logger\LoggerFactory;

/**
 * @file
 * @ingroup OAuth
 *
 * @license GPL-2.0-or-later
 * @author Chris Steipp
 */

class MWOAuthRequest extends OAuthRequest {
	private $sourceIP;

	public function __construct( $httpMethod, $httpUrl, $parameters, $sourcIP=false ) {
		$this->sourceIP = $sourcIP;
		parent::__construct( $httpMethod, $httpUrl, $parameters );
	}

	public function getConsumerKey() {
		$key = '';
		if ( isset( $this->parameters['oauth_consumer_key'] ) ) {
			$key = $this->parameters['oauth_consumer_key'];
		}
		return $key;
	}

	/**
	 * Track the source IP of the request, so we can enforce the IP whitelist
	 * @return String $ip the ip of the source
	 */
	public function getSourceIP() {
		return $this->sourceIP;
	}

	public static function fromRequest( \WebRequest $request ) {
		$httpMethod = strtoupper( $request->getMethod() );
		$httpUrl = $request->getFullRequestURL();
		$logger = LoggerFactory::getInstance( 'OAuth' );

		// Find request headers
		$requestHeaders = MWOAuthUtils::getHeaders();

		// Parse the query-string to find GET parameters
		$parameters = $request->getQueryValues();

		// It's a POST request of the proper content-type, so parse POST
		// parameters and add those overriding any duplicates from GET
		if ( $request->wasPosted()
			&& isset( $requestHeaders['Content-Type'] )
			&& strpos(
				$requestHeaders['Content-Type'],
				'application/x-www-form-urlencoded'
			) === 0
		) {
			$postData = OAuthUtil::parse_parameters( $request->getRawPostString() );
			$logger->debug( __METHOD__ . ': Post String = ' . $request->getRawPostString() );
			$parameters = array_merge( $parameters, $postData );
		}

		// We have a Authorization-header with OAuth data. Parse the header
		// and add those overriding any duplicates from GET or POST
		if ( isset( $requestHeaders['Authorization'] )
			&& substr( $requestHeaders['Authorization'], 0, 6 ) == 'OAuth '
		) {
			$headerParameters = OAuthUtil::split_header(
				$requestHeaders['Authorization']
			);
			$parameters = array_merge( $parameters, $headerParameters );
		}
		$logger->debug( __METHOD__ . ": parameters:\n" . print_r( $parameters, true ) );

		return new self( $httpMethod, $httpUrl, $parameters, $request->getIP() );
	}
}
