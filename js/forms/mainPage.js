﻿define(["html", "forms/topList"], function($H, topList){
	function template(){with($H){
		return div(
			div({id:"pnlTopList"})
		);
	}}
	
	return {
		view: function(pnl){
			pnl.html(template());
			
			topList.view($("#pnlTopList"));
			
		}
	};
});