<?php
require('../util.php');
$con = openConnection();

execSql($con, "DROP TABLE Resumes");
execSql($con, 
	"CREATE TABLE Resumes(".
	"PID INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(PID),".
	"Title CHAR(30), Salary CHAR(30), Age INT)"
);

execSql($con, "INSERT INTO Resumes (Title, Salary, Age) VALUES (\"Сварщик\", \"35000\", 33)");
execSql($con, "INSERT INTO Resumes (Title, Salary, Age) VALUES (\"Электрик\", \"30000\", 38)");
execSql($con, "INSERT INTO Resumes (Title, Salary, Age) VALUES (\"Программист\", \"50000\", 27)");
execSql($con, "INSERT INTO Resumes (Title, Salary, Age) VALUES (\"Водитель\", \"40000\", 43)");



closeConnection($con);

echo("DONE<br/>");

