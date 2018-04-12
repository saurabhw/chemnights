<?php 
require 'db.php';

$sql="SELECT * FROM sessiondates ORDER BY dates ASC";

$result=$mysqli->query($sql);

$a=array();
$myObj = new stdClass();

while($row = $result->fetch_assoc()){
		//echo $row['dates'] .','. $row['newStudents'] .','. $row['returning'] .'*';
		
		$myObj->aDate = $row['dates'];
		$myObj->newStudents = $row['newStudents'];
		$myObj->returning = $row['returning'];
		
		$myJSON = json_encode($myObj);
		
		array_push($a,$myJSON);
	}	

	echo json_encode($a);

$mysqli->close();
?>