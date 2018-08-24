#!/bin/sh
# Define env
export MW_INSTALL_PATH=/var/www/html

# Add open-id plugin
# https://www.mediawiki.org/wiki/Extension:OpenID
php $MW_INSTALL_PATH/maintenance/update.php --quick


# Elasticsearch
# Delete $wgSearchType if exists
sed -i -n "/\$wgSearchType = 'CirrusSearch';/d" $MW_INSTALL_PATH/LocalSettings.php

# Add $wgDisableSearchUpdate to LocalSettings.php
sed -i -n '$ a \$wgDisableSearchUpdate = true;' $MW_INSTALL_PATH/LocalSettings.php

# Generate Elasticsearch index
php $MW_INSTALL_PATH/extensions/CirrusSearch/maintenance/updateSearchIndexConfig.php

# Remove $wgDisableSearchUpdate from LocalSettings.php
sed -i -n '/\$wgDisableSearchUpdate = true;/d' $MW_INSTALL_PATH/LocalSettings.php

php $MW_INSTALL_PATH/extensions/CirrusSearch/maintenance/forceSearchIndex.php --skipLinks --indexOnSkip
php $MW_INSTALL_PATH/extensions/CirrusSearch/maintenance/forceSearchIndex.php --skipParse

# Add $wgSearchType to LocalSettings.php
sed -i -n "$ a \$wgSearchType = 'CirrusSearch';" $MW_INSTALL_PATH/LocalSettings.php

# Start
apachectl -e info -D FOREGROUND
