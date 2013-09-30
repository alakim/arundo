var TreeNodeEditor = (function($, $A, H){
	var dlgID = "treeNodeEditorDlg";
	
	var templates = {
		dialog: function(data){with(H){
			return table({border:0, cellpadding:3, cellspacing:0},
				apply(data.node, function(val, k){
					if(k=="state" || k=="id") return null;
					var title = k=="text"?$A.locale.getItem("name")
						:k;
					return tr(
						td(title),
						td(
							input({type:"text", "class":"fldCat", value:val, fldID:k, style:"width:250px;"})
						)
					);
				})
			);
		}}
	};
	

	return function(){var _=this;
		
		$.extend(_,{
			catID:null,
			open:function(catID){
				if(!$("#"+dlgID).length){
					$("body").append(Html.div({id:dlgID}));
					$("#"+dlgID)
						.dialog({
							title:$A.locale.getItem("treeNodeEditor"), 
							width: 450, height: 300,
							resizable: true,
							buttons:[
								{text:$A.locale.getItem("btOK"), handler:function(){
									saveData(function(){
										$("#"+dlgID).dialog("close");
										_.onSaved();
									});
								}},
								{text:$A.locale.getItem("btCancel"), handler:function(){
									$("#"+dlgID).dialog("close");
								}}
							]
						});
				}
				var contentPnl = $("#"+dlgID+" .dialog-content");
				var propGrid = $(Html.table({"class":"catProp", width:"250"}));
				contentPnl.html(propGrid);
				
				propGrid.propertygrid({
					loader: $A.dataSource.getCatalogProperties,
					showGroup: false,
					columns: [[
						{field:"name", title:$A.locale.getItem("property"), width:60},
						{field:"value", title:$A.locale.getItem("value"), width: 100}
					]],
					queryParams:{catID:catID}
				});
				
				function saveData(onSuccess){
					var data = contentPnl.find('.catProp').propertygrid('getChanges');
					$A.dataSource.saveCatalogProperties(_.catID, data, onSuccess, $A.displayError);
				}
				
				$("#"+dlgID).dialog("open");
				
				if(catID){
					// $A.dataSource.getCatalogProperties(catID, function(data){
						// contentPnl.html(templates.dialog(data));
					// }, $A.displayError);
				}
			},
			onSaved: function(){}
		});
	};
})(jQuery, Arundo, Html);