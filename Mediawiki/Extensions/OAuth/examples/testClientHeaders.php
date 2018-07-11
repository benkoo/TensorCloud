<?php

if ( PHP_SAPI !== 'cli' ) {
	die( "CLI-only test script\n" );
}

/**
 * A basic client for overall testing
 */

require '../lib/OAuth.php';

$consumerKey = 'dpf43f3p2l4k3l03';
$consumerSecret = 'kd94hf93k423kf44';
$baseurl = 'https://localhost/wiki/index.php?title=Special:OAuth';
$endpoint = $baseurl . '/initiate&format=json&oauth_callback=oob';

$endpoint_acc = $baseurl . '/token&format=json';

$c = new OAuthConsumer( $consumerKey, $consumerSecret );
$parsed = parse_url( $endpoint );
$params = [];
parse_str( $parsed['query'], $params );
$req_req = OAuthRequest::from_consumer_and_token( $c, null, "GET", $endpoint, $params );
$hmac_method = new OAuthSignatureMethod_HMAC_SHA1();
$sig_method = $hmac_method;
$req_req->sign_request( $sig_method, $c, null );

$headers = [ $req_req->to_header() ];

echo "Calling: $endpoint\nHeader: {$headers[0]}\n\n";

$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $endpoint );
curl_setopt( $ch, CURLOPT_PORT, 443 );
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
curl_setopt( $ch, CURLOPT_HEADER, 0 );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
$data = curl_exec( $ch );

if ( !$data ) {
	echo 'Curl error: ' . curl_error( $ch );
}

echo "Returned: $data\n\n";

$token = json_decode( $data );

print "Visit $baseurl/authorize&oauth_token={$token->key}&oauth_consumer_key=$consumerKey\n";

// ACCESS TOKEN
print "Enter the verification code:\n";
$fh = fopen( "php://stdin", "r" );
$line = fgets( $fh );

$rc = new OAuthConsumer( $token->key, $token->secret );
$parsed = parse_url( $endpoint_acc );
parse_str( $parsed['query'], $params );
$params['oauth_verifier'] = trim( $line );

$acc_req = OAuthRequest::from_consumer_and_token( $c, $rc, "GET", $endpoint_acc, $params );
$acc_req->sign_request( $sig_method, $c, $rc );

echo "Calling: $acc_req\n";

unset( $ch );
$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, (string)$acc_req );
curl_setopt( $ch, CURLOPT_PORT, 443 );
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
curl_setopt( $ch, CURLOPT_HEADER, 0 );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
$data = curl_exec( $ch );
if ( !$data ) {
	echo 'Curl error: ' . curl_error( $ch );
}

echo "Returned: $data\n\n";
