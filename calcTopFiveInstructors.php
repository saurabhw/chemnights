  <?php 
require 'db.php';

$sql="SELECT instructor, sum(timing) AS timing, individualstudenttiming.crse, time, days from individualstudenttiming, studentlist WHERE individualstudenttiming.eid = studentlist.eid and individualstudenttiming.crse = studentlist.crse GROUP BY instructor, individualstudenttiming.crse ORDER BY timing DESC limit 5";

$result=$mysqli->query($sql);

$a=array();
$myObj = new stdClass();

while($row = $result->fetch_assoc()){
		//echo $row['dates'] .','. $row['newStudents'] .','. $row['returning'] .'*';
		
		$myObj->name = $row['instructor'];
		$myObj->timing = round($row['timing'],2);
		$myObj->crse = $row['crse'];
		$myObj->t = $row['time'];
		$myObj->days = $row['days'];
		
		$myJSON = json_encode($myObj);
		
		array_push($a,$myJSON);
	}	

	echo json_encode($a);

$mysqli->close();
?>