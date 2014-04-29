define([constModule, "test/db", "user"], function($C, db, user){
	var delay = 500;
	
	return {
		getTopList: function(callback){
			setTimeout(function(){
				var res = [], vac = [], count = 4;
				for(var i=0; i<Math.min(count, db.resumes.length-1); i++) res.push(db.resumes[i]);
				for(var i=0; i<Math.min(count, db.vacancies.length-1); i++) vac.push(db.vacancies[i]);
				
				callback({
					res:res,
					vac:vac
				});
			}, delay);
		},
		getVacancies: function(conditions, callback){
			function checkConditions(vac){
				return true;
			}
			setTimeout(function(){
				var res = [];
				for(var vac,i=0; vac = db.vacancies[i], i<db.vacancies.length-1; i++){
					if(checkConditions(vac)) res.push(vac);
				}
				callback(res);
			}, delay);
		},
		getVacancy: function(id, callback){
			setTimeout(function(){
				var vac;
				for(var i=0; vac = db.vacancies[i], i<db.vacancies.length-1; i++){
					if(vac.id==id) break
				}
				callback(vac);
			}, delay)
		},
		getResumes: function(conditions, callback){
			function checkConditions(r){
				return true;
			}
			setTimeout(function(){
				var res = [];
				for(var r,i=0; r = db.resumes[i], i<db.resumes.length-1; i++){
					if(checkConditions(r)) res.push(r);
				}
				callback(res);
			}, delay);
		},
		getResume: function(id, callback){
			setTimeout(function(){
				var r;
				for(var i=0; r = db.resumes[i], i<db.resumes.length-1; i++){
					if(r.id==id) break
				}
				callback(r);
			}, delay);
		},
		addResume: function(data, callback){
			setTimeout(function(){
				console.log("Saved ", data);
				callback(true);
			}, delay);
		},
		addVacancy: function(data, callback){
			setTimeout(function(){
				console.log("Saved ", data);
				callback(true);
			}, delay);
		},
		logon: function(data, callback){
			setTimeout(function(){
				console.log("Logon: ", data);
				callback({userName:"Тестовый пользователь", resCount:1, vacCount:1});
			}, delay);
		},
		logoff: function(data, callback){
			setTimeout(function(){
				console.log("Logoff");
				callback(true);
			}, delay);
		},
		getUserData: function(callback){
			setTimeout(function(){
				callback({name:"Тестовый пользователь", resCount:1, vacCount:1});
			}, delay);
		}
	};
});