(function($, $A, H){
	function template(){with(H){
		return div({"class":"easyui-layout", style:"width:1200px;height:400px;"},
			div({"data-options":"region:'west',split:true", title:$A.locale.getItem("catalogs"), style:"width:220px;"},
				div({"class":"toolBar"},
					a({"class":"toolButton btTreeEditNode"}),
					a({"class":"toolButton btTreeAddNode"}),
					a({"class":"toolButton btTreeDelNode"}),
					a({"class":"toolButton btTreeOpenNode"}),
					a({"class":"toolButton btRefreshTree"})
				),
				ul({"class":"catTreePnl"})
			),
			div({"data-options":"region:'center',title:false"},
				div({"class":"dataGridPnl"})
			)
		);
	}}
	
	
	function buildEditor(pnl, rowEditor, treeNodeEditor, rootID){
		
		function buildTreeTools(){
			pnl.find(".toolBar .toolButton").linkbutton({plain: true});
			pnl.find(".toolBar .btTreeEditNode").linkbutton({iconCls: "icon-edit"})
				.tooltip({deltaX:20, content:$A.locale.getItem("btEdit")})
				.click(function(){
					var selected = pnl.find(".catTreePnl").tree('getSelected');
					if(!selected){$A.displayWarning($A.locale.getItem("warningSelectAnyCatalog")); return;}
					treeNodeEditor.open(selected.id);
				});
			pnl.find(".toolBar .btTreeAddNode").linkbutton({iconCls: "icon-add"})
				.tooltip({content:$A.locale.getItem("btNew")})
				.click(function(){
					treeNodeEditor.open();
				});
			pnl.find(".toolBar .btTreeDelNode").linkbutton({iconCls: "icon-remove"})
				.tooltip({content:$A.locale.getItem("btDelete")})
				.click(function(){
					$.messager.confirm($A.locale.getItem("confirm"), $A.locale.getItem("confirmDeleteCat"), function(r){
						if(r) $A.dataSource.deleteCatalog(treeNodeEditor.catID, refreshTree, $A.displayError);
					});
				});
			pnl.find(".toolBar .btTreeOpenNode").linkbutton({iconCls: "icon-redo"})
				.tooltip({content:$A.locale.getItem("btOpenNewWindow")})
				.click(function(){
					var selected = pnl.find(".catTreePnl").tree('getSelected');
					if(!selected){$A.displayWarning($A.locale.getItem("warningSelectAnyCatalog")); return;}
					$A.view.addPanel(selected.id+"pnl", selected.text);
					$A.view.getSelectedTab().catalogEditor(selected.id);
				});
			pnl.find(".toolBar .btRefreshTree").linkbutton({iconCls: "icon-reload"})
				.tooltip({content:$A.locale.getItem("btRefresh")})
				.click(refreshTree);
		}
		
		function deleteRows(rowIDs){
			if(rowIDs.length){
				$.messager.confirm($A.locale.getItem("confirm"), $A.locale.getItem("confirmDeleteRows"),function(r){
					if(r) $A.dataSource.deleteRows(rowIDs, refreshGrid, $A.displayError);
				});
			}
			else{
				$A.displayWarning($A.locale.getItem("warningSelRows2Del"));
			}
		}
		
		function addSysColumns(columns){
			return [{checkbox:true}].concat(columns);
		}

		function refreshGrid(){pnl.find(".dataGridPnl").datagrid("reload");}
		function refreshTree(){pnl.find(".catTreePnl").tree("reload");}
		
		pnl.html(template())
			.find(".easyui-layout").layout();
		
		pnl.find(".catTreePnl").tree({
			loader: function(prm, onSuccess, onError){
				$A.dataSource.getCatalogTree({rootID: rootID}, onSuccess, onError);
			},
			onClick: function(node){
				rowEditor.catID = node.id;
				treeNodeEditor.catID = node.id;
				$A.dataSource.getTableColumns(node.id, function(columns){
					columns = addSysColumns(columns);
					pnl.find(".dataGridPnl").datagrid({
						loader: $A.dataSource.getTable,
						columns:[columns],
						queryParams:{catID:node.id},
						onClickRow: function(rowIdx, rowData){
							rowEditor.open(rowData.id);
						}
					});
				}, $A.displayError);
			}
		});
		buildTreeTools(pnl, treeNodeEditor);
		
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
		}, $A.displayError);
		rowEditor.catID = rootID;
		rowEditor.onSaved = refreshGrid;
		
		treeNodeEditor.catID = rootID;
		treeNodeEditor.onSaved = refreshTree;
		
	}

	$.fn.catalogEditor = (function(rootID){
		$(this).each(function(i,el){
			buildEditor($(el), new RowEditor(), new TreeNodeEditor(), rootID);
		});
	});
})(jQuery, Arundo, Html);