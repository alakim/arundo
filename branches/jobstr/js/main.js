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

requirejs([
		"jquery", "html", 
		"forms/mainPage", 
		"forms/vacSearch", "forms/resSearch", "forms/qSearch",
		"forms/addResume", "forms/addVacancy",
		"forms/authentication"
	], function($, $H, mainPage, vacSearch, resSearch, qSearch, addResume, addVacancy, auth) {
		var mainPnl = $(".mainPanel"),
			hdrPnl = $("#headerPanel");
		
		mainPage.view(mainPnl);

		$("#bDefault").attr({href:"#"}).click(function(){
			mainPage.view(mainPnl);
			qSearch.view(hdrPnl);
		});
		
		$("#bVacSearch").attr({href:"#"}).click(function(){
			hdrPnl.html($H.h2("Раздел для соискателей"));
			vacSearch.view(mainPnl);
		});
		
		$("#bAddResume").attr({href:"#"}).click(function(){
			hdrPnl.html($H.h2("Раздел для соискателей"));
			addResume.view(mainPnl);
		});
		
		$("#bResSearch").attr({href:"#"}).click(function(){
			hdrPnl.html($H.h2("Раздел для работодателей"));
			resSearch.view(mainPnl);
		});
		
		$("#bAddVacancy").attr({href:"#"}).click(function(){
			hdrPnl.html($H.h2("Раздел для работодателей"));
			addVacancy.view(mainPnl);
		});
		
		auth.view($("#ctl00_UPanel_pnlLogon"));
		
		qSearch.view(hdrPnl);
	}
);