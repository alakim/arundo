<?php
require('../util.php');
require('db/GenericTable.php');
require('db/dbResumes.php');
require('db/dbVacancies.php');

$con = openConnection();


echo("Rebuilding Resumes <br/>");
$dbRes = new DbResumes();
$dbRes->rebuild($con);

echo("Rebuilding Vacancies <br/>");
$dbVac = new DbVacancies();
$dbVac->rebuild($con);




closeConnection($con);

echo("DONE<br/>");

