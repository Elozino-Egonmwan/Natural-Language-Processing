<?php
session_start();
//echo 2;	
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    include 'connectServer.php';
    $conn = serverConnection(); 
    if ($conn->connect_error) {		 
	    echo 'Connection failed: ' . $conn->connect_error;                
	    die();
    }
	$employeeStatus = $_SESSION["EmployeeAdded"];
	//echo 'Status '.$employeeStatus;
	//echo 2;		
	if ($employeeStatus == 1){
		//$id= $_REQUEST["id"];
		  $sql = "SELECT MAX(id) FROM SSW_STAFF";		  
		  $result = $conn->query($sql);	
		  $row = $result->fetch_array();
		  $id = $row[0];
		  $sql = "SELECT * FROM SSW_STAFF WHERE id = '$id'";		  
		  $result = $conn->query($sql);		 
		  while($row = $result->fetch_assoc()) {
			  $staffID = $row["StaffID"];
		  }
		 // echo 'staffID'.$staffID;
		//2.Traverse through the HTML 'tableStatus' and insert into the DataBase for Status
		$st = $_POST['s_Status'];	
		$n = count($st);  		  
		//echo $n."Status";
		for ($i = 0; $i < $n; $i++) { 
			$status = $_POST["s_Status"][$i];
			$from = $_POST["startDate"][$i];
			$end = $_POST["endDate"][$i];
			if(isset ($_POST["display"][$i])){
				$visibility = TRUE;	
			}else{$visibility = FALSE;}
			//insert into the Table for Status                    
			$sql = "INSERT INTO SSW_STAFF_STATUS (StaffID,Status,Start,Stop, Visible)
			VALUES ('$staffID','$status', '$from','$end', '$visibility')";
			if ($conn->query($sql) === TRUE) {
			  //successful													
			}
			else{
			  echo 'Error updating Status';
			} // close inserting into table status
		}//close for loop
		echo "Employee Successfully added.Reloading...";
		echo '<script type="text/javascript"> window.open("EmployeeDirectory.html","_top"); </script>';
	}//close if employee added
	$conn->close;
}//close server request
						
?>