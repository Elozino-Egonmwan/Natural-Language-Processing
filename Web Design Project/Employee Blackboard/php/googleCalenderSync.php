<?php
// Start the session
session_start();
include 'connectServer.php';     
$conn = serverConnection(); 		  
if ($conn->connect_error) {		 
  echo 'Connection failed: ' . $conn->connect_error;                
  die();  
}
$searchName = $_REQUEST["named"];
$status = $_REQUEST["status"];
$start = $_REQUEST["startDate"];
$end =$_REQUEST["endDate"];
$statusId = $_REQUEST["statId"];
$visibility = 1;
$updated = 1;
if ($searchName !== "") {	
	$names = explode(" ", $searchName); /* split compound names  eg Matthias. G**/	
	$sql = "SELECT * FROM SSW_STAFF";
	$result = $conn->query($sql);	
	$count = 0;
	while($row = $result->fetch_assoc()) {
		$match = 0; 
		$lName = $row["Lastname"];
		$fName =$row["Firstname"];
		//$staffID = $row["StaffID"];
		
		if(count($names) == 1){
			if ( stristr($fName, $names[0]) ||  stristr($lName,  $names[0])) {
				$match = 1;	
				$count++;
				$staffID = $row["StaffID"];
			}
		}
		else{			
			$lenL = strlen($names[1]);
			$lenF = strlen($names[0]);			 
			if (  stristr($names[0], substr($fName, 0, $lenF)) &&   stristr($names[1], substr($lName, 0, $lenL))    ||
			      stristr($names[0], substr($lName, 0, $lenL)) &&   stristr($names[1], substr($fName, 0, $lenF)) 
			) {
			/*if (  ( stristr($fName, $names[0]) || stristr($lName,$names[0]) ) &&
				  ( stristr($lName, $names[1]) || stristr($fName,$names[1])   )   
			   ) {	*/			   
			
				 $match = 1;	
				 $count++;				
				 $staffID = $row["StaffID"]; 	
				 // echo 'count is' . $count . 'staffID' . $fName;			  
			}
		}	
				
	}//end while	 select from Staff	
	
	
	 if($count == 1){			
		$sql = "SELECT * FROM SSW_STAFF_STATUS WHERE  StatusID = '$statusId'";
		$result = $conn->query($sql);
		  if($result->num_rows == 0){ // no dups insert		
			$sql = "INSERT INTO SSW_STAFF_STATUS (StaffID,Status,Start,Stop, Visible,StatusID,staffCalendarName)  VALUES ('$staffID','$status', '$start','$end', '$visibility','$statusId','$searchName')";			  
			if ($conn->query($sql) === TRUE) {
				echo '1';
			}
			else{echo $conn->error;}
		  }else{ // dups update	
				
			   
			   $sql = "SELECT * FROM SSW_STAFF_STATUS WHERE StatusID = '$statusId'";
			   $result = $conn->query($sql);				 
			   while($row = $result->fetch_assoc()) {
				   $savedStatus = $row["Status"];
				   $savedStart = $row["Start"];
				   $savedEnd = $row["Stop"];
				   $savedName = $row["staffCalendarName"];
				   
				   if(strcmp($savedName,$searchName) != 0){ //name changed on cal
				   		$sqlDel = "DELETE FROM SSW_STAFF_STATUS WHERE StatusID = '$statusId'"; //delete old
 						$resDel = $conn->query($sqlDel);
						$sqlIns = "INSERT INTO SSW_STAFF_STATUS (StaffID,Status,Start,Stop, Visible,StatusID,staffCalendarName)  VALUES ('$staffID','$status', '$start','$end', '$visibility','$statusId','$searchName')";	//insert new
						$resIns = $conn->query($sqlIns);
						$updated = 0;
				   }//end if name changed
				   
				   else{
					   if( (strcmp($status,$savedStatus) == 0) && (strtotime($start) == strtotime($savedStart)) && (strtotime($end) == strtotime($savedEnd)) ){
						   $updated = 0;
						   //echo strtotime($start) . ' ' . strtotime($savedStart);
					   }//end if no updates at all
				   
			       }//end else name not changed
			   }
			   if($updated == 1){
				 $sql = "UPDATE SSW_STAFF_STATUS Set Status ='$status',Start ='$start',Stop ='$end' WHERE StatusID = '$statusId'";			  
				 if ($conn->query($sql) === TRUE) {
					echo '1';
				 }
				 else{echo $conn->error;}
			  }else{echo '1';}
		  } // end numRows > 0
		}//end if count == 1	 and unique
		
	    /**name changed on googleCal but does nt match with DB **/
		if($count == 0){
			$sql = "SELECT * FROM SSW_STAFF_STATUS WHERE  StatusID = '$statusId'";
		    $result = $conn->query($sql);
		    if($result->num_rows > 0){
				$sqlDel = "DELETE FROM SSW_STAFF_STATUS WHERE StatusID = '$statusId'"; //delete old
 				$resDel = $conn->query($sqlDel);
		    }
		} //$count > 1
		else{
			echo '1'; // excess match
		}
    //echo $count;
	
} // end searchString == null

 $conn->close;	
 
 

  ?>
   
			