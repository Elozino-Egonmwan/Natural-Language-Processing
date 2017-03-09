<?php echo'
<div class = "table-responsive">
 <table class="table table-hover" style="color:#000">
 </tbody>'; 
  for($i = 0; $i <15; $i++){
  echo'
    <tr>
  	
	<div id = "id'.$i.'"></div>
	<div id = "distance'.$i.'"></div>
	<div id = "stats'.$i.'"></div>	
	<div id = "duration'.$i.'"></div>
  </tr> &nbsp;&nbsp;';
	
  } 
  echo'
  <tbody>
  </table>
  </div';
  ?>