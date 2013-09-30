Arundo.dataSource = (function($, $A, $P){
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
		if(!subtree) treeNodes = {};
		subtree = subtree || testData.tree;
		$.each(subtree, function(i, nd){
			if(treeNodes[nd.id]) $.messager.alert("Test Data Source Error", "Tree Node '"+nd.id+"' already exists!", "error");
			treeNodes[nd.id] = {node:nd, parent:parentID};
			if(nd.children){
				indexTree(nd.children, nd.id);
			}
		});
	}
	indexTree();
	
	var rowIndex = {};
	function indexRows(){
		rowIndex = {};
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
	
	function excludeBranch(tree, branchRoot){
		if(!tree) return;
		var res = [];
		$.each(tree, function(i, nd){
			if(nd.id!=branchRoot){
				res.push(nd);
				if(nd.children)
					nd.children = excludeBranch(nd.children, branchRoot);
			}
		});
		return res;
	}

	
	var __ = {
		name:"Test Data Source", 
		getCatalogTree: function(param, onSuccess, onError){
			var root = param.rootID?treeNodes[param.rootID].node:null;
			var subtree = root?root.children : testData.tree;
			var res;
			
			if(param.depth==1){
				res = [];
				$.each(subtree, function(i, itm){
					res.push({id: itm.id, text: itm.text});
				});
			}
			else{
				res = root?[{id:param.rootID, text:root.text, children: subtree}]
						:subtree;
			}
			if(param.excludeBranch) res = excludeBranch(res, param.excludeBranch);
			if(param.includeRoot) res = [{id:null, text:"/"}].concat(res);
			onSuccess(res);
		}, 
		getRecord: function(recID, catID, onSuccess, onError){
			var rec = rowIndex[recID];
			if(!rec){
				onError($A.locale.getItem("errRowNotExist").replace("$", recID));
				return;
			}
			var row = rec.data;
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
			if(false) // придумать условие!
				onError($A.locale.getItem("errRecSaving"));
			else
				onSuccess();
		},
		getTable: function(param, onSuccess, onError){
			var  cat = testData.rows[param.catID];
			if(!cat) onError($A.locale.getItem("errCatNotExist").replace("$", param.catID));
			else onSuccess(cat);
		},
		getTableColumns: function(catID, onSuccess, onError){
			onSuccess(findColumns(catID));
		},
		getAllColumns: function(catID, onSuccess, onError){
			onSuccess(findColumns(catID, "field;title;type"));
		},
		deleteRows: function(rowIDs, onSuccess, onError){
			$.each(rowIDs, function(i, recID){
				var catID = rowIndex[recID].catID;
				var catRows = testData.rows[catID];
				res = [];
				$.each(catRows, function(i, row){
					if(row.id!=recID) res.push(row);
				});
				testData.rows[catID] = res;
			});
			onSuccess();
		},
		deleteCatalog: function(catID, onSuccess, onError){
			onError("deleteCatalog: method is not implemented!");
		},
		getCatalogProperties: function(param, onSuccess, onError){
			var newMode = param.catID==null;
			if(newMode){
				onSuccess({total:3, rows:[
					{name:"ID", "value": createNewID(), hidden:true, editor:"none"},
					{name:"Parent", "value": null, editor:{type:"combotree", options:{
						loader:function(prm, onSuccess, onError){
							$A.dataSource.getCatalogTree({rootID: null, includeRoot:true}, onSuccess, onError);
						}
					}}},
					{name:"Name", "value":"", editor:"text"}
				]});
			}
			else{
				var data = treeNodes[param.catID];
				if(!data){
					onError($A.locale.getItem("errCatNotExist").replace("$", catID));
					return;
				}
				onSuccess({total:3, rows:[
					{name:"ID", "value": data.node.id, hidden:true, editor:"none"},
					{name:"Parent", "value": data.parent, editor:{type:"combotree", options:{
						loader:function(prm, onSuccess, onError){
							// важно исключать из вывода дерева ветвь данного узла,
							// чтобы пользователь ошибочно не создал рекурсивных ссылок
							$A.dataSource.getCatalogTree({rootID: null, excludeBranch:data.node.id, includeRoot:true}, onSuccess, onError);
						}
					}}},
					{name:"Name", "value":data.node.text, editor:"text"}
				]});
			}
		},
		saveCatalogProperties: function(catID, data, onSuccess, onError){
			var cat = treeNodes[catID];
			if(!cat){onError($A.locale.getItem("errCatSaving").replace("$", catID)); return;}
			$.each(data, function(i, prop){
				switch(prop.name){
					case "Name": cat.node.text = prop.value; break;
					case "Parent":
						var prt = prop.value?treeNodes[prop.value].node:null;
						if(prt) $P.set(prt, "children/#*", cat.node);
							else testData.tree.push(cat.node);
						var oldParent = (cat.parent && treeNodes[cat.parent])?treeNodes[cat.parent].node:null;
						var nCh = [];
						var oldSubTree = oldParent?oldParent.children:testData.tree;
						for(var i=0; i<oldSubTree.length; i++){
							var itm = oldSubTree[i];
							if(itm.id!=cat.node.id) nCh.push(itm);
						}
						if(oldParent) oldParent.children = nCh; 
							else testData.tree = nCh;
						indexTree();
						break;
					default: break;
				}
			});
			onSuccess();
		}
	};
	
	return __;
})(jQuery, Arundo, JsPath);