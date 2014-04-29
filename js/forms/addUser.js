﻿define(["html", "knockout", "validation", constModule, "forms/common", "dataSource"], function($H, ko, validation, $C, common, ds){
	
	function template(){with($H){
		function star(){with($H){
			return span({style:"color:red"}, "*");
		}}
		function validMsg(field){with($H){
			return span({"class":"validation", "data-bind":"text:"+field+".validationMessage"})
		}}

		return div({"class":"dialog"},
			h2("Регистрация пользователя"),
			table({width:"100%", border:0, cellpadding:3, cellspacing:0},
				tr(
					td({width:250}, "Имя"),
					td(input({type:"text", "data-bind":"value:name"}), validMsg("name"))
				),
				tr(
					td("Логин", star()),
					td(input({type:"text", "data-bind":"value:login"}), validMsg("login"))
				),
				tr(
					td("Пароль", star()),
					td(input({type:"password", "data-bind":"value:password"}), validMsg("password"))
				),
				tr(
					td("Подтверждение пароля", star()),
					td(input({type:"password", "data-bind":"value:password2"}), validMsg("password2"))
				),
				tr(
					td("EMail", star()),
					td(input({type:"text", "data-bind":"value:email"}), validMsg("email"))
				),
				
				tr(
					td(
						div("Код подтверждения", star()),
						div(img({"data-bind":"attr:{src:captcha.imgUrl}"})),
						div(input({type:"button", value:"Показать другой код", "data-bind":"click:updateCaptcha"}))
					),
					td(
						input({type:"text", "data-bind":"value:captcha.code"}), validMsg("captcha.code")
					)
				),
				tr(td({colspan:2, align:"center"},  
					p("Поля, отмеченные символом", star(), " , обязательны для заполнения."),
					input({type:"button", value:"Разместить резюме", "data-bind":"click:send"})
				))
			),
			div({"class":"resultPanel"})
		);
	}}
	
	function resultTemplate(result){with($H){
		return div(
			"Спасибо, Вы зарегистрированы на сайте."
		);
	}}
	
	function RequestModel(){var _=this;
		_.name = ko.observable("").extend({required:"Укажите имя пользователя"});;
		_.login = ko.observable("").extend({required:"Укажите логин"});
		
		_.password = ko.observable("").extend({required:"Укажите пароль"});
		_.password2 = ko.observable("").extend({required:{message:"Подтвердите пароль", equalsField:_.password}});
		

		_.email = ko.observable("").extend({requiredEMail:true});
		
		_.captcha = {
			key: ko.observable(),
			code: ko.observable("").extend({required:"Введите код подтверждения"})
		};
		_.captcha.imgUrl = ko.computed(function(){
			return "captcha/image.php?k=" + this.captcha.key();
		}, _);
		
		_.updateCaptcha = function(){
			_.captcha.key((new Date().getTime())+"");
		};

		_.send = function(){
			if(!validation.validate(_)) return;
			if(_.password!=_.password2){
				alert("Пароли не совпадают!");
				return;
			}
			
			var data = common.getModelFields(_, "name;login;password;email"),
				pnl = $(".content .resultPanel");
			data.captcha = {key:_.captcha.key, code:_.captcha.code()};
			
			common.wait(pnl);
			ds.addUser(data, function(result){
				result = $.parseJSON(result);
				if(result.error){
					alert(result.error=="Bad CAPTCHA code."?"Неправильный код подтверждения":("Ошибка сохранения данных:"+result.error));
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
			
			var model = new RequestModel();
			ko.applyBindings(model, pnl.find("div")[0]);
			model.updateCaptcha();
		}
	};
});