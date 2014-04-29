<?php
require('../util.php');
$con = openConnection();

$uid = $_REQUEST["uid"];
$ticket = $_REQUEST["ticket"];
$rowCount = $_REQUEST["rowCount"];
$pageNr = $_REQUEST["pageNr"];
$owner = $_REQUEST["owner"];

//conditions
$condCount = $_REQUEST["count"];
$condKeywords = $_REQUEST["keywords"];
$condPeriod = $_REQUEST["period"];
$condRegion = $_REQUEST["region"];
$condRubric = $_REQUEST["rubric"];
$condSalary = $_REQUEST["salary"];
$condSchedule = $_REQUEST["schedule"];


$conditions = array();
if($owner!="") array_push($conditions, "Owner=".$owner);
if($condRegion!="") array_push($conditions, "Region=".$condRegion);
if($condRubric!="" and $condRubric!="0") array_push($conditions, "Rubric=".$condRubric);
if($condSalary!="") array_push($conditions, "Salary=".$condSalary);
if($condSchedule!="" and $condSchedule!="0") array_push($conditions, "Schedule=".$condSchedule);


if(checkSession($con, $uid, $ticket)){
	// $filter = $filter." or Owner='".$uid."'";
}
	
$filter = implode(" and ", $conditions);
if(strlen($filter)>0) $filter = "WHERE ".$filter;

$sql = "SELECT * FROM Vacancies ".$filter." LIMIT ".($pageNr*$rowCount).",".$rowCount;

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
	writeJsonField($row, "Salary", true); echo(",");
	writeJsonField($row, "Organization", true);
	echo("}");

}
echo("]");


closeConnection($con);

