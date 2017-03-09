
<table class="table table-hover table-bordered statusTable">        
  <tbody class="sortable1 connectedSortable">                                          
    <tr> 
      <td><!--display-->
        <p class="checkbox" style="margin-left:20px"><input type="checkbox" data-toggle="tooltip" data-placement="right" title="Display" disabled></p>							
      </td>
      <td class="col-sm-4"><!-- status--> 
        <input type="text" class="form-control" placeholder="Status"  onClick = "attemptManualStatusChange()"  readonly>
      </td>
      <!-- calendar addon -->
      <td class="col-sm-4"><!-- start date-->							
        
            <input type="text" class="form-control"  placeholder="From"  onClick = "attemptManualStatusChange()"  readonly> 
            
                                    
      </td>				
      <td class="col-sm-4"><!-- end date-->
        
            <input type="text" class="form-control"  placeholder="To"  onClick = "attemptManualStatusChange()" readonly>
            
      </td>
      <!-- delete  and add status functions removed -->
      
    </tr>
  </tbody>
</table>