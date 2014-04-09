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
		"jquery", "html", "actions",
		"forms/mainPage", 
		"forms/vacSearch", "forms/resSearch", "forms/qSearch",
		"forms/addResume", "forms/addVacancy",
		"forms/authentication"
	], function($, $H, Actions, mainPage, vacSearch, resSearch, qSearch, addResume, addVacancy, auth) {
		var mainPnl = $(".mainPanel"),
			hdrPnl = $("#headerPanel");
		
		mainPage.view(mainPnl);
		
		var actions = new Actions({
			main: function(){
				mainPage.view(mainPnl);
				qSearch.view(hdrPnl);
			},
			vacSearch: function(){
				hdrPnl.html($H.h2("Раздел для соискателей"));
				vacSearch.view(mainPnl);
			},
			addResume: function(){
				hdrPnl.html($H.h2("Раздел для соискателей"));
				addResume.view(mainPnl);
			},
			resSearch: function(){
				hdrPnl.html($H.h2("Раздел для работодателей"));
				resSearch.view(mainPnl);
			},
			addVacancy: function(){
				hdrPnl.html($H.h2("Раздел для работодателей"));
				addVacancy.view(mainPnl);
			}
		})

		actions.bind("#bDefault", "main");
		actions.bind("#bVacSearch", "vacSearch");
		actions.bind("#bAddResume", "addResume");
		actions.bind("#bResSearch", "resSearch");
		actions.bind("#bAddVacancy", "addVacancy");
		
		
		auth.view($("#pnlLogon"));
		
	}
);