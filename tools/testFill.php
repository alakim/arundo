<?php
require('../util.php');
$con = openConnection();

echo("Filling Resumes<br/>");
execSql($con, "INSERT INTO Resumes (Title, Salary, Age) VALUES (\"�������\", \"35000\", 33)");
execSql($con, "INSERT INTO Resumes (Title, Salary, Age) VALUES (\"��������\", \"30000\", 38)");
execSql($con, "INSERT INTO Resumes (Title, Salary, Age) VALUES (\"�����������\", \"50000\", 27)");
execSql($con, "INSERT INTO Resumes (Title, Salary, Age) VALUES (\"��������\", \"40000\", 43)");

echo("Filling Vacancies<br/>");
execSql($con, "INSERT INTO Vacancies (Title, Salary, Organization) VALUES (\"�������\", \"30000\", \"OOO ������\")");
execSql($con, "INSERT INTO Vacancies (Title, Salary, Organization) VALUES (\"���������\", \"60000\", \"OOO ������\")");
execSql($con, "INSERT INTO Vacancies (Title, Salary, Organization) VALUES (\"�����������\", \"32000\", \"OOO ������\")");
execSql($con, "INSERT INTO Vacancies (Title, Salary, Organization) VALUES (\"������������ ��������\", \"65000\", \"OOO ������\")");


closeConnection($con);

echo("DONE<br/>");

