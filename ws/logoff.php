<?php
require('../util.php');
$con = openConnection();

$ID = $_REQUEST["id"];
$ticket = $_REQUEST["ticket"];

// $result = mysqli_query($con,"SELECT Name FROM Users WHERE ID='".$ID."' AND Ticket='".$ticket."'");
// if($result->num_rows==1){
if(checkSession($con, $ID, $ticket)){
	mysqli_query($con, "UPDATE Users SET Ticket = '' WHERE ID='".$ID."'");
	echo("{}");
}
else{
	echo("{\"error\":\"User not exists or session is already closed\"}");
}

closeConnection($con);


