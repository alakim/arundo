define(["html", "knockout", "validation", constModule, "forms/common", "dataSource"], function($H, ko, validation, $C, common, ds){
	
	function template(){with($H){
		function star(){with($H){
			return span({style:"color:red"}, "*");
		}}
		function validMsg(field){with($H){
			return span({"class":"validation", "data-bind":"text:"+field+".validationMessage"})
		}}

		return div({"class":"dialog"},
			h2("Размещение резюме"),
			table({width:"100%", border:0, cellpadding:3, cellspacing:0},
				tr(th({colspan:2, align:"left"}, "Личные данные")),
				tr(td({width:200}, "Ф.И.О.", star()), td(input({type:"text", "data-bind":"value:fio"}), validMsg("fio"))),
				tr(td("Возраст", star()), td(input({type:"text", "data-bind":"value:age"}), validMsg("age"))),
				tr(
					td("Пол", star()), 
					td(select({"data-bind":"value:sex"},
						option({value:"-1"}, " "),
						option({value:"1"}, "Мужской"),
						option({value:"0"}, "Женский")
					), validMsg("sex"))
				),
				tr(
					td("Регион проживания"), 
					td(select({"data-bind":"options:regions, value:region, optionsValue:'id', optionsText:'name'"}))
				),
				tr(th({colspan:2, align:"left"}, "Пожелания")),
				tr(
					td("Рубрика", star()), 
					td(select({"data-bind":"options:rubrics, value:rubric, optionsValue:'id', optionsText:'name'"}))
				),
				tr(
					td("Должность", star()), 
					td(input({type:"text", "data-bind":"value:post"}), validMsg("post"))
				),
				tr(
					td("Зарплата"), 
					td(input({type:"text", "data-bind":"value:salary"}))
				),
				tr(
					td("График"), 
					td(select({"data-bind":"options:schedules, value:schedule, optionsValue:'id', optionsText:'name'"}))
				),
				
				tr(th({colspan:2, align:"left"}, "Резюме")),
				tr(
					td("Образование", star()), 
					td(select({"data-bind":"options:educations, value:education, optionsValue:'id', optionsText:'name'"}), validMsg("education"))
				),
				tr(
					td("Опыт работы", star()), 
					td(select({"data-bind":"options:experiences, value:experience, optionsValue:'id', optionsText:'name'"}), validMsg("experience"))
				),
				tr(
					td("Профессиональные навыки и умения"), 
					td(textarea({"data-bind":"value:skills"}))
				),
				
				tr(th({colspan:2, align:"left"}, "Контактная информация")),
				tr(
					td("Телефон"), 
					td(input({type:"text", "data-bind":"value:phone"}))
				),
				tr(
					td("E-Mail", star()), 
					td(input({type:"text", "data-bind":"value:email"}), validMsg("email"))
				),
				
				tr(th({colspan:2, align:"left"}, "Условия размещения")),
				tr(td({colspan:2},
					div({"class":"rule_placing"})
				)),
				tr(
					td({colspan:2}, input({type:"checkbox", "data-bind":"checked:agree"}), "Я принимаю условия соглашения", star(), validMsg("agree"))
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
			"Спасибо, Ваше резюме размещено на сайте."
		);
	}}
	
	function RequestModel(){var _=this;
		_.fio = ko.observable("").extend({required:"Введите Ф.И.О."});
		_.age = ko.observable("").extend({required:{message:"Укажите возраст", regex:/^\d+$/}});
		
		_.regions = $C.regions;
		_.region = ko.observable(_.regions[0]);
		_.sex = ko.observable().extend({required:{message:"Укажите пол", condition:"x|x!=-1"}});
		
		_.rubrics = [{id:0, name:"[Все рубрики]"}].concat($C.rubrics);
		_.rubric = ko.observable(_.rubrics[0]);
		
		_.post = ko.observable("").extend({required:"Укажите должность"});
		_.salary = ko.observable("");
		
		_.schedules = $C.schedules;
		_.schedule = ko.observable(_.schedules[0]);
		
		_.educations = [{id:"-1", name:"   "}].concat($C.educations);
		_.education = ko.observable(_.educations[0]).extend({required:{message:"Укажите образование", condition:"x|x!=-1"}});
		
		_.experiences = [{id:"-1", name:"   "}].concat($C.experiences);
		_.experience = ko.observable(_.experiences[0]).extend({required:{message:"Укажите опыт работы", condition:"x|x!=-1"}});
		
		_.skills = ko.observable("");
		_.phone = ko.observable("");
		_.email = ko.observable("").extend({requiredEMail:true});
		_.agree = ko.observable(false).extend({required:{message:"Вы должны принять условия соглашения", value:true}});
		
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
			
			var data = common.getModelFields(_, "fio;age;region;rubric;sex;post;salary;schedule;education;experience;skills;phone;email;agree"),
				pnl = $(".content .resultPanel");
			data.captcha = {key:_.captcha.key, code:_.captcha.code()};
			
			common.wait(pnl);
			ds.addResume(data, function(result){
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