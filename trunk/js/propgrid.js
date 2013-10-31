(function($, $A, $H){
	var templates = {
		grid: function(data){with($H){
			return div(
				table({border:1, cellpadding:3, cellspacing:0},
					apply(data.columns, function(col, id){
						col.id = id;
						return tr(
							th(col.title),
							td(templates.cell(col, data.values[col.id]))
						);
					})
				)
			);
		}},
		cell: function(col, val){with($H){
			if(!col.editor) col.editor = "text";
			if(col.editor=="fixed") return val;
			if([col.editor.type, col.editor].indexOf("treeRef")>=0){
				return input({"class":"treeRef", colID:col.id, type:"text", value:val});
			}
			if(col.editor=="text"){
				return input({type:"text", colID:col.id, value:val});
			}
		}}
	};
	
	function buildGrid(pnl, options){
		var data = options.data;
		pnl.html(templates.grid(data));
		pnl.find(".treeRef").each(function(i, fld){fld = $(fld);
			var colID = fld.attr("colID");
			fld.combotree(data.columns[colID].editor.options);
		});
	}
	
	$.fn.propertyGrid = function(options){
		$(this).each(function(i, el){
			buildGrid($(el), options);
		});
	};
})(jQuery, Arundo, Html);