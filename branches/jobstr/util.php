<?php function openConnection(){	$con=mysqli_connect("localhost","sa","123456","jobstr");	// Check connection	if (mysqli_connect_errno()){		echo "Failed to connect to MySQL: " . mysqli_connect_error();		return false;	}		return $con;}function closeConnection($con){	mysqli_close($con);}function execSql($con, $sql){	$res = mysqli_query($con, $sql);	if ($res){		//echo("Success<br/>");		return $res;	}	else{		echo "Error: " . mysqli_error($con)."<br/>";	}}