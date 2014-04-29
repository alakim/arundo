<?php
require('../util.php');
$con = openConnection();

$uid = $_REQUEST["uid"];
$ticket = $_REQUEST["ticket"];
$ID = $_REQUEST["id"];

$filter = " Owner is NULL";

if(checkSession($con, $uid, $ticket)){
	$filter = $filter." or Owner='".$uid."'";
}

$result = mysqli_query($con, "SELECT * FROM Vacancies WHERE ID=".$ID);

$row = mysqli_fetch_array($result);

echo("{");
writeJsonField($row, "ID", false); echo(",");
writeJsonField($row, "Title", true); echo(",");
writeJsonField($row, "Salary", true); echo(",");
writeJsonField($row, "Date", true); echo(",");
writeJsonField($row, "Rubric", false); echo(",");
writeJsonField($row, "Organization", true); echo(",");
writeJsonField($row, "Description", true); echo(",");
writeJsonField($row, "Contact", true); echo(",");
writeJsonField($row, "Phone", true); echo(",");
writeJsonField($row, "Email", true);
echo("}");


closeConnection($con);


