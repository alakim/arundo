<?phprequire('../util.php');$con = openConnection();$uid = $_REQUEST["uid"];$ticket = $_REQUEST["ticket"];$ID = $_REQUEST["id"];$filter = " Owner is NULL";if(checkSession($con, $uid, $ticket)){	$filter = $filter." or Owner='".$uid."'";}$result = mysqli_query($con, "SELECT * FROM Resumes WHERE ID=".$ID);$row = mysqli_fetch_array($result);function writeField($row, $fldName, $stringMode, $end){	$fld = strtolower($fldName);	$val = $row[$fldName];	if(is_null($val)){ $val = "null";}	else if($stringMode) {$val = "\"".$val."\"";}	echo("\"".$fld."\":".$val);	if(!$end)echo(",");}echo("{");writeField($row, "ID", false, false);writeField($row, "Title", true, false);writeField($row, "Salary", true, false);writeField($row, "Rubric", false, false);writeField($row, "Description", true, false);writeField($row, "Fio", true, false);writeField($row, "Age", false, false);writeField($row, "Region", false, false);writeField($row, "Education", false, false);writeField($row, "Experience", false, false);writeField($row, "Phone", true, false);writeField($row, "Email", true, false);writeField($row, "Date", true, true);echo("}");closeConnection($con);