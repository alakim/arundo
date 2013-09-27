var TreeNodeEditor = (function($, $A, H){
	var dlgID = "treeNodeEditorDlg";
	
	var templates = {
		dialog: function(data){with(H){
			return table({border:1, cellpadding:3, cellspacing:0},
				apply(data.node, function(val, k){
					return tr(
						td(k),
						td(val)
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
				contentPnl.html("loading...");
				
				function saveData(onSuccess){
					onSuccess();
					// var data = collectData(contentPnl);
					// $A.dataSource.saveRecord(_.rowID, _.catID, data, onSuccess, $A.displayError);
				}
				
				$("#"+dlgID).dialog("open");
				
				if(catID){
					$A.dataSource.getCatalogProperties(catID, function(data){
						contentPnl.html(templates.dialog(data));
					}, $A.displayError);
				}
			},
			onSaved: function(){}
		});
	};
})(jQuery, Arundo, Html);