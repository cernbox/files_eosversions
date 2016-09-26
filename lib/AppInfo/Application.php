<?php

namespace OCA\Files_EosVersions\AppInfo;

use OCP\AppFramework\App;
use OCP\Util;

class Application extends App {
	public function __construct(array $urlParams = array()) {
		parent::__construct('files_eosversions', $urlParams);
	}

	/**
	 * Load additional scripts when the files app is visible
	 */
	public static function onLoadFilesAppScripts() {
		Util::addScript('files_eosversions', 'versionmodel');
		Util::addScript('files_eosversions', 'versioncollection');
		Util::addScript('files_eosversions', 'versionstabview');
		Util::addScript('files_eosversions', 'filesplugin');
	}
}
