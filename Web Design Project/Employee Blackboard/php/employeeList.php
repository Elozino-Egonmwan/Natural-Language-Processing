<?php echo'
<form class="form-horizontal" role="form" name="employeeDir" method="post" enctype="multipart/form-data" action="EmployeeDB.php" target="formFrame" id="form'.$id.'"> ';?> 
	<div class = "table-responsive"> <?php echo'     
		<table class="table table-hover staffTable table-condensed col-sm-12" id = "staffTable'.$id.'">  ';?>      
			<tbody> 
				<tr> 
					<td> <!--image -->
                    	<?php echo'			
						<img src="newUser.gif" class="img-thumbnail" alt="No Photo" width="100" height="100" id = "fotoSrc'.$id.'" data-toggle="tooltip" data-placement="right" title="fotoSrc'.$id.'"><br><br>
						<input type = "button" value = "Upload" onClick = "hideImage('.$foto.''.$id.')"> 
						<input type="file" name="fileToUpload"  id = "'.$foto.''.$id.'" onchange="imgPreview(this,'.$foto.''.$id.')" style="display:none" >'; ?>						  
					</td>							
					<td><!-- main form details: Email,PrefixTitle,FirstNme,Last name, Postfix,Function,Grp, rm number, rm directions -->								
						<div class="form-group"><!-- email -->				 
							<div class="col-sm-12"><?php echo'
								<input type="email" name="s_email" class="form-control" id = "email'.$id.'" placeholder="someone@hotmail.com" value = "'.$email.'" required onkeyup= "saveState(this,'.$savedEmail.',id,'.$id.')"> <input type="hidden" id = "email'.$id.'Checker">';?>
							</div>
						</div>  
						<div class="form-group"><!-- prefix title -->							                         
							<div class="col-sm-12"><?php echo '
								<input type="text" name="s_Title" class="form-control" id = "prefixTitle'.$id.'" placeholder="Prefix Title" value ="'.$title.'" onkeyup="saveState(this,'.$savedPrefixTitle.',id,'.$id.')"><input type="hidden" id = "prefixTitle'.$id.'Checker">'; ?>	
							</div>
						</div>             
						<div class="form-group">						                            
							<div class="col-sm-6"><!-- First name --><?php echo'
								<input type="text" name="s_firstName" class="form-control col-sm-2" value = "'.$fName.'" id = "fName'.$id.'" placeholder="First Name" required onkeyup="saveState(this,'.$savedFname.',id,'.$id.')"><input type="hidden" id = "fName'.$id.'Checker">';?>							  
							</div>                            
							<div class="col-sm-6"><!-- Last name --><?php echo'
								<input type="text" name="s_lastName" class="form-control" value = "'.$lName.'" id = "lName'.$id.'" placeholder="Last Name" required onkeyup="saveState(this,'.$savedLname.',id,'.$id.')"><input type="hidden" id = "lName'.$id.'Checker">';?>	
							</div>
						</div>					  
						<div class="form-group"><!-- postfix title -->						                        
							<div class="col-sm-12"><?php echo '
								<input type="text" name="s_pTitle" class="form-control" value = "'.$postfixTitle.'" id = "postfixTitle'.$id.'" placeholder="Postfix Title" onkeyup="saveState(this,'.$savedPostfixTitle.',id,'.$id.')"><input type="hidden" id = "postfixTitle'.$id.'Checker">'; ?>
							</div>
						</div>   
						<div class="form-group">					
							<div class="col-sm-6"><!-- Function --><?php echo '
                            	<input type="text" name="s_Function" class="form-control" value = "'.$fnction.'" id = "fnction'.$id.'" placeholder="Function" onkeyup="saveState(this,'.$savedFunctn.',id,'.$id.')"><input type="hidden" id = "fnction'.$id.'Checker">'; ?>
							</div>						
							<div class="col-sm-6"><!-- Group -->  <?php echo '        
								<select class="form-control" id = "grpID'.$id.'" name="s_Group" onClick="saveState(this,'.$savedGrpID.',id,'.$id.')">';
									$sql = "SELECT * FROM SSW_GROUPS ORDER BY Rank ASC";
									$resultGrp = $conn->query($sql); 
									while($row = $resultGrp->fetch_assoc()) {	
										$staffGrpName = $row["Name"];
										$staffGrpID = $row["Rank"];
										if($staffGrpName != $grpName){
											echo' <option value = '.$staffGrpID.'>'.$staffGrpName.'</option>';
										}else{
											echo' <option value = '.$staffGrpID.' selected="selected">'.$staffGrpName.'</option>';
										}
									}echo'		
								</select><input type="hidden" id = "grpID'.$id.'Checker">';?>	   				  
							</div>					
						</div>
						<div class="form-group">				  
							<div class="col-sm-6"><!--room number --><?php echo'
                            	<input type="text" name="s_Room"  value = "'.$rm.'" id = "rm'.$id.'"  class="form-control s_Room" placeholder="Room Number" required onkeyup="saveState(this,'.$savedRm.',id,'.$id.')"><input type="hidden" id = "rm'.$id.'Checker">'; ?>
                            </div>
							<div class="col-sm-6"><!--room directions --><?php echo'				    
                                <a href = "javascript:void(0)" onClick="directions(this,null,'.$id.')">&#8592;</a>&nbsp; &nbsp; 
                                <a href = "javascript:void(0)" onClick="directions(this,null,'.$id.')">&#8593;</a>&nbsp; &nbsp;
                                <a href = "javascript:void(0)" onClick="directions(this,null,'.$id.')">&#8594;</a>&nbsp; &nbsp;
                                <a href = "javascript:void(0)" onClick="directions(this,null,'.$id.')">&#8595;</a>&nbsp;&nbsp; 
                                <a href = "javascript:void(0)" onClick="directions(this,null,'.$id.')">&#8598;</a>&nbsp;&nbsp;
                                <a href = "javascript:void(0)" onClick="directions(this,null,'.$id.')">&#8599;</a>&nbsp; &nbsp;
                                <a href = "javascript:void(0)" onClick="directions(this,null,'.$id.')">&#8600;</a>&nbsp; &nbsp;
                                <a href = "javascript:void(0)" onClick="directions(this,null,'.$id.')">&#8601;</a> ';?>
							</div>
						</div>		
						<div class="form-group">
							<div class = "col-sm-12"> <!-- statuses-->				  
								<table class="table table-hover table-bordered statusTable">        
									<tbody class="sortable1 connectedSortable">
                                    	<?php
                                    	 /* status table data */	   
                                        $sql = "SELECT * FROM SSW_STAFF_STATUS WHERE StaffID = '$staffID'";
                                        $resultSubTable = $conn->query($sql);
										$i = 0; 			  
                                        if ($resultSubTable->num_rows == 0) {						 
                                          echo '<tr>';
                                          include 'dynamicNewStatus.php?id='.$id .'&i='.$i ;
                                          echo'</tr>'; $i++;
                                        }else{                                           
                                           while($row = $resultSubTable->fetch_assoc()) {
                                              $s = $row["id"];
                                              $status =$row["Status"];$savedStatus= "'$status'" ;
                                              $start=$row["Start"]; $savedStart = "'$start'";
                                              $stop = $row["Stop"];$savedStop="'$stop'";
                                              $display = $row["Visible"];$savedDisplay ="'$display'";
                                              if($display == 1){$chkd = "checked";}else{$chkd = "";} ;?>                                          			
											<tr> 
												<td><!--display--><?php echo'
													<p class="checkbox" style="margin-left:20px"><input type="checkbox" value="" id = "display'.$i.''.$id.'"  name = "display[]" data-toggle="tooltip" data-placement="right" title="Display" onClick="saveState(this,'.$savedDisplay.',id,'.$id.')" '.$chkd.'><input type="hidden" id = "display'.$i.''.$id.'Checker"></p>'; ?>							
												</td>
												<td class="col-sm-4"><!-- status--> <?php echo'
                                                	<input type="text" name="s_Status[]" id = "status'.$i.''.$id.'" value = "'.$status.'" class="form-control" placeholder="Status" onkeyup="saveState(this,'.$savedStatus.',id,'.$id.')"><input type="hidden"  id = "status'.$i.''.$id.'Checker">';?>
                                                </td>
												<td class="col-sm-3"><!-- start date--><?php echo'							
													<div class="input-group date" id="datetimepicker'.$i.''.$id.'">
    													<input type="text" class="form-control" id = "start'.$i.''.$id.'" value = "'.$start.'" placeholder="From" name= "startDate[]"  onkeyup="saveState(this,'.$savedStart.',id,'.$id.')"><input type="hidden" id = "start'.$i.''.$id.'Checker"> '; ?>
    													<span class="input-group-addon">
                                                        	<a href = "javascript:void(0)" onClick = "pickerDate()"><span class="glyphicon glyphicon-calendar" ></span></a>
                                                        </span>
													</div> 							
												</td>				
												<td class="col-sm-3"><!-- end date--><?php echo'
													<div class="input-group date" id="datetimepickers'.$i.''.$id.'">
    													<input type="text" class="form-control" id = "stop'.$i.''.$id.'"  value = "'.$stop.'" placeholder="To" name= "endDate[]" onkeyup="saveState(this,'.$savedStop.',id,'.$id.')"><input type="hidden" id = "stop'.$i.''.$id.'Checker">';?>
    													<span class="input-group-addon">
        													<a href = "javascript:void(0)" onClick = "pickerDate()"><span class="glyphicon glyphicon-calendar"></span></a>
   														</span>
													</div>
												</td>				
												<td> <!-- delete status--> <?php echo'
                                                	<a href = "javascript:void(0)" onClick = "deleteStatus(this,'.$id.')" data-toggle="tooltip" data-placement="bottom" title="Delete Status">
														<span class="glyphicon glyphicon-remove-sign"></span>
													</a>';?>
												</td>
												<td><!-- add status--><?php echo'
                                                	<a href = "javascript:void(0)" onClick = "addStatus(this,'.$id.')" data-toggle="tooltip" data-placement="left" title="Add Status">
                                                		<span class="glyphicon glyphicon-plus-sign"></span>
                                                	</a>';?>
                                                </td>				
											</tr><?php $i++; }; //clos while  ?>
										</tbody>
									</table> <!--end sub table status-->
                                   <?php }; //clse else ?>
								</div>				  
							</div><br><!--end statuses -->
							<div><!-- control buttons-->  
								<p><?php echo'
									<input type="submit" name="createButton" class="btn btn-success saveMe" id = "saveMe'.$id.'" value="SAVE" style = "visibility:'.$vis.'"  onClick = "saveChanges('.$id.')">&nbsp;&nbsp;
      								<button type="reset" class="btn btn-info revert" style = "visibility:'.$vis.'" id = "revert'.$id.'"  onClick=" revert(this,'.$id.')">REVERT</button>';?>
								</p>	
							</div>	  
					</td><!-- main form details: Email,PrefixTitle,FirstNme,Last name, Postfix,Function,Grp, rm number, rm directions,status-->
                    <td class ="col-sm-1"><!--hide n show--><?php
                    	if($isVisible == TRUE){ echo'
    						<button class="btn btn-default btn-sm" id = "hide'.$id.'" onClick = "toggleDisplay(this,'.$id.')" >HIDE</button><br><br><br><br><br><br><br><br><br><br><br>	';
    					}else{ echo'
    						<button class="btn btn-info btn-sm" id = "show'.$id.'" onClick = "toggleDisplay(this,'.$id.')" >SHOW</button><br><br><br><br><br><br><br><br><br><br><br>
    						<script type="text/javascript"> blurForm("'.$id.'") </script>	';
    					}
    					echo'	
    					<a href = "javascript:void(0)" onClick = "deleteStaffRecord(this,'.$id.')"  data-toggle="tooltip" title="Delete Staff">
							<img src="trash.png" class="trash  img-thumbnail" id = "trash'.$id.'"  alt="Delete Staff" width="40" height="80">
						</a>';?>	
                    </td>		
				</tr>
			</tbody>
		</table>
	</div> <!--close table responsive-->	
</form>