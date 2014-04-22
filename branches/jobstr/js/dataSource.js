﻿define(["user"], function(user){	return {		getTopList: function(callback, onError){			param = {uid:user.id, ticket: user.ticket};			$.getJSON("ws/topList.php", param, function(data){				callback(data);			}, function(){				onError("Error loading Top List");			});		},		getVacancies: function(conditions, callback){			param = {				uid:user.id, ticket: user.ticket,				pageNr: conditions.pageNr || 0,				rowCount: conditions.rowCount || 10			};			$.getJSON("ws/vacancies.php", param, function(data){				callback(data);			}, function(){				onError("Error loading Vacancies");			});		},		getVacancy: function(id, callback){			param = {				uid:user.id, ticket: user.ticket,				id: id			};			$.getJSON("ws/vacancy.php", param, function(data){				callback(data);			}, function(){				onError("Error loading Vacancy");			});		},		getResumes: function(conditions, callback){			param = {				uid:user.id, ticket: user.ticket,				pageNr: conditions.pageNr || 0,				rowCount: conditions.rowCount || 10			};			$.getJSON("ws/resumes.php", param, function(data){				callback(data);			}, function(){				onError("Error loading Resumes");			});		},		getResume: function(id, callback){			param = {				uid:user.id, ticket: user.ticket,				id: id			};			$.getJSON("ws/resume.php", param, function(data){				callback(data);			}, function(){				onError("Error loading Resume");			});		},		addResume: function(data, callback){			param = {				uid:user.id, ticket: user.ticket,				data: data			};			$.post("ws/addResume.php", param, function(data){				console.log(data);				callback(data);			});		},		addVacancy: function(data, callback){			throw "Method is not implemented";		},		logon: function(data, callback){			$.getJSON("ws/logon.php", data, function(res){				callback(res);			}, function(){				onError("Logon error");			});		},		logoff: function(data, callback){			$.getJSON("ws/logoff.php", data, function(res){				callback(res);			}, function(){				onError("Logoff error");			});		}	};});