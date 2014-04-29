define(["html", "knockout", "validation", constModule, "forms/common", "dataSource"], function($H, ko, validation, $C, common, ds){
	
	function template(){with($H){
		function validMsg(field){with($H){
			return span({"class":"validation", "data-bind":"text:"+field+".validationMessage"})
		}}

		return div({"class":"dialog"},
			h2("Персональные данные"),
			table({width:"100%", border:0, cellpadding:3, cellspacing:0},
				tr(
					td({width:250}, "Имя"),
					td(input({type:"text", "data-bind":"value:name"}), validMsg("name"))
				),
				tr(
					td("Логин"),
					td(input({type:"text", "data-bind":"value:login"}), validMsg("login"))
				),
				tr(
					td("Пароль"),
					td(input({type:"password", "data-bind":"value:password"}), validMsg("password"))
				),
				tr(
					td("Подтверждение пароля"),
					td(input({type:"password", "data-bind":"value:password2"}), validMsg("password2"))
				),
				tr(
					td("EMail"),
					td(input({type:"text", "data-bind":"value:email"}), validMsg("email"))
				),
				
				tr(td({colspan:2, align:"center"},  
					input({type:"button", value:"Сохранить изменения", "data-bind":"click:saveData"})
				))
			),
			div({"class":"resultPanel"})
		);
	}}
	
	function resultTemplate(result){with($H){
		return div(
			"Персональные данные сохранены."
		);
	}}
	
	function RequestModel(data){var _=this;
		_.id = data.id;
		_.name = ko.observable(data.name).extend({required:"Укажите имя пользователя"});;
		_.login = ko.observable(data.login).extend({required:"Укажите логин"});
		
		_.password = ko.observable(data.password).extend({required:"Укажите пароль"});
		_.password2 = ko.observable(data.password).extend({required:{message:"Подтвердите пароль", equalsField:_.password}});
		

		_.email = ko.observable(data.email).extend({requiredEMail:true});
		
		_.saveData = function(){
			if(!validation.validate(_)) return;
			if(_.password!=_.password2){
				alert("Пароли не совпадают!");
				return;
			}
			var fields = "name;login;email";
			if(_.password.length) fields+=";password";
			
			var data = common.getModelFields(_, fields),
				pnl = $(".content .resultPanel");
			
			common.wait(pnl);
			ds.saveUser(data, function(result){
				result = $.parseJSON(result);
				if(result.error){
					alert("Ошибка сохранения данных:"+result.error);
					return;
				}
				$(".mainPanel").html(resultTemplate(result))
			});
		}
	}
	
	return {
		view: function(pnl){
			pnl.html(template());
			pnl.find(".rule_placing").html($("#resRulesTemplate").html());
			
			ds.getUserData(function(data){
				var model = new RequestModel(data);
				ko.applyBindings(model, pnl.find("div")[0]);
			});
		}
	};
});