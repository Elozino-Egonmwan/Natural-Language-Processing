<?php
// Start the session
session_start();
$id = 0;
$defaultStatusId = -1;
?>
<form class="form-horizontal" role="form" name="employeeDir" method="post" enctype="multipart/form-data" action="EmployeeDB.php" target="formFrame" id="form0" style="display:none">  
	<div class = "table-responsive"> <?php echo'     
		<table class="table table-hover staffTable col-sm-12" id = "staffTable'.$id.'"> '; $imgSrc = "'fotoSrc$id'";; $fotoID = "'foto$id'";?>      
			<tbody> 
				<tr> 
					<td><!--image --><?php echo'			
						<img src="newUser.gif" class="img-thumbnail" alt="No Photo" width="100" height="100" id = "fotoSrc'.$id.'" data-toggle="tooltip" data-placement="right" title="Upload Photo"><br><br>                        
						<input type = "button" value = "Upload" onClick = "hideImage('.$fotoID.')"> 
						<input type="file" name="fileToUpload" id = "foto'.$id.'" onchange="imgPreview(this,'.$imgSrc.',null,'.$id.',id)" style="display:none" >
						<input type="hidden" id = "foto'.$id.'Checker">' ;?>												  
					</td>							
					<td><!-- main form details: Email,PrefixTitle,FirstNme,Last name, Postfix,Function,Grp, rm number, rm directions -->								
						<div class="form-group"><!-- email -->				 
							<div class="col-sm-12"><?php echo'
								<input type="email" name="s_email" class="form-control" id = "email'.$id.'" placeholder="someone@hotmail.com" required onkeyup="saveState(this,null,id,'.$id.')"><input type="hidden" id = "email'.$id.'Checker">';?>
							</div>
						</div>  
						<div class="form-group"><!-- prefix title -->							                         
							<div class="col-sm-12"><?php echo '
								<input type="text" name="s_Title" class="form-control" id = "prefixTitle'.$id.'" placeholder="Prefix Title" value = "" onkeyup="saveState(this,null,id,'.$id.')"><input type="hidden" id = "prefixTitle'.$id.'Checker">'; ?>	
							</div>
						</div>             
						<div class="form-group">						                            
							<div class="col-sm-6"><!-- First name --><?php echo'
								<input type="text" name="s_firstName" class="form-control col-sm-2" id = "fName'.$id.'" placeholder="First Name" required onkeyup="saveState(this,null,id,'.$id.')"><input type="hidden" id = "fName'.$id.'Checker">';?>							  
							</div>                            
							<div class="col-sm-6"><!-- Last name --><?php echo'
								<input type="text" name="s_lastName" class="form-control" id = "lName'.$id.'" placeholder="Last Name" required onkeyup="saveState(this,null,id,'.$id.')">						<input type="hidden" id = "lName'.$id.'Checker">';?>	
							</div>
						</div>					  
						<div class="form-group"><!-- postfix title -->						                        
							<div class="col-sm-12"><?php echo '
								<input type="text" name="s_pTitle" class="form-control" id = "postfixTitle'.$id.'" placeholder="Postfix Title" onkeyup="saveState(this,null,id,'.$id.')">	<input type="hidden" id = "postfixTitle'.$id.'Checker">'; ?>
							</div>
						</div>   
						<div class="form-group">					
							<div class="col-sm-6"><!-- Function --><?php echo '
                            	<input type="text" name="s_Function" class="form-control" id = "fnction'.$id.'" placeholder="Function" onkeyup="saveState(this,null,id,'.$id.')"><input type="hidden" id = "fnction'.$id.'Checker">'; ?>
							</div>						
							<div class="col-sm-6"><!-- Group -->  <?php echo '        
								<select class="form-control" id = "grpID'.$id.'" name="s_Group" onClick="saveState(this,null,id,'.$id.')">';
									$sql = "SELECT * FROM SSW_GROUPS ORDER BY Rank ASC";
									$resultGrp = $conn->query($sql); 
									while($row = $resultGrp->fetch_assoc()) {	
										$staffGrpName = $row["Name"];
										$staffGrpID = $row["id"];
										echo'
											<option value = '.$staffGrpID.'>'.$staffGrpName.'</option>';
									}echo'
								</select><input type="hidden" id = "grpID'.$id.'Checker">';?>	   				  
							</div>					
						</div>
						<div class="form-group">				  
							<div class="col-sm-6"><!--room number --><?php echo'
                            	<input type="text" name="s_Room" id = "rm'.$id.'"  class="form-control s_Room" placeholder="Room Number" required onkeyup="saveState(this,null,id,'.$id.')"><input type="hidden" id = "rm'.$id.'Checker">'; ?>
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
						<!-- status-->
                       
							<div><!-- control buttons-->  
								<p><?php echo'
									<input type="submit" name="createButton" class="btn btn-success saveMe" id = "saveMe'.$id.'"  value="SAVE"  style= "visibility:hidden" onClick = "saveChanges('.$id.')">&nbsp;&nbsp;
									<button type="reset" class="btn btn-danger revert" id = "revert'.$id.'"  onClick=" revert(this,'.$id.')" style= "visibility: hidden">CANCEL</button>';?>
								</p>	
							</div>	  
					</td><!-- main form details: Email,PrefixTitle,FirstNme,Last name, Postfix,Function,Grp, rm number, rm directions,status-->		
				</tr>
			</tbody>
		</table>
	</div> <!--close table responsive-->	
</form>