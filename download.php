<?php
OCP\JSON::checkAppEnabled('files_eosversions');
OCP\JSON::checkLoggedIn();

$username = \OC::$server->getUserSession()->getUser()->getUID();
$instanceManager = \OC::$server->getCernBoxEosInstanceManager();

$file = $_GET['file'];
$revision= $_GET['revision'];
$filename = 'files' . $file;

$entry = $instanceManager->get($username, $filename);

if($entry) {
	header('Content-Type:'.$entry->getMimeType());
	OCP\Response::setContentDispositionHeader(basename($filename), 'attachment');
	OCP\Response::disableCaching();
	OCP\Response::setContentLengthHeader($entry->getSize());

	@ob_end_clean();
	$handle = $instanceManager->downloadVersion($username, $filename, $revision);
	if ($handle) {
		$chunkSize = 8192; // 8 kB chunks
		while (!feof($handle)) {
			echo fread($handle, $chunkSize);
			flush();
		}
	}
} else {
	header("HTTP/1.0 404 Not Found");
	exit;
}
