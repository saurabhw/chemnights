 <?php 
require 'db.php';

$sql="SELECT individualstudenttiming.eid, individualstudenttiming.crse, timing, crn, instructor, sname, time , days, email FROM individualstudenttiming, studentlist WHERE individualstudenttiming.eid = studentlist.eid AND individualstudenttiming.crse = studentlist.crse ORDER BY timing DESC LIMIT 5";

$result=$mysqli->query($sql);

$a=array();
$myObj = new stdClass();

while($row = $result->fetch_assoc()){
		//echo $row['dates'] .','. $row['newStudents'] .','. $row['returning'] .'*';
		
		$myObj->name = $row['sname'];
		$myObj->timing = $row['timing'];
		$myObj->crse = $row['crse'];
		$myObj->t = $row['time'];
		$myObj->days = $row['days'];
		
		$myJSON = json_encode($myObj);
		
		array_push($a,$myJSON);
	}	

	echo json_encode($a);
	

$mysqli->close();
?>