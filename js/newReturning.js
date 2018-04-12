$(document).ready(function () {
	
	
	
	// ajax call for getting the data from database
	
	var http = new XMLHttpRequest();
	var url = "getNewAndReturning.php";
	var params = "";

	//"imgId=Henry&lname=Ford"
	http.open("POST", url, true);

	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() {//Call a function when the state changes.
	
		if(http.readyState == 4 && http.status == 200) {
			//alert(http.responseText);	
			var resp = http.responseText;
			var newStudents = [];
			var returning = [];
			var resp = JSON.parse(http.responseText);
			
			
			for (i = 0; i < resp.length; i++) { 
				var respParsed = JSON.parse(resp[i]);	
				newStudents.push([i+1,respParsed.newStudents]); 
			}
			
			for (j = 0; j < resp.length; j++) { 
				var respParsed = JSON.parse(resp[j]);	
				returning.push([j+1,respParsed.returning]); 
			}
		
	
			var total = [];
			for (k = 0; k < resp.length; k++) { 
				total.push([k+1, (parseInt(newStudents[k][1]) + parseInt(returning[k][1]))]);
			}
			
			//alert(total);
	
			// To echo dates 1=>03/03/2018 and so on
			
			var dateRef = '';
			for (l = 0; l < resp.length; l++) { 
				var respParsed = JSON.parse(resp[l]);
				dateRef += l+1 +"=>"+	respParsed.aDate +" || ";				
			}
			document.getElementById("dateRef").innerText = dateRef;
			

	// Graph Data ##############################################
	var graphData = [{
			// New
			data: newStudents,
			//data: [ [6, 1300], [7, 1600], [8, 1900], [9, 2100], [10, 2500], [11, 2200], [12, 2000], [13, 1950], [14, 1900], [15, 2000] ],
			color: '#71c73e'
		}, {
			// Returning Visits
			data: returning,
			color: '#77b7c5',
			points: { radius: 4, fillColor: '#77b7c5' }
		}, {
			// total Visits
			data: total,
			color: 'red',
			points: { radius: 4, fillColor: 'orange' }
		}
		
	];

	// Lines Graph #############################################
	$.plot($('#graph-lines'), graphData, {
		series: {
			points: {
				show: true,
				radius: 5
			},
			lines: {
				show: true
			},
			shadowSize: 0
		},
		grid: {
			color: '#646464',
			borderColor: 'transparent',
			borderWidth: 20,
			hoverable: true
		},
		xaxis: {
			tickColor: 'transparent',
			tickDecimals: 1
		},
		yaxis: {
			tickSize: 1
		}
	});

	// Bars Graph ##############################################
	$.plot($('#graph-bars'), graphData, {
		series: {
			bars: {
				show: true,
				barWidth: .9,
				align: 'center'
			},
			shadowSize: 0
		},
		grid: {
			color: '#646464',
			borderColor: 'transparent',
			borderWidth: 20,
			hoverable: true
		},
		xaxis: {
			tickColor: 'transparent',
			tickDecimals: 1
		},
		yaxis: {
			tickSize: 1
		}
	});

	// Graph Toggle ############################################
	$('#graph-bars').hide();

	$('#lines').on('click', function (e) {
		$('#bars').removeClass('active');
		$('#graph-bars').fadeOut();
		$(this).addClass('active');
		$('#graph-lines').fadeIn();
		e.preventDefault();
	});

	$('#bars').on('click', function (e) {
		$('#lines').removeClass('active');
		$('#graph-lines').fadeOut();
		$(this).addClass('active');
		$('#graph-bars').fadeIn().removeClass('hidden');
		e.preventDefault();
	});

	// Tooltip #################################################
	function showTooltip(x, y, contents) {
		$('<div id="tooltip">' + contents + '</div>').css({
			top: y - 16,
			left: x + 20
		}).appendTo('body').fadeIn();
	}

	var previousPoint = null;

	$('#graph-lines, #graph-bars').bind('plothover', function (event, pos, item) {
		if (item) {
			if (previousPoint != item.dataIndex) {
				previousPoint = item.dataIndex;
				$('#tooltip').remove();
				var x = item.datapoint[0],
					y = item.datapoint[1];
					showTooltip(item.pageX, item.pageY, y + ' visitors at ' + x + '.00h');
			}
		} else {
			$('#tooltip').remove();
			previousPoint = null;
		}
	});
	
	}
	}
	http.send(params);

});