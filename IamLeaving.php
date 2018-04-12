 <?php 
require 'db.php';

date_default_timezone_set("America/Detroit");

$ok=1;

$Eid = $mysqli->escape_string($_POST['Eid']);
$comments = $mysqli->escape_string($_POST['comments']);
$rating = $mysqli->escape_string($_POST['rating']);

if($comments == '' && $rating == ''){
	$comments = "NA";
	$rating = -1;
}

//check if the eid is in the table if not it means either the eid entered is wrong or he is not signed in

$sqlCheckInAndWrong = "SELECT * FROM tutoringsession WHERE eid='$Eid'";

$resultCheckInAndWrong=$mysqli->query($sqlCheckInAndWrong);

$rowcount=mysqli_num_rows($resultCheckInAndWrong);

if($rowcount == 0){
	echo 2;
}
elseif($rowcount > 0){

	//if eid is correct but is already signed out i.e the row has end date already then say already signed out

	$sqlAlreadyOut = "SELECT * FROM tutoringsession WHERE eid='$Eid'";

	$resultAlreadyOut=$mysqli->query($sqlAlreadyOut);

	$row = $resultAlreadyOut->fetch_assoc();
		if($row['sessionEndTime']!=null){
			$ok = 0;
			echo 1;
		}
		else{
			$ok = 2;
		}
		
}
if($ok == 2){

	// if everything is ok then update with out time and send an email
	
	


	$d = date("m-d-Y");
	$t = date("h:i:s");

	$sql="UPDATE tutoringsession SET sessionEndTime = '$t', comments='$comments', rating='$rating' WHERE eid='$Eid'";


	$result=$mysqli->query($sql);


	$sqlHistorical="UPDATE tutoringsessionhistorical SET sessionEndTime = '$t', comments='$comments', rating='$rating' WHERE eid='$Eid'";

	$result=$mysqli->query($sqlHistorical);
	
	
	
	
	$sqlGetInTime = "SELECT * FROM tutoringsession WHERE eid='$Eid'";
	
	$resultGetInTime=$mysqli->query($sqlGetInTime);
	
	$rowGetInTime = $resultGetInTime->fetch_assoc();
		
	$to_time = strtotime($t);
	$from_time = strtotime($rowGetInTime['sessionStartTime']);
	$interval =  round(abs($to_time - $from_time) / 60,2). " minutes";
	echo $interval;
	$intervalNum = round(abs($to_time - $from_time) / 60,2);
	
	$courseNo = $rowGetInTime['crse'];
	
	
	//checking if the sessionDates table has todays date already
	$dateAlreadyExist;
	
	$sqlCheckDateAlready = "SELECT * FROM sessiondates WHERE dates = '$d' ";
	
	$resultCheckDateAlready = $mysqli->query($sqlCheckDateAlready); 
	
	$rowcountCheckDateAlready = mysqli_num_rows($resultCheckDateAlready);
	
	if($rowcountCheckDateAlready>0){
		$dateAlreadyExist = 1;
	}
	else{
		$dateAlreadyExist = 0;
	}
	
	//to maintain time spent in the tutoring session for individual student
	//check if already exist that is returning update query for individualStudentTiming table
	
	$sqlCheckReturning="SELECT * FROM individualstudenttiming WHERE eid='$Eid'";
	
	$resultCheckReturning = $mysqli->query($sqlCheckReturning); 
	
	$rowcountCheckReturning = mysqli_num_rows($resultCheckReturning);
	
	if($rowcountCheckReturning>0){
		$sqlUpdateTiming="UPDATE individualstudenttiming SET timing = timing + '$intervalNum' WHERE eid='$Eid'";
		
		$mysqli->query($sqlUpdateTiming); 
		
		//if execution is in this section then the student is returning  will have to check if the date already exists.
		
		if($dateAlreadyExist == 1){
			$sqlUpdateDates = "UPDATE sessiondates SET returning = returning + 1 WHERE dates = '$d'";
			$mysqli->query($sqlUpdateDates); 
		}
		else{
			$sqlInsertDates = "INSERT INTO sessiondates(dates, newStudents, returning) VALUES('$d', '0', '1') ";
			$mysqli->query($sqlInsertDates); 
		}
		
	}
	
	//if not then insert 
	else{
		$sqlInsertTiming = "INSERT INTO individualstudenttiming(eid, crse, timing) VALUES('$Eid', '$courseNo', '$intervalNum') ";
		
		$mysqli->query($sqlInsertTiming); 
		
		//if execution is in this section then the student is new
		
		if($dateAlreadyExist == 1){
			$sqlUpdateDates = "UPDATE sessiondates SET newStudents = newStudents + 1 WHERE dates = '$d'";
			$mysqli->query($sqlUpdateDates); 
		}
		else{
			$sqlInsertDates = "INSERT INTO sessiondates(dates, newStudents, returning) VALUES('$d', '1', '0') ";
			$mysqli->query($sqlInsertDates); 
		}
	}
	
		
	//Sending an email
	
	$sqlGetEmail = "SELECT * FROM studentlist WHERE eid='$Eid'";
	
	$resultGetEmail = $mysqli->query($sqlGetEmail); 
	
	
	while($row = $resultGetEmail->fetch_assoc()){
		$email = $row['email'];
	}
	
	$to = $email;
	$subject = 'CHEMISTRY NIGHTS';
	$message = 'Dear Students,

	Thank you for attending the Organic Chemistry Night tutoring session. You spent ' .$intervalNum. ' minutes today. 
	We really appreciate your presence and your hard work towards your course. 
	Hope you had a productive time. See you on next time.
	If you have any questions or additional feedback about the tutoring session, feel free to contact Dr. Jose Vites at jvites@emich.edu.';
	$headers = 'from:CSIE';


	mail($to,$subject,$message,$headers);
		
	
	
	
}

$mysqli->close();
?>