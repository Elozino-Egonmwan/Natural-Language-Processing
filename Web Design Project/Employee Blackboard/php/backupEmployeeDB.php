<?php
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
		  $title = $titles= $email =$firstName =  $lastName = $foto = $functn = $grp = $rmNum = ""; 
		  $title = $_POST["s_Title"];     
		  $titles = $_POST["s_pTitle"]; 
		  $email = $_POST["s_email"];       
		  $firstName = $_POST["s_firstName"];
		  $lastName = $_POST["s_lastName"];
		  $foto = $_FILES["fileToUpload"]["name"];
		  $functn = $_POST["s_Function"];
		  $rmNum = $_POST["s_Room"];		  		  
		  $grp = $_POST["s_Group"];
		  if ($grp == ""){		
		   echo "Please Select a valid group";
		  }else{			
			//validate entries for insertion into database
			$sql = "SELECT * FROM SSW_STAFF WHERE Email = '$email'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			  // account already exists	         
			  echo "An account already exists with this email";
			} else {
				//Enteries valid, okay to insert
				$sql = "INSERT INTO SSW_EMPLOYEES (Email, Title, Firstname, Lastname, Titles, Photo,  Funktn, Grp, Room_Number)
				VALUES ('$email','$title','$firstName', '$lastName','$titles','$foto','$functn','$grp', '$rmNum')";	        	
				if ($conn->query($sql) === TRUE) {
					//$acc = 1; 
					$last_id = $conn->insert_id; 
					$tableStatus =  "Staff".$last_id."_Status"; 
					$sql = "CREATE TABLE IF NOT EXISTS $tableStatus (
					id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					Status TEXT,
					Start DATE, 
					Stop DATE,
					Visible BOOLEAN					                
					)";	
					if ($conn->query($sql) === TRUE) { 
					//1. update link to status table on ssw board
						$sql = "UPDATE SSW_EMPLOYEES SET Status_Table ='$tableStatus' WHERE id ='$last_id' ";
						if ($conn->query($sql) === TRUE) {
							//2.Traverse through the HTML 'tableStatus' and insert into the DataBase for Status
							$statuS = $_POST["s_Status"];
							$numRows = count($statuS);
							for ($i = 0; $i < $numRows; $i++) { 
							  $status = $_POST["s_Status"][$i];
							  $from = $_POST["startDate"][$i];
							  $end = $_POST["endDate"][$i];
							  if(isset ($_POST["status"][$i])){
							  	$visibility = TRUE;	
							  }else{$visibility = FALSE;}
							  //insert into the Table for Status                    
							  $sql = "INSERT INTO $tableStatus (Status,Start,Stop, Visible)
							  VALUES ('$status', '$from','$end', '$visibility')";
							  if ($conn->query($sql) === TRUE) {
								  //successful
							  }
							  else{
								  echo 'Error updating Status';
							  }
							}							
							if (isset($_SESSION['Location'])){
								$loc = $_SESSION['Location'] ; 
							} else{
								$loc = "Home.html";
							}					 
							echo "Employee Successfully added";							 		
						}	
						} else {
							echo "Error creating Status Table: " . $conn->error;   
						}								                                                	                  		
					  
				} else {
					echo "Error creating Table Employees: " . $conn->error;
				   // echo  '<script type="text/javascript">display("Unable to create account");</script>' ;		 
				}
			}
		  } 
        }                 
        $conn->close();
    }
    
  ?> 