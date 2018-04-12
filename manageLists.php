<?php
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
  
  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
  
  <link rel="stylesheet" href="css/profile.css">
  <link rel="stylesheet" href="css/manageLists.css">	
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

<!-- First Container -->
<div class="container-fluid bg-1 text-center">  
  <h3 class="margin">Student List and Course List Management.</h3>  
  <p>Upload new student list and course list at the beginning of every semester.</p>
</div>

<!-- Second Container -->
<div class="container-fluid bg-2 text-center">
	<p>The student list should have a structure as shown below. The CRN, Crse columns should be formatted as numbers in the excel.</p>
	<div>
		<img src="img/studentListExample.PNG">	
	</div>
	<p>
	<p>
		The excel sheet should be in .xls format.
	</p>	
		<form id="studentListUploadForm" method="post">
			<input type="file" class="form-group form-control" name="studentList">
			<button type="submit" class="btn btn-default btn-lg form-group">Upload Student list</button>
		</form>
	</p>      
</div>

<!-- Third Container -->
<!--
<div class="container-fluid bg-3 text-center">
	<p>
		<form id="courseListUploadForm" method="post">
			<input type="file" class="form-group form-control" name="courseList">
			<button type="submit" class="btn btn-default btn-lg form-group">Upload Course list</button>
		</form>
	</p>      
</div>
-->

<!-- Universal Modal -->
<div id="uniModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button id="closeBtn" type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"></h4>
      </div>
      <div class="modal-body">		
		<div class="loader" id="loader"></div>		
		<p id="text" class="text-center"></p>
      </div>
      <div class="modal-footer">
        <button id="lcloseBtn" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<!-- Footer -->
<?php include 'footer.php'?>
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src='js/manageLists.js'></script>


</body>
</html>
