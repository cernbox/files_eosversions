(function() {
	OCA.EosVersions = OCA.EosVersions || {};

	/**
	 * @namespace
	 */
	OCA.EosVersions.Util = {
		/**
		 * Initialize the versions plugin.
		 *
		 * @param {OCA.Files.FileList} fileList file list to be extended
		 */
		attach: function(fileList) {
			if (fileList.id === 'trashbin' || fileList.id === 'files.public') {
				return;
			}

			fileList.registerTabView(new OCA.EosVersions.VersionsTabView('versionsTabView', {order: -10}));
		}
	};
})();

OC.Plugins.register('OCA.Files.FileList', OCA.EosVersions.Util);

