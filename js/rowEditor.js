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
				type=="text"?input({type:"text", value:val, fldID:id})
				:type=="date"?input({"class":"dateFld", type:"text", value:val, fldID:id})
				:type=="textHTML"?textarea({fldID:id}, val)
				:span(val)
			);
		}}
	};
	
	var __={
		open:function(rowIdx, rowData){
			if(!$("#"+dlgID).length){
				$("body").append(Html.div({id:dlgID}));
				$("#"+dlgID)
					.dialog({
						title:$A.locale.getItem("rowEditor"), 
						width: 450, height: 300,
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
				contentPnl.html(templates.dialog(data))
					.find(".dateFld").datebox({
						formatter: function(d){
							var y = d.getFullYear();
							var m = d.getMonth()+1;
							var d = d.getDate();
							if(m<10) m = "0"+m;
							if(d<10) d = "0"+d;
							return [d, m, y].join(".");
						},
						parser: function(s){
							var date = s.split(".");
							var d = parseInt(date[0], 10);
							var m = parseInt(date[1], 10);
							var y = parseInt(date[2], 10);
							return new Date(y, m-1, d);
						}
					});
			}, $A.displayError);
		}
	};
	
	
	
	return __;
})(jQuery, Arundo, Html);