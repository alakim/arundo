var RowEditor = (function($, $A, H){
	var dlgID = "rowEditorDlg";
	
	var templates = {
		dialog: function(data){with(H){
			return table({border:0, cellpadding:3, cellspacing:0},
				apply(data.columns, function(col){
					return tr(col.type=="rowID"?{style:"color:#888;"}:null,
						td({"class":"fieldName"}, col.title),
						templates.field(col.field, data.data?data.data[col.field]:templates.emptyValue(col.type), col.type)
					)
				})
			);
		}},
		emptyValue: function(colType){
			if(colType == "date") return $A.date.format(new Date());
			return "";
		},
		field: function(id, val, type){with(H){
			return td(
				type=="text"?input({"class":"editField", type:"text", value:val, fldID:id})
				:type=="date"?input({"class":"editField dateFld", type:"text", value:val, fldID:id})
				:type=="textHTML"?textarea({"class":"editField", fldID:id}, val)
				:type=="refList"?input({"class":"editField refList", type:"text", value:val, fldID:id})
				:type=="rights"?table({"class":"rightsTable", style:style({width:400, height:300})})
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
				
				function buildFieldControls(){
					contentPnl.find(".dateFld").datebox({
						formatter: $A.date.format,
						parser: $A.date.parse
					}).end().find(".refList").combobox({
						valueField:'id',
						textField:'text',
						multiple:true,
						loader:function(prm, onSuccess, onError){
							$A.dataSource.getRefRows({rowID:_.rowID, catID:_.catID}, onSuccess, onError);
						}
					}).end().find(".rightsTable").treegrid({
						treeField:"name",
						loader:function(groupID, onSuccess, onError){
							$A.dataSource.getPermissions(groupID, onSuccess, onError);
						},
						columns:[[
							{field:"name", title:"Catalog", width:200},
							{field:"read", title:"Read", width:80, editor:"checkbox"},
							{field:"write", title:"Write", width:80, editor:"checkbox"}
						]]
					});
				}
				
				$("#"+dlgID).dialog("open");
				if(_.rowID){
					$A.dataSource.getRecord(_.rowID, _.catID, function(data){
						contentPnl.html(templates.dialog(data));
						buildFieldControls();
					}, $A.displayError);
				}
				else{
					$A.dataSource.getAllColumns(_.catID, function(data){
						contentPnl.html(templates.dialog({columns:data}));
						buildFieldControls();
					});
				}
			},
			onSaved: function(){}
		});
	};
})(jQuery, Arundo, Html);