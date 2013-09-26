(function($, $A, H){
	function template(){with(H){
		return div({"class":"easyui-layout", style:"width:1200px;height:400px;"},
			div({"data-options":"region:'west',split:true", title:$A.locale.getItem("catalogs"), style:"width:220px;"},
				div({"class":"toolBar"},
					a({"class":"toolButton btTreeEditNode"}),
					a({"class":"toolButton btTreeAddNode"}),
					a({"class":"toolButton btTreeDelNode"})
				),
				ul({"class":"catTreePnl"})
			),
			div({"data-options":"region:'center',title:false"},
				div({"class":"dataGridPnl"})
			)
		);
	}}
	
	function buildTreeTools(pnl){
		pnl.find(".toolBar .toolButton").linkbutton({plain: true});
		pnl.find(".toolBar .btTreeEditNode").linkbutton({iconCls: "icon-edit"})
			.tooltip({deltaX:20, content:$A.locale.getItem("btEdit")})
			.click(function(){
				alert("edit tree node");
			});
		pnl.find(".toolBar .btTreeAddNode").linkbutton({iconCls: "icon-add"})
			.tooltip({content:$A.locale.getItem("btNew")})
			.click(function(){
				alert("add tree node");
			});
		pnl.find(".toolBar .btTreeDelNode").linkbutton({iconCls: "icon-remove"})
			.tooltip({content:$A.locale.getItem("btDelete")})
			.click(function(){
				alert("delete tree node");
			});
	}
	
	function buildEditor(pnl, rowEditor, rootID){
		
		function deleteRows(rowIDs){
			if(rowIDs.length){
				$.messager.confirm($A.locale.getItem("confirm"), $A.locale.getItem("confirmDeleteRows"),function(r){
					if (r) $A.dataSource.deleteRows(rowIDs, refreshGrid, $A.displayError);
				});
			}
			else{
				$.messager.alert($A.locale.getItem("warning"), $A.locale.getItem("warningSelRows2Del"), "warning");
			}
		}
		
		function addSysColumns(columns){
			return [{checkbox:true}].concat(columns);
		}

		function refreshGrid(){
			pnl.find(".dataGridPnl").datagrid("reload");
		}
		
		pnl.html(template())
			.find(".easyui-layout").layout();
		
		pnl.find(".catTreePnl").tree({
			loader: function(prm, onSuccess, onError){
				$A.dataSource.getCatalogTree({rootID: rootID}, onSuccess, onError);
			},
			onClick: function(node){
				rowEditor.catID = node.id;
				$A.dataSource.getTableColumns(node.id, function(columns){
					columns = addSysColumns(columns);
					pnl.find(".dataGridPnl").datagrid({
						loader: $A.dataSource.getTable,
						columns:[columns],
						queryParams:{catID:node.id}
					});
				});
			}
		});
		buildTreeTools(pnl);
		
		$A.dataSource.getTableColumns(rootID, function(columns){
			columns = addSysColumns(columns);
			pnl.find(".dataGridPnl").datagrid({
				loader: $A.dataSource.getTable,
				columns: [columns],
				queryParams:{catID:rootID},
				singleSelect: true,
				selectOnCheck: false,
				onClickRow: function(rowIdx, rowData){
					rowEditor.open(rowData.id);
				},
				toolbar: [
					{
						iconCls: 'icon-add',
						text: $A.locale.getItem("btNew"),
						handler: function(){rowEditor.open();}
					},
					{
						iconCls: 'icon-remove',
						text: $A.locale.getItem("btDelete"),
						handler: function(){
							var rows = pnl.find(".dataGridPnl").datagrid("getChecked");
							var rowIDs = [];
							$.each(rows, function(i, row){
								rowIDs.push(row.id);
							});
							deleteRows(rowIDs);
						}
					},'-',
					{
						iconCls: 'icon-help',
						handler: function(){
							$.messager.alert("Under Construction", "See project site for more help", "info");
						}
					}
				]
			})
		});
		rowEditor.catID = rootID;
		rowEditor.onSaved = refreshGrid;
		
	}

	$.fn.catalogEditor = (function(rootID){
		$(this).each(function(i,el){
			buildEditor($(el), new RowEditor(), rootID);
		});
	});
})(jQuery, Arundo, Html);