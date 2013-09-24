Arundo.dataSource = (function($){
	var tree = [
		{text:"Персоналии", id:"persons", children:[
			{text:"Руководство", id:"management"},
			{text:"Отдел разработки", id:"developers"},
			{text:"Бухгалтерия", id:"accDep"},
			{text:"АХО", id:"economy"}
		]},
		{text:"Новости", id:"news"},
		{text:"Товары", id:"goods"}
	];
	var treeNodes = {};
	
	function indexTree(subtree){
		subtree = subtree || tree;
		$.each(subtree, function(i, nd){
			if(treeNodes[nd.id]) alert("Tree Node '"+nd.id+"' already exists!");
			treeNodes[nd.id] = nd;
			if(nd.children){
				indexTree(nd.children);
			}
		});
	}
	
	indexTree();
	
	var __ = {
		name:"Test Data Source", 
		getCatalogTree: function(param, onSuccess, onError){
			var subtree = param.rootID?treeNodes[param.rootID].children : tree;
			
			if(param.depth==1){
				var res = [];
				$.each(subtree, function(i, itm){
					res.push({id: itm.id, text: itm.text});
				});
				onSuccess(res);
			}
			else
				onSuccess(subtree);
		}, 
		getMenu: function(onSuccess, onError){
		}, 
		getRecord: function(recId, onSuccess, onError){
		},
		getTable: function(param, onSuccess, onError){
			var catID = param.catID;
			var idx = ({
				persons:"A",
				management:"B",
				developers:"C",
				accDep:"D",
				economy:"E",
				news:"F",
				goods:"G"
			}[catID] )|| "X";
			onSuccess([
				{"productid":"FI-SW-01"+"-"+idx,"productname":"Koi"},
				{"productid":"K9-DL-01"+"-"+idx,"productname":"Dalmation"},
				{"productid":"RP-SN-01"+"-"+idx,"productname":"Rattlesnake"},
				{"productid":"RP-LI-02"+"-"+idx,"productname":"Iguana"},
				{"productid":"FL-DSH-01"+"-"+idx,"productname":"Manx"},
				{"productid":"FL-DLH-02"+"-"+idx,"productname":"Persian"},
				{"productid":"AV-CB-01"+"-"+idx,"productname":"Amazon Parrot"}
			])
		},
		getColumns: function(catID, onSuccess, onError){
			onSuccess([
				{field:"productid", title:"ID"},
				{field:"productname", title:"Name"}
			]);
		}
	};
	
	return __;
})(jQuery);