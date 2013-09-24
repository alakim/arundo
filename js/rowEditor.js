var RowEditor = (function($, $A, H){

	var dlgID = "rowEditorDlg";
	
	var __={
		open:function(rowIdx, rowData){
			if(!$("#"+dlgID).length){
				$("body").append(Html.div({id:dlgID}));
			}
			$("#"+dlgID)
				.html(rowIdx+" opened!")
				.dialog({
					title:"Row Editor", 
					width: 300, height: 200,
					resizable: true
				});
		}
	};
	
	
	
	return __;
})(jQuery, Arundo, Html);