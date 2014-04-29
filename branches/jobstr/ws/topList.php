<?php
require('../util.php');
$con = openConnection();

$rowCount = 3;

echo("{\"res\":[");

$resumes = mysqli_query($con,"SELECT * FROM Resumes LIMIT ".$rowCount);
$first = true;
while($row = mysqli_fetch_array($resumes)){
	if(!$first) echo(","); else $first = false;
	echo("{");
	writeJsonField($row, "Title", true); echo(",");
	writeJsonField($row, "Salary", true); echo(",");
	writeJsonField($row, "Age", false);
	echo("}");
}
echo("],\"vac\":[");

$vacancies = mysqli_query($con,"SELECT * FROM Vacancies LIMIT ".$rowCount);
$first = true;
while($row = mysqli_fetch_array($vacancies)){
	if(!$first) echo(","); else $first = false;
	
	echo("{");
	writeJsonField($row, "Title", true); echo(",");
	writeJsonField($row, "Salary", true); echo(",");
	writeJsonField($row, "Organization", true);
	echo("}");
}
echo("]}");

closeConnection($con);


