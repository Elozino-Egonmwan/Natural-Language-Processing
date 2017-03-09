<!-- calendar removed -->
<td class="col-sm-3"><!-- start date--><?php echo'							
													<div class="input-group date" id="datetimepicker'.$i.''.$id.'">
    													<input type="text" class="form-control" id = "start'.$i.''.$id.'" value = "'.$start.'" placeholder="From" name= "startDate[]"  onkeyup="saveState(this,'.$savedStart.',id,'.$id.')"><input type="hidden" id = "start'.$i.''.$id.'Checker"> '; ?>
    													<span class="input-group-addon"><?php echo'
                                                        	<a href = "javascript:void(0)"><span class="glyphicon glyphicon-calendar" ></span></a>';?>
                                                        </span>
													</div> 							
												</td>				
												<td class="col-sm-3"><!-- end date--><?php echo'
													<div class="input-group date" id="datetimepickers'.$i.''.$id.'">
    													<input type="text" class="form-control" id = "stop'.$i.''.$id.'"  value = "'.$stop.'" placeholder="To" name= "endDate[]" onkeyup="saveState(this,'.$savedStop.',id,'.$id.')"><input type="hidden" id = "stop'.$i.''.$id.'Checker">';?>
    													<span class="input-group-addon"><?php echo '
        													<a href = "javascript:void(0)"><span class="glyphicon glyphicon-calendar"></span></a>';?>
   														</span>
													</div>
												</td>		
                                                
<!-- removed delete and add status -->
<td> <!-- delete status--> <?php echo'
                                                	<a href = "javascript:void(0)" onClick = "deleteStatus(this,'.$id.','.$s.')" data-toggle="tooltip" data-placement="bottom" title="Delete Status">
														<span class="glyphicon glyphicon-remove-sign"></span>
													</a>';?>
												</td>
												<td><!-- add status--><?php echo'
                                                	<a href = "javascript:void(0)" onClick = "addStatus(this,'.$id.')" data-toggle="tooltip" data-placement="left" title="Add Status">
                                                		<span class="glyphicon glyphicon-plus-sign"></span>
                                                	</a>';?>
                                                </td>				                                                
<!-- removed status table from new staff-->
<div class="form-group">
							<div class = "col-sm-12"> <!-- statuses-->				  
								<table class="table table-hover table-bordered statusTable">        
									<tbody class="sortable1 connectedSortable">
											<tr> 
												<td><!--display--><?php echo'
													<p class="checkbox" style="margin-left:20px;"><input type="checkbox" value="" id = "display0'.$id.'" name = "display[]" data-toggle="tooltip" data-placement="right" title="Display" onClick="saveState(this,null,id,'.$id.')"><input type="hidden" id = "display0'.$id.'Checker"></p>'; ?>							
												</td>
												<td class="col-sm-4"><!-- status--> <?php echo'
                                                	<input type="text" name="s_Status[]" id = "status0'.$id.'" class="form-control" placeholder="Status" onkeyup="saveState(this,null,id,'.$id.')"><input type="hidden" id = "status0'.$id.'Checker">';?>
                                                </td>
												<td class="col-sm-3"><!-- start date-->							
													<div class="input-group date" id="datetimepicker"><?php echo'
    													<input type="text" class="form-control" id = "start0'.$id.'" placeholder="From" name= "startDate[]"  onkeyup="saveState(this,null,id,'.$id.')"><input type="hidden" id = "start0'.$id.'Checker">'; ?>
    													<span class="input-group-addon"><?php echo'
                                                        	<a href = "javascript:void(0)" onClick = "handleAuthClick(event,'.$id.','.$id.')"><span class="glyphicon glyphicon-calendar" ></span></a>'; ?>
                                                        </span>
													</div>							
												</td>				
												<td class="col-sm-3"><!-- end date-->
													<div class="input-group date" id="datetimepicker0"><?php echo'
    													<input type="text" class="form-control" id = "stop0'.$id.'" placeholder="To" name= "endDate[]" onkeyup="saveState(this,null,id,'.$id.')"><input type="hidden" id = "stop0'.$id.'Checker">';?>
    													<span class="input-group-addon"><?php echo'
        													<a href = "javascript:void(0)" onClick = "handleAuthClick(event,'.$id.','.$id.')"><span class="glyphicon glyphicon-calendar"></span></a>'; ?>
   														</span>
													</div>
												</td>				
												<td> <!-- delete status--> <?php echo'
                                                	<a href = "javascript:void(0)" onClick = "deleteStatus(this,'.$id.','.$defaultStatusId.')" data-toggle="tooltip" data-placement="bottom" title="Delete Status">
														<span class="glyphicon glyphicon-remove-sign"></span>
													</a>';?>
												</td>
												<td><!-- add status--><?php echo'
                                                	<a href = "javascript:void(0)" onClick = "addStatus(this,'.$id.')" data-toggle="tooltip" data-placement="left" title="Add Status">
                                                		<span class="glyphicon glyphicon-plus-sign"></span>
                                                	</a>';?>
                                                </td>				
											</tr>
										</tbody>
									</table> <!--end sub table status-->
								</div>				  
							</div><br><!--end statuses -->                                                
                                              
                                            