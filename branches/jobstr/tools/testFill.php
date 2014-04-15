<?php
require('../util.php');
$con = openConnection();

echo("Filling Resumes<br/>");
execSql($con, "INSERT INTO Resumes (Title, Salary, Age) VALUES (\"Сварщик\", \"35000\", 33)");
execSql($con, "INSERT INTO Resumes (Title, Salary, Age) VALUES (\"Электрик\", \"30000\", 38)");
execSql($con, "INSERT INTO Resumes (Title, Salary, Age) VALUES (\"Программист\", \"50000\", 27)");
execSql($con, "INSERT INTO Resumes (Title, Salary, Age) VALUES (\"Водитель\", \"40000\", 43)");

echo("Filling Vacancies<br/>");
execSql($con, "INSERT INTO Vacancies (Title, Salary, Organization) VALUES (\"Сварщик\", \"30000\", \"OOO Кирпич\")");
execSql($con, "INSERT INTO Vacancies (Title, Salary, Organization) VALUES (\"Бухгалтер\", \"60000\", \"OOO Кирпич\")");
execSql($con, "INSERT INTO Vacancies (Title, Salary, Organization) VALUES (\"Фрезеровщик\", \"32000\", \"OOO Кирпич\")");
execSql($con, "INSERT INTO Vacancies (Title, Salary, Organization) VALUES (\"Руководитель проектов\", \"65000\", \"OOO Кирпич\")");


closeConnection($con);

echo("DONE<br/>");

