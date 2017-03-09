<?php
include 'connectServer.php';     
$conn = serverConnection(); 		  
if ($conn->connect_error) {		 
	echo 'Connection failed: ' . $conn->connect_error;                
	die();
} 	
$id= $_REQUEST["id"];
$v = $_REQUEST["v"];
$sql = "UPDATE SSW_STAFF SET isVisible ='$v' WHERE id= '$id'";                      
  if ($conn->query($sql) === TRUE) {
	   
  } else {
	   $conn->error ;
  }
$conn->close;
?>