var RowEditor = (function($, $A, H){

	var dlgID = "rowEditorDlg";
	
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
			$("#"+dlgID).dialog("open");
		}
	};
	
	
	
	return __;
})(jQuery, Arundo, Html);