<?php
	  session_start();
	  $id= $_REQUEST["id"];	 
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createButton"])) { 
		  include 'connectServer.php';
		  $conn = serverConnection(); 
		  if ($conn->connect_error) {		 
			  echo 'Connection failed: ' . $conn->connect_error;                
			  die();
        }
		$staffID =  "Staff".$id;		
		$newFoto = $_FILES["fileToUpload"]["name"];		//get new foto	
		$sql = "SELECT * FROM SSW_STAFF WHERE StaffID = '$staffID'";	// getOld Foto						  
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()) { 
		  $oldFoto = $row["Photo"]; 
		}		
		$checkFoto = 0;
		$uploadOk = 1;
		if($newFoto == ""){ //take oldFoto, no need for further checks 
			$foto = $oldFoto;	
			//echo 'Empty new ';
		}
		if($newFoto == $oldFoto){ //take oldFoto, no need for further checks 
			$foto = $oldFoto;
			//echo 'Same as old ';
		}
		if($newFoto != "" && $newFoto != $oldFoto){ // new file; delete old
			/**delete old after new is confirmed ok**/			
			/** check new **/
			$checkFoto = 1;
			$foto = $newFoto;
			//echo 'Checking new ' . $foto;
		}
		if($checkFoto == 1){			
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
		}//chk foto
		if($uploadOk <> 0){ /** foto check produced no error */
		/* now ok to delete old foto */
		  if($checkFoto == 1 && $oldFoto != ""){
			$picDel = "uploads/" .$oldFoto;
			if($oldFoto != ""){ // nothing to delete?		 
			 if(unlink($picDel)){			  
				  //echo  $oldFoto ." Deleted.";
			  }
			  else{
				  echo 'Unable to delete ';
			  }
			}
		  }
		  $staffID =  "Staff".$id;	
		  $prefixTitle = $_POST["s_Title"];     
		  $postfixTitle = $_POST["s_pTitle"]; 
		  $email = $_POST["s_email"];       
		  $firstName = $_POST["s_firstName"];
		  $lastName = $_POST["s_lastName"];		  
		  $functn = $_POST["s_Function"];
		  $rmNum = $_POST["s_Room"];		  		  
		  $grp = $_POST["s_Group"];				  
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
			$sql = "SELECT * FROM SSW_STAFF WHERE Email = '$email' AND StaffID != '$staffID'";
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
				$sql = "UPDATE SSW_STAFF SET Email = '$email', PrefixTitle ='$prefixTitle', Firstname='$firstName', Lastname='$lastName',
				PostfixTitle='$postfixTitle',Functn='$functn',GroupID ='$grpID', Room ='$rmNum', Photo = '$foto' WHERE StaffID= '$staffID'";
				$error = 0; //initialize error state					        	
				if ($conn->query($sql) === TRUE) {					
					echo "Successfully Updated. Reloading...";	
					/*echo '<script type="text/javascript"> window.location.assign(window.location); </script>';	 */
					echo '<script type="text/javascript"> window.open("EmployeeDirectory.html","_top"); </script>';
				}//close updating into staff table							
				else { 
					echo "Error updating staff: " . $conn->error;				    
				}
			}// acct already exists
		  }//invalid entries 
        } //upload error               
        $conn->close();
    }
  ?> 