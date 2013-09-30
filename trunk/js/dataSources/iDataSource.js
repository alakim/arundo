var IDataSource = (function(){
	
	var iDefinition = {
		"function":[
			"getCatalogTree", 
			"getRecord",
			"saveRecord", 
			"getTableColumns",
			"getAllColumns", 
			"deleteRows",
			"deleteCatalog", 
			"getCatalogProperties"
		],
		"string":[
			"name"
		]
	};

	function checkInterface(obj, type, members){
		$.each(members, function(i, m){
			if(typeof(obj[m])!=type)
				__.displayConfigError("Missing Data Source interface member "+type+"::"+m);
		})
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