<?php
require('../util.php');
$con = openConnection();

echo("Dropping Resumes<br/>");
execSql($con, "DROP TABLE Resumes");
echo("Dropping Vacancies<br/>");
execSql($con, "DROP TABLE Vacancies");



closeConnection($con);

echo("DONE<br/>");

