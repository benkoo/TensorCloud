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
