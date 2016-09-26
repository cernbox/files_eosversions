(function() {
	/**
	 * @memberof OCA.EosVersions
	 */
	var VersionCollection = OC.Backbone.Collection.extend({
		model: OCA.EosVersions.VersionModel,

		/**
		 * @var OCA.Files.FileInfoModel
		 */
		_fileInfo: null,

		_endReached: false,
		_currentIndex: 0,

		url: function() {
			var url = OC.generateUrl('/apps/files_eosversions/ajax/getVersions.php');
			var query = {
				source: this._fileInfo.getFullPath(),
				start: this._currentIndex
			};
			return url + '?' + OC.buildQueryString(query);
		},

		setFileInfo: function(fileInfo) {
			this._fileInfo = fileInfo;
			// reset
			this._endReached = false;
			this._currentIndex = 0;
		},

		getFileInfo: function() {
			return this._fileInfo;
		},

		hasMoreResults: function() {
			return !this._endReached;
		},

		fetch: function(options) {
			if (!options || options.remove) {
				this._currentIndex = 0;
			}
			return OC.Backbone.Collection.prototype.fetch.apply(this, arguments);
		},

		/**
		 * Fetch the next set of results
		 */
		fetchNext: function() {
			if (!this.hasMoreResults()) {
				return null;
			}
			if (this._currentIndex === 0) {
				return this.fetch();
			}
			return this.fetch({remove: false});
		},

		reset: function() {
			this._currentIndex = 0;
			OC.Backbone.Collection.prototype.reset.apply(this, arguments);
		},

		parse: function(result) {
			var fullPath = this._fileInfo.getFullPath();
			var results = _.map(result.data.versions, function(version) {
				console.log(version);
				//var revision = parseInt(version.version, 10);
				// eos versions are strings not ints
				var revision = version.version;
				return {
					id: revision,
					name: version.name,
					fullPath: fullPath,
					timestamp: version.mtime,
					size: version.size,
					version: version.version,
				};
			});
			this._endReached = result.data.endReached;
			this._currentIndex += results.length;
			return results;
		}
	});

	OCA.EosVersions = OCA.EosVersions || {};

	OCA.EosVersions.VersionCollection = VersionCollection;
})();

