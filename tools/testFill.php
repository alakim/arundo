<?php
require('../util.php');
$con = openConnection();

echo("Filling Resumes<br/>");
execSql($con, "INSERT INTO Resumes (Title, Salary, Age) VALUES (\"�������\", \"35000\", 33)");
execSql($con, "INSERT INTO Resumes (Title, Salary, Age) VALUES (\"��������\", \"30000\", 38)");
execSql($con, "INSERT INTO Resumes (Title, Salary, Age) VALUES (\"�����������\", \"50000\", 27)");
execSql($con, "INSERT INTO Resumes (Title, Salary, Age) VALUES (\"��������\", \"40000\", 43)");



closeConnection($con);

echo("DONE<br/>");

