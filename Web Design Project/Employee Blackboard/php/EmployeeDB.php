<?php
	 session_start();
	 $_SESSION["EmployeeAdded"] = 0;
      if ($_SERVER["REQUEST_METHOD"] == "POST") { 
      	include 'connectServer.php';
        $conn = serverConnection(); 
        if ($conn->connect_error) {		 
            echo 'Connection failed: ' . $conn->connect_error;                
            die();
        }						
		if(($_FILES["fileToUpload"]["size"] == 0) ){ //no file upload is not an error
		  $uploadOk = -1;
		}else{
		  $uploadOk = 1;
		  $target_dir = "uploads/";
		  $target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);		  
		  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		  
		  // Check if image file is a actual image or fake image			
		  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		  if($check !== false) {
			 // echo "File is an image - " . $check["mime"] . ".";	  
			  $uploadOk = 1;			
		  } else {			 
			  echo "File is not an image.";
			  $uploadOk = 0;			
		  }				  
		  // Check if file already exists
		  if (file_exists($target_file)) {			  
			  $uploadOk = -1;
		  }
		  // Check file size
		  if ($_FILES["fileToUpload"]["size"] > 500000) {			  
			  echo 'Sorry, your file is too large.';
			  $uploadOk = 0;
		  }
		  // Allow certain file formats
		  $image = strtolower($imageFileType);
		  if($image != "jpg" && $image != "png" && $image != "jpeg"
		  && $image != "gif" ) {			  
			  echo 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';
			  $uploadOk = 0;
		  }   
		  // Check if $uploadOk is set to 0 by an error
		  if ($uploadOk == 0) {			  
			 //error
		  }if ($uploadOk == -1) {
			  //file already exists no new upload			
		  } if($uploadOk == 1) {			
			  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {				  
			  } else {
				  $uploadOk = 0;				  
				  echo "Sorry, there was an error uploading your file.";
			  }
		  }
	    }
		if($uploadOk <> 0){ /** foto check produced no error */
		  
		  // define variables and set to empty values
		  $prefixTitle = $postfixTitle= $email =$firstName =  $lastName = $foto = $functn = $grp = $rmNum = ""; 
		  $prefixTitle = $_POST["s_Title"];     
		  $postfixTitle = $_POST["s_pTitle"]; 
		  $email = $_POST["s_email"];       
		  $firstName = $_POST["s_firstName"];
		  $lastName = $_POST["s_lastName"];
		  $foto = $_FILES["fileToUpload"]["name"];
		  $functn = $_POST["s_Function"];
		  $rmNum = $_POST["s_Room"];		  		  
		  $grp = $_POST["s_Group"];	
		  $vis = 1; //employee visibility	
		  
		  //echo $_POST["s_Status"][2];
		  $error = 0;
		  $report= "Please Fill in the field(s): ";
		  if($email == ""){$error = 1;$report.="Email ";}
		  if($firstName == ""){$error = 1;$report.="Firstname ";}
		  if($lastName == ""){ $error = 1; $report.="Lastname ";}	
	      if($rmNum == ""){ $error = 1;$report.="Room number ";}
		  if($grp == ""){ $error = 1;$report.="Group ";}
		  if ($error == 1){
			  echo $report;			  
		  }else{			 		
			//validate entries for insertion into database
			$sql = "SELECT * FROM SSW_STAFF WHERE Email = '$email'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			  // account already exists	         
			  echo "An account already exists with this email";				  
			} else {
				//validate entries for insertion into database
				$sql = "SELECT * FROM SSW_GROUPS WHERE Rank = '$grp'";
				$result = $conn->query($sql);
				while($row = $result->fetch_assoc()) {
                 	$grpID = $row["id"];
				}
				//Enteries valid, okay to insert
				$sql = "INSERT INTO SSW_STAFF (Email, PrefixTitle, Firstname, Lastname,PostfixTitle, Photo,  Functn, GroupID, Room,isVisible)
				VALUES ('$email','$prefixTitle','$firstName', '$lastName','$postfixTitle','$foto','$functn','$grpID', '$rmNum','$vis')";	        	
				if ($conn->query($sql) === TRUE) {					
					$last_id = $conn->insert_id; 
					$staffID =  "Staff".$last_id;				
					//1. update staff id
					$sql = "UPDATE SSW_STAFF SET StaffID= '$staffID' WHERE id= '$last_id' ";
					if ($conn->query($sql) === TRUE) {
						//2.Traverse through the HTML 'tableStatus' and insert into the DataBase for Status
						 $st = $_POST["s_Status"];	
						 $n = count($st);  		  
						 //echo $n;
						 for ($i = 0; $i < $n; $i++) { 
							$status = $_POST["s_Status"][$i];
							$from = $_POST["startDate"][$i];
							$end = $_POST["endDate"][$i];
							if(isset ($_POST["display"][$i])){
							  $visibility = TRUE;	
							}else{$visibility = FALSE;}
							//insert into the Table for Status 
							if($status != "")  {                 
							  $sql = "INSERT INTO SSW_STAFF_STATUS (StaffID,Status,Start,Stop, Visible)
							  VALUES ('$staffID','$status', '$from','$end', '$visibility')";						 	
							  if ($conn->query($sql) === TRUE) {
								  //insertion i successful													
							  }
							  else{
								  echo 'Error updating Status';
							  } // close inserting into table status
							}//end if status is null
						  }//close for loop																	 		
					}//close update ssw_staff for staff id
					$_SESSION["EmployeeAdded"] = 1;
					echo "Added.Reloading...";						   
					echo '<script type="text/javascript"> window.open("EmployeeDirectory.html","_top"); </script>';
				}//close insertion into staff table							
				else { 
					echo "Error adding staff: " . $conn->error;				    
				}
			}// acct already exists
		  }//invalid entries 
        }  //upload error               
        $conn->close();
    }
  ?> 