<?php

OCP\JSON::checkLoggedIn();
OCP\JSON::checkAppEnabled('files_eosversions');
OCP\JSON::callCheck();

$username = \OC::$server->getUserSession()->getUser()->getUID();
$instanceManager = \OC::$server->getCernBoxEosInstanceManager();

// $source is: /test/sideview-triggers-sharing.png
// hint: it is not prefixed with 'files'.
$file = (string)$_GET['file'];

// $revision is the revision number => 1474556733.0b4737e7
$revision= $_GET['revision'];

$filename = 'files' . $file;
$ok = $instanceManager->rollbackFileToVersion($username, $filename, $revision);
if($ok) {
	OCP\JSON::success(array("data" => array( "revision" => $revision, "file" => $file )));
} else {
	$l = \OC::$server->getL10N('files_versions');
	OCP\JSON::error(array("data" => array( "message" => $l->t("Could not revert: %s", array($file) ))));
}
