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
				{id:"n1", date:"22.08.2013", title:"Протон-М вышел на орбиту", text:"Состоялся успешный запуск ракеты-носителя Протон-М с разгонным блоком Бриз, доставившей новый спутник связи на околоземную орбиту."},
				{id:"n2", date:"23.08.2013", title:"Планируется экспедиция к Марсу", text:"Рассматривается проект пилотируемой экспедиции к Марсу."}
			],
			goods:[
				{id:"selmerCl301", name:"Clarinet Bb Selmer USA CL301", description:"Boehm System, 6 rings, 17 keys"},
				{id:"vandorenV12-3", name:"Vandoren Clarinet Reeds V12 #3"}
			]
		},
		columns:{
			persons:[
					{field:"id", title:"Row ID", type:"rowID"},
					{field:"fio", title:"ФИО", type:"text"}
				],
			news:[
				{field:"id", title:"Row ID", type:"rowID"},
				{field:"date", title:"Дата", type:"date"},
				{field:"title", title:"Заголовок", type:"text"},
				{field:"text", title:"Текст", type:"textHTML"}
			],
			goods:[
				{field:"id", title:"Row ID", type:"rowID"},
				{field:"name", title:"Наименование", type:"text"},
				{field:"description", title:"Описание", type:"textHTML"}
			]
		}
	};

	var treeNodes = {};
	function indexTree(subtree, parentID){
		subtree = subtree || testData.tree;
		$.each(subtree, function(i, nd){
			if(treeNodes[nd.id]) alert("Tree Node '"+nd.id+"' already exists!");
			treeNodes[nd.id] = {node:nd, parent:parentID};
			if(nd.children){
				indexTree(nd.children, nd.id);
			}
		});
	}
	indexTree();
	
	var rowIndex = {};
	function indexRows(){
		for(var k in testData.rows){
			var cat = testData.rows[k];
			for(var i=0; i<cat.length; i++){
				var row = cat[i];
				rowIndex[row.id] = {catID:k, data:row};
			}
		}
	}
	indexRows();
	
	function findColumns(catID, fields){
		if(!catID) return [];
		fields = fields || "field;title";
		if(typeof(fields)=="string") fields = fields.split(";");
		var columns = testData.columns[catID];
		if(!columns) return findColumns(treeNodes[catID].parent, fields);
		var res = [];
		$.each(columns, function(i, col){
			var cDef = {};
			$.each(fields, function(j, fld){
				cDef[fld] = col[fld];
			});
			res.push(cDef);
		});
		return res;
	}
	
	function createNewID(){
		return "itm"+(new Date()).getTime();
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
		getRecord: function(recID, catID, onSuccess, onError){
			var row = rowIndex[recID].data;
			var res = {
				columns:{},
				data:row
			};
			$.each(findColumns(catID, "field;title;type"), function(i, col){
				res.columns[col.field] = col;
			});
			onSuccess(res);
		},
		saveRecord: function(recID, catID, data, onSuccess, onError){
			var newMode = recID==null;
			var row = newMode?{}:rowIndex[recID].data;
			for(var k in data) row[k] = data[k];
			if(newMode){
				row.id = createNewID();
				testData.rows[catID].push(row);
				indexRows();
			}
			onSuccess();
		},
		getTable: function(param, onSuccess, onError){
			onSuccess(testData.rows[param.catID]);
		},
		getTableColumns: function(catID, onSuccess, onError){
			onSuccess(findColumns(catID));
		},
		getAllColumns: function(catID, onSuccess, onError){
			onSuccess(findColumns(catID, "field;title;type"));
		}
	};
	
	return __;
})(jQuery);