﻿define(["html", "knockout", constModule, "forms/common", "dataSource"], function($H, ko, $C, common, ds){
	function template(){with($H){
		return div(
			h2("Быстрый поиск")
		);
	}}
	
	function RequestModel(){var _=this;
		
	}
	
	return {
		view: function(pnl){
			pnl.html(template());
			ko.applyBindings(new RequestModel(), pnl.find("div")[0]);
		}
	};
});