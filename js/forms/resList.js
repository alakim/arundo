define(["html", "dataSource", "user", constModule, "forms/common", "forms/resEdit"], function($H, ds, user, $C, common, resEdit){
	
	function template(data){with($H){
		return div(
			div({id:"resumeEdit", style:"display:none"}),
			div({id:"resumeList"}, 
				table({border:0, cellpadding:3, cellspacing:0},
					tr({"class":"tblHeader"},
						th("ФИО"),
						th("Возраст"),
						th("EMail"),
						th("Телефон"),
						th("Специальность"),
						th("Рубрика")
					),
					apply(data, function(row, i){
						var rub = $.grep($C.rubrics, function(r){return r.id==row.rubric});
						return tr(i%2?{"class":"even"}:null,
							td(a({href:"#res"+row.id}, row.fio)),
							td(row.age),
							td(row.email),
							td(row.phone),
							td(row.title),
							td(rub.length?rub[0].name:null)
						);
					})
				)
			)
		);
	}}
	
	function showResume(evt){
		var id = evt.target.href.match(/#res(\d+)$/)[1];
		$("#resumeList").hide();
		$("#resumeEdit").show();
		resEdit.view(id, $("#resumeEdit"));
	}
	
	return {
		view: function(pnl){pnl=$(pnl);
			common.wait(pnl);
			ds.getResumes({owner:user.id}, function(data){
				pnl.html(template(data));
				pnl.find("a").click(showResume);
			});
		}
	};
});