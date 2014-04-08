﻿define(["html", "knockout", "const", "forms/common", "dataSource"], function($H, ko, $C, common, ds){	function template(){with($H){		function star(){			return span({style:"color:red"}, "*");		}		return div({"class":"dialog"},			h2("Размещение резюме"),			table({width:"100%", border:0, cellpadding:3, cellspacing:0},				tr(th({colspan:2, align:"left"}, "Личные данные")),				tr(td({width:200}, "Ф.И.О.", star()), td(input({type:"text", "data-bind":"text:fio"}))),				tr(td("Возраст", star()), td(input({type:"text", "data-bind":"text:age"}))),				tr(					td("Пол", star()), 					td(select({"data-bind":"value:sex"},						option({value:"1"}, "Мужской"),						option({value:"0"}, "Женский")					))				),				tr(					td("Регион проживания"), 					td(select({"data-bind":"options:regions, value:region, optionsValue:'id', optionsText:'name'"}))				),				tr(th({colspan:2, align:"left"}, "Пожелания")),				tr(					td("Рубрика", star()), 					td(select({"data-bind":"options:rubrics, value:rubric, optionsValue:'id', optionsText:'name'"}))				),				tr(					td("Должность", star()), 					td(input({type:"text", "data-bind":"value:post"}))				),				tr(					td("Зарплата"), 					td(input({type:"text", "data-bind":"value:salary"}))				),				tr(					td("График"), 					td(select({"data-bind":"options:schedules, value:schedule, optionsValue:'id', optionsText:'name'"}))				),								tr(th({colspan:2, align:"left"}, "Резюме")),				tr(					td("Образование", star()), 					td(select({"data-bind":"options:educations, value:education, optionsValue:'id', optionsText:'name'"}))				),				tr(					td("Опыт работы", star()), 					td(select({"data-bind":"options:experiences, value:experience, optionsValue:'id', optionsText:'name'"}))				),				tr(					td("Профессиональные навыки и умения"), 					td(textarea({"data-bind":"value:skills"}))				),								tr(th({colspan:2, align:"left"}, "Контактная информация")),				tr(					td("Телефон"), 					td(input({type:"text", "data-bind":"value:phone"}))				),				tr(					td("E-Mail", star()), 					td(input({type:"text", "data-bind":"value:email"}))				),								tr(th({colspan:2, align:"left"}, "Условия размещения")),				tr(td({colspan:2},					div({"class":"rule_placing"})				)),				tr(td({colspan:2, align:"center"},  					p("Поля, отмеченные символом", star(), " , обязательны для заполнения."),					input({type:"button", value:"Разместить резюме", "data-bind":"click:send"})				))			),			div({"class":"resultPanel"})		);	}}		function resultTemplate(result){with($H){		return div(			"Спасибо, Ваше резюме размещено на сайте."		);	}}		function RequestModel(){var _=this;		_.fio = ko.observable();		_.age = ko.observable();				_.regions = $C.regions;		_.region = ko.observable(_.regions[0]);		_.sex = ko.observable();				_.rubrics = [{id:0, name:"[Все рубрики]"}].concat($C.rubrics);		_.rubric = ko.observable(_.rubrics[0]);				_.post = ko.observable("");		_.salary = ko.observable("");				_.schedules = $C.schedules;		_.schedule = ko.observable(_.schedules[0]);				_.educations = $C.educations;		_.education = ko.observable(_.educations[0]);				_.experiences = $C.experiences;		_.experience = ko.observable(_.experiences[0]);				_.skills = ko.observable("");		_.phone = ko.observable("");		_.email = ko.observable("");						_.getData = function(){			return {				fio: _.fio(),				age: _.age(),				region: _.region(),				rubric: _.rubric(),				sex: _.sex(),				post: _.post(),				salary: _.salary(),				schedule: _.schedule(),				education: _.education(),				experience: _.experience(),				skills: _.skills(),				phone: _.phone(),				email: _.email()			};		},		_.send = function(){			var data = this.getData(),				pnl = $(".content .resultPanel");			common.wait(pnl);			ds.addResume(data, function(result){				$(".mainPanel").html(resultTemplate(result))			});		}	}		return {		view: function(pnl){			pnl.html(template());			pnl.find(".rule_placing").html($("#resRulesTemplate").html());						ko.applyBindings(new RequestModel(), pnl.find("div")[0]);		}	};});