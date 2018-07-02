## Math(include Latex):

https://www.mediawiki.org/wiki/Extension:Math

https://www.siteground.com/tutorials/mediawiki/math/

And verify it : http://0.0.0.0:4444/index.php/Special:Version


## Updated Filetypes acceptance: 
Following files should now be accepted in file upload: 'png', 'gif', 'jpg', 'jpeg', 'jp2', 'webp', 'ppt', 'pdf', 'psd',
    'mp3', 'xls', 'xlsx', 'swf', 'doc','docx', 'odt', 'odc', 'odp', 'odg', 'mpp'
## Piwik

require_once "$IP/extensions/Piwik/Piwik.php";
$wgPiwikURL = "docker.toyhouse.cc";//without http protocal
$wgPiwikIDSite = "2";
