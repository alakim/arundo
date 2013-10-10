(function($, $A, H){
	$.fn.mainForm = (function(){
		function template(tree){with(H){
			return markup(
				ul({"class":"mainMenu"},
					li(a({"class":"logoff"}, $A.locale.getItem("Logoff"))),
					li(a({"class":"subtree"}, $A.locale.getItem("wholeTree"))),
					apply(tree, function(el){
						return li(a({"class":"subtree", catID:el.id},
							el.text
						));
					})
				),
				div(
					form({id:"frmLogoff", action:"logon.php", method:"post"},
						input({type:"hidden", name:"hAction", value:"logoff"})
					)
				)
			);
		}}
		
		function buildForm(pnl){
			$A.dataSource.getCatalogTree({depth:1}, function(tree){
				pnl.html(template(tree))
					.find("a.subtree").linkbutton({plain: true})
					.click(function(){
						var catID = $(this).attr("catID");
						var title = $(this).text();
						$A.view.addPanel(catID+"pnl", title);
						$A.view.getSelectedTab().catalogEditor(catID);
					})
					.end().find("a.logoff").linkbutton({plain: true})
					.click(function(){
						$("#frmLogoff").submit();
					});
			});
		}
		
		$(this).each(function(i,el){
			buildForm($(el));
		});
	});
})(jQuery, Arundo, Html);