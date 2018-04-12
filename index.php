<?php 
require 'db.php';
session_start();
?>


<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    if (isset($_POST['login'])) { //user logging in

        require 'login.php';
        
    }
    
    elseif (isset($_POST['register'])) { //user registering
        
        require 'register.php';
        
    }
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

  <link rel="stylesheet" href="css/index.css">

<!-- For new and returning graph -->  
  <link rel="stylesheet" href="css/graph.css">	

    
  <style>html,body{height:100%}</style>
  
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
		<!-- Trigger the modal with an anchor -->
        <li><a href="#" data-toggle="modal" data-target="#myModal">Admin Login</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- First Container -->
<div class="container-fluid bg-1 text-center" >
  <h1 class="margin">CSIE CHEM Nights</h1>
  
  <h3></h3>
</div>

<!-- Second Container -->
<div class="container-fluid bg-2 text-center">
  <h3 class="margin">About the tutoring</h3>
  <p>College can be tough, but not when CSIE is around. We at CSIE Provide Semester round tutoring for chemistry. We have highly skilled tutors who are ready to help the students. </p>
</div>





<!-- Graph HTML -->
<div class="container bg-3 text-center"> 
<div class="row">
<div class="col-md-12"> 
<div id="graph-wrapper">
	<div class="graph-info">
		<a href="javascript:void(0)" class="visitors">New</a>
		<a href="javascript:void(0)" class="returning">Returning </a>
		<a href="javascript:void(0)" class="total">Total</a>

		<a href="#" id="bars"><span></span></a>
		<a href="#" id="lines" class="active"><span></span></a>
	</div>

	<div class="graph-container">
		<div id="graph-lines"></div>
		<div id="graph-bars"></div>
	</div>	
</div>
</div>
</div>
</div>


<div class="container-fluid bg-2 text-center">
  <h3>Graph Dates</h3>		
  <p id="dateRef"></p>  
</div>

<!-- end Graph HTML -->

<!-- Top 5 students Container -->
<div class="container-fluid bg-4 text-center">
  <h3 class="margin">Top 5 Students</h3>
  
  <table style="width:100%" id="top5Students">
	  <tr>
		<th>Student Name</th>
		<th>Time accumulated</th> 
		<th>Course Number</th>
		<th>Course time</th>
		<th>Course days</th>
	  </tr>
	  	  
  </table>
</div>


<!-- Top 5 instructor Container -->
<div class="container-fluid bg-5 text-center">
  <h3 class="margin">Top 5 Instructors</h3>
  <table style="width:100%" id="top5Instructors">
	  <tr>
		<th>Instructor Name</th>
		<th>Time accumulated</th> 
		<th>Course Number</th>
		<th>Course time</th>
		<th>Course days</th>
	  </tr>
	  	  
  </table>
</div>




<?php include 'footer.php'?>



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Admin Login</h4>
      </div>
      <div class="modal-body">
		<form action="index.php" method="post" autocomplete="off">
			<input class="form-control form-group" type="email" placeholder="Email" name="email">
			<input class="form-control form-group" type="password" placeholder="Password" name="password">
			<div ><button class="form-control form-group btn btn-success" type="submit" name="login" >Log In</button></div>
		</form>
		<p class="forgot"><a href="forgot.php">Forgot Password?</a></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>






<script src="js/jquery.flot.min.js"></script>
<script src="js/newReturning.js"></script>


<script src="js/index.js"></script>


</body>
</html>
