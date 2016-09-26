<?php

OCP\JSON::checkLoggedIn();
OCP\JSON::callCheck();
OCP\JSON::checkAppEnabled('files_eosversions');

$username = \OC::$server->getUserSession()->getUser()->getUID();
$instanceManager = \OC::$server->getCernBoxEosInstanceManager();

// $source is: /test/sideview-triggers-sharing.png
// hint: it is not prefixed with 'files'.
$source = (string)$_GET['source'];

// start is the offset like 0, 100, 200 ...
// we flush all versions at once so we don't care about the offset
$start = (int)$_GET['start'];


$filename = 'files' . $source;
$versions = $instanceManager->getVersionsForFile($username, $filename);

$formattedVersions = array();
foreach($versions as $version) {
	$key = $version['revision'] . "#" . $source;
	$version['cur'] = 0;
	$version['path'] = $source;
	$version['version'] = $version['revision'];
	$version['name'] = basename($source);
	$formattedVersions[$key] = $version;
}

\OCP\JSON::success(array('data' => array('versions' => $formattedVersions, 'endReached' => true)));
