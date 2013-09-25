var RowEditor = (function($, $A, H){
	var dlgID = "rowEditorDlg";
	
	var templates = {
		dialog: function(data){with(H){
			return table({border:0, cellpadding:3, cellspacing:0},
				apply(data.data, function(val, colID){
					var col = data.columns[colID];
					return tr(col.type=="rowID"?{style:"color:#888;"}:null,
						td({"class":"fieldName"}, col.title),
						templates.field(col.field, val, col.type)
					);
				})
			);
		}},
		field: function(id, val, type){with(H){
			return td(
				type=="text"?input({"class":"editField", type:"text", value:val, fldID:id})
				:type=="date"?input({"class":"editField dateFld", type:"text", value:val, fldID:id})
				:type=="textHTML"?textarea({"class":"editField", fldID:id}, val)
				:span(val)
			);
		}}
	};
	
	function collectData(pnl){
		var res = {};
		pnl.find(".editField").each(function(i, fld){fld=$(fld);
			res[fld.attr("fldID")] = fld.val();
		});
		return res;
	}

	return function(){var _=this;
		
		$.extend(_,{
			catID:null,
			open:function(rowID){
				_.rowID = rowID;
				if(!$("#"+dlgID).length){
					$("body").append(Html.div({id:dlgID}));
					$("#"+dlgID)
						.dialog({
							title:$A.locale.getItem("rowEditor"), 
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
					var data = collectData(contentPnl);
					$A.dataSource.saveRecord(_.rowID, _.catID, data, onSuccess, $A.displayError);
				}
				
				$("#"+dlgID).dialog("open");
				if(_.rowID){
					$A.dataSource.getRecord(_.rowID, _.catID, function(data){
						contentPnl.html(templates.dialog(data))
							.find(".dateFld").datebox({
								formatter: $A.date.format,
								parser: $A.date.parse
							});
					}, $A.displayError);
				}
				else{
					//$A.dataSource.
				}
			},
			onSaved: function(){}
		});
	};
})(jQuery, Arundo, Html);