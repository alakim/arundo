﻿define(["html"], function($H){	return {		wait: function(pnl){with($H){			pnl.html(				img({src:"images/wait.gif"})			);		}},		getModelFields: function(model, fields){			var res = {};			if(!(fields instanceof Array))				fields = fields.split(";");			for(var f,i=0; f=fields[i],i<fields.length; i++){				if(typeof(model[f])!="function") throw "model."+f+" is not a function";				res[f] = model[f]();			}			return res;		}	};});