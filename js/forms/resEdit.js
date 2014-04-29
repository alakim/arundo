define(["html", "knockout", "validation", constModule, "forms/common", "dataSource"], function($H, ko, validation, $C, common, ds){
	
	function template(){with($H){

		function validMsg(field){with($H){
			return span({"class":"validation", "data-bind":"text:"+field+".validationMessage"})
		}}

		return div({"class":"dialog"},
			h2("Редактирование резюме"),
			table({width:"100%", border:0, cellpadding:3, cellspacing:0},
				tr(th({colspan:2, align:"left"}, "Личные данные")),
				tr(td({width:200}, "Ф.И.О."), td(input({type:"text", "data-bind":"value:fio"}), validMsg("fio"))),
				tr(td("Возраст"), td(input({type:"text", "data-bind":"value:age"}), validMsg("age"))),
				tr(
					td("Пол"), 
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
					td("Рубрика"), 
					td(select({"data-bind":"options:rubrics, value:rubric, optionsValue:'id', optionsText:'name'"}))
				),
				tr(
					td("Должность"), 
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
					td("Образование"), 
					td(select({"data-bind":"options:educations, value:education, optionsValue:'id', optionsText:'name'"}), validMsg("education"))
				),
				tr(
					td("Опыт работы"), 
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
					td("E-Mail"), 
					td(input({type:"text", "data-bind":"value:email"}), validMsg("email"))
				),
				
				tr(td({colspan:2, align:"center"},  
					input({type:"button", value:"Закрыть", "data-bind":"click:closeWindow", style:"margin-right:12px;"}),
					input({type:"button", value:"Сохранить изменения", "data-bind":"click:saveResume", style:"margin-right:12px;"}),
					input({type:"button", value:"Удалить резюме", "data-bind":"click:delResume"})
				))
			),
			div({"class":"resultPanel"})
		);
	}}
	
	function RequestModel(data){var _=this;
		_.id = data.id;
		_.fio = ko.observable(data.fio).extend({required:"Введите Ф.И.О."});
		_.age = ko.observable(data.age).extend({required:{message:"Укажите возраст", regex:/^\d+$/}});
		
		_.regions = $C.regions;
		_.region = ko.observable(data.region);
		_.sex = ko.observable(data.sex).extend({required:{message:"Укажите пол", condition:"x|x!=-1"}});
		
		_.rubrics = [{id:0, name:"[Все рубрики]"}].concat($C.rubrics);
		_.rubric = ko.observable(data.rubric);
		
		_.post = ko.observable(data.post).extend({required:"Укажите должность"});
		_.salary = ko.observable(data.salary);
		
		_.schedules = $C.schedules;
		_.schedule = ko.observable(data.schedule);
		
		_.educations = [{id:"-1", name:"   "}].concat($C.educations);
		_.education = ko.observable(data.education).extend({required:{message:"Укажите образование", condition:"x|x!=-1"}});
		
		_.experiences = [{id:"-1", name:"   "}].concat($C.experiences);
		_.experience = ko.observable(data.experience).extend({required:{message:"Укажите опыт работы", condition:"x|x!=-1"}});
		
		_.skills = ko.observable(data.skills);
		_.phone = ko.observable(data.phone);
		_.email = ko.observable(data.email).extend({requiredEMail:true});
		
		
		_.closeWindow = function(){
			$("#resumeList").show();
			$("#resumeEdit").html("").hide();
		};

		_.delResume = function(){
			if(confirm("Удалить резюме?")){
				ds.delResume(_.id, function(result){
					common.actions.exec("viewResList");
				});
			}
		};

		_.saveResume = function(){
			if(!validation.validate(_)) return;
			
			var data = common.getModelFields(_, "fio;age;region;rubric;sex;post;salary;schedule;education;experience;skills;phone;email"),
				pnl = $(".content .resultPanel");
			data.id = _.id;
			
			common.wait(pnl);
			ds.saveResume(data, function(result){
				result = $.parseJSON(result);
				if(result.error){
					alert("Ошибка сохранения данных:"+result.error);
					return;
				}
				
				common.actions.exec("viewResList");
			});
		};
	}
	
	return {
		view: function(id, pnl){pnl=$(pnl);
			pnl.html(template());
			
			ds.getResume(id, function(data){
				var model = new RequestModel(data);
				ko.applyBindings(model, pnl.find("div")[0]);
			});
		}
	};
});