<?php
require('../util.php');
$con = openConnection();

$uid = $_REQUEST["uid"];
$ticket = $_REQUEST["ticket"];
$rowCount = $_REQUEST["rowCount"];
$pageNr = $_REQUEST["pageNr"];
$owner = $_REQUEST["owner"];

// conditions
$condCount = $_REQUEST["count"];
$condEducation = $_REQUEST["education"];
$condExperience = $_REQUEST["experience"];
$condKeywords = $_REQUEST["keywords"];
$condPeriod = $_REQUEST["period"];
$condRegion = $_REQUEST["region"];
$condRubric = $_REQUEST["rubric"];

$conditions = array();
if($owner!="") array_push($conditions, "Owner=".$owner);
if($condRegion!="") array_push($conditions, "Region=".$condRegion);
if($condRubric!="" and $condRubric!="0") array_push($conditions, "Rubric=".$condRubric);
if($condEducation!="" and $condEducation!="0") array_push($conditions, "Education=".$condEducation);
if($condExperience!="" and $condExperience!="0") array_push($conditions, "Experience=".$condExperience);


if(checkSession($con, $uid, $ticket)){
	// $filter = $filter." or Owner='".$uid."'";
}

	
$filter = implode(" and ", $conditions);
if(strlen($filter)>0) $filter = "WHERE ".$filter;

$sql = "SELECT * FROM Resumes ".$filter." LIMIT ".($pageNr*$rowCount).",".$rowCount;

//echo($sql);
	
$result = mysqli_query($con, $sql);
if(!$result){
	echo("[]");
	die();
}

echo("[");
$first = true;
while($row = mysqli_fetch_array($result)){
	if(!$first) echo(","); else $first=false;
	echo("{");
	writeJsonField($row, "ID", false); echo(",");
	writeJsonField($row, "Title", true); echo(",");
	// writeJsonField($row, "Salary", true); echo(",");
	writeJsonField($row, "Rubric", false); echo(",");
	// writeJsonField($row, "Description", true); echo(",");
	writeJsonField($row, "Fio", true); echo(",");
	writeJsonField($row, "Age", false); echo(",");
	// writeJsonField($row, "Region", false); echo(",");
	// writeJsonField($row, "Education", false); echo(",");
	// writeJsonField($row, "Experience", false); echo(",");
	writeJsonField($row, "Phone", true); echo(",");
	writeJsonField($row, "Email", true); echo(",");
	writeJsonField($row, "Date", true);
	echo("}");
}
echo("]");


closeConnection($con);

