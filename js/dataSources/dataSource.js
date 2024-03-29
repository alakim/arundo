Arundo.dataSource = (function($, $A, $P){
	var __ = {
		name:"Simple Data Source", 
		getCatalogTree: function(param, onSuccess, onError){
			param.ticket = $A.ticket;
			$.getJSON("ws/tree.php", param, function(data){
				onSuccess(data);
			}, function(){
				onError($A.locale.getItem("errLoadingTree"));
			});
		}, 
		getRecord: function(recID, catID, onSuccess, onError){
			$.getJSON("ws/record.php", {recID:recID, catID:catID, ticket:$A.ticket}, function(data){
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
			$.post("ws/saverec.php", {recID:recID, catID:catID, data:data, ticket:$A.ticket}, function(res){
				res = JSON.parse(res);
				if(res.error){
					var errCode = res.error=="RecordMissing"?"errRecordMissing"
						:res.error=="errCatNotExist"?"errCatNotExist"
						:"errSavingRecord";
					onError($A.locale.getItem(errCode).replace("$", recID));
				}
				else
					onSuccess();
			});
		},
		getTable: function(param, onSuccess, onError){
			param.ticket = $A.ticket;
			$.getJSON("ws/table.php", param, function(data){
				onSuccess(data);
			}, function(){
				onError($A.locale.getItem("errLoadingTable"));
			});
		},
		getTableColumns: function(catID, onSuccess, onError){
			$.getJSON("ws/columns.php", {catID:catID, ticket:$A.ticket, all:0}, function(data){
				onSuccess(data);
			}, function(){
				onError($A.locale.getItem("errLoadingColumns"));
			});
		},
		getAllColumns: function(catID, onSuccess, onError){
			$.getJSON("ws/columns.php", {catID:catID, ticket:$A.ticket, all:1}, function(data){
				onSuccess(data);
			}, function(){
				onError($A.locale.getItem("errLoadingColumns"));
			});
		},
		deleteRows: function(catID, rowIDs, onSuccess, onError){
			$.post("ws/delrows.php", {catID:catID, rowIDs:rowIDs.join(";"), ticket:$A.ticket}, function(res){
				res = JSON.parse(res);
				if(res.error) onError($A.locale.getItem("errDeleteRow"));
				else onSuccess(res);
			});
		},
		deleteCatalog: function(catID, onSuccess, onError){onError("Method 'deleteCatalog' not implemented.");},
		getCatalogProperties: function(param, onSuccess, onError){
			$.post("ws/catdata.php", {catID:param.catID, ticket:$A.ticket}, function(res){
				res = JSON.parse(res);
				if(res.error) onError(res);
				else onSuccess(res);
			});
		},
		saveCatalogProperties: function(catID, data, onSuccess, onError){
			$.post("ws/savecatdata.php", {catID:catID, data:data, ticket:$A.ticket}, function(res){
				res = JSON.parse(res);
				if(res.error) onError(res);
				else onSuccess(res);
			});
			// onError("Method 'saveCatalogProperties' not implemented.");
		},
		
		getRefRows: function(prm, onSuccess, onError){
			$.getJSON("ws/refrows.php", {recID:prm.rowID, catID:prm.catID, ticket:$A.ticket}, function(data){
				if(data.error){
					var errCode = "errLoadingReferences";
					onError($A.locale.getItem(errCode).replace("$", recID));
				}
				else
					onSuccess(data);
			}, function(){
				onError($A.locale.getItem("errLoadingReferences"));
			});
		},
		getPermissions: function(groupID, onSuccess, onError){
			$.getJSON("ws/permissions.php", {grpID:groupID, ticket:$A.ticket}, function(data){
				if(data.error){
					var errCode = "errLoadingPermissions";
					onError($A.locale.getItem(errCode).replace("$", recID));
				}
				else
					onSuccess(data);
			}, function(){
				onError($A.locale.getItem("errLoadingPermissions"));
			});
		}
	};
	
	return __;
})(jQuery, Arundo, JsPath);