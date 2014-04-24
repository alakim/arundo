define(["knockout"], function(ko){
	function lambda(expr){
		expr = expr.split("|");
		return new Function(expr[0], "return "+expr[1]);
	}
	
	ko.extenders.required = function(target, options) {
		var overrideMessage = typeof(options)=="string"?options:options.message;
		
		target.hasError = ko.observable();
		target.validationMessage = ko.observable();
	 
		function validate(newValue) {
			var valid = newValue!=null && (typeof(newValue)!="string" || newValue.length>0);
			if(valid && options.value!=null){
				valid = newValue==options.value;
			}
			else {
				if(valid && options.regex)
					valid = (newValue+"").match(options.regex)!=null;
				if(valid && options.condition){
					var cond = lambda(options.condition);
					valid = cond(newValue);
				}
			}
			target.hasError(!valid);
			target.validationMessage(valid ? "" : overrideMessage || "Это поле обязательное.");
		}
	 
		validate(target());
	 
		target.subscribe(validate);
	
		return target;
	};
	
	
	function getMessages(model, level){
		level = level || 0;
		var res = [];
		for(var k in model){
			if(model[k].validationMessage){
				var msg = model[k].validationMessage();
				if(msg.length) res.push(msg);
			}
			if(level<3){
				var r1 = getMessages(model[k], level+1);
				if(r1.length) res = res.concat(r1);
			}
		}
		return res;
	}
	
	
	return {
		validate: function(model){
			var valid = getMessages(model);
			if(valid.length){
				alert(valid.join("\n"));
			}
			return valid.length==0;
		}

	};
});