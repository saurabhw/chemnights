 <?php 
require 'db.php';

$Eid = $mysqli->escape_string($_POST['Eid']);

$sql="SELECT * FROM studentlist WHERE eid = '$Eid'";

$result=$mysqli->query($sql);

$rowcount=mysqli_num_rows($result);

if($rowcount == 0){
	echo 0;
}

$sqlAlreadyInCheck="SELECT * FROM tutoringsession WHERE eid = '$Eid'";

$resultCheck=$mysqli->query($sqlAlreadyInCheck);

$rowcountCheck=mysqli_num_rows($resultCheck);

if($rowcountCheck > 0){
	echo 1;
}

else{
	while($row = $result->fetch_assoc()){
		echo $row['sname'];
		break;
	}	
}

$mysqli->close();
?>