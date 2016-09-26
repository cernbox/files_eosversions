<?php
namespace OCA\Files_EosVersions\AppInfo;

$application = new Application();

$this->create('files_eosversions_download', 'download.php')
	->actionInclude('files_eosversions/download.php');
$this->create('files_eosversions_ajax_getVersions', 'ajax/getVersions.php')
	->actionInclude('files_eosversions/ajax/getVersions.php');
$this->create('files_eosversions_ajax_rollbackVersion', 'ajax/rollbackVersion.php')
	->actionInclude('files_eosversions/ajax/rollbackVersion.php');

