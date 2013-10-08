(function($, $A, H){
	$.fn.mainForm = (function(){
		function template(tree){with(H){
			return ul({"class":"mainMenu"},
				li(a($A.locale.getItem("wholeTree"))),
				apply(tree, function(el){
					return li(a({catID:el.id},
						el.text
					));
				})
			);
		}}
		
		function buildForm(pnl){
			$A.dataSource.getCatalogTree({depth:1}, function(tree){
				pnl.html(template(tree))
					.find("a").linkbutton({plain: true})
					.click(function(){
						var catID = $(this).attr("catID");
						var title = $(this).text();
						$A.view.addPanel(catID+"pnl", title);
						$A.view.getSelectedTab().catalogEditor(catID);
					});
			});
		}
		
		$(this).each(function(i,el){
			buildForm($(el));
		});
	});
})(jQuery, Arundo, Html);