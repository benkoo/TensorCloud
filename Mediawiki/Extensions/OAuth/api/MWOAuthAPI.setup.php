<?php

namespace MediaWiki\Extensions\OAuth;

/**
 * Class containing hooked functions for an OAuth environment
 */
class MWOAuthAPISetup {
	const TTL_REFRESH_WINDOW = 600; // refresh if expiring in 10 minutes

	/**
	 * Prevent CentralAuth from issuing centralauthtokens if we have
	 * OAuth headers in this request.
	 * @return bool
	 */
	public static function onCentralAuthAbortCentralAuthToken() {
		$request = \RequestContext::getMain()->getRequest();
		if ( MWOAuthUtils::hasOAuthHeaders( $request ) ) {
			return false;
		}
		return true;
	}

	/**
	 * Prevent redirects to canonical titles, since that's not what the OAuth
	 * request signed.
	 * @param WebRequest $request
	 * @param Title $title
	 * @param OutputPage $output
	 * @return bool
	 */
	public static function onTestCanonicalRedirect( $request, $title, $output ) {
		if ( MWOAuthUtils::hasOAuthHeaders( $request ) ) {
			return false;
		}
		return true;
	}
}
