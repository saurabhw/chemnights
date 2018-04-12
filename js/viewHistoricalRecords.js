 $(document).ready(function () {
	var http = new XMLHttpRequest();
	var url = "getHistorical.php";	
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
				
				document.getElementById("historical").innerHTML += "<tr><td>"+respParsed.eid+"</td><td>"+respParsed.crse+"</td><td>"+respParsed.sessionDate+"</td><td>"+respParsed.sessionStartTime+"</td><td>"+respParsed.sessionEndTime+"</td><td>"+respParsed.comments+"</td><td>"+respParsed.rating+"</td></tr>" ;	
			}
			
		}
	}
	http.send(params);
	
	
});