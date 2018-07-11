<?php

if ( PHP_SAPI !== 'cli' ) {
	die( "CLI-only test script\n" );
}

/**
 * Testing integration with MediaWiki OAuth Extension
 *
 * The current extension follows OAuth 1.0a spec and while the
 * extension works, you have to be aware of a few quirks.
 *
 * This sample is there to help you work your mind through the OAuth
 * process. Its assuming your MediaWiki installation has this extension
 * installed so you can become your own OAuth service provider. In other
 * words, users in the wiki will be able to make various APIs calls
 * to this wiki using OAuth tokens.
 *
 * PLEASE NOTE:
 *
 *   Remember that OAuth 1.0 expects that the GET Request parameters
 *   are sorted in some order, then to have it hashed.
 *
 *   In relation to MW; One known caveat is that the `$baseurl` has to
 *   be calling to your MediaWiki's `index.php` with
 *   `index.php?title=Special:OAuth` directly.
 *
 *   Otherwise the extension will return an URL that way, and will break the hash
 *   signature and you will get an error.
 */

require __DIR__ . '/../lib/OAuth.php';

/**
 * Local to this example
 *
 * Whether you want to also see
 * the objects being sent to the wire.
 */
$moreVerbose = false;

/**
 * Consumer key
 *
 * This is the application key you would
 * get from the application you want to connect
 * with your MediaWiki installation.
 */
$consumerKey = 'dpf43f3p2l4k3l03';

/**
 * Secret
 *
 * This is the generated secret key
 * that you would get when you ask.
 */
$consumerSecret = 'kd94hf93k423kf44';

/**
 * Base URL
 *
 * Set to your MediaWiki address with "index.php?title=Special:OAuth".
 *
 * Remember that its a known limitation that you cannot use pretty URLs
 * in this context.
 *
 * Ideally, you should have a SSL VirtualHost, but this test would not
 * fail if you don't have one yet.
 */
$baseurl = 'https://localhost/w/index.php?title=Special:OAuth';

/**
 * Request token (a.k.a. the first step)
 *
 * The first step starts at "Special:OAuth/initiate" from the extension.
 *
 * Note that the `oauth_callback=oob` means "Out Of Band", and we currently
 * cannot generate an URL based on headers, but from contents of the Response
 * body (hence "out of band").
 *
 * This is due to the fact that the way the extension is made, it'll return
 * something in the Response body that will need to create the link and
 * make the user validate, and get the token.
 */
$request_token_url = $baseurl . '/initiate&format=json&oauth_callback=oob';

/**
 * Validate token (a.k.a. the 2nd step)
 *
 * This is the URL you use to send back to the application
 * when that the connecting application gives you when the
 * user accepted the request.
 */
$validate_token_url = $baseurl . '/token&format=json';

/**
 * You should not need to edit anything else beyond this point
 */

// This is to allow you to work without SSL locally
$baseUrlIsSsl = (bool)preg_match( '/^https/i', $baseurl );

print <<<HELPTEXT

    Testing OAuth integration with MediaWiki.

HELPTEXT;

/**
 * First step
 */
$c = new OAuthConsumer( $consumerKey, $consumerSecret );
$parsed = parse_url( $request_token_url );
$params = [];
parse_str( $parsed['query'], $params );
$req_req = OAuthRequest::from_consumer_and_token( $c, null, "GET", $request_token_url, $params );
$hmac_method = new OAuthSignatureMethod_HMAC_SHA1();
$sig_method = $hmac_method;
$req_req->sign_request( $sig_method, $c, null );

print <<<HELPTEXT


    First step, asking for an URL to send the user to.


HELPTEXT;

echo "Calling: $req_req".PHP_EOL;

$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, (string)$req_req );
if ( $baseUrlIsSsl === true ) {
	curl_setopt( $ch, CURLOPT_PORT, 443 );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
}
curl_setopt( $ch, CURLOPT_HEADER, 0 );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
if ( $moreVerbose === true ) {
	curl_setopt( $ch, CURLOPT_VERBOSE, 1 );
}
$data = curl_exec( $ch );

if ( !$data ) {
	die( 'cURL error: ' . curl_error( $ch ) );
}

$token = json_decode( $data );

// @codingStandardsIgnoreStart
print <<<HELPTEXT

	Response body should be a JSON object with three keys:
		- key
		- secret
		- oauth_callback_confirmed

	You got: {$data}


	************************

	Step two!

	So far, we made one request and we should have what we need to get acknowledgement from the end user.

	In order to continue, we have to ask the user for a permission. With what we just did, it gave us a one-time URL to send our user to.

	The process can continue only if the user accepted it. Once accepted, MediaWiki's OAuth Extension creates an "oauth_verifier" string that you need to give for the next step.

	Now, WITH YOUR WEB BROWSER, follow this link and pass through the validation.

	Link: {$baseurl}/authorize&oauth_token={$token->key}&oauth_consumer_key={$consumerKey}


HELPTEXT;
// @codingStandardsIgnoreEnd

// ACCESS TOKEN
print 'What was the "verification value" the MediaWiki installation gave?'.PHP_EOL;
$fh = fopen( "php://stdin", "r" );
$line = fgets( $fh );

/**
 * Second step
 */
$rc = new OAuthConsumer( $token->key, $token->secret );
$parsed = parse_url( $validate_token_url );
parse_str( $parsed['query'], $params );
$params['oauth_verifier'] = trim( $line );

$acc_req = OAuthRequest::from_consumer_and_token( $c, $rc, "GET", $validate_token_url, $params );
$acc_req->sign_request( $sig_method, $c, $rc );

print <<<HELPTEXT

    Going to validate token with another Request to the backend...

HELPTEXT;

echo "Calling: $acc_req".PHP_EOL;

unset( $ch );
$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, (string)$acc_req );
if ( $baseUrlIsSsl === true ) {
	curl_setopt( $ch, CURLOPT_PORT, 443 );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
}
curl_setopt( $ch, CURLOPT_HEADER, 0 );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
if ( $moreVerbose === true ) {
	curl_setopt( $ch, CURLOPT_VERBOSE, 1 );
}
$data = curl_exec( $ch );
if ( !$data ) {
	echo 'Curl error: ' . curl_error( $ch );
}

print <<<HELPTEXT

    If all worked well, you should have a JSON object with two keys: key, secret.

    You got:

HELPTEXT;

var_dump( $data );
