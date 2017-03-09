<?php
// Start the session
session_start();
include 'connectServer.php';     
$conn = serverConnection(); 		  
if ($conn->connect_error) {		 
  echo 'Connection failed: ' . $conn->connect_error;                
  die();  
} 
$searchStr= $_REQUEST["search"];
$searchStr = "$searchStr";
$result = "";
?>
<div style="height: 40px"></div>
<div id = "EmployeesTable">
    
<?php 
if($searchStr == ""){
	$_SESSION['srch'] = "";	
}

if ($searchStr !== "") {
	$count = 0;  
	$_SESSION['srch'] = $searchStr = strtolower($searchStr);
	$searchItems = explode(" ", $searchStr); /* split compound search items names  eg Matthias. G**/	
	$lenSrch = count($searchItems);
			  
	$len = strlen($searchStr);
	$statusMatch = 0;
	$match = 0;
    $sql = "SELECT *  FROM SSW_GROUPS INNER JOIN SSW_STAFF 
          ON SSW_STAFF.GroupID = SSW_GROUPS.id 
          ORDER BY SSW_GROUPS.Rank,SSW_STAFF.Lastname,SSW_STAFF.Firstname";		  
          $result = $conn->query($sql);		 
          while($row = $result->fetch_assoc()) {										
              $id = $row ["id"];
              $foto = $row["Photo"]; $savedFoto =  "'$foto'";
			  if($foto == ""){$src = "newUser.gif";}else{$src = 'uploads/'.$foto;}			  
              $email = $row["Email"];$savedEmail = "'$email'";
              $title = $row["PrefixTitle"];$savedPrefixTitle = "'$title'";			 
              $fName =$row["Firstname"];$savedFname = "'$fName'";
              $lName = $row["Lastname"];$savedLname = "'$lName'";				  
              $postfixTitle = $row["PostFixTitle"]; $savedPostfixTitle= "'$postfixTitle'";			
              $fnction =  $row["Functn"];$savedFunctn ="'$fnction'";			
              $grpID = $row["GroupID"]; $savedGrpID = "'$grpID'";
              $grpName =$savedGrpName =$row["Name"];
              $rm =$row["Room"];$savedRm = "'$rm'";			
              $staffID = $row["StaffID"];$savedStaffID = "'$staffID'";
              $isVisible = $row["isVisible"];
              $vis = "hidden";					  
              $state = $_SESSION['form'.$id];  
			  
			  /** statuses **/
			  $sql = "SELECT * FROM SSW_STAFF_STATUS WHERE StaffID = '$staffID'";
			  
			  $resultSubTable = $conn->query($sql);	                                          
			  while($row = $resultSubTable->fetch_assoc()) {				  
				  $srchStatus =$row["Status"];
				  for($i = 0; $i < $lenSrch; $i++){
					if ( stristr($srchStatus, $searchItems[$i]) ){
						$statusMatch = 1;
					}
			      }
								  	
			  }//end while statuses
			  
			  for($i = 0; $i < $lenSrch; $i++){
				if ( stristr($fName, $searchItems[$i]) || 
					 stristr($lName, $searchItems[$i]) ||
					 stristr($grpName,$searchItems[$i]) ||
					 stristr($fnction, $searchItems[$i]) ||
					 stristr($email, $searchItems[$i]) ||
					 stristr($rm, $searchItems[$i]) ||
					 stristr($title, $searchItems[$i]) ||
					 stristr($postfixTitle, $searchItems[$i]) ||
					 ($statusMatch == 1)				   
				   ) {
					   $match = 1;
			   }
			   if($match == 1){
					 include 'employeeData.php';
					 $statusMatch = 0; //reset statusMatch
					 $match = 0; //reset match
					 $count++;
			   }
			  }
			   
		  }//end while
		  if($count == 0){
			  echo' <p style= "color:red"> Sorry NO Records Match " '.$searchStr.' "</p>';
			  //echo '<script type="text/javascript"> window.open("EmployeeDirectory.html"); </script>';
		  }
} // end searchString == null

	 $conn->close;		
  ?>
     
</div>
           
			