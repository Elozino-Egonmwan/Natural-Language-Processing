<?php
// Start the session
session_start();
include 'connectServer.php';     
$conn = serverConnection(); 		  
if ($conn->connect_error) {		 
  echo 'Connection failed: ' . $conn->connect_error;                
  die();
  //include 'dynamicNewStaff.php';
} 
$conn->close;
?>
<div style="height: 40px"></div>
<div id="authorize-div" style="display: none"></div>
<!--<pre id="output"></pre>-->
<div id = "alert"></div>
<div id = "EmployeesTable">  
    <button onClick = "handleAuthClick(event)" id = "googleCal" style="display:none">Sync</button>		    
	<?php include 'dynamicNewStaff.php'; 
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
			  $srch = $_SESSION["srchVal"];
              //echo $s;
              if($state == "changed"){					 
                  $vis = "visible";
                  if(isset($_SESSION['email' . $id])){$email = $_SESSION['email' . $id];}
                  if(isset($_SESSION['fName' . $id])){$fName = $_SESSION['fName' . $id];}
                  if(isset($_SESSION['lName' . $id])){$lName = $_SESSION['lName' . $id];}
                  if(isset($_SESSION['lName' . $id])){$lName = $_SESSION['lName' . $id]; }
                  if(isset($_SESSION['postfixTitle' . $id])){$postfixTitle = $_SESSION['postfixTitle' . $id];}
                  if(isset($_SESSION['fnction' . $id])){$fnction = $_SESSION['fnction' . $id];}
                  //if(isset($_SESSION['grpID' . $id])){$grpID = $_SESSION['grpID' . $id];}	
                  if(isset($_SESSION['grpID' . $id])){ 
                    $grpID = $_SESSION['grpID' . $id];
                    $sql = "SELECT *  FROM SSW_GROUPS WHERE Rank ='$grpID'"; 
                     $r = $conn->query($sql);	
                     while($row = $r->fetch_assoc()) {
                       $grpName = $row['Name'];
                      }
                   }
                  if(isset($_SESSION['rm' . $id])){$rm = $_SESSION['rm' . $id]; }
              }
			  include 'employeeData.php';
		  }//end while
		?>		    
</div>
           
			