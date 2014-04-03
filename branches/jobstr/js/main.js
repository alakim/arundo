requirejs.config({
    baseUrl: "js",
    paths: {
		jquery: "lib/jquery-1.7.2.min",
		html:"lib/html",
		knockout:"lib/knockout-3.1.0",
        lib: "lib"
    },
	shim:{
		"html":{exports:"Html"}
	}
});

requirejs(["jquery", "html", "knockout"], function   ($, $H, $K) {
	$(".mainPanel").html((function(){with($H){
		return div({"class":"testPnl"},
			"SUCCESS",
			p("name: ", span({"data-bind":"text:name"}))
		)
	}})());
	
	
	function TestModel(){
		this.name = "test model";
	}
	
	$K.applyBindings(new TestModel(), $(".testPnl")[0]);
});