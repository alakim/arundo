define(["jcook"], function(){
	return {
		cookie: function(nm, val, opt){
			return $.cookie(nm, val, opt);
		}
	};
});