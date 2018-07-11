<?php

if ( function_exists( 'wfLoadExtension' ) ) {
	wfLoadExtension( 'OAuth' );
	// Keep i18n globals so mergeMessageFileList.php doesn't break
	$wgMessagesDirs['MWOAuth'] = __DIR__ . '/i18n';
	$wgExtensionMessagesFiles['MWOAuthAliases'] = __DIR__ . '/frontend/language/MWOAuth.alias.php';
	/* wfWarn(
		'Deprecated PHP entry point used for OAuth extension. ' .
		'Please use wfLoadExtension instead, ' .
		'see https://www.mediawiki.org/wiki/Extension_registration for more details.'
	); */
	return;
} else {
	die( 'This version of the OAuth extension requires MediaWiki 1.29+' );
}
