 <?php 
require 'db.php';

date_default_timezone_set("America/Detroit");

$Eid = $mysqli->escape_string($_POST['Eid']);
$courseNo = $mysqli->escape_string($_POST['courseNo']);
$d = date("m-d-Y");
$t = date("h:i:s");

$sql="INSERT INTO tutoringsession(eid, crse, sessionDate, sessionStartTime ) VALUES('$Eid' , '$courseNo', '$d', '$t')";

$result=$mysqli->query($sql);


$sqlHistorical="INSERT INTO tutoringsessionhistorical(eid, crse, sessionDate, sessionStartTime) VALUES('$Eid' , '$courseNo', '$d', '$t')";

$result=$mysqli->query($sqlHistorical);


$mysqli->close();
?>