<?php
require('../util.php');
$con = openConnection();

echo("Creating Resumes table<br/>");

if(execSql($con, "show tables like \"Resumes\"")->num_rows>0){
	execSql($con, "DROP TABLE Resumes");
}
execSql($con, 
	"CREATE TABLE Resumes(".
	"ID INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(ID),".
	"Title CHAR(30), Salary CHAR(30), Age INT)"
);

echo("Creating Vacancies table<br/>");
if(execSql($con, "show tables like \"Vacancies\"")->num_rows>0){
	execSql($con, "DROP TABLE Vacancies");
}
execSql($con, 
	"CREATE TABLE Vacancies(".
	"ID INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(ID),".
	"Title CHAR(30), Salary CHAR(30), Organization CHAR(30))"
);



closeConnection($con);

echo("DONE<br/>");

