(function() {
	/**
	 * @memberof OCA.EosVersions
	 */
	var VersionModel = OC.Backbone.Model.extend({

		/**
		 * Restores the original file to this revision
		 */
		revert: function(options) {
			options = options ? _.clone(options) : {};
			var model = this;
			var file = this.getFullPath();
			var revision = this.get('version');

			$.ajax({
				type: 'GET',
				url: OC.generateUrl('/apps/files_eosversions/ajax/rollbackVersion.php'),
				dataType: 'json',
				data: {
					file: file,
					revision: revision,
				},
				success: function(response) {
					if (response.status === 'error') {
						if (options.error) {
							options.error.call(options.context, model, response, options);
						}
						model.trigger('error', model, response, options);
					} else {
						if (options.success) {
							options.success.call(options.context, model, response, options);
						}
						model.trigger('revert', model, response, options);
					}
				}
			});
		},

		getFullPath: function() {
			return this.get('fullPath');
		},

		getPreviewUrl: function() {
			var url = OC.generateUrl('/apps/files_eosversions/preview');
			var params = {
				file: this.get('fullPath'),
				version: this.get('version')
			};
			return url + '?' + OC.buildQueryString(params);
		},

		getDownloadUrl: function() {
			var url = OC.generateUrl('/apps/files_eosversions/download.php');
			var params = {
				file: this.get('fullPath'),
				revision: this.get('version'),
				'x-access-token': OC['X-Access-Token']
			};
			return url + '?' + OC.buildQueryString(params);
		}
	});

	OCA.EosVersions = OCA.EosVersions || {};

	OCA.EosVersions.VersionModel = VersionModel;
})();

