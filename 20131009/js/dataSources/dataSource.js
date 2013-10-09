Arundo.dataSource = (function($, $A, $P){
	var __ = {
		name:"Simple Data Source", 
		getCatalogTree: function(param, onSuccess, onError){
			$.getJSON("ws/tree.php", param, function(data){
				onSuccess(data);
			}, function(){
				onError($A.locale.getItem("errLoadingTree"));
			});
		}, 
		getRecord: function(recID, catID, onSuccess, onError){
			$.getJSON("ws/record.php", {recID:recID, catID:catID}, function(data){
				if(data.error){
					var errCode = data.error=="RecordMissing"?"errRecordMissing"
						:"errLoadingRecord";
					onError($A.locale.getItem(errCode).replace("$", recID));
				}
				else
					onSuccess(data);
			}, function(){
				onError($A.locale.getItem("errLoadingRecord"));
			});
		},
		saveRecord: function(recID, catID, data, onSuccess, onError){
			$.post("ws/saverec.php", {recID:recID, catID:catID, data:data}, function(res){
				res = JSON.parse(res);
				if(res.error){
					var errCode = res.error=="RecordMissing"?"errRecordMissing"
						:"errSavingRecord";
					onError($A.locale.getItem(errCode).replace("$", recID));
				}
				else
					onSuccess(data);
			});
		},
		getTable: function(param, onSuccess, onError){
			$.getJSON("ws/table.php", param, function(data){
				onSuccess(data);
			}, function(){
				onError($A.locale.getItem("errLoadingTable"));
			});
		},
		getTableColumns: function(catID, onSuccess, onError){
			$.getJSON("ws/columns.php", {catID:catID}, function(data){
				onSuccess(data);
			}, function(){
				onError($A.locale.getItem("errLoadingColumns"));
			});
		},
		getAllColumns: function(catID, onSuccess, onError){onError("Method 'getAllColumns' not implemented.");},
		deleteRows: function(rowIDs, onSuccess, onError){onError("Method 'deleteRows' not implemented.");},
		deleteCatalog: function(catID, onSuccess, onError){onError("Method 'deleteCatalog' not implemented.");},
		getCatalogProperties: function(param, onSuccess, onError){onError("Method 'getCatalogProperties' not implemented.");},
		saveCatalogProperties: function(catID, data, onSuccess, onError){onError("Method 'saveCatalogProperties' not implemented.");},
		
		getRefRows: function(prm, onSuccess, onError){
			$.getJSON("ws/refrows.php", {recID:prm.rowID, catID:prm.catID}, function(data){
				if(data.error){
					var errCode = "errLoadingReferences";
					onError($A.locale.getItem(errCode).replace("$", recID));
				}
				else
					onSuccess(data);
			}, function(){
				onError($A.locale.getItem("errLoadingReferences"));
			});
		}
	};
	
	return __;
})(jQuery, Arundo, JsPath);