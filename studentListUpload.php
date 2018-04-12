<?php
require 'db.php';

if(is_array($_FILES)) {
	if(is_uploaded_file($_FILES['studentList']['tmp_name'])) {
		$sourcePath = $_FILES['studentList']['tmp_name'];
		//$targetPath = "lists/".$_FILES['studentList']['name'];
		$file_ext=strtolower(end(explode('.',$_FILES['studentList']['name'])));
		$targetPath = "lists/studentList.".$file_ext;
		if(move_uploaded_file($sourcePath,$targetPath)) {
			require 'PHPExcel/IOFactory.php';
			$objPHPExcel = PHPExcel_IOFactory::load($targetPath);
			
					$create = "CREATE TABLE IF NOT EXISTS studentlist(eid varchar(9),crn varchar(5),instructor varchar(100),sname varchar(100),crse varchar(10), time varchar(10), days varchar(10), email varchar(50),primary key (eid,crn))";
					mysqli_query($mysqli, $create);
				
					
					
					$trunc = "TRUNCATE TABLE individualstudenttiming";
					mysqli_query($mysqli, $trunc);
					
					
					$trunc = "TRUNCATE TABLE sessiondates";
					mysqli_query($mysqli, $trunc);
					
					
					$trunc = "TRUNCATE TABLE tutoringsession";
					mysqli_query($mysqli, $trunc);
					
					$trunc = "TRUNCATE TABLE studentlist";
					mysqli_query($mysqli, $trunc);
					
					
			
			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet){
				$highestRow = $worksheet->getHighestRow();
				for($row=2; $row<=$highestRow; $row++) //start from the second row skiping the header
				{		
								
					$eid = mysqli_real_escape_string($mysqli, $worksheet->getCellByColumnAndRow(0, $row)->getValue());   //col 1
					$crn = mysqli_real_escape_string($mysqli, $worksheet->getCellByColumnAndRow(1, $row)->getValue());  //col 2
					$instructor = mysqli_real_escape_string($mysqli, $worksheet->getCellByColumnAndRow(2, $row)->getValue());  //col 3
					$sName = mysqli_real_escape_string($mysqli, $worksheet->getCellByColumnAndRow(3, $row)->getValue());  //col 4
					$crse = mysqli_real_escape_string($mysqli, $worksheet->getCellByColumnAndRow(4, $row)->getValue());  //col 5
					$time = mysqli_real_escape_string($mysqli, $worksheet->getCellByColumnAndRow(5, $row)->getValue());  //col 6
					$days = mysqli_real_escape_string($mysqli, $worksheet->getCellByColumnAndRow(6, $row)->getValue());  //col 7
					$email = mysqli_real_escape_string($mysqli, $worksheet->getCellByColumnAndRow(7, $row)->getValue());  //col 8
					
					$query = "INSERT INTO studentlist(eid, crn, instructor, sname, crse, time, days, email) VALUES ('".$eid."', '".$crn."', '".$instructor."', '".$sName."', '".$crse."', '".$time."', '".$days."', '".$email."')";
					mysqli_query($mysqli, $query);					
				}
			  }
			
			
			
		}
	}
}
?>