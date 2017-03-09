<?php
// Start the session
session_start();
include 'connectServer.php';     
$conn = serverConnection(); 		  
if ($conn->connect_error) {		 
  echo 'Connection failed: ' . $conn->connect_error;                
  die();  
}
$arrayIds = json_decode($_REQUEST["statuses"]);
$length = count($arrayIds);
$sql = "SELECT * FROM SSW_STAFF_STATUS";
$result = $conn->query($sql);	
while($row = $result->fetch_assoc()) {
	$isValid = 0; // invalid
	$statId = $row["StatusID"];
	for($i = 0; $i < $length; $i++){		
		if($statId == $arrayIds[$i]){
			$isValid = 1;
			//echo '0';
		}
	}//end for loop
	if($isValid == 0){
		$sql = "DELETE FROM SSW_STAFF_STATUS WHERE StatusID = '$statId'";
		 if ($conn->query($sql) === TRUE) {
			echo '1';
		  }
		  else{echo $conn->error;}
	}///end invalid id
	else{echo '1';} //valid id, no delete done
}// end while
$conn->close;		
  ?>
   
			