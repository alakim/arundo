(function($A, H){
	var panelIndex = 0;
	
	var __ = {
		init: function(){
			__.addPanel("mainPnl", $A.locale.getItem("mainPage"), true);
			$("#mainPnl").mainForm();
			
		},
		addPanel: function(id, title, fixed){
			panelIndex++;
			$('#tabsPnl').tabs('add',{
				title: title || ('Tab'+panelIndex),
				content: H.div({id:id, style:"padding:10px;"}),
				closable: !fixed
			});
		},
		getSelectedTab: function(){
			return $("#tabsPnl").tabs("getSelected");
		}
	};
	$A.view = __;
})(Arundo, Html);

