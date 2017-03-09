<?php
session_start();
$val = $_REQUEST["val"];
$id = $_REQUEST["id"];
include 'connectServer.php';
$conn = serverConnection(); 
if ($conn->connect_error) {		 
	echo 'Connection failed: ' . $conn->connect_error;                
	die();
}

$sql = "UPDATE SSW_STAFF_STATUS SET Visible = '$val' WHERE id= '$id'";	
 if ($conn->query($sql) === TRUE) {	
	   // echo $vis . ' ' . $newStatus;
 }
 else{
	 echo $conn->error;
 }
?>