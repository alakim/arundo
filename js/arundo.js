var Arundo = (function($, $H, $P){

	var locale = (function(){
		function getLocale(lang){
			return lang? locale.items[lang]: (locale.items.ru || locale.items.en);
		}
		
		var _Loc = {
			items:{
				en:{
					catalogs: "Catalogs",
					mainPage: "Main",
					wholeTree: "Whole Tree",
					rowEditor: "Edit Row",
					btOK: "OK",
					btCancel: "Cancel"
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
				displayConfigError("Missing Data Source interface member "+type+"::"+m);
		})
	}
	
	function checkDataSource(){
		if(!__.dataSource) displayConfigError("Missing Data Source.");
		checkInterface(__.dataSource, "function", ["getCatalogTree", "getMenu", "getRecord", "getColumns"]);
		checkInterface(__.dataSource, "string", ["name"]);
	}
	
	function checkView(){
		if(!__.view) displayConfigError("Missing View");
		checkInterface(__.view, "function", ["init"]);
	}
	
	function displayConfigError(msg){
		alert("Configuration Error\n\n"+msg);
	}
	
	var __ = {
		locale: locale,
		dataSource: null,
		view: null,
		initPanel: function(pnl){
			__.locale.localize(pnl);
			$(pnl).find(".easyui-linkbutton").linkbutton();
		},
		init: function(){
			__.locale.localize("body");
			checkDataSource();
			checkView();
			__.view.init();
			//buildMainMenu();
			//console.log(Arundo);
		}
	};
	
	$(__.init);
	return __;
})(jQuery, Html, JsPath);