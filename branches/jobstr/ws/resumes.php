<?phprequire('../util.php');$con = openConnection();$ticket = $_REQUEST["ticket"];$rowCount = $_REQUEST["rowCount"];$result = mysqli_query($con,"SELECT * FROM Resumes LIMIT ".$rowCount);echo("[");while($row = mysqli_fetch_array($result)){	echo("{\"title\":\"".$row['Title']."\", \"salary\":\"".$row['Salary']."\", \"age\":".$row['Age']."},");}echo("null");echo("]");closeConnection($con);