var RowEditor = (function($, $A, H){

	var dlgID = "rowEditorDlg";
	
	var templates = {
		dialog: function(data){with(H){
			return table({border:1, cellpadding:3, cellspacing:0},
				apply(data.data, function(val, colID){
					return tr(
						td(data.columns[colID].title),
						td(val)
					);
				})
			);
		}}
	};
	
	var __={
		open:function(rowIdx, rowData){
			if(!$("#"+dlgID).length){
				$("body").append(Html.div({id:dlgID}));
				$("#"+dlgID)
					.html(rowIdx+" opened!")
					.dialog({
						title:$A.locale.getItem("rowEditor"), 
						width: 300, height: 200,
						resizable: true,
						buttons:[
							{text:$A.locale.getItem("btOK"), handler:function(){
								alert("OK");
							}},
							{text:$A.locale.getItem("btCancel"), handler:function(){
								$("#"+dlgID).dialog("close");
							}}
						]
					});
			}
			var contentPnl = $("#"+dlgID+" .dialog-content");
			contentPnl.html("loading...");
			$("#"+dlgID).dialog("open");
			$A.dataSource.getRecord(rowData.id, function(data){
				contentPnl.html(templates.dialog(data));
			}, $A.displayError);
		}
	};
	
	
	
	return __;
})(jQuery, Arundo, Html);