var IDataSource = (function(){
	
	var iDefinition = {
		"function":[
			"getCatalogTree", 
			"getRecord",
			"saveRecord", 
			"getTableColumns",
			"getTable",
			"getAllColumns", 
			"deleteRows",
			"deleteCatalog", 
			"getCatalogProperties",
			"saveCatalogProperties"
		],
		"string":[
			"name"
		]
	};
	
	var iTypes = {};
	(function(){
		for(var k in iDefinition){var defList = iDefinition[k];
			for(var i=0; i<defList.length; i++){var itm = defList[i];
				iTypes[itm] = k;
			}
		}
	})();

	function checkInterface(obj, type, members){
		$.each(members, function(i, m){
			if(typeof(obj[m])!=type)
				__.displayConfigError("Missing Data Source interface member "+type+"::"+m);
		});
		for(var k in obj){
			if(!iTypes[k])
				__.displayConfigError("Member "+type+"::"+k+" is not defined in interface IDataSource.");
		}
	}


	var __={
		check: function(dataSource){
			if(!dataSource) displayConfigError("Missing Data Source.");
			for(var k in iDefinition){
				checkInterface(dataSource, k, iDefinition[k]);
			}
		},
		displayConfigError: function(msg){
			alert("Configuration Error\n"+(msg.message || msg.text || msg));
		}
	};
	return __;
})();