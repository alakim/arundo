define(["html", "knockout", "validation", constModule, "forms/common", "dataSource"], function($H, ko, validation, $C, common, ds){
	function template(){with($H){
		function validMsg(field){with($H){
			return span({"class":"validation", "data-bind":"text:"+field+".validationMessage"})
		}}
		
		return div({"class":"dialog"},
			h2("Редактирование вакансии"),
			table({width:"100%", border:0, cellpadding:3, cellspacing:0},
			
				tr(th({colspan:2, align:"left"}, "Информация о вакансии")),
				tr(td({width:200}, "Название организации"), td(
					input({type:"text","data-bind":"value:organization"}),
					validMsg("organization")
				)),
				tr(
					td("Рубрика"), 
					td(select({"data-bind":"options:rubrics, value:rubric, optionsValue:'id', optionsText:'name'"}), validMsg("rubric"))
				),
				tr(
					td("Должность"), 
					td(
						input({type:"text", "data-bind":"value:post"}),
						validMsg("post")
					)
				),
				tr(
					td("Зарплата"), 
					td(
						"от ", input({type:"text", "data-bind":"value:salaryMin"}),
						" до ", input({type:"text", "data-bind":"value:salaryMax"})
					)
				),
				tr(
					td("График работы"), 
					td(select({"data-bind":"options:schedules, value:schedule, optionsValue:'id', optionsText:'name'"}))
				),
				tr(
					td("Дополнительная информация"), 
					td(textarea({"data-bind":"value:addInfo"}))
				),
				
				tr(th({colspan:2, align:"left"}, "Требования к соискателю ")),
				tr(td("Возраст"), td(input({type:"text", "data-bind":"value:age"}), validMsg("age"))),
				tr(
					td("Пол"), 
					td(select({"data-bind":"value:sex"},
						option({value:"-1"}, "Любой"),
						option({value:"1"}, "Мужской"),
						option({value:"0"}, "Женский")
					))
				),
				tr(
					td("Образование"), 
					td(select({"data-bind":"options:educations, value:education, optionsValue:'id', optionsText:'name'"}))
				),
				tr(th({colspan:2, align:"left"}, "Расположение места работы")),
				tr(
					td("Регион"), 
					td(select({"data-bind":"options:regions, value:region, optionsValue:'id', optionsText:'name'"}))
				),
				
				tr(th({colspan:2, align:"left"}, "Контактная информация")),
				tr(
					td("Контактное лицо"), 
					td(input({type:"text", "data-bind":"value:contactPerson"}))
				),
				tr(
					td("Телефон"), 
					td(input({type:"text", "data-bind":"value:phone"}))
				),
				tr(
					td("E-Mail"), 
					td(input({type:"text", "data-bind":"value:email"}), validMsg("email"))
				),
				
				tr(td({colspan:2, align:"center"}, 
					input({type:"button", value:"Закрыть", "data-bind":"click:closeWindow", style:"margin-right:12px;"}),
					input({type:"button", value:"Сохранить изменения", "data-bind":"click:saveData", style:"margin-right:12px;"}),
					input({type:"button", value:"Удалить вакансию", "data-bind":"click:delRecord"})
				))
			),
			div({"class":"resultPanel"})
		);
	}}
	
	
	function RequestModel(data){var _=this;
		_.id = data.id;
		_.organization = ko.observable(data.organization).extend({required:"Введите название организации"});
		
		_.rubrics = [{id:0, name:"[Выберите рубрику]"}].concat($C.rubrics);
		_.rubric = ko.observable(data.rubric).extend({required:{message:"Выберите рубрику", condition:"x|x!=0"}});
	
		_.post = ko.observable(data.post).extend({required:"Введите название должности"});
		_.salaryMin = ko.observable(data.salary);
		_.salaryMax = ko.observable("");
		
		_.schedules = $C.schedules;
		_.schedule = ko.observable(data.schedule);
		
		_.addInfo = ko.observable(data.description);
		
		_.age = ko.observable(data.age).extend({required:{message:"Введите возраст", regex:/^\s*\d+\s*$/}});
		_.sex = ko.observable(data.sex);
		
		_.educations = $C.educations;
		_.education = ko.observable(data.education);
	
		_.regions = $C.regions;
		_.region = ko.observable(data.region);
		
		_.contactPerson = ko.observable(data.contact);
		_.phone = ko.observable(data.phone);
		_.email = ko.observable(data.email).extend({requiredEMail:true});

		_.closeWindow = function(){
			$("#vacanciesList").show();
			$("#vacancyEdit").html("").hide();
		};

		_.delRecord = function(){
			if(confirm("Удалить вакансию?")){
				ds.delVacancy(_.id, function(result){
					common.actions.exec("viewVacList");
				});
			}
		};
		
		_.saveData = function(){
			if(!validation.validate(_)) return;
			
			var data = common.getModelFields(_, "organization;rubric;post;salaryMin;salaryMax;schedule;addInfo;sex;age;education;region;contactPerson;phone;email"),
				pnl = $(".content .resultPanel");
			data.id = _.id;
			
			common.wait(pnl);
			ds.saveVacancy(data, function(result){
				result = $.parseJSON(result);
				if(result.error){
					alert("Ошибка сохранения данных:"+result.error);
					return;
				}
				common.actions.exec("viewVacList");
			});
		}
	}
	
	return {
		view: function(id, pnl){pnl=$(pnl);
			
			common.wait(pnl);
			ds.getVacancy(id, function(data){
				pnl.html(template());
				ko.applyBindings(new RequestModel(data), pnl.find("div")[0]);
			});
		}
	};
});