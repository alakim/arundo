(function($, $A, $H){
	
	function buildGrid(pnl, options){
		pnl.html("PROPERTY GRID!");
	}
	
	$.fn.propertyGrid = function(options){
		$(this).each(function(i, el){
			buildGrid($(el), options);
		});
	};
})(jQuery, Arundo, Html);