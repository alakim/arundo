<?php
require('../util.php');
$con = openConnection();

$login = $_REQUEST["login"];
$password = crypt($_REQUEST["password"], $Settings['cryptKey']);


$result = mysqli_query($con,"SELECT ID, Name FROM Users WHERE login='".$login."' AND password='".$password."'");
if($result->num_rows==1){
	$row = $result->fetch_array();
	$ticket = crypt(time(), $Settings['cryptKey']);
	$ID = $row["ID"];
	mysqli_query($con, "UPDATE Users SET Ticket = '".$ticket."' WHERE ID='".$ID."'");
	echo("{\"ticket\":\"".$ticket."\", \"userName\":\"".str_replace("\"", "\\\"", $row["Name"])."\", \"id\":\"".$ID."\"}");
}
else{
	echo("{\"error\":\"Bad login or password\"}");
}

closeConnection($con);


