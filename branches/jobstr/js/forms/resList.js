﻿define(["html", "dataSource", "const", "forms/common"], function($H, ds, $C, common){	function template(data){with($H){		return div(table({border:0, cellpadding:3, cellspacing:0},			tr({"class":"tblHeader"},				th("ФИО"),				th("Возраст"),				th("EMail"),				th("Телефон"),				th("Специальность"),				th("Рубрика")			),			apply(data, function(row, i){				var rub = $.grep($C.rubrics, function(r){return r.id==row.rubric});				return tr(i%2?{"class":"even"}:null,					td(a({href:"#"}, row.fio)),					td(row.age),					td(row.email),					td(row.phone),					td(row.title),					td(rub.length?rub[0].name:null)				);			})		));	}}		return {		view: function(pnl){			common.wait(pnl);			ds.getResumes({}, function(data){				pnl.html(template(data));			});		}	};});