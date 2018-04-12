<?php 
require 'db.php';

$sql="SELECT * FROM tutoringsessionhistorical ORDER BY sessionDate DESC";

$result=$mysqli->query($sql);

$a=array();
$myObj = new stdClass();

while($row = $result->fetch_assoc()){
		
		
		$myObj->eid = $row['eid'];
		$myObj->crse = $row['crse'];
		$myObj->sessionDate = $row['sessionDate'];
		$myObj->sessionStartTime = $row['sessionStartTime'];
		$myObj->sessionEndTime = $row['sessionEndTime'];
		$myObj->comments = $row['comments'];
		$myObj->rating = $row['rating'];
		
		$myJSON = json_encode($myObj);
		
		array_push($a,$myJSON);
	}	

	echo json_encode($a);

$mysqli->close();
?>