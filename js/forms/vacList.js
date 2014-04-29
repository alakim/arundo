define(["html", "dataSource", "user", constModule, "forms/common", "forms/vacEdit"], function($H, ds, user, $C, common, vacEdit){
	function template(data){with($H){
		return div(
			div({id:"vacancyEdit", style:"display:none"}),
			div({id:"vacanciesList"},
				table({border:0, cellpadding:3, cellspacing:0},
					tr({"class":"tblHeader"},
						th("Название фирмы"),
						th("Электронный адрес"),
						th("ФИО кадровика"),
						th("Телефон"),
						th("Специальность"),
						th("Рубрика")
					),
					apply(data, function(row, i){
						var rub = $.grep($C.rubrics, function(r){return r.id==row.rubric});
						return tr(i%2?{"class":"even"}:null,
							td(a({href:"#vac"+row.id}, row.organization)),
							td(row.email),
							td(row.contact),
							td(row.phone),
							td(row.title),
							td(rub.length?rub[0].name:null)
						);
					})
				)
			)
		);
	}}
	
	function showDialog(evt){
		var id = evt.target.href.match(/#vac(\d+)$/)[1];
		$("#vacanciesList").hide();
		$("#vacancyEdit").show();
		vacEdit.view(id, $("#vacancyEdit"));
	}
	
	return {
		view: function(pnl){
			common.wait(pnl);
			ds.getVacancies({owner:user.id}, function(data){
				pnl.html(template(data));
				pnl.find("a").click(showDialog);
			});
		}
	};
});