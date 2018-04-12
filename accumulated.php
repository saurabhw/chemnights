  <?php
  
  require 'db.php';
  
/* Displays user information and some useful messages */
session_start();

// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "You must log in before viewing your this page!";
  header("location: error.php");    
}
else {
    // Makes it easier to read
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];
	$_SESSION['message'] = "";
}
?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Welcome <?= $first_name.' '.$last_name ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/profile.css">	
  <link rel="stylesheet" href="css/viewHistoricalRecords.css">	

  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
  <div class="form">
                    
        
          <?php 
     
          // Display message about account verification link only once
          if ( isset($_SESSION['message']) )
          {
              echo $_SESSION['message'];
              
              // Don't annoy the user with more messages upon page refresh
              unset( $_SESSION['message'] );
          }
          
          ?>
        
          
          <?php
          
          // Keep reminding the user this account is not active, until they activate
          if ( !$active ){
              echo
              '<div class="info">
              Account is unverified, please confirm your email by clicking
              on the email link!
              </div>';
          }
          
          ?>
    </div>
	
<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      
	  <img src="img/CSIE Logo.jpg" class="img-responsive " alt="logo" width="70" height="">
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">        
		
        <li><a href="logout.php">Log Out</a></li>
      </ul>
    </div>
  </div>
</nav>



<?php 

$sql="SELECT individualstudenttiming.eid, individualstudenttiming.crse, timing, crn, instructor, sname, time , days, email FROM individualstudenttiming, studentlist WHERE individualstudenttiming.eid = studentlist.eid AND individualstudenttiming.crse = studentlist.crse ORDER BY timing DESC";

$result=$mysqli->query($sql);


?>

<!-- First Container -->
<div class="container-fluid bg-1 text-center">
	<h3 class="margin">Timing accumulated by students</h3>
	<h3></h3>
	<table style="width:100%" id="historical" class="table">
		<tr>
			<td>Student Name</td>
			<td>Time accumulated</td>
			<td>Course Number</td>
			<td>Course time</td>
			<td>Course days</td>			
		</tr>
		
		<?php 
			while($row = $result->fetch_assoc()){
		?>
		
			<tr>
				<td><?php echo $row['sname']; ?></td>
				<td><?php echo $row['timing']; ?></td>
				<td><?php echo $row['crse']; ?></td>
				<td><?php echo $row['time']; ?></td>
				<td><?php echo $row['days']; ?></td>			
			</tr>
		
		<?php } ?>
	</table>
</div>

<div class="text-center">
<button id="btn" class="btn btn-success">Export to Excel</button>
</div>


<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script type="text/javascript" src="js/jquery.table2excel.js"></script>

<script type="text/javascript">

$('.btn').click(function(){
	$('table').table2excel({
		name:'Accumulated Timings',
		filename:'Accumulated Timings'
	});
});

</script>


<!-- Footer -->
<?php include 'footer.php';?>
    



</body>
</html>
