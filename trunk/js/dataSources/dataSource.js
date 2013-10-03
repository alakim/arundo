Arundo.dataSource = (function($, $A, $P){
	var __ = {
		name:"Simple Data Source", 
		getCatalogTree: function(param, onSuccess, onError){
			$.getJSON("data/tree.php", param, function(data){
				onSuccess(data);
			});
		}, 
		getRecord: function(recID, catID, onSuccess, onError){onError("Method 'getRecord' not implemented.");},
		saveRecord: function(recID, catID, data, onSuccess, onError){onError("Method 'saveRecord' not implemented.");},
		getTable: function(param, onSuccess, onError){onError("Method 'getTable' not implemented.");},
		getTableColumns: function(catID, onSuccess, onError){onError("Method 'getTableColumns' not implemented.");},
		getAllColumns: function(catID, onSuccess, onError){onError("Method 'getAllColumns' not implemented.");},
		deleteRows: function(rowIDs, onSuccess, onError){onError("Method 'deleteRows' not implemented.");},
		deleteCatalog: function(catID, onSuccess, onError){onError("Method 'deleteCatalog' not implemented.");},
		getCatalogProperties: function(param, onSuccess, onError){onError("Method 'getCatalogProperties' not implemented.");},
		saveCatalogProperties: function(catID, data, onSuccess, onError){onError("Method 'saveCatalogProperties' not implemented.");}
	};
	
	return __;
})(jQuery, Arundo, JsPath);