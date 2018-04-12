<?php 
require 'db.php';
session_start();

date_default_timezone_set("America/Detroit");

// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "You must log in before viewing your this page!";
  header("location: error.php");    
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
  
  <title>CSIE Tutoring</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">  
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/startSession.css">
  
  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
  
</head>
<body>

<!-- Navbar -->
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
		<li><a href="logout.php">Admin Log Out</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- First Container -->
<div class="container-fluid bg-1 text-center" >
  <h1 class="margin ">Welcome to CSIE tutoring session on <?php echo date("m/d/Y") ; ?>. Our tutors are happy to help you.</h1>
	<br>
	<br>
	<input id="Eid" type="text" class="form-group form-controll" placeholder="Enter your E Id: E0123456" ><!--requiredness of this field will be taken care during the ajax call of the button clicks-->
	<div>
	  <button class="btn btn-success btn-lg form-group form-controll" data-toggle="modal" data-target="#myModal" onclick="IamArriving()" >I am arriving</button><!-- Ajax call to compute name-->
	  <button class="btn btn-danger btn-lg form-group form-controll"  data-toggle="modal" data-target="#leavingModal" onclick="classAdjust()" >I am leaving</button>
	</div>  
</div>



<!-- Second Container -->
<div class="container-fluid bg-2 text-center">
  <h3 class="margin">Admin Use only</h3>
  <p></p>
  <a href="#" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#endModal" onclick="calculateUnsignedoutStudents();">
     END TUTORING SESSION
  </a>
</div>

<!-- Footer -->
<?php include 'footer.php';?>






<!-- Student Name Confirmation Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center" id="title">Student Name Confirmation</h4>
      </div>
      <div class="modal-body">
		
		<div id="notFound" class="hidden">
			<p class="forgot text-center" >E id not found in the database make sure E id is typed correct eg. E01234567. </p>			
		</div>
		
		<div id="success" class="hidden">
			<p class="forgot text-center" >Sign in successful. Have a great tutoring session and don't forget to signout when you leave!</p>			
		</div>
		
		<div id="already" class="hidden">
			<p class="forgot text-center" >You are already Signed in.</p>			
		</div>
		
		<div id="nameConfirmation">
			<p class="forgot text-center" >Is Your name <span id="studentName">XYZ</span></p>
			<div class="text-center">
				<button class="btn btn-success btn-lg form-group form-controll" type="submit" name="login" onclick="computeCoursesTaken()">Yes</button>
				<button class="btn btn-danger btn-lg form-group form-controll" type="submit" name="login" data-dismiss="modal" >No</button>
			</div>
		</div>
		
		<div id="courseSelList" class="hidden">
			<p class="forgot text-center">What course will you be studing today?</p>
			<div id="list">					
				
				
			</div>
		</div>
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>





<!-- End tutoring session confirmation Modal -->
<div id="endModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Admin Login Needed for Ending Session</h4>
      </div>
      <div class="modal-body">
		<div id="modalContent">
			<span id="notSignedOut" style="color:red;"></span> <span style="color:blue;">Students are still signed into the tutoring session. Ending the session will cause a force logout and award each of them a default of 30 minutes time.</span>
			<input class="form-control form-group" type="email" placeholder="Email" name="email" id="Email">
			<input class="form-control form-group" type="password" placeholder="Password" name="password" id="pass">
			<span id="correctOrNot"></span>
			<div ><button class="form-control form-group btn btn-danger" name="login" onclick="checkAndEndSession()" >End Session</button></div>
		</div>
		<span id="endSuccessful" style="color:green"></span>
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<!-- End tutoring session confirmation Modal -->
<div id="leavingModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">I am Leaving</h4>
      </div>
      <div class="modal-body">
		<p id="time" class="hidden">You spent <span id="timeSpentToday" style="color:blue">120</span>  in the session today.</p>
		<p id="alertResponse" class="hidden" style="color:red"></p>
		<div id="commentsAndRating">
			<p>Thank you for attending the tutoring session. Your presence is greatly appreciated</p>			
			<p>Would you like to describe your experience at the tutoring session?</p>
			<input id="comments" type="text" class="form-group form-control" placeholder="Your comments goes here...">
			<p>Rate your experience: </p>
			<span class="glyphicon glyphicon-star-empty" style=" font-size:1.3em;" id="1" onmouseover="fillStarsTill(1)" ></span>
			<span class="glyphicon glyphicon-star-empty" style=" font-size:1.3em;" id="2" onmouseover="fillStarsTill(2)" ></span>
			<span class="glyphicon glyphicon-star-empty" style=" font-size:1.3em;" id="3" onmouseover="fillStarsTill(3)" ></span>
			<span class="glyphicon glyphicon-star-empty" style=" font-size:1.3em;" id="4" onmouseover="fillStarsTill(4)" ></span>
			<span class="glyphicon glyphicon-star-empty" style=" font-size:1.3em;" id="5" onmouseover="fillStarsTill(5)" ></span>
			
			<input type="number" value="" id="starRating" class="hidden">
		</div>
      </div>
      <div class="modal-footer">
        <div class="text-center" id="signOutBtn"><button type="button" id="Button" class="btn btn-lg btn-warning" onclick="IamLeaving()">Sign Me out</button></div>
      </div>
    </div>

  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/startSession.js"></script>
</body>
</html>
