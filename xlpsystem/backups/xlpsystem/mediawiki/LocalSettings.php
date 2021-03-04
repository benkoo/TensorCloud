<?php
# This file was automatically generated by the MediaWiki 1.31.0
# installer. If you make manual changes, please keep track in case you
# need to recreate them later.
#
# See includes/DefaultSettings.php for all configurable settings
# and their default values, but don't forget to make changes in _this_
# file, not there.
#
# Further documentation for configuration settings may be found at:
# https://www.mediawiki.org/wiki/Manual:Configuration_settings

# Protect against web entry
if ( !defined( 'MEDIAWIKI' ) ) {
  exit;
}


## Uncomment this to disable output compression
# $wgDisableOutputCompression = true;

$wgSitename = "XLP_wiki";
$wgMetaNamespace = "XLP_wiki";

## The URL base path to the directory containing the wiki;
## defaults for all runtime URL paths are based off of this.
## For more information on customizing the URLs
## (like /w/index.php/Page_title to /wiki/Page_title) please see:
## https://www.mediawiki.org/wiki/Manual:Short_URL
$wgScriptPath = "";

## The protocol and server name to use in fully-qualified URLs
$wgServer = "http://localhost:801";

## The URL path to static resources (images, scripts, etc.)
$wgResourceBasePath = $wgScriptPath;

## The URL path to the logo.  Make sure you change this from the default,
## or else you'll overwrite your logo when you upgrade!
$wgLogo = "$wgResourceBasePath/resources/assets/toyhouse.png";

## UPO means: this is also a user preference option

$wgEnableEmail = true;
$wgEnableUserEmail = true; # UPO

$wgEmergencyContact = "apache@localhost";
$wgPasswordSender = "apache@localhost";

$wgEnotifUserTalk = false; # UPO
$wgEnotifWatchlist = false; # UPO
$wgEmailAuthentication = true;

## Database settings
$wgDBtype = "mysql";
$wgDBserver = "mariadb";
$wgDBname = "neet_wiki";
$wgDBuser = "root";
$wgDBpassword = "W2qgpsLtQt";

# MySQL specific settings
$wgDBprefix = "";

# MySQL table options to use during installation or update
$wgDBTableOptions = "ENGINE=InnoDB, DEFAULT CHARSET=binary";

## Shared memory settings
$wgMainCacheType = CACHE_NONE;
$wgMemCachedServers = [];

## To enable image uploads, make sure the 'images' directory
## is writable, then set this to true:
$wgEnableUploads = true;
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "/usr/bin/convert";

## upload file extensions
$wgFileExtensions = array_merge( $wgFileExtensions,
    array( 'doc', 'xls', 'mpp', 'pdf', 'ppt', 'pptx', 'xlsx', 'docx', 'jpg',
        'tiff', 'odt', 'odg', 'ods', 'odp', 'xmind', 'zip'
    )
);

$wgMaxUploadSize = 104857600;

# InstantCommons allows wiki to use images from https://commons.wikimedia.org
$wgUseInstantCommons = false;

# Periodically send a pingback to https://www.mediawiki.org/ with basic data
# about this MediaWiki instance. The Wikimedia Foundation shares this data
# with MediaWiki developers to help guide future development efforts.
$wgPingback = true;

## If you use ImageMagick (or any other shell command) on a
## Linux server, this will need to be set to the name of an
## available UTF-8 locale
$wgShellLocale = "C.UTF-8";

## Set $wgCacheDirectory to a writable directory on the web server
## to make your wiki go slightly faster. The directory should not
## be publically accessible from the web.
#$wgCacheDirectory = "$IP/cache";

# Site language code, should be one of the list in ./languages/data/Names.php
$wgLanguageCode = "en";

$wgSecretKey = "c3f2884a2fe1fd40ea505f1c218e043ae52c0e8feff1537b9bcee066e62adb3f";

# Changing this will log out all existing sessions.
$wgAuthenticationTokenVersion = "1";

# Site upgrade key. Must be set to a string (default provided) to turn on the
# web installer while LocalSettings.php is in place
$wgUpgradeKey = "e18756f9b786dc82";

## For attaching licensing metadata to pages, and displaying an
## appropriate copyright notice / icon. GNU Free Documentation
## License and Creative Commons licenses are supported so far.
$wgRightsPage = ""; # Set to the title of a wiki page that describes your license/copyright
$wgRightsUrl = "";
$wgRightsText = "";
$wgRightsIcon = "";

# Path to the GNU diff3 utility. Used for conflict resolution.
$wgDiff3 = "/usr/bin/diff3";

## Default skin: you can change the default skin. Use the internal symbolic
## names, ie 'vector', 'monobook':
$wgDefaultSkin = "vector";

# Enabled skins.
# The following skins were automatically enabled:
wfLoadSkin( 'MonoBook' );
wfLoadSkin( 'Timeless' );
wfLoadSkin( 'Vector' );


# End of automatically generated settings.
# Add more configuration options below.


# Matomo
# if using matomo, need to modify these info
wfLoadExtension( 'Piwik' );
$wgPiwikURL = "localhost:802";
$wgPiwikIDSite = "1";


// ##Oauth
// $wgInvalidUsernameCharacters = '';
// wfLoadExtension( 'MW-OAuth2Client' );
// $wgOAuth2Client['client']['id']     = 'T8mEKn9rH9fCTDOej92QM27ljEXhn1NCL0HjSPEM'; // The client ID assigned to you by the provider
// $wgOAuth2Client['client']['secret'] = 'phQUTZcoWrliUu19kjfhcyl2sKy9G9JK8rab8Dmw'; // The client secret assigned to you by the provider
// $wgOAuth2Client['configuration']['authorize_endpoint']     = 'http://hotbackup.toyhouse.cc:81//oauth/authorize'; // Authorization URL
// $wgOAuth2Client['configuration']['access_token_endpoint']  = 'http://hotbackup.toyhouse.cc:81//oauth/token'; // Token URL
// $wgOAuth2Client['configuration']['api_endpoint']           = 'http://hotbackup.toyhouse.cc:81//oauth/me'; // URL to fetch user JSON
// $wgOAuth2Client['configuration']['redirect_uri']           = 'http://hotbackup.toyhouse.cc:801/index.php/Special:OAuth2Client/callback'; // URL for OAuth2 server to redirect to,

// $wgOAuth2Client['configuration']['username'] = 'user_login'; // JSON path to username
// $wgOAuth2Client['configuration']['email'] = 'user_email'; // JSON path to email
// $wgOAuth2Client['configuration']['http_bearer_token'] = 'Bearer'; // Token to use in HTTP Authentication
// $wgOAuth2Client['configuration']['query_parameter_token'] = 'access_token'; // query parameter to use
// //$wgOAuth2Client['configuration']['scopes'] = 'read_citizen_info'; //Permissions
// $wgOAuth2Client['configuration']['service_name'] = 'Oauth Registry'; // the name of your service
// $wgOAuth2Client['configuration']['service_login_link_text'] = 'OAuth2Login'; // the text of the login link


# Elastica
wfLoadExtension( 'Elastica' );

# Show exception details
$wgShowExceptionDetails = true;

# CirrusSearch
require_once( "$IP/extensions/CirrusSearch/CirrusSearch.php" );
$wgCirrusSearchServers = [ 'elasticsearch'];
$wgSearchType = 'CirrusSearch';
