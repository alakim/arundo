﻿define(["html", "dataSource", "user", constModule, "forms/common"], function($H, ds, user, $C, common){	function template(data){with($H){		return div(table({border:0, cellpadding:3, cellspacing:0},			tr({"class":"tblHeader"},				th("Название фирмы"),				th("Электронный адрес"),				th("ФИО кадровика"),				th("Телефон"),				th("Специальность"),				th("Рубрика")			),			apply(data, function(row, i){				var rub = $.grep($C.rubrics, function(r){return r.id==row.rubric});				return tr(i%2?{"class":"even"}:null,					td(a({href:"#"}, row.organization)),					td(row.email),					td(row.contact),					td(row.phone),					td(row.title),					td(rub.length?rub[0].name:null)				);			})		));	}}		return {		view: function(pnl){			common.wait(pnl);			ds.getVacancies({owner:user.id}, function(data){				pnl.html(template(data));			});		}	};});