﻿define(["jquery"], function($){

	function Actions(list){
		this.actionsList = list || {};
		this.init();
	}
	
	Actions.prototype = {
		add: function(list){
			$.extend(this.actionsList, list);
		},
		exec: function(actNm){
			this.actionsList[actNm]();
		},
		bind: function(linkButton, actName){
			$(linkButton).attr({href:"#"+actName}).click(this.actionsList[actName]);
		},
		init: function(){
			var act = window.location.hash;
			if(!act.length) return;
			act = act.slice(1);
			if(this.actionsList[act]) this.actionsList[act]();
		}
	};
	
	return Actions;
});