var TreeNodeEditor = (function($, $A, H){
	var dlgID = "treeNodeEditorDlg";
	
	var templates = {
		dialog: function(data){with(H){
			return table({border:1, cellpadding:3, cellspacing:0},
				tr(td())
			);
		}}
	};
	

	return function(){var _=this;
		
		$.extend(_,{
			catID:null,
			open:function(rowID){
				alert("open!!!!!");
			},
			onSaved: function(){}
		});
	};
})(jQuery, Arundo, Html);