<?php
// Start the session
session_start();
$id= $_REQUEST["id"];
$i = $_REQUEST["pos"];
$defaultStatusId = -1;
?>						  
<td><!--display--><?php echo'
	<p class="checkbox" style="margin-left:20px;"><input type="checkbox" value="" id = "display'.$i.''.$id.'" name = "display[]" data-toggle="tooltip" data-placement="right" title="Display" onClick="saveState(this,null,id,'.$id.')"><input type="hidden" id = "display'.$i.''.$id.'Checker"></p>'; ?>							
</td>
<td class="col-sm-4"><!-- status--> <?php echo'
	<input type="text" name="s_Status[]" id = "status'.$i.''.$id.'" class="form-control" placeholder="Status" onkeyup="saveState(this,null,id,'.$id.')"><input type="hidden" id = "status'.$i.''.$id.'Checker">';?>
</td>
<td class="col-sm-3"><!-- start date-->							
	<div class="input-group date" id="datetimepicker6"><?php echo'
		<input type="text" class="form-control" id = "start'.$i.''.$id.'" placeholder="From" name= "startDate[]"  onkeyup="saveState(this,null,id,'.$id.')"><input type="hidden" id = "start'.$i.''.$id.'Checker">'; ?>
		<span class="input-group-addon"><?php echo '
			<a href = "javascript:void(0)" onClick = "handleAuthClick(event,'.$i.','.$id.')"><span class="glyphicon glyphicon-calendar" ></span></a>'; ?>
		</span>
	</div>							
</td>				
<td class="col-sm-3"><!-- end date-->
	<div class="input-group date" id="datetimepicker7"><?php echo'
		<input type="text" class="form-control" id = "stop'.$i.''.$id.'" placeholder="To" name= "endDate[]" onkeyup="saveState(this,null,id,'.$id.')"><input type="hidden" id = "stop'.$i.''.$id.'Checker">';?>
		<span class="input-group-addon"><?php echo'
			<a href = "javascript:void(0)" onClick = "handleAuthClick(event,'.$i.','.$id.')"><span class="glyphicon glyphicon-calendar"></span></a>'; ?>
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