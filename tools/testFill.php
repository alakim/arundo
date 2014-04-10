<?php
require('../util.php');
$con = openConnection();

echo("Filling Resumes<br/>");
execSql($con, "INSERT INTO Resumes (Title, Salary, Age) VALUES (\"Сварщик\", \"35000\", 33)");
execSql($con, "INSERT INTO Resumes (Title, Salary, Age) VALUES (\"Электрик\", \"30000\", 38)");
execSql($con, "INSERT INTO Resumes (Title, Salary, Age) VALUES (\"Программист\", \"50000\", 27)");
execSql($con, "INSERT INTO Resumes (Title, Salary, Age) VALUES (\"Водитель\", \"40000\", 43)");



closeConnection($con);

echo("DONE<br/>");

