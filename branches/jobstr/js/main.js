requirejs.config({
    baseUrl: "js",
    paths: {
		jquery: "lib/jquery-1.7.2.min",
		html:"lib/html",
		knockout:"lib/knockout-3.1.0",
        lib: "lib",
		dataSource:"test/dataSource",
		"const":"test/const"
    },
	shim:{
		"html":{exports:"Html"}
	}
});

requirejs(["jquery", "html", "forms/mainPage", "forms/vacSearch", "forms/resSearch"], function   ($, $H, mainPage, vacSearch, resSearch) {
	var mainPnl = $(".mainPanel");
	
	mainPage.view(mainPnl);

	$("#bDefault").attr({href:"#"}).click(function(){
		mainPage.view(mainPnl);
	});
	
	$("#bVacSearch").attr({href:"#"}).click(function(){
		vacSearch.view(mainPnl);
	});
	
	$("#bResSearch").attr({href:"#"}).click(function(){
		resSearch.view(mainPnl);
	});
});