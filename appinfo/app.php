<?php
\OCP\Util::addStyle('files_eosversions', 'versions');

$eventDispatcher = \OC::$server->getEventDispatcher();
$eventDispatcher->addListener('OCA\Files::loadAdditionalScripts', ['OCA\Files_EosVersions\AppInfo\Application', 'onLoadFilesAppScripts']);

