var Html = {
	version: "2.3.215",
	xhtmlMode: true	
};

(function(){
	function extend(o,s){for(var k in s){o[k] = s[k];}}
	
	function each(coll, F){
		if(!coll) return;
		if(coll.length)
			for(var i=0; i<coll.length;i++) F(coll[i], i);
		else
			for(var k in coll) F(coll[k], k);
	}
	
	function defineTags(tags, selfClosing, notEmpty){
		each(tags, function(t){
			Html[t] = new Function("content", "return Html.tag(\""+t+"\", arguments,"+(selfClosing?"true":"false")+","+(notEmpty?"true":"false")+");");
		});
	}
	
	function defineSelfClosingTags(tags){defineTags(tags, true, false);}
	function defineNotEmptyTags(tags){defineTags(tags, false, true)}
	
	extend(Html, {
		tag: function(name, content, selfClosing, notEmpty){
			var h = [];
			var a = [];
			each(content, function(el){
				if(typeof(el)!="object")
					h.push(el);
				else{
					each(el, function(val, nm){
						a.push(" "+nm+"=\""+val+"\"");
					});
				}
			});
			
			h = h.join("");
			if(h.match(/^\s+$/i))
				h = "";
			if(notEmpty && h.length==0)
				h = "&nbsp;";
			
			if(selfClosing && h.length==0)
				return "<"+name+a.join("")+(Html.xhtmlMode? "/>":">");
			else
				return "<"+name+a.join("")+">"+h+"</"+name+">";
		},
		
		apply: function(coll, F){
			var h = [];
			each(coll, function(el, i){
				h.push(F(el, i));
			});
			return h.join("");
		},
		
		times: function(count, F){
			var h = [];
			for(var i=0; i<count; i++)
				h.push(F(i+1));
			return h.join("");
		},
		
		tagCollection: function(){
			var res = [];
			each(arguments, function(tag){
				res.push(tag);
			});
			return res.join("");
		},
		
		json: function(o){
			if(o==null) return 'null';
			if(typeof(o)=="string") return "'"+o.replace(/\"/g, "\\\"")+"'";
			if(typeof(o)=="boolean") return o.toString();
			if(typeof(o)=="number") return o.toString();
			if(typeof(o)=="function") return "";
			if(o.constructor==Array){
				var res = [];
				for(var i=0; i<o.length; i++) res.push(Html.json(o[i]));
				return "["+res.join(",")+"]";
			}
			if(typeof(o)=="object"){
				var res = [];
				for(var k in o) res.push(k+":"+Html.json(o[k]));
				return "{"+res.join(",")+"}";
			}
			return "";
		},
		
		format: function(str, v1, v2){
			for(var i=0; i<arguments.length; i++){
				str = str.replace(new RegExp("{\s*"+i+"\s*}", "ig"), arguments[i+1])
			}
			return str;
		},
		
		callFunction: function(name, a1, a2){
			var args = [];
			for(var i=1; i<arguments.length; i++){
				var arg = arguments[i];
				arg = typeof(arg)=="string" && arg.match(/^@/)? arg.slice(1, arg.length)
					:Html.json(arg);
				args.push(arg);
			}
			return [name, "(", args.join(","), ")"].join("");
		}
	});
	
	defineTags(["div", "a", "p", "span", "ul", "ol", "li", "table", "tbody", "thead", "tr", "input", "label", "textarea", "pre", "select", "option", "h1", "h2", "h3", "h4", "h5", "h6", "button"]);
	defineSelfClosingTags(["img", "hr", "br", "iframe"]);
	defineNotEmptyTags(["th", "td"]);
})();