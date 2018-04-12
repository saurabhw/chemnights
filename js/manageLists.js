 $(document).ready(function (e) {
	$("#studentListUploadForm").on('submit',(function(e) {
		$('#closeBtn').addClass( "hidden" );
		$('#lcloseBtn').addClass( "hidden" );
		$("#text").text("Uploading Student List");			
		$("#uniModal").modal();
		e.preventDefault();	
		$.ajax({
        	url: "studentListUpload.php",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data)
		    {
			//$("#targetLayer").html(data);
				$('#closeBtn').removeClass( "hidden" );
				$('#lcloseBtn').removeClass( "hidden" );
				$('#loader').addClass( "hidden" );
				$("#text").text("Student List upload successful"); 
				$("#uniModal").modal();
		    },
		  	error: function() 
	    	{
	    	} 	        
	   });
	}));
});

$(document).ready(function (e) {
	$("#courseListUploadForm").on('submit',(function(e) {		
		e.preventDefault();
		$.ajax({
        	url: "courseListUpload.php",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data)
		    {
			//$("#targetLayer").html(data);
				$("#text").text("Course List upload successful"); 
				$("#uniModal").modal();
		    },
		  	error: function() 
	    	{
	    	} 	        
	   });
	}));
});



