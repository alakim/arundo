var localMode = window.location.href.match(/^file:\/\/\//i),
	constModule = localMode?"test/const":"/const.php";
	
requirejs.config({
    baseUrl: "js",
    paths: {
		jquery: "lib/jquery-1.11.0.min",
		jcook: "lib/jquery.cookie",
		cookie: localMode?"test/cookie":"cookie",
		html:"lib/html",
		knockout:"lib/knockout-3.1.0",
        lib: "lib",
		dataSource:localMode?"test/dataSource":"dataSource"
    },
	urlArgs: "bust=" + (new Date()).getTime(),
	shim:{
		"html":{exports:"Html"}
	}
});

requirejs([
		"jquery", "cookie", "html", "actions", "forms/common",
		"forms/mainPage", 
		"forms/vacSearch", "forms/resSearch", "forms/qSearch",
		"forms/addResume", "forms/addVacancy",
		"forms/authentication"
	], function($, $Cookie, $H, Actions, common, mainPage, vacSearch, resSearch, qSearch, addResume, addVacancy, auth) {
		var mainPnl = $(".mainPanel"),
			hdrPnl = $("#headerPanel");
			
		if(localMode){
			$("body").append($H.div({style:"position:absolute; left:400px; top:10px; background-color:yellow; color:red; font-weight:bold; border:1px solid red; padding:15px;"}, "LOCAL TEST MODE"));
		}
		
		mainPage.view(mainPnl);
		
		common.actions.add({
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

		common.actions.bind("#bDefault", "main");
		common.actions.bind("#bVacSearch", "vacSearch");
		common.actions.bind("#bAddResume", "addResume");
		common.actions.bind("#bResSearch", "resSearch");
		common.actions.bind("#bAddVacancy", "addVacancy");
		
		auth.view($("#pnlLogon"));
		
	}
);