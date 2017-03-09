<?php
  include 'connectServer.php';
  $conn = serverConnection(); 		  
  if ($conn->connect_error) {		 
	  echo 'Connection failed: ' . $conn->connect_error;                
	  die();
  }
  $report = "SCRIPT REPORT" . "<br>";
  
  /** Table for Staff **/
 $sql = "CREATE TABLE IF NOT EXISTS SSW_STAFF (
	    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		Email VARCHAR(30),
		PrefixTitle VARCHAR(30),		 		  
		Firstname VARCHAR(50) NOT NULL,
		Lastname VARCHAR(50) NOT NULL,
		PostFixTitle VARCHAR(30),
		Photo TEXT,
		Functn VARCHAR(30),
		GroupID INT(6),
		Room NVARCHAR(10) NOT NULL,	
		StaffID VARCHAR (30),	
		isVisible BOOLEAN,				         
		reg_date TIMESTAMP
	  )";                      
	  if ($conn->query($sql) === TRUE) {
		   $report = $report . "SSW Staff table created" . "<br>";
	  } else {
		   $report = $report . "Error Creating SSW Staff table" . $conn->error . "<br>";
	  }    
  
$sql = "CREATE TABLE IF NOT EXISTS SSW_STAFF_STATUS (
	    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		StaffID VARCHAR (30),
		Status TEXT,
		StatusID TEXT,
		Start TIMESTAMP, 
		Stop TIMESTAMP,
		Visible BOOLEAN	
	  )";                      
	  if ($conn->query($sql) === TRUE) {
		   $report = $report . "SSW Staff Status table created" . "<br>";
	  } else {
		   $report = $report . "Error Creating SSW Staff Status table" . $conn->error . "<br>";
	  }  

$sql = "CREATE TABLE IF NOT EXISTS SSW_GROUPS (
	    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		Rank INT(6) UNIQUE KEY,
		Name TEXT		
	  )";                      
	  if ($conn->query($sql) === TRUE) {
		   $report = $report . "SSW Staff Groups table created" . "<br>";
	  } else {
		   $report = $report . "Error Creating SSW Staff Group table" . $conn->error . "<br>";
	  }

/*$names = array("Board of Directors","Secetary","Guest","Employee","Oracle Labs","Christian Doppler Laboratory","Others");
$rank = array(1,2,3,4,5,6,7);
for($i= 0; $i < 7; $i++){
	$sql = "INSERT INTO SSW_GROUPS (Rank,Name)
				VALUES ('$rank[$i]','$names[$i]')";	
	$conn->query($sql);
}*/

/*$sql = "DROP TABLE SSW_STAFF_STATUS ";                      
	  if ($conn->query($sql) === TRUE) {
		   $report = $report . "SSW Staff Status table dropped" . "<br>";
	  } else {
		   $report = $report . "Error Altering Staff Status" . $conn->error . "<br>";
	  }*/


/*$sql = "ALTER TABLE SSW_STAFF ALTER COLUMN PrefixTitle TEXT ";                      
	  if ($conn->query($sql) === TRUE) {
		   $report = $report . "SSW Staff table altered" . "<br>";
	  } else {
		   $report = $report . "Error Altering Staff Table" . $conn->error . "<br>";
	  }*/


echo $report;
?>