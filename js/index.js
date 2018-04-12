$('.form').find('input, textarea').on('keyup blur focus', function (e) {
  
  var $this = $(this),
      label = $this.prev('label');

	  if (e.type === 'keyup') {
			if ($this.val() === '') {
          label.removeClass('active highlight');
        } else {
          label.addClass('active highlight');
        }
    } else if (e.type === 'blur') {
    	if( $this.val() === '' ) {
    		label.removeClass('active highlight'); 
			} else {
		    label.removeClass('highlight');   
			}   
    } else if (e.type === 'focus') {
      
      if( $this.val() === '' ) {
    		label.removeClass('highlight'); 
			} 
      else if( $this.val() !== '' ) {
		    label.addClass('highlight');
			}
    }

});

$('.tab a').on('click', function (e) {
  
  e.preventDefault();
  
  $(this).parent().addClass('active');
  $(this).parent().siblings().removeClass('active');
  
  target = $(this).attr('href');

  $('.tab-content > div').not(target).hide();
  
  $(target).fadeIn(600);
  
});



$(document).ready(function () {
	var http = new XMLHttpRequest();
	var url = "calcTopFiveStudents.php";	
	var params = "";

	//"imgId=Henry&lname=Ford"
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {//Call a function when the state changes.
		if(http.readyState == 4 && http.status == 200) {
			//alert(http.responseText);	
			
			var resp = JSON.parse(http.responseText);
			
			
			for (i = 0; i < resp.length; i++) { 
				var respParsed = JSON.parse(resp[i]);	
				
				document.getElementById("top5Students").innerHTML += "<tr><td>"+respParsed.name+"</td><td>"+respParsed.timing+"</td><td>"+respParsed.crse+"</td><td>"+respParsed.t+"</td><td>"+respParsed.days+"</td></tr>" ;	
			}
			
		}
	}
	http.send(params);
	
	
});




$(document).ready(function () {
	var http = new XMLHttpRequest();
	var url = "calcTopFiveInstructors.php";	
	var params = "";

	//"imgId=Henry&lname=Ford"
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {//Call a function when the state changes.
		if(http.readyState == 4 && http.status == 200) {
			//alert(http.responseText);	
			
			var resp = JSON.parse(http.responseText);
			
			
			for (i = 0; i < resp.length; i++) { 
				var respParsed = JSON.parse(resp[i]);	
				
				document.getElementById("top5Instructors").innerHTML += "<tr><td>"+respParsed.name+"</td><td>"+respParsed.timing+"</td><td>"+respParsed.crse+"</td><td>"+respParsed.t+"</td><td>"+respParsed.days+"</td></tr>" ;	
			}
			
		}
	}
	http.send(params);
	
	
});