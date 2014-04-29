<?php 
require('util.php');
$con = openConnection();

function writeSection($con, $sid, $name){
	echo("\"".$name."\": [");
	$res = mysqli_query($con,"SELECT * FROM Constants WHERE Section=".$sid);
	$first = true;
	while($row = mysqli_fetch_array($res)){
		if(!$first) echo(","); else $first=false;
		echo("{\"id\":".$row["ID"].", \"name\":\"".$row["Name"]."\"}");
	}
	echo("]");
}

echo("define([], function(){");
echo("var C = {");

$res = mysqli_query($con,"SELECT * FROM ConstantSections");
$first = true;
while($row = mysqli_fetch_array($res)){
	if(!$first) echo(","); else $first=false;
	writeSection($con, $row["ID"], $row["Name"]);
}


echo("};");
echo("C.searchOptions = {counts:[25, 50, 100], periods:C.searchOptionsPeriods};");
echo(" return C;});");
closeConnection($con);



