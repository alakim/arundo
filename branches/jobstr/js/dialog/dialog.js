define(["jquery", "forms/common"], function($, common){
	common.requireCSS("js/dialog/dialog.css");
	
	return {
		open: function(){
			$(".dialog").html("opened!");
		},
		close: function(){
			$(".dialog").html("");
		}
	};
});