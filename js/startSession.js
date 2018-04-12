function changeColorToGreen(x){
	x.style.backgroundColor  = "green";
	x.style.color  = "white";
}

function changeColorToWhite(x){
	x.style.backgroundColor  = "white";
	x.style.color  = "black";
}

function computeCoursesTaken(){
	//var x = document.getElementById('nameConfirmation');
	//x.parentNode.removeChild(x);
	$("#nameConfirmation").addClass("hidden");
	
	document.getElementById('title').innerText = "Course Selection";
	document.getElementById("courseSelList").classList.remove("hidden");
	/*Ajax call to generate the list*/
	
	var http = new XMLHttpRequest();
	var url = "computeCoursesTaken.php";
	var Eid = document.getElementById("Eid").value;
	var params = "Eid="+Eid;

	//"imgId=Henry&lname=Ford"
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {//Call a function when the state changes.
		if(http.readyState == 4 && http.status == 200) {
			//alert(http.responseText);	
			var courses =  http.responseText.split("*")
			//document.getElementById('studentName').innerText=http.responseText;
			
			document.getElementById("list").innerHTML ='';
			
			for(i = 0; i < courses.length-1; i++){
				document.getElementById("list").innerHTML += '<div class="box courseBox" onmouseover="changeColorToGreen(this)" onclick="registerIntoSession(\''+courses[i]+'\')" onmouseout="changeColorToWhite(this)"><p class="text-center"> CHEM '+courses[i]+'</p></div>';
			}
		}
	}
	http.send(params);
	
	
}





/*To fillup the review stars*/
function fillStarsTill(starNo){
	clearAllStars();
	
	if(starNo == 1){
		document.getElementById("1").className = "glyphicon glyphicon-star";
		document.getElementById("1").style.color = "yellow";
		
		document.getElementById("starRating").value = "1";
	}
	
	if(starNo == 2){
		document.getElementById("1").className = "glyphicon glyphicon-star";
		document.getElementById("1").style.color = "yellow";
		
		document.getElementById("2").className = "glyphicon glyphicon-star";
		document.getElementById("2").style.color = "yellow";
		
		document.getElementById("starRating").value = "2";
	}
	
	if(starNo == 3){
		document.getElementById("1").className = "glyphicon glyphicon-star";
		document.getElementById("1").style.color = "yellow";
		
		document.getElementById("2").className = "glyphicon glyphicon-star";
		document.getElementById("2").style.color = "yellow";
		
		document.getElementById("3").className = "glyphicon glyphicon-star";
		document.getElementById("3").style.color = "yellow";
		
		document.getElementById("starRating").value = "3";
	}
	
	if(starNo == 4){
		document.getElementById("1").className = "glyphicon glyphicon-star";
		document.getElementById("1").style.color = "yellow";
		
		document.getElementById("2").className = "glyphicon glyphicon-star";
		document.getElementById("2").style.color = "yellow";
		
		document.getElementById("3").className = "glyphicon glyphicon-star";
		document.getElementById("3").style.color = "yellow";
		
		document.getElementById("4").className = "glyphicon glyphicon-star";
		document.getElementById("4").style.color = "yellow";
		
		document.getElementById("starRating").value = "4";
	}
	
	if(starNo == 5){
		document.getElementById("1").className = "glyphicon glyphicon-star";
		document.getElementById("1").style.color = "yellow";
		
		document.getElementById("2").className = "glyphicon glyphicon-star";
		document.getElementById("2").style.color = "yellow";
		
		document.getElementById("3").className = "glyphicon glyphicon-star";
		document.getElementById("3").style.color = "yellow";
		
		document.getElementById("4").className = "glyphicon glyphicon-star";
		document.getElementById("4").style.color = "yellow";
		
		document.getElementById("5").className = "glyphicon glyphicon-star";
		document.getElementById("5").style.color = "yellow";
		
		document.getElementById("starRating").value = "5";
	}
}

/* Clearing all stars on mouse out */

function clearAllStars(){
	document.getElementById("1").className = "glyphicon glyphicon-star-empty";
	document.getElementById("2").className = "glyphicon glyphicon-star-empty";
	document.getElementById("3").className = "glyphicon glyphicon-star-empty";
	document.getElementById("4").className = "glyphicon glyphicon-star-empty";
	document.getElementById("5").className = "glyphicon glyphicon-star-empty";
	
	document.getElementById("1").style.color = "black";
	document.getElementById("2").style.color = "black";
	document.getElementById("3").style.color = "black";
	document.getElementById("4").style.color = "black";
	document.getElementById("5").style.color = "black";
	
}





