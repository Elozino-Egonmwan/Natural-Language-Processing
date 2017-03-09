<?php
session_start();
include 'connectServer.php';     
$conn = serverConnection(); 		  
if ($conn->connect_error) {		 
	echo 'Connection failed: ' . $conn->connect_error;                
	die();
} 
$id= $_REQUEST["id"];
$sql = "SELECT * FROM SSW_STAFF WHERE id = '$id'";
		$result= $conn->query($sql); 			  
		if ($result->num_rows == 0) {						 
		  echo 'No record found';
		}else{	
		   while($row = $result->fetch_assoc()) {
			  $staffID = $row["StaffID"];		
			  $staffName = $row["Lastname"];	   
		   }
		    $sql = "DELETE FROM SSW_STAFF WHERE id = '$id'";
			$result= $conn->query($sql); 			  
			if ($conn->query($sql) === TRUE) {
				$sql = "DELETE FROM SSW_STAFF_STATUS WHERE StaffID = '$staffID'";
				$result= $conn->query($sql); 
				if ($conn->query($sql) === TRUE) {
					echo $staffName.' Successfully Deleted';
				}
			}		   
		}
$conn->close;
?>