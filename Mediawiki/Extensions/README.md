## Math(include Latex):

https://www.mediawiki.org/wiki/Extension:Math

https://www.siteground.com/tutorials/mediawiki/math/

And verify it : http://0.0.0.0:4444/index.php/Special:Version

First Step:

Upload Math folder to DOCKER_ID /opt/bitnami/mediawiki/extensions

Second Step:

Add following extensions to LocalSettings.php
```
require_once "$IP/extensions/Math/Math.php";
```

and

```
$wgDefaultUserOptions['math'] = 'mathml';
$wgMathFullRestbaseURL = 'https://en.wikipedia.org/api/rest_';
```

Last Step, PHP update:

```
$php /opt/bitnami/mediawiki/maintenance/update.php
```

Insert to wiki for testing:

```
<math>E=mc^2</math>
<math>u'' + p(x)u' + q(x)u=f(x),\quad x>a</math>
<math>\lim_{z\rightarrow z_0} f(z)=f(z_0)</math>
```

## Updated Filetypes acceptance: 
Following files should now be accepted in file upload: 'png', 'gif', 'jpg', 'jpeg', 'jp2', 'webp', 'ppt', 'pdf', 'psd',
    'mp3', 'xls', 'xlsx', 'swf', 'doc','docx', 'odt', 'odc', 'odp', 'odg', 'mpp'


## Piwik
```
require_once "$IP/extensions/Piwik/Piwik.php";
$wgPiwikURL = "docker.toyhouse.cc";//without http protocal
$wgPiwikIDSite = "2";
```
## OpenID/OAuth2.0

### OAuthServer

Wordpress plugin: https://wp-oauth.com

### OAuthClient

Mediawiki extension: https://github.com/Schine/MW-OAuth2Client

To get the extension to work w/ Wordpress as OAuthServer, two files need to change. 

1. <code>/opt/bitnami/mediawiki/extensions/MW-OAuth2Client/SpecialOAuth2Client.php</code>

Search for the following two lines (towards the bottom):
```
 $username = $response['user'][$wgOAuth2Client['configuration']['username']];
 $email = $response['user'][$wgOAuth2Client['configuration']['email']];
```

Then Change to:
```
 $username = $response[$wgOAuth2Client['configuration']['username']];
 $email = $response[$wgOAuth2Client['configuration']['email']];
```

2. <code>/opt/bitnami/mediawiki/LocalSettings.php</code>

Add the Following to the bottom of the file:
```
#OAuthClient
#https://www.mediawiki.org/wiki/Manual:$wgInvalidUsernameCharacters
$wgInvalidUsernameCharacters = '';
wfLoadExtension( 'MW-OAuth2Client' );

$wgOAuth2Client['client']['id']     = 'client_id_given_by_WP_OAuth_Server_Plugin'; // The client ID assigned to you by the provider
$wgOAuth2Client['client']['secret'] = 'secret_key_given_by_WP_OAuth_Server_Plugin'; // The client secret assigned to you by the pro$

$wgOAuth2Client['configuration']['authorize_endpoint']     = 'http://url_to_wordpress/oauth/authorize'; // Authorization URL
$wgOAuth2Client['configuration']['access_token_endpoint']  = 'http://url_to_wordpress/oauth/token'; // Token URL
$wgOAuth2Client['configuration']['api_endpoint']           = 'http://url_to_wordpress/oauth/me'; // URL to fetch user JSON
$wgOAuth2Client['configuration']['redirect_uri']           = 'http://url_to_mediawiki/index.php/Special:OAuth2Client/callback'; $

$wgOAuth2Client['configuration']['username'] = 'user_login'; // JSON path to username
$wgOAuth2Client['configuration']['email'] = 'user_email'; // JSON path to email

$wgOAuth2Client['configuration']['http_bearer_token'] = 'Bearer'; // Token to use in HTTP Authentication
$wgOAuth2Client['configuration']['query_parameter_token'] = 'access_token'; // query parameter to use
//$wgOAuth2Client['configuration']['scopes'] = 'read_citizen_info'; //Permissions

$wgOAuth2Client['configuration']['service_name'] = 'OAuth Registry'; // the name of your service
$wgOAuth2Client['configuration']['service_login_link_text'] = 'OAuth2Login'; // the text of the login link
```
