<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html>
  <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <title></title>      
  </head>
  <body>
    <?php		  
      include 'connectServer.php';
      $conn = serverConnection(); 		  
      if ($conn->connect_error) {		 
          echo 'Connection failed: ' . $conn->connect_error;                
          die();
      }      
     ?> 
    <div class = "table-responsive">     
     <table class="table table-hover ">        
        <tbody>
          <?php
		      //check number of employee records on db			 
					  			
			  $sql = "SELECT * 
			  FROM SSW_GROUPS INNER JOIN SSW_STAFF 
			  ON SSW_STAFF.GroupID = SSW_GROUPS.Rank 
			  ORDER BY SSW_GROUPS.Rank,SSW_STAFF.Lastname,SSW_STAFF.Firstname";
			  $res = $conn->query($sql); 			  
			  if ($res->num_rows == 0) {			  
				 echo '<script type="text/javascript"> display("No Employee Records"); </script>';    
			  }else{	//closing braces at bottom end					 		  				 
				  while($row = $res->fetch_assoc()) { 
					  $foto =  $row["Photo"]; 	
					  $title =  $row["PrefixTitle"]; 
					  $fName =  $row["Firstname"]; 
					  $lName =  $row["Lastname"]; 
					  $postfixTitle =  $row["PostfixTitle"]; 
					  $grpID = $row["GroupID"];
					  $grpName = $row["Name"];
					  $fnc = $row["Functn"]; 
					  $rm = $row["Room"];
					  $staffID = $row["StaffID"];
					  $id = $row["id"];					  
					/** obtain most current status **/
					$sql = "SELECT * FROM SSW_STAFF_STATUS WHERE StaffID= '$staffID' ORDER BY Stop ASC LIMIT 1";
				  	$result = $conn->query($sql);				  				 
					while($row = $result->fetch_assoc()) {
						$status = $row["Status"] ;					
				 echo'
				  <tr>
				    <td class ="col-sm-2"><img src="thumbnail.gif" class="img-thumbnail" alt="No Photo" width="100" height="100" id = '.$id.'></td>							
					<td><span style= "font-weight: bold"> Name: </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.$title.' ' .' '.$fName.' ' .' '.$lName.' ' .' '.$postfixTitle.'  
						<br><span style= "font-weight: bold"> Group: </span>&nbsp;&nbsp;&nbsp;&nbsp; '.$grpName.' ';
						if($fnc <> ""){
						echo'
						<br><span style= "font-weight: bold"> Function: </span>&nbsp;'.$fnc.' ';
						}echo'
						<br><span style= "font-weight: bold">Room: </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.$rm.'   ';
						if( $status!== ""){
						 echo'<br><span style= "font-weight: bold">Status: </span>&nbsp;&nbsp;&nbsp;&nbsp; '.$status.'  ';
						}echo'
                    </td>
					<script type="text/javascript"> displayFoto("'.$id.'" ,"'.$foto.'"  ) </script>
				  </tr>';
				  }//end while				  
                   }; ?> <!--closing braces for "for loop" -->
		  </tbody>
     </table>
     </div>
    <?php  $conn->close; };?>
  </body>
</html> 