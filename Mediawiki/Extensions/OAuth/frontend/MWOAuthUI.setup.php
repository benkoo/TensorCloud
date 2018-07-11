<?php

namespace MediaWiki\Extensions\OAuth;

/**
 * Class containing hooked functions for an OAuth environment
 */
class MWOAuthUISetup {
	/**
	 * @return void
	 */
	public static function conditionalSetup() {
		global $wgLogTypes, $wgLogNames,
			$wgLogHeaders, $wgLogActionsHandlers;

		if ( MWOAuthUtils::isCentralWiki() ) {
			$wgLogTypes[] = 'mwoauthconsumer';
			$wgLogNames['mwoauthconsumer'] = 'mwoauthconsumer-consumer-logpage';
			$wgLogHeaders['mwoauthconsumer'] = 'mwoauthconsumer-consumer-logpagetext';
			$wgLogActionsHandlers['mwoauthconsumer/*'] = MWOAuthLogFormatter::class;
		}
	}
}
