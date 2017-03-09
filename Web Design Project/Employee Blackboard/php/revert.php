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
          <?php		
		  		  $i = $_REQUEST["id"];				   
				  $sql = "SELECT * FROM SSW_EMPLOYEES WHERE id = '$i'";
				  $result = $conn->query($sql);				  				 
					while($row = $result->fetch_assoc()) { 
					  $foto =  $row["Photo"]; 	
					  $title =  $row["Title"]; 
					  $fName =  $row["Firstname"]; 
					  $lName =  $row["Lastname"]; 
					  $moreTitles =  $row["Titles"]; 
					  $grp = $row["Grp"];
					  $fnc = $row["Funktn"]; 
					  $rm = $row["Room_Number"];					  
					  $email = $row["Email"];
					  $statusTable = $row["Status_Table"]; 					  
					}; 					 	
					echo'				                   					  
				    <form class = "form-horizontal" role="form" name="formNewEmployee" method="post" enctype="multipart/form-data" action=""><br>
					<td class="col-sm-1">						
						<img src="thumbnail.gif" class="img-thumbnail" alt="No Photo" width="100" height="100" id = '.$i.' data-toggle="tooltip" title="'.$foto.'"><br><br>
						<input type = "button" value = "Browse" onClick = hideImage("'.$foto.'")>   
						<input type="file" name="fileToUpload" id = "'.$foto.'" onchange="imgPreview(this,'.$i.')" value= "'.$foto.'" style="display:none" >			 						
					</td>
					 <td class="col-sm-11">
					   <div class="form-group">						                         
						  <div class="col-sm-12">
							  <input type="email" name="s_email" class="form-control" placeholder="someone@hotmail.com" required value = "'.$email.'">
						  </div>
						</div><br>              
					  <div class="form-group">						                         
						  <div class="col-sm-12">
							  <input type="text" name="s_Title" class="form-control" placeholder="Prefix Title" value = "'.$title.'">
						  </div>
					   </div> <br>             
						<div class="form-group">						                            
						  <div class="col-sm-6">
							  <input type="text" name="s_firstName" class="form-control col-sm-2" placeholder="First Name" required value = "'.$fName.'">							  
						  </div>
						  <div class="col-sm-6">
						  	<input type="text" name="s_lastName" class="form-control" placeholder="Last Name" required value = "'.$lName.'">
						  </div>
						</div><br>					  
						<div class="form-group">						                        
						  <div class="col-sm-12">
							  <input type="text" name="s_pTitle" class="form-control" placeholder="Postfix Title" value = "'.$moreTitles.'">
						  </div>
					   </div><br>   
						<div class="form-group">						                          
						  <div class="col-sm-6">
							  <input type="text" name="s_Function" class="form-control" placeholder="Function" value = "'.$fnc.'" >
						  </div>
						  <div class="col-sm-6">          
							<select class="form-control" id="group" name="s_Group" value = "'.$grp.'" >  
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
							 <input type="text" name="s_Room" id = "room" class="form-control" placeholder="Room Number" required value = "'.$rm.'" >
						  </div>
						  <div class="col-sm-6">
							 <a href = "javascript:void(0)" onClick="directions(this,'.$i.')">&#8592;</a>&nbsp; &nbsp; 
							 <a href = "javascript:void(0)" onClick="directions(this,'.$i.')">&#8593;</a>&nbsp; &nbsp;
							 <a href = "javascript:void(0)" onClick="directions(this,'.$i.')">&#8594;</a>&nbsp; &nbsp;
							 <a href = "javascript:void(0)" onClick="directions(this,'.$i.')">&#8595;</a>&nbsp;&nbsp; 
							 <a href = "javascript:void(0)" onClick="directions(this,'.$i.')">&#8598;</a>&nbsp;&nbsp;
							 <a href = "javascript:void(0)" onClick="directions(this,'.$i.')">&#8599;</a>&nbsp; &nbsp;
							 <a href = "javascript:void(0)" onClick="directions(this,'.$i.')">&#8600;</a>&nbsp; &nbsp;
							 <a href = "javascript:void(0)" onClick="directions(this,'.$i.')">&#8601;</a> 
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
									   //include 'file:///C|/Users/Gebruiker/Documents/sswboard.co.nf/tableNoStatus.php';
									       
									}else{	//closing braces at bottom end			    			
									  $sql = "SELECT MAX(id) FROM $statusTable"; 
									  $result = $conn->query($sql); 
									  $row = $result->fetch_array();
									  $m = $row[0];
									  //create n rows				
									  for($j = 1; $j <= $m; $j++){														  				 
										  $sql = "SELECT * FROM $statusTable WHERE id = '$j'";
										  $result = $conn->query($sql);
										   while($row = $result->fetch_assoc()) { 
											  $status = $row["Status"];
											  $start = $row["Start"];
											  $stop = $row["Stop"];
											  $display = $row["Visible"];
											  if($display === TRUE){
												  $check = "checked";
											  }else{$check = " ";}
										   };echo'							
								<tr>
								  <td class="col-sm-5" ><input type="text" name="s_Status[]" class="form-control" placeholder="Status" value = "'.$status.'" ></td>
								  <td class="col-sm-3">							
									  <div class="input-group date" id="datetimepicker6">
										  <input type="text" class="form-control" placeholder="From" name= "startDate[]"  value = "'.$start.'">
										  <span class="input-group-addon">
											  <a href = "javascript:void(0)" onClick = "pickerDate()"><span class="glyphicon glyphicon-calendar"></span></a>
										  </span>
									  </div>							
								  </td>                  
								  <td class="col-sm-3">
									  <div class="input-group date" id="datetimepicker7">
										  <input type="text" class="form-control" placeholder="To" name= "endDate[]"  value = "'.$stop.'">
										  <span class="input-group-addon">
											  <a href = "javascript:void(0)" onClick = "pickerDate()"><span class="glyphicon glyphicon-calendar"></span></a>
										  </span>
									  </div>
                                </td>
                                <td>
                                    <p class="checkbox" style="margin-left:20px;"><input type="checkbox" name = "display[]" data-toggle="tooltip" title="Display" "'.$check.'"></p>								
                                </td>
                                <td><a href = "javascript:void(0)" onClick = "deleteStatus(this,'.$i.')" data-toggle="tooltip" title="Delete Status"><span class="glyphicon glyphicon-remove-sign"></span></a></td>
							   <td><a href = "javascript:void(0)" onClick = "addStatus(this,'.$i.')" data-toggle="tooltip" title="Add Status"><span class="glyphicon glyphicon-plus-sign"></span></a></td>						
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
					  	<input type="submit" name="createButton" class="btn btn-success saveMe" value="SAVE"  style = "visibility:hidden">&nbsp;&nbsp;
						<button type="button" class="btn btn-info revert" style = "visibility:hidden">REVERT</button>
					 </p>
                   </form>
                  </td>
				 <td class ="col-sm-1">
					<a href = "javascript:void(0)" onClick = "deleteStaffRecord(this,'.$i.')"  data-toggle="tooltip" title="Delete Staff"><img src="trash.png" class=" trash img-thumbnail" alt="Delete Staff" width="40" height="80" style = "visibility:hidden"></a><br><br>						
				  </td>				  
                  '; ?>
                <?php ?> <!--closing braces for "for loop" -->                
        <?php $conn->close; ?>	     */       
  </body>  
</html>                