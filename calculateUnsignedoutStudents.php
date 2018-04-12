 <?php
	require 'db.php';

	$sql="SELECT * FROM tutoringsession WHERE sessionEndTime IS NULL";

	$result=$mysqli->query($sql);

	$rowcount=mysqli_num_rows($result);

	echo $rowcount;	

	$mysqli->close();
 
 ?>