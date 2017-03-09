<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html lang = "en">
  <head>  
    <meta charset = "UTF-8">		
    <title> </title>    
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
    <iframe name="formFrame" style= "display:none"> </iframe>     
     <table class="table table-hover staffTable col-sm-12" id = "staffTable">        
        <tbody>
          <?php
		      //check number of employee records on db
			  $sql = "SELECT * FROM SSW_EMPLOYEES ";
			  $result = $conn->query($sql); 			  
			  if ($result->num_rows == 0) {			  
				 echo '<script type="text/javascript"> display("No Employee Records"); </script>';    
			  }else{	//closing braces at bottom end			    			
				$sql = "SELECT MAX(id) FROM SSW_EMPLOYEES"; 
				$result = $conn->query($sql); 
				$row = $result->fetch_array();
				$n = $row[0];
				//create n rows				
				//for($i = 1; $i <= $n; $i++){	
				 $i = 1;	   
				  $sql = "SELECT * FROM SSW_EMPLOYEES ORDER BY Lastname";
				  $result = $conn->query($sql);
				   echo $result->num_rows;
					while($row = $result->fetch_assoc()) {
					  $id = $row ["id"];
					  $foto =  $row["Photo"]; 
					  if(isset($_SESSION['email' . $id])){$email = $_SESSION['email' . $id];}else{ $email = $row["Email"];}
					  if(isset($_SESSION['prefixTitle' . $id])){$title = $_SESSION['prefixTitle' . $id];}else{ $title = $row["Title"];}	
					  if(isset($_SESSION['fName' . $id])){$fName = $_SESSION['fName' . $id];}else{ $fName = $row["Firstname"];}
					  if(isset($_SESSION['lName' . $id])){$lName = $_SESSION['lName' . $id];}else{ $lName = $row["Lastname"];}
					  if(isset($_SESSION['postfixTitle' . $id])){$postfixTitle = $_SESSION['postfixTitle' . $id];}else{ $postfixTitle = $row["Titles"];}
					  if(isset($_SESSION['fnction' . $id])){$fnction = $_SESSION['fnction' . $id];}else{ $fnction = $row["Funktn"];}
					  if(isset($_SESSION['grp' . $id])){$grp = $_SESSION['grp' . $id];}else{ $grp = $row["Grp"];}
					  if(isset($_SESSION['rm' . $id])){$rm = $_SESSION['rm' . $id];}else{ $rm = $row["Room_Number"];}					  
					  $statusTable = $row["Status_Table"]; 					  				  
					echo'					 	
					
	<tr>                  					  
	  <form class = "form-horizontal" role="form" name="employeeDir" method="post" enctype="multipart/form-data" action="EmployeeDB.php?id= '.$id.'" target="formFrame">					
	  <td class="col-sm-1">						
		  <img src="thumbnail.gif" class="img-thumbnail" alt="No Photo" width="100" height="100" id = '.$i.' data-toggle="tooltip" title="'.$foto.'"><br><br>
		  <input type = "button" value = "Browse" onClick = hideImage("'.$foto.'")>   
		  <input type="file" name="fileToUpload" id = "'.$foto.'" onchange="imgPreview(this,'.$i.')" value= "'.$foto.'" style="display:none" >
		  <p class = "myId" style= "visibility: hidden"> "'.$id.'" </p>			 						
	  </td>
	   <td class="col-sm-11">
		 <div class="form-group">						                         
			<div class="col-sm-12">
				<input type="email" name="s_email" class="form-control" id = "email'.$id.'" placeholder="someone@hotmail.com" required value = "'.$email.'" onkeyup="storeVal(this,id)">
			</div>
		  </div><br>              
		<div class="form-group">						                         
			<div class="col-sm-12">
				<input type="text" name="s_Title" class="form-control" id = "prefixTitle'.$id.'" placeholder="Prefix Title" value = "'.$title.'" onkeyup="storeVal(this,id)">
			</div>
		 </div> <br>             
		  <div class="form-group">						                            
			<div class="col-sm-6">
				<input type="text" name="s_firstName" class="form-control col-sm-2" id = "fName'.$id.'" placeholder="First Name" required value = "'.$fName.'" onkeyup="storeVal(this,id)">							  
			</div>
			<div class="col-sm-6">
			  <input type="text" name="s_lastName" class="form-control" id = "lName'.$id.'" placeholder="Last Name" required value = "'.$lName.'" onkeyup="storeVal(this,id)">
			</div>
		  </div><br>					  
		  <div class="form-group">						                        
			<div class="col-sm-12">
				<input type="text" name="s_pTitle" class="form-control" id = "postfixTitle'.$id.'" placeholder="Postfix Title" value = "'.$postfixTitle.'" onkeyup="storeVal(this,id)">
			</div>
		 </div><br>   
		  <div class="form-group">						                          
			<div class="col-sm-6">
				<input type="text" name="s_Function" class="form-control" id = "fnction'.$id.'" placeholder="Function" value = "'.$fnction.'" onkeyup="storeVal(this,id)" >
			</div>
			<div class="col-sm-6">          
			  <select class="form-control" id = "grp'.$id.'" name="s_Group" value = "'.$grp.'" onClick="storeVal(this,id)" >  
				<option value = "'.$grp.'">'.$grp.'</option>             
				<option value = "Board of Directors">Board of Directors</option>
				<option value = "Sec">Secetrary</option>
				<option value = "Guest">Guest</option>
				<option value = "Employee">Employee</option>
				<option value = "OracleLabs">Oracle Labs</option>
				<option value = "CDL">Christian Doppler Laboratory</option>
				<option value = "Others">Others</option>
			  </select>                          
			</div>
		  </div><br>					
		  <div class="form-group">                       
			<div class="col-sm-6">
			   <input type="text" name="s_Room" id = "rm'.$id.'" class="form-control s_Room" placeholder="Room Number" required value = "'.$rm.'" onkeyup="storeVal(this,id)" >
			</div>
			<div class="col-sm-6">
			   <a href = "javascript:void(0)" onClick="directions(this)">&#8592;</a>&nbsp; &nbsp; 
			   <a href = "javascript:void(0)" onClick="directions(this)">&#8593;</a>&nbsp; &nbsp;
			   <a href = "javascript:void(0)" onClick="directions(this)">&#8594;</a>&nbsp; &nbsp;
			   <a href = "javascript:void(0)" onClick="directions(this)">&#8595;</a>&nbsp;&nbsp; 
			   <a href = "javascript:void(0)" onClick="directions(this)">&#8598;</a>&nbsp;&nbsp;
			   <a href = "javascript:void(0)" onClick="directions(this)">&#8599;</a>&nbsp; &nbsp;
			   <a href = "javascript:void(0)" onClick="directions(this)">&#8600;</a>&nbsp; &nbsp;
			   <a href = "javascript:void(0)" onClick="directions(this)">&#8601;</a> 
			</div>
		  </div><br>						
		  <div class="form-group">						
			 <div class = "col-sm-12">							
				<table class="table table-hover table-bordered statusTable">        
				  <tbody class="sortable1 connectedSortable" >';
				  
					  /* status table data */
	   
					  //check number of statuses on employee record
					  $sql = "SELECT * FROM $statusTable ";
					  $result = $conn->query($sql); 			  
					  if ($result->num_rows == 0) {			  
						 //include '../sswboard.co.nf/tableNoStatus.php';
							 
					  }else{	//closing braces at bottom end			    			
						$sql = "SELECT MAX(id) FROM $statusTable"; 
						$result = $conn->query($sql); 
						$row = $result->fetch_array();
						$m = $row[0];
						//create m rows				
						for($j = 1; $j <= $m; $j++){														  				 
							$sql = "SELECT * FROM $statusTable WHERE id = '$j'";
							$result = $conn->query($sql);
							 while($row = $result->fetch_assoc()) {
								$s = $row["id"];
								if(isset($_SESSION['status' . $id . $s])){$status = $_SESSION['status' . $id . $s];}else{ $status = $row["Status"];} 
								if(isset($_SESSION['start' . $id . $s])){$start = $_SESSION['start' . $id . $s];}else{ $start = $row["Start"];} 
								if(isset($_SESSION['stop' . $id . $s])){$stop = $_SESSION['stop' . $id . $s];}else{ $stop = $row["Stop"];} 
								if(isset($_SESSION['display' . $id . $s])){$display = $_SESSION['display' . $id . $s];}else{ $display = $row["Visible"];
								if($display === TRUE){$check = "checked";}else{$check = " ";}} 
								//$status = $row["Status"];
								//$start = $row["Start"];
								//$stop = $row["Stop"];
								
							 };echo'							
				  <tr>
					<td class="col-sm-5" ><input type="text" name="s_Status[]" class="form-control" id = "status'.$id.''.$s.'" placeholder="Status" value = "'.$status.'" onkeyup="storeVal(this,id)"></td>
					<td class="col-sm-3">							
						<div class="input-group date" id="datetimepicker6">
							<input type="text" class="form-control" id = "start'.$id.''.$s.'" placeholder="From" name= "startDate[]"  value = "'.$start.'" onkeyup="storeVal(this,id)">
							<span class="input-group-addon"> here
								<a href = "javascript:void(0)"  onClick = "handleAuthClick(event,'.$i.','.$id.')"><span class="glyphicon glyphicon-calendar"></span></a>
							</span>
						</div>							
					</td>                  
					<td class="col-sm-3">
						<div class="input-group date" id="datetimepicker7">
							<input type="text" class="form-control" id = "stop'.$id.''.$s.'" placeholder="To" name= "endDate[]"  value = "'.$stop.'" onkeyup="storeVal(this,id)">
							<span class="input-group-addon">
								<a href = "javascript:void(0)" onClick = "pickerDate()"><span class="glyphicon glyphicon-calendar"></span></a>
							</span>
						</div>
				  </td>
				  <td>
					  <p class="checkbox" style="margin-left:20px;"><input type="checkbox"  id = "display'.$id.''.$s.'" name = "display[]" data-toggle="tooltip" title="Display" "'.$check.'" onClick="storeVal(this,id)"></p>								
				  </td>
				  <td><a href = "javascript:void(0)" onClick = "deleteStatus(this)" data-toggle="tooltip" title="Delete Status"><span class="glyphicon glyphicon-remove-sign"></span></a></td>
				 <td><a href = "javascript:void(0)" onClick = "addStatus(this)" data-toggle="tooltip" title="Add Status"><span class="glyphicon glyphicon-plus-sign"></span></a></td>						
				</tr>';
						};
				echo'
				</tbody>
			  </table>';
			   };echo'
		   </div>				  
		  </div>          
		<script type="text/javascript"> displayFoto("'.$i.'" ,"'.$foto.'"  ) </script>
		<p>
		  <input type="submit" name="createButton" class="btn btn-success saveMe" value="SAVE" onClick = "saveChanges(this)" style = "visibility:hidden">&nbsp;&nbsp;
		  <button type="reset" class="btn btn-info revert" style = "visibility:hidden" onClick=" revert(this)">REVERT</button>
	   </p>
	 </form>
	</td>
   <td class ="col-sm-1">
	  <a href = "javascript:void(0)" onClick = "deleteStaffRecord(this)"  data-toggle="tooltip" title="Delete Staff"><img src="trash.png" class="trash img-thumbnail" alt="Delete Staff" width="40" height="80" style = "visibility:hidden"></a><br><br>						
	</td>				  
   </tr> '; $i++; }?>
	  <?php   ?> <!--closing braces for "for loop" -->
      </tbody>
  </table>
 </div>
<?php }; $conn->close; ?>	            
  </body>  
</html>    

<?php
/*var rowData = "<td><p class='checkbox' style='margin-left:20px;'><input type='checkbox' name = 'display[]' data-toggle='tooltip' data-placement='right' title='Display'></p>			</td>	";
	rowData+= "<td class='col-sm-4'><input type='text' name='s_Status[]' class='form-control' placeholder='Status'</td>";
	//from date
	rowData+= "<td class='col-sm-3'><div class='input-group date' id='datetimepicker6'><input type='text' class='form-control' placeholder='From'  name = 'startDate[]'>";
    rowData+="<span class='input-group-addon'><a href = 'javascript:void(0)' onClick = 'pickerDate()'><span class='glyphicon glyphicon-calendar'></span></a></span></div></td>";
	//end date
	rowData+= "<td class='col-sm-3'><div class='input-group date' id='datetimepicker7'><input type='text' class='form-control' placeholder='To'  name = 'endDate[]'>";
    rowData+="<span class='input-group-addon'><a href = 'javascript:void(0)' onClick = 'pickerDate()'><span class='glyphicon glyphicon-calendar'></span></a></span></div></td>";
	//delete status
	rowData+="<td><a href = 'javascript:void(0)' onClick = 'deleteStatus(this)' data-toggle='tooltip' data-placement='bottom' title='Delete Status'><span class='glyphicon glyphicon-remove-sign'></span></a></td>";
	//addStatus
	rowData+="<td><a href = 'javascript:void(0)' onClick = 'addStatus(this)' data-toggle='tooltip' data-placement='left' title='Add Status'><span class='glyphicon glyphicon-plus-sign'></span></a></td>";
	newRow.innerHTML= rowData;
	
	
	 if ( stristr($searchStr, substr($fName, 0, $len)) || 
			  	   stristr($searchStr, substr($lName, 0, $len)) ||
				   stristr($searchStr, substr($grpName, 0, $len)) ||
				   stristr($searchStr, substr($fnction, 0, $len)) ||
				   stristr($searchStr, substr($email, 0, $len)) ||
				   stristr($searchStr, substr($rm, 0, $len)) ||
				   stristr($title, $searchStr) ||
				   stristr($searchStr, substr($postfixTitle, 0, $len)) ||
				   ($statusMatch == 1)				   
				 ) {
					 include 'employeeData.php';
					 $statusMatch = 0; //reset statusMatch
					 $count++;				   
			  }*/
			  
			  /* onClick event on checkbox  onClick="saveState(this,'.$savedDisplay.',id,'.$id.')"
	?>             