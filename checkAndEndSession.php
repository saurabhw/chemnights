  <?php
	require 'db.php';
	
	date_default_timezone_set("America/Detroit");

	// Escape email to protect against SQL injections
	$email = $mysqli->escape_string($_POST['Email']);
	$result = $mysqli->query("SELECT * FROM users WHERE email='$email'");

	if ( $result->num_rows == 0 ){ // User doesn't exist
		echo "incorrect";
	}
	else { // User exists
		$user = $result->fetch_assoc();

		if ( password_verify($_POST['pass'], $user['password']) ) {
			
			//The credentials received are correct
			$sqlGetAllUnsignedOut = "SELECT * FROM tutoringsession WHERE sessionEndTime IS NULL";
			
			$resultGetAllUnsignedOut = $mysqli->query($sqlGetAllUnsignedOut);
			
			while($row = $resultGetAllUnsignedOut->fetch_assoc()){
				//echo $row['eid'];
				$eid = $row['eid'];
				$crse = $row['crse'];
				$sessionDate = $row['sessionDate'];
				
				$startTime = strtotime($row['sessionStartTime']);
				$endTime = date("H:i:s", strtotime('+30 minutes', $startTime));
				
				$sqlSetEndTime = "UPDATE tutoringsession SET sessionEndTime ='$endTime' WHERE eid = '$eid'";
				
				$mysqli->query($sqlSetEndTime);
			

				//updating the data in historical table
				$sqlSetEndTimeHistorical = "UPDATE tutoringsessionhistorical SET sessionEndTime ='$endTime' WHERE eid = '$eid' AND sessionDate = '$sessionDate'";
				
				$mysqli->query($sqlSetEndTimeHistorical);
				
				//updating or inserting the individual student timing
				
				//calculating the interval
								
				$TendTime =	strtotime($endTime);
				$TstartTime = strtotime($row['sessionStartTime']);
				
				$intervalNum = round(abs($TendTime - $TstartTime) / 60,2);
				
				$sqlCheckReturning="SELECT * FROM individualstudenttiming WHERE eid='$eid' AND crse = '$crse'";
	
				$resultCheckReturning = $mysqli->query($sqlCheckReturning); 
				
				$rowcountCheckReturning = mysqli_num_rows($resultCheckReturning);
				
				if($rowcountCheckReturning>0){
				
					//update
					$sqlUpdateIndTime = "UPDATE individualstudenttiming SET timing = timing + '$intervalNum' WHERE eid = '$eid' AND crse = '$crse'";
					
					$mysqli->query($sqlUpdateIndTime);
					
					//If the execution is in this section then it means that the student is returning considering the crse as well that he came for new subject
					$sqlUpdateDates = "UPDATE sessiondates SET returning = returning + 1 WHERE dates = '$sessionDate'";
					$mysqli->query($sqlUpdateDates); 
				
				}
				else{
					
					//Insert
					$sqlInsertIndTime = "INSERT INTO individualstudenttiming(eid, crse, timing) VALUES('$eid', '$crse', '$intervalNum')";
				
					$mysqli->query($sqlInsertIndTime);
					
					//If the execution is in this section then the student is new
					$sqlUpdateDates = "UPDATE sessiondates SET newStudents = newStudents + 1 WHERE dates = '$sessionDate'";
					$mysqli->query($sqlUpdateDates); 
		
					
					
				}
				
				//Updating the sessiondates table
				
			}
			
			
			//TRUNCATE THE SESSION TABLE
				
			$sqlTruncateHistorical = "TRUNCATE TABLE tutoringsession";
				
			$mysqli->query($sqlTruncateHistorical);
			
			
		}
		else {
			echo "incorrect";
		}
	}
 
 
 $mysqli->close();
 ?>