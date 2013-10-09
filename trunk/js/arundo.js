var Arundo = (function($, $H, $P){

	IDataSource.displayConfigError = displayConfigError;

	var dateUtility = {
		format: function(d){
			var y = d.getFullYear();
			var m = d.getMonth()+1;
			var d = d.getDate();
			if(m<10) m = "0"+m;
			if(d<10) d = "0"+d;
			return [d, m, y].join(".");
		},
		parse: function(s){
			var date = s.split(".");
			var d = parseInt(date[0], 10);
			var m = parseInt(date[1], 10);
			var y = parseInt(date[2], 10);
			return new Date(y, m-1, d);
		}
	};

	var locale = (function(){
		function getLocale(lang){
			return lang? locale.items[lang]: (locale.items.ru || locale.items.en);
		}
		
		var _Loc = {
			items:{
				en:{
					Logoff: "Logoff",
					catalogs: "Catalogs",
					mainPage: "Main",
					wholeTree: "Whole Tree",
					rowEditor: "Edit Row",
					treeNodeEditor: "Edit catalog",
					btOK: "OK",
					btCancel: "Cancel",
					btDelete: "Delete",
					btNew: "New",
					btEdit: "Edit",
					btOpenNewWindow: "Open in new window",
					btRefresh: "Refresh",
					warning: "Warning",
					error: "Error",
					configError: "Configuration Error",
					confirm: "Confirm",
					confirmDeleteRows: "Are you sure you want to delete selected records?",
					confirmDeleteCat: "Are you sure you want to delete selected catalog?",
					warningSelRows2Del: "Select rows to delete.",
					warningSelectAnyCatalog: "Select any catalog.",
					errLoadingTree: "Error loading catalog tree.",
					errLoadingColumns: "Error loading table columns",
					errLoadingTable: "Error loading table rows",
					errLoadingRecord: "Error loading record",
					errLoadingReferences: "Error loading reference list",
					errRecordMissing: "Record '$' does not exists.",
					errSavingRecord: "Error saving record '$'",
					errCatNotExist: "Catalog '$' does not exists.",
					errRowNotExist: "Record '$' does not exists.",
					errRecSaving: "Record saving error.",
					errCatSaving: "Catalog saving error.",
					errUserOrGrpNotExist: "User or User Group does not exists."
				}
			},
			addItems: function(lang, items){
				for(var id in items){
					$P.set(locale.items, [lang, id].join("/"), items[id]);
				}
			},
			localize: function(context, lang){
				context = context || "body";
				$(context).find(".local").each(function(i, itm){itm=$(itm);
					var locTarget = itm.attr("ar-locale-target");
					var locID = itm.attr("ar-locale-id");
					if(!locID) return;
					var val = _Loc.getItem(locID, lang);
					if(locTarget)
						switch(locTarget){
							case "panel-title":
								itm.prev().find(".panel-title").text(val);
								break;
							default:
								itm.attr(locTarget, val);
						}
					else
						itm.text(val);
				});
			},
			getItem: function(locID, lang){
				return getLocale(lang)[locID] || locale.items.en[locID] || locID;
			}
		};
		return _Loc;
	})();
	
	function checkInterface(obj, type, members){
		$.each(members, function(i, m){
			if(typeof(obj[m])!=type)
				displayConfigError("Missing interface member "+type+"::"+m);
		})
	}
	
	function checkView(){
		if(!__.view) displayConfigError("Missing View");
		checkInterface(__.view, "function", ["init"]);
	}
	
	function displayConfigError(msg){
		$.messager.alert(locale.getItem("configError"), msg.message || msg.text || msg, "error");
	}
	
	var __ = {
		locale: locale,
		date: dateUtility,
		dataSource: null,
		view: null,
		initPanel: function(pnl){
			__.locale.localize(pnl);
			$(pnl).find(".easyui-linkbutton").linkbutton();
		},
		init: function(){
			__.locale.localize("body");
			IDataSource.check(__.dataSource);
			checkView();
			__.view.init();
		},
		displayError: function(err){
			$.messager.alert(locale.getItem("error"), (err.message || err), "error");
		},
		displayWarning: function(msg){
			$.messager.alert(locale.getItem("warning"), msg, "warning")
		}
	};
	
	$(__.init);
	return __;
})(jQuery, Html, JsPath);