define(["html", "dataSource", "forms/common"], function($H, ds, common){
	function template(data){with($H){
		var tblAttr = {border:0, cellpadding:3, cellspacing:0, width:"100%"};
		return table(tblAttr,
			tr(th("Последние вакансии"), th("Последние резюме")),
			tr(
				td(table(tblAttr, apply(data.vac, function(v){
					return v?tr(td(v.title), td(v.salary)):null;
				}))),
				td(table(tblAttr, apply(data.res, function(r){
					return r?tr(td(r.title), td(r.salary)):null;
				})))
			)
		);
	}}
	
	return {
		view: function(pnl){
			common.wait(pnl);
			ds.getTopList(function(data){
				pnl.html(template(data));
			});
		}
	};
});