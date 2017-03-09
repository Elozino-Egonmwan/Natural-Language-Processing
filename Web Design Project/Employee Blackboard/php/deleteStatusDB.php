<?php
session_start();
include 'connectServer.php';     
$conn = serverConnection(); 		  
if ($conn->connect_error) {		 
	echo 'Connection failed: ' . $conn->connect_error;                
	die();
} 
$id= $_REQUEST["id"];
$sql = "DELETE FROM SSW_STAFF_STATUS WHERE id = '$id'";
$result= $conn->query($sql); 
if ($conn->query($sql) === TRUE) {
	echo ' Successfully Deleted';
} 		
$conn->close;
?>