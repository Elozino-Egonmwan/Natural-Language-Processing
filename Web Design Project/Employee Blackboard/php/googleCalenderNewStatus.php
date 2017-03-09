<?php
// Start the session
session_start();
$id= $_REQUEST["id"];
$pos = $_REQUEST["pos"];
$evt =  $_REQUEST["status"];
$start =  $_REQUEST["startDate"];
$end =  $_REQUEST["endDate"];
$defaultStatusId = -1;
//xmlhttp.open("GET", "googleCalenderNewStatus.php?id=" + ID+ "&pos=" + insPos + "&status=" + status + "&startDate=" + startDate + "&endDate=" + endDate, true);

?>						  
<td><!--display--><?php echo'
	<p class="checkbox" style="margin-left:20px;"><input type="checkbox" value="" id = "display'.$pos.''.$id.'" name = "display[]" data-toggle="tooltip" data-placement="right" title="Display" onClick="saveState(this,null,id,'.$id.')"><input type="hidden" id = "display'.$pos.''.$id.'Checker"></p>'; ?>							
</td>
<td class="col-sm-4"><!-- status--> <?php echo'
	<input type="text" name="s_Status[]" id = "status'.$pos.''.$id.'" value = "'.$evt.'" class="form-control" placeholder="Status" onkeyup="saveState(this,null,id,'.$id.')"><input type="hidden" id = "status'.$pos.''.$id.'Checker">';?>
</td>
<td class="col-sm-3"><!-- start date-->							
	<div class="input-group date" id="datetimepicker6"><?php echo'
		<input type="text" class="form-control" id = "start'.$pos.''.$id.'" value = "'.$start.'" placeholder="From" name= "startDate[]"  onkeyup="saveState(this,null,id,'.$id.')"><input type="hidden" id = "start'.$pos.''.$id.'Checker">'; ?>
		<span class="input-group-addon">
			<a href = "javascript:void(0)" onClick = "pickerDate()"><span class="glyphicon glyphicon-calendar" ></span></a>
		</span>
	</div>							
</td>				
<td class="col-sm-3"><!-- end date-->
	<div class="input-group date" id="datetimepicker7"><?php echo'
		<input type="text" class="form-control" id = "stop'.$pos.''.$id.'" value = "'.$end.'" placeholder="To" name= "endDate[]" onkeyup="saveState(this,null,id,'.$id.')"><input type="hidden" id = "stop'.$pos.''.$id.'Checker">';?>
		<span class="input-group-addon">
			<a href = "javascript:void(0)" onClick = "pickerDate()"><span class="glyphicon glyphicon-calendar"></span></a>
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