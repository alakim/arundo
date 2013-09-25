(function($, $A, H){
	function template(){with(H){
		return div({"class":"easyui-layout", style:"width:1200px;height:400px;"},
			div({"data-options":"region:'west',split:true", title:$A.locale.getItem("catalogs"), style:"width:220px;"},
				ul({"class":"catTreePnl"})
			),
			div({"data-options":"region:'center',title:false"},
				div({"class":"dataGridPnl"})
			)
		);
	}}
	
	function buildEditor(pnl, rowEditor, rootID){
		pnl.html(template())
			.find(".easyui-layout").layout();
		
		pnl.find(".catTreePnl").tree({
			loader: function(prm, onSuccess, onError){
				$A.dataSource.getCatalogTree({rootID: rootID}, onSuccess, onError);
			},
			onClick: function(node){
				$A.dataSource.getColumns(node.id, function(columns){
					pnl.find(".dataGridPnl").datagrid({
						loader: $A.dataSource.getTable,
						columns:[columns],
						queryParams:{catID:node.id}
					});
				});
			}
		});
		$A.dataSource.getColumns(rootID, function(columns){
			pnl.find(".dataGridPnl").datagrid({
				loader: $A.dataSource.getTable,
				columns: [columns],
				queryParams:{catID:rootID},
				singleSelect: true,
				onClickRow: rowEditor.open
			})
		})
	}
	
	$.fn.catalogEditor = (function(rootID){
		$(this).each(function(i,el){
			buildEditor($(el), new RowEditor(), rootID);
		});
	});
})(jQuery, Arundo, Html);