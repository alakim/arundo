Arundo.dataSource = (function($, $A, $P){
	var __ = {
		name:"Simple Data Source", 
		getCatalogTree: function(param, onSuccess, onError){
			$.getJSON("data/tree.php", param, function(data){
				onSuccess(data);
			});
		}, 
		getRecord: function(recID, catID, onSuccess, onError){},
		saveRecord: function(recID, catID, data, onSuccess, onError){},
		getTable: function(param, onSuccess, onError){},
		getTableColumns: function(catID, onSuccess, onError){},
		getAllColumns: function(catID, onSuccess, onError){},
		deleteRows: function(rowIDs, onSuccess, onError){},
		deleteCatalog: function(catID, onSuccess, onError){},
		getCatalogProperties: function(param, onSuccess, onError){},
		saveCatalogProperties: function(catID, data, onSuccess, onError){}
	};
	
	return __;
})(jQuery, Arundo, JsPath);