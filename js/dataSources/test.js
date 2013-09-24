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
	
	var testData = {
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
	};
	
	var __ = {
		name:"Test Data Source", 
		getCatalogTree: function(param, onSuccess, onError){
			var root = param.rootID?treeNodes[param.rootID]:null;
			var subtree = root?root.children : tree;
			
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
		getRecord: function(recId, onSuccess, onError){
		},
		getTable: function(param, onSuccess, onError){
			onSuccess(testData[param.catID]);
		},
		getColumns: function(catID, onSuccess, onError){
			var columns;
			switch(catID){
				case "persons":
				case "management":
				case "developers":
				case "accDep":
				case "economy":
					columns = [
						{field:"id", title:"ID"},
						{field:"fio", title:"ФИО"}
					];
					break;
				case "news":
					columns = [
						{field:"id", title:"ID"},
						{field:"date", title:"Дата"},
						{field:"title", title:"Заголовок"},
						{field:"text", title:"Текст"}
					];
					break;
				case "goods":
					columns = [
						{field:"id", title:"ID"},
						{field:"name", title:"Наименование"},
						{field:"description", title:"Описание"}
					];
					break;
			}
			onSuccess(columns);
		}
	};
	
	return __;
})(jQuery);