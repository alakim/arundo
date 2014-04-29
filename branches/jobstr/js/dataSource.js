define(["user"], function(user){
	return {
		getTopList: function(callback, onError){
			param = {uid:user.id, ticket: user.ticket};
			$.getJSON("ws/topList.php", param, function(data){
				callback(data);
			}, function(){
				onError("Error loading Top List");
			});
		},
		getVacancies: function(conditions, callback){
			param = {
				uid:user.id, ticket: user.ticket,
				pageNr: 0, rowCount: 10
			};
			$.extend(param, conditions);
			$.getJSON("ws/vacancies.php", param, function(data){
				callback(data);
			}, function(){
				onError("Error loading Vacancies");
			});
		},
		getVacancy: function(id, callback){
			param = {
				uid:user.id, ticket: user.ticket,
				id: id
			};
			$.getJSON("ws/vacancy.php", param, function(data){
				callback(data);
			}, function(){
				onError("Error loading Vacancy");
			});
		},
		saveVacancy: function(data, callback){
			param = {
				uid:user.id, ticket: user.ticket,
				data: data
			};
			$.post("ws/saveVacancy.php", param, function(data){
				callback(data);
			});
		},
		delVacancy: function(id, callback){
			param = {
				uid:user.id, ticket: user.ticket,
				vacID: id
			};
			$.post("ws/delVacancy.php", param, function(data){
				callback(data);
			});
		},
		getResumes: function(conditions, callback){
			param = {
				uid:user.id, ticket: user.ticket,
				pageNr: 0, rowCount: 10
			};
			$.extend(param, conditions);
			$.getJSON("ws/resumes.php", param, function(data){
				callback(data);
			}, function(){
				onError("Error loading Resumes");
			});
		},
		getResume: function(id, callback){
			param = {
				uid:user.id, ticket: user.ticket,
				id: id
			};
			$.getJSON("ws/resume.php", param, function(data){
				callback(data);
			}, function(){
				onError("Error loading Resume");
			});
		},
		addResume: function(data, callback){
			param = {
				uid:user.id, ticket: user.ticket,
				data: data
			};
			$.post("ws/addResume.php", param, function(data){
				callback(data);
			});
		},
		saveResume: function(data, callback){
			param = {
				uid:user.id, ticket: user.ticket,
				data: data
			};
			$.post("ws/saveResume.php", param, function(data){
				callback(data);
			});
		},
		delResume: function(id, callback){
			param = {
				uid:user.id, ticket: user.ticket,
				resID: id
			};
			$.post("ws/delResume.php", param, function(data){
				callback(data);
			});
		},		
		addVacancy: function(data, callback){
			param = {
				uid:user.id, ticket: user.ticket,
				data: data
			};
			$.post("ws/addVacancy.php", param, function(data){
				callback(data);
			});
		},
		logon: function(data, callback){
			$.getJSON("ws/logon.php", data, function(res){
				callback(res);
			}, function(){
				onError("Logon error");
			});
		},
		logoff: function(data, callback){
			$.getJSON("ws/logoff.php", data, function(res){
				callback(res);
			}, function(){
				onError("Logoff error");
			});
		},
		getUserData: function(callback){
			param = {
				uid:user.id, ticket: user.ticket
			};
			$.getJSON("ws/userData.php", param, function(res){
				callback(res);
			}, function(){
				onError("Logoff error");
			});
		},
		addUser: function(data, callback){
			param = {
				uid:user.id, ticket: user.ticket,
				data: data
			};
			$.post("ws/addUser.php", param, function(data){
				callback(data);
			});
		},
		saveUser: function(data, callback){
			param = {
				uid:user.id, ticket: user.ticket,
				data: data
			};
			$.post("ws/saveUser.php", param, function(data){
				callback(data);
			});
		}
	};
});