define(["jquery", "cookie", "html", "knockout", "dataSource", "user", "forms/common", "actions", "forms/resList", "forms/vacList", "forms/addUser", "forms/userEdit"], 
	function($, $C, $H, ko, ds, user, common, Actions, resList, vacList, addUser, userEdit){

	
	function buildAnonymousPanel(panel){
		function template(){with($H){
			return div({"class":"formPnl"},
				div({"class":"section_title_noslash"}, "Вход"),
				table({border:0, cellpadding:3, cellspacing:0},
					tr(
						td("Логин"),
						td(input({type:"text", "data-bind":"value:login"})),
						td()
					),
					tr(
						td("Пароль"),
						td(input({type:"password", "data-bind":"value:password"})),
						td(input({type:"button", "data-bind":"click:logon", value:"Войти"}))
					)
				),
				p({style:"text-align:right; margin-right:10px;"}, a({id:"userRegistration", href:"#"}, "Зарегистрироваться"))
			);
		}}
		
		panel.html(template());
		common.actions.bind("#userRegistration", "userRegistration");
		ko.applyBindings(new LogonModel(), panel.find(".formPnl")[0]);
	}
	
	function buildAuthorizedPanel(panel, uData){
		function template(data){with($H){
			return div({"class":"formPnl"},
				p("Добро пожаловать, ", data.userName, "!"),
				p(input({type:"button", "data-bind":"click:logoff", value:"Выйти"})),
				h3("Резюме"),
				p(a({id:"allResume", href:"#"}, "Все резюме (", data.resCount,")")),
				h3("Вакансии"),
				p(a({id:"allVacancies", href:"#"}, "Все вакансии (", data.vacCount,")")),
				hr(),
				p(a({id:"personalData", href:"#"}, "Личный кабинет"))
			);
		}}
		
		panel.html(template({
			id: user.id, ticket:user.ticket, 
			userName: uData.name,
			resCount: uData.resCount,
			vacCount: uData.vacCount
		}));
		common.actions.bind("#allResume", "viewResList");
		common.actions.bind("#allVacancies", "viewVacList");
		common.actions.bind("#personalData", "viewPersonalData");
		ko.applyBindings(new LogoffModel(), panel.find(".formPnl")[0]);
	}

	var panel,
		hdrPnl = $("#headerPanel");
	
	function clearUser(){
		user.ticket = null;
		user.id = null;
		user.name = null;
		$C.cookie('userID', "");
		$C.cookie('userTicket', "");
	}

	function LogonModel(){var _=this;
		_.login = ko.observable("");
		_.password = ko.observable("");
		_.logon = function(){
			var data = {login:_.login(), password: _.password()};
			common.wait(panel);
			ds.logon(data, function(res){
				if(res.error){
					clearUser();
					buildAnonymousPanel(panel);
				}
				else{
					$.extend(user, res);
					ds.getUserData(function(uData){
						buildAuthorizedPanel(panel, uData);
						$C.cookie('userID', res.id, { expires:1});
						$C.cookie('userTicket', res.ticket, { expires:1});
					});
				}
			});
		}
	}
	
	function LogoffModel(){var _=this;
		_.logoff = function(){
			common.wait(panel);
			ds.logoff({id:user.id, ticket:user.ticket}, function(res){
				if(res.error) alert(res.error);
				clearUser();
				buildAnonymousPanel(panel);
			});
		}
	}
	
	common.actions.add({
		viewResList: function(){
			hdrPnl.html($H.h2("Управление резюме"));
			resList.view($(".mainPanel"));
		},
		viewVacList: function(){
			hdrPnl.html($H.h2("Управление вакансиями"));
			vacList.view($(".mainPanel"));
		},
		userRegistration: function(){
			hdrPnl.html($H.h2("Управление пользователями"));
			addUser.view($(".mainPanel"));
		},
		viewPersonalData: function(){
			hdrPnl.html($H.h2("Личный кабинет"));
			userEdit.view($(".mainPanel"));
		}
	});
	
	return {
		view: function(pnl){
			
			panel = pnl;
			var uid = $C.cookie("userID"),
				ticket = $C.cookie("userTicket");
				
			if(ticket && ticket.length){
				user.id = uid;
				user.ticket = ticket;
				ds.getUserData(function(uData){
					user.name = uData.name;
					buildAuthorizedPanel(pnl, uData);
				});
			}
			else{
				buildAnonymousPanel(pnl);
			}
		}
	};
});