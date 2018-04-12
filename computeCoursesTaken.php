<?php 
require 'db.php';

$Eid = $mysqli->escape_string($_POST['Eid']);

$sql="SELECT * FROM studentlist WHERE eid = '$Eid'";

$result=$mysqli->query($sql);

while($row = $result->fetch_assoc()){
echo $row['crse'];
echo '*';
}	

?>