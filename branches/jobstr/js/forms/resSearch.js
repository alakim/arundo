﻿define(["html", "knockout", constModule, "forms/common", "dataSource"], function($H, ko, $C, common, ds){
	function template(){with($H){
		return div(
			h2("Поиск резюме"),
			table({border:0, cellpadding:3, cellspacing:0},
				tr(
					th("Ключевые слова:"),
					td(input({type:"text", "data-bind":"value: keywords"}))
				),
				tr(
					th("Регион:"),
					td(select({"data-bind":"options:regions, value:region, optionsValue:'id', optionsText:'name'"}))
				),
				tr(
					th({valign:"top"}, "Рубрика:"),
					td(select({size:8, "data-bind":"options:rubrics, value:rubric, optionsValue:'id', optionsText:'name'"}))
				),
				tr(
					th("Образование:"),
					td(select({"data-bind":"options:educations, value:education, optionsValue:'id', optionsText:'name'"}))
				),
				tr(
					th("Опыт работы:"),
					td(select({"data-bind":"options:experiences, value:experience, optionsValue:'id', optionsText:'name'"}))
				),
				tr(
					th("Показать резюме:"),
					td(
						select({"data-bind":"options:counts, value:count"}),
						select({"data-bind":"options:periods, value:period, optionsValue:'id', optionsText:'name'"})
					)
				),
				tr(td({colspan:2},
					input({type:"button", value:"Искать", "data-bind":"click:send"})
				))
			),
			div({"class":"resultPanel"})
		);
	}}
	
	function listTemplate(data){with($H){
		return div({"class":"wrapper_results"},
			apply(data, function(itm){
				if(!itm) return;
				var region = $.grep($C.regions, function(r){return r.id==itm.region})[0],
					education = $.grep($C.educations, function(r){return r.id==itm.education})[0],
					experience = $.grep($C.experiences, function(r){return r.id==itm.experience})[0];
				
				return div({"class":"panel_expand"},
					table({width:"100%", border:0, cellspacing:0, cellpadding:3},
						tr(
							td({width:25, align:"right", "class":"image"},
								img({src:"images/plus.jpg", "class":"image_pointer plus", itmID:itm.id}),
								img({src:"images/minus.jpg", "class":"image_pointer minus", itmID:itm.id})
							),
							td({"class":"profession"}, span({"class":"linkButton"}, itm.title)),
							td({width:180, "class":"pay"}, 
								typeof(itm.salary)=="number"?span("от ", itm.salary, " руб.")
									:itm.salary
							)
						),
						tr(
							td(img({width:"30px", src:"images/null.GIF"})),
							td({"class":"addinfo"}, 
								itm.fio, 
								itm.age?span(" возраст ", itm.age):null,
								region?span(" проживает ", region.name):null,
								education?span(" образование ", education.name):null,
								experience?span(" опыт работы ", experience.name):null
							),
							td({"class":"date"}, itm.date)
						),
						tr(
							td({style:"padding-left:30px", colspan:3})
						)
					),
					div({"class":"details"})
				)
			})
		);
	}}
	
	function detailsTemplate(vac){with($H){
		var rubric = $.grep($C.rubrics, function(r){
			return r.id==vac.rubric;
		})[0];
			
		return div(
			rubric?p({style:"text-align:right"}, rubric.name):null,
			vac.description?div(vac.description):null,
			table({border:0},
				vac.contact?tr(th({align:"right"}, "Для связи:"), td(vac.contact)):null,
				vac.phone?tr(th({align:"right"}, "Телефон:"), td(vac.phone)):null,
				vac.email?tr(th({align:"right"}, "E-Mail:"), td(vac.email)):null
			)
		);
	}}
	
	function RequestModel(){var _=this;
		_.keywords = ko.observable("");
		_.regions = $C.regions;
		_.region = ko.observable(_.regions[0]);
		
		_.rubrics = [{id:0, name:"[Все рубрики]"}].concat($C.rubrics);
		_.rubric = ko.observable(_.rubrics[0]);
		
		_.educations = [{id:0, name:"[Любое]"}].concat($C.educations);
		_.education = ko.observable(_.educations[0]);
		
		_.experiences = [{id:0, name:"[Любой]"}].concat($C.experiences);
		_.experience = ko.observable(_.experiences[0]);
		
		_.periods = $C.searchOptions.periods;
		_.period = ko.observable(_.periods[0]);
		
		_.counts = $C.searchOptions.counts;
		_.count = ko.observable(_.counts[0]);
				
		_.send = function(){
			var request = common.getModelFields(_, "keywords;region;rubric;education;experience;count;period"),
				pnl = $(".content .resultPanel");
			common.wait(pnl);
			ds.getResumes(request, function(data){
				pnl.html(listTemplate(data));
				
				pnl.find(".plus").click(function(){var _=$(this);
					var id = _.attr("itmID"),
						dPnl = pnl.find(".panel_expand:has(img.plus[itmID='"+id+"']) div.details");
					_.hide();
					_.parent().find(".minus").show();
					
					if(dPnl.html().length) dPnl.show();
					else{
						common.wait(dPnl);
						ds.getResume(id, function(details){
							dPnl.html(detailsTemplate(details)).show();
						});
					}
				});
				pnl.find(".minus").click(function(){var _=$(this);
					var id = _.attr("itmID"),
						dPnl = pnl.find(".panel_expand:has(img.plus[itmID='"+id+"']) div.details");
					dPnl.hide();
					_.hide();
					_.parent().find(".plus").show();
				}).hide();
			});
		}
	}
	
	return {
		view: function(pnl){
			pnl.html(template());
			ko.applyBindings(new RequestModel(), pnl.find("div")[0]);
		}
	};
});