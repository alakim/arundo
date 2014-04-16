<?php
require_once('db/dbResumes.php');
require_once('db/dbVacancies.php');
require_once('db/dbUsers.php');
require_once('db/dbConst.php');

require_once('db/dbResumesTest.php');
require_once('db/dbVacanciesTest.php');
require_once('db/dbUsersTest.php');
require_once('db/dbConstTest.php');

$con = openConnection();


echo("Rebuilding Resumes <br/>");
$dbRes = new DbResumesTest();
$dbRes->rebuild($con);

echo("Rebuilding Vacancies <br/>");
$dbVac = new DbVacanciesTest();
$dbVac->rebuild($con);

echo("Rebuilding Users <br/>");
$dbUsr = new DbUsersTest();
$dbUsr->rebuild($con);

echo("Rebuilding Constants <br/>");
$dbConst = new DbConstTest();
$dbConst->rebuild($con);


//echo("Current time: ".time()."<br/>");




closeConnection($con);

echo("DONE<br/>");

