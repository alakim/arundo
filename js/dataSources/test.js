Arundo.dataSource = (function($){
	var testData = {
		tree: [
			{text:"Персоналии", id:"persons", children:[
				{text:"Руководство", id:"management"},
				{text:"Отдел разработки", id:"developers"},
				{text:"Бухгалтерия", id:"accDep"},
				{text:"АХО", id:"economy"}
			]},
			{text:"Новости", id:"news"},
			{text:"Товары", id:"goods"}
		], 
		rows:{
			persons:[
				{"id":"PPS","fio":"Петренко П.С."}
			],
			management:[
				{"id":"III","fio":"Иванов И.И"},
				{"id":"PPP","fio":"Петров П.П."}
			],
			developers:[
				{"id":"SSS","fio":"Сидоров С.С."}
			],
			accDep:[
				{"id":"KKK","fio":"Кульман К.К."}
			],
			economy:[
				{"id":"VVV","fio":"Ватман В.В."}
			],
			news:[
				{id:"n1", date:"2013-08-22T11:35", title:"Протон-М вышел на орбиту", text:"Состоялся успешный запуск ракеты-носителя Протон-М с разгонным блоком Бриз, доставившей новый спутник связи на околоземную орбиту."},
				{id:"n2", date:"2013-08-23T09:00", title:"Планируется экспедиция к Марсу", text:"Рассматривается проект пилотируемой экспедиции к Марсу."}
			],
			goods:[
				{id:"selmerCl301", name:"Clarinet Bb Selmer USA CL301", description:"Boehm System, 6 rings, 17 keys"},
				{id:"vandorenV12-3", name:"Vandoren Clarinet Reeds V12 #3"}
			]
		},
		columns:{
			persons:[
					{field:"id", title:"ID"},
					{field:"fio", title:"ФИО"}
				],
			news:[
				{field:"id", title:"ID"},
				{field:"date", title:"Дата"},
				{field:"title", title:"Заголовок"},
				{field:"text", title:"Текст"}
			],
			goods:[
				{field:"id", title:"ID"},
				{field:"name", title:"Наименование"},
				{field:"description", title:"Описание"}
			]
		}
	};

	var treeNodes = {};
	
	(function indexTree(subtree, parentID){
		subtree = subtree || testData.tree;
		$.each(subtree, function(i, nd){
			if(treeNodes[nd.id]) alert("Tree Node '"+nd.id+"' already exists!");
			treeNodes[nd.id] = {node:nd, parent:parentID};
			if(nd.children){
				indexTree(nd.children, nd.id);
			}
		});
	})();
	
	var rowIndex = {};
	(function indexRows(){
		for(var k in testData.rows){
			var cat = testData.rows[k];
			for(var i=0; i<cat.length; i++){
				var row = cat[i];
				rowIndex[row.id] = {catID:k, data:row};
			}
		}
	})();
	
	function findColumns(catID){
		if(!catID) return [];
		var columns = testData.columns[catID];
		if(columns) return columns;
		else return findColumns(treeNodes[catID].parent);
	}

	
	var __ = {
		name:"Test Data Source", 
		getCatalogTree: function(param, onSuccess, onError){
			var root = param.rootID?treeNodes[param.rootID].node:null;
			var subtree = root?root.children : testData.tree;
			
			if(param.depth==1){
				var res = [];
				$.each(subtree, function(i, itm){
					res.push({id: itm.id, text: itm.text});
				});
				onSuccess(res);
			}
			else{
				var rTree = root?[{id:param.rootID, text:root.text, children: subtree}]
						:subtree;
				onSuccess(rTree);
			}
		}, 
		getMenu: function(onSuccess, onError){
		}, 
		getRecord: function(recID, onSuccess, onError){
			var row = rowIndex[recID].data;
			var catID = rowIndex[recID].catID;
			var res = {
				columns:{},
				data:row
			};
			$.each(findColumns(catID), function(i, col){
				res.columns[col.field] = col;
			});
			onSuccess(res);
		},
		getTable: function(param, onSuccess, onError){
			onSuccess(testData.rows[param.catID]);
		},
		getColumns: function(catID, onSuccess, onError){
			onSuccess(findColumns(catID));
		}
	};
	
	return __;
})(jQuery);