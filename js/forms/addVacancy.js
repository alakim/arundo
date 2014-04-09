﻿define(["html", "knockout", "const", "forms/common", "dataSource"], function($H, ko, $C, common, ds){	function template(){with($H){		function star(){			return span({style:"color:red"}, "*");		}		return div({"class":"dialog"},			h2("Размещение вакансии"),			table({width:"100%", border:0, cellpadding:3, cellspacing:0},							tr(th({colspan:2, align:"left"}, "Информация о вакансии")),				tr(td({width:200}, "Название организации", star()), td(input({type:"text","data-bind":"value:organization"}))),				tr(					td("Рубрика", star()), 					td(select({"data-bind":"options:rubrics, value:rubric, optionsValue:'id', optionsText:'name'"}))				),				tr(					td("Должность", star()), 					td(input({type:"text", "data-bind":"value:post"}))				),				tr(					td("Зарплата"), 					td(						"от ", input({type:"text", "data-bind":"value:salaryMin"}),						" до ", input({type:"text", "data-bind":"value:salaryMax"})					)				),				tr(					td("График работы"), 					td(select({"data-bind":"options:schedules, value:schedule, optionsValue:'id', optionsText:'name'"}))				),				tr(					td("Дополнительная информация"), 					td(textarea({"data-bind":"value:addInfo"}))				),								tr(th({colspan:2, align:"left"}, "Требования к соискателю ")),				tr(td("Возраст", star()), td(input({type:"text", "data-bind":"value:age"}))),				tr(					td("Пол", star()), 					td(select({"data-bind":"value:sex"},						option({value:"1"}, "Мужской"),						option({value:"0"}, "Женский")					))				),				tr(					td("Образование", star()), 					td(select({"data-bind":"options:educations, value:education, optionsValue:'id', optionsText:'name'"}))				),				tr(th({colspan:2, align:"left"}, "Расположение места работы")),				tr(					td("Регион"), 					td(select({"data-bind":"options:regions, value:region, optionsValue:'id', optionsText:'name'"}))				),								tr(th({colspan:2, align:"left"}, "Контактная информация")),				tr(					td("Контактное лицо"), 					td(input({type:"text", "data-bind":"value:contactPerson"}))				),				tr(					td("Телефон"), 					td(input({type:"text", "data-bind":"value:phone"}))				),				tr(					td("E-Mail", star()), 					td(input({type:"text", "data-bind":"value:email"}))				),																				tr(th({colspan:2, align:"left"}, "Условия размещения")),				tr(td({colspan:2},					div({"class":"rule_placing"})				)),				tr(					td({colspan:2}, input({type:"checkbox", "data-bind":"checked:agree"}), "Я принимаю условия соглашения", star())				),				tr(td({colspan:2, align:"center"}, 					p("Поля, отмеченные символом", star(), " , обязательны для заполнения."),					input({type:"button", value:"Разместить вакансию", "data-bind":"click:send"})				))			),			div({"class":"resultPanel"})		);	}}		function resultTemplate(result){with($H){		return div(			"Спасибо, вакансия размещена на сайте."		);	}}		function RequestModel(){var _=this;		_.organization = ko.observable();				_.rubrics = [{id:0, name:"[Выберите рубрику]"}].concat($C.rubrics);		_.rubric = ko.observable(_.rubrics[0]);			_.post = ko.observable("");		_.salaryMin = ko.observable("");		_.salaryMax = ko.observable("");				_.schedules = $C.schedules;		_.schedule = ko.observable(_.schedules[0]);				_.addInfo = ko.observable("");				_.age = ko.observable();		_.sex = ko.observable();				_.educations = $C.educations;		_.education = ko.observable(_.educations[0]);			_.regions = $C.regions;		_.region = ko.observable(_.regions[0]);				_.contactPerson = ko.observable("");		_.phone = ko.observable("");		_.email = ko.observable("");		_.agree = ko.observable(false);		_.send = function(){			var data = common.getModelFields(_, "organization;rubric;post;salaryMin;salaryMax;schedule;addInfo;sex;age;education;region;contactPerson;phone;email;agree"),				pnl = $(".content .resultPanel");			common.wait(pnl);			ds.addVacancy(data, function(result){				$(".mainPanel").html(resultTemplate(result))			});		}	}		return {		view: function(pnl){			pnl.html(template());			pnl.find(".rule_placing").html($("#vacRulesTemplate").html());						ko.applyBindings(new RequestModel(), pnl.find("div")[0]);		}	};});