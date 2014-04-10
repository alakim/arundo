var localMode = window.location.href.match(/^file:\/\/\//i),
	constModule = localMode?"test/const":"/const.php";
	
requirejs.config({
    baseUrl: "js",
    paths: {
		jquery: "lib/jquery-1.7.2.min",
		html:"lib/html",
		knockout:"lib/knockout-3.1.0",
        lib: "lib",
		dataSource:localMode?"test/dataSource":"dataSource"
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
			
		if(localMode){
			$("body").append($H.div({style:"position:absolute; left:400px; top:10px; background-color:yellow; color:red; font-weight:bold; border:1px solid red; padding:15px;"}, "LOCAL TEST MODE"));
		}
		
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