function IamArriving(){
 $("#success").addClass("hidden");
 $("#already").addClass("hidden");
var http = new XMLHttpRequest();
var url = "IamArriving.php";
var Eid = document.getElementById("Eid").value;
var params = "Eid="+Eid;

//"imgId=Henry&lname=Ford"
http.open("POST", url, true);

//Send the proper header information along with the request
http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

http.onreadystatechange = function() {//Call a function when the state changes.
    if(http.readyState == 4 && http.status == 200) {
        //alert(http.responseText);	
		if(http.responseText == 0){			
			 $("#notFound").removeClass("hidden");
			 $("#nameConfirmation").addClass("hidden");
			 $("#courseSelList").addClass("hidden");			
		}
		else if(http.responseText == 1){
			document.getElementById("Eid").value="";
			$("#already").removeClass("hidden");
			$("#courseSelList").addClass("hidden");
			$("#notFound").addClass("hidden");
			$("#nameConfirmation").addClass("hidden");
		}
		else{	
			$("#courseSelList").addClass("hidden");
			$("#nameConfirmation").removeClass("hidden");			
			document.getElementById('studentName').innerText=http.responseText;		
			$("#notFound").addClass("hidden");
		}
    }
}
http.send(params);
}


function registerIntoSession(courseNo){
	var http = new XMLHttpRequest();
	var url = "registerIntoSession.php";
	var Eid = document.getElementById("Eid").value;
	var params = "Eid="+Eid+"&courseNo="+courseNo;

	//"imgId=Henry&lname=Ford"
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {//Call a function when the state changes.
		if(http.readyState == 4 && http.status == 200) {
			//alert(http.responseText);	
			$('#success').removeClass("hidden");
			$("#courseSelList").addClass("hidden");	
			document.getElementById('Eid').value='';	
			
		}
	}
	http.send(params);
}



function IamLeaving(courseNo){
	
	document.getElementById("Button").disabled = true;
	
	var http = new XMLHttpRequest();
	var url = "IamLeaving.php";
	var Eid = document.getElementById("Eid").value;
	var comments = document.getElementById("comments").value;
	var rating = document.getElementById("starRating").value;
	var params = "Eid="+Eid+"&comments="+comments+"&rating="+rating;

	//"imgId=Henry&lname=Ford"
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {//Call a function when the state changes.
		if(http.readyState == 4 && http.status == 200) {
			
			document.getElementById("Button").disabled = false;
			//alert(http.responseText);	
			document.getElementById('Eid').value='';
			document.getElementById('comments').value='';
			document.getElementById('starRating').value='';
			clearAllStars();
					
			
			//alert(http.responseText);
			if(http.responseText == 2){
				$('#alertResponse').removeClass("hidden");
				$('#commentsAndRating').addClass("hidden");
				$('#signOutBtn').addClass("hidden");
				$('#time').addClass("hidden");				
				document.getElementById('alertResponse').innerText='Sign out unsuccessful. Either you are not signed In or the Eid you entered is incorrect.';				
			}
			if(http.responseText == 1){
				$('#alertResponse').removeClass("hidden");
				$('#commentsAndRating').addClass("hidden");
				$('#signOutBtn').addClass("hidden");
				$('#time').addClass("hidden");
				document.getElementById('alertResponse').innerText='You are already signed out.';				
			}
			if(http.responseText != 1 && http.responseText != 2){
				$('#time').removeClass("hidden");
				$("#commentsAndRating").addClass("hidden");
				$("#signOutBtn").addClass("hidden");
				document.getElementById('timeSpentToday').innerText=http.responseText;
			}	
			
		}
	}
	http.send(params);
}



function classAdjust(){
	$("#time").addClass("hidden");
	$("#alertResponse").addClass("hidden");
	$('#signOutBtn').removeClass("hidden");
	$('#commentsAndRating').removeClass("hidden");
}


function calculateUnsignedoutStudents(){
	var http = new XMLHttpRequest();
	var url = "calculateUnsignedoutStudents.php";	
	var params = "";

	//"imgId=Henry&lname=Ford"
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {//Call a function when the state changes.
		if(http.readyState == 4 && http.status == 200) {
				
			document.getElementById('notSignedOut').innerText=http.responseText;
			document.getElementById('correctOrNot').innerText="";
		}
	}
	http.send(params);
}


function checkAndEndSession(){
	var http = new XMLHttpRequest();
	var url = "checkAndEndSession.php";	
	var Email = document.getElementById("Email").value;
	var pass = document.getElementById("pass").value;
	var params = "Email="+Email+"&pass="+pass;

	//"imgId=Henry&lname=Ford"
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {//Call a function when the state changes.
		if(http.readyState == 4 && http.status == 200) {
			//alert(http.responseText);
			if(http.responseText.trim()=="incorrect"){	
			document.getElementById('correctOrNot').innerText="Email or Password is incorrect, Please try again";
			}
			else{
				$("#modalContent").addClass("hidden");
				document.getElementById('endSuccessful').innerText="Session ended successfuly. You will now be redirected to Admin functionality page";
				setTimeout(redirect, 4000)
				
			}
			
		}
	}
	http.send(params);
}

function redirect() {
    location.replace("http://www.chemnights.com/index.php"); // will have to change when hosting the site
}