
<!DOCTYPE html>
<html>
  <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <title></title>            
  </head>
  <body>
  
  <form class = "form-horizontal" role="form" name="formNewEmployee" method="post" enctype="multipart/form-data" action="<?php echo($_SERVER["PHP_SELF"]);?>"><br> 
      <div class="form-group">          
          <label class = "control-label col-sm-2">PHOTO SPECS: [100 X 100;500KB]</label>          
          <div class="col-sm-9">              
              <img src="thumbnail.gif" class="img-thumbnail" alt="No Photo" width="100" height="100" id = "imgPre"> 
          </div>
       </div>       
       <div class="form-group">
       <label class = "control-label col-sm-2"></label>         
          <div class="col-sm-9">
              <input type="file" name="fileToUpload" id = "fotoName" onchange="imgPreview(this,'imgPre');" >              
          </div>
       </div>
       <div class="form-group">          
          <label class = "control-label col-sm-2"><span style="color:red">*</span>Email:</label>
          <div class="col-sm-9">
              <input type="email" title = "yuyt" name="s_email" class="form-control" placeholder="someone@hotmail.com" required value = "<?php echo $_POST['s_email']; ?>">
          </div>
        </div>              
      <div class="form-group">          
          <label class = "control-label col-sm-2">Title (Prefix):</label>
          <div class="col-sm-9">
              <input type="text" name="s_Title" class="form-control" placeholder="Prefix Title" value = "<?php echo $_POST['s_Title']; ?>"> 
          </div>
       </div>              
        <div class="form-group">          
          <label class = "control-label col-sm-2"><span style="color:red">*</span>First Name:</label>
          <div class="col-sm-9">
              <input type="text" name="s_firstName" class="form-control" placeholder="First Name" required value = "<?php echo $_POST['s_firstName']; ?>"> 
          </div>
        </div>            
        <div class="form-group">          
          <label class = "control-label col-sm-2"><span style="color:red">*</span>Last Name:</label>
          <div class="col-sm-9">
              <input type="text" name="s_lastName" class="form-control" placeholder="Last Name" required value = "<?php echo $_POST['s_lastName']; ?>" >
          </div>
        </div>
        <div class="form-group">          
          <label class = "control-label col-sm-2">Title (Postfix):</label>
          <div class="col-sm-9">
              <input type="text" name="s_pTitle" class="form-control" placeholder="Postfix Title" value = "<?php echo $_POST['s_pTitle']; ?>"> 
          </div>
       </div>   
        <div class="form-group">          
          <label class = "control-label col-sm-2">Function:</label>
          <div class="col-sm-9">
              <input type="text" name="s_Function" class="form-control" placeholder="Function" value = "<?php echo $_POST['s_Function']; ?>" >
          </div>
        </div>  
        
        <div class="form-group">          
          <label for = "group" class = "control-label col-sm-2"><span style="color:red">*</span>Group:</label>
          <div class="col-sm-9">          
          	<select class="form-control" id="group" name="s_Group" value = "<?php echo $_POST['s_Group']; ?>" > 
              <option value = "">Select a Group</option>             
              <option value = "Board of Directors">Board of Directors</option>
              <option value = "Sec">Secetrary</option>
              <option value = "Guest">Guest</option>
              <option value = "Employee">Employee</option>
              <option value = "OracleLabs">Oracle Labs</option>
              <option value = "CDL">Christian Doppler Laboratory</option>
              <option value = "Others">Others</option>
            </select>            
             <!-- <input type="text" name="s_Group" class="form-control" placeholder="Group" required value = "<?php echo $_POST['s_Group']; ?>" > -->
          </div>
        </div>  
        <div class="form-group">          
          <label class = "control-label col-sm-2"><span style="color:red">*</span>Room Number:</label>
          <div class="col-sm-9">
              <input type="text" name="s_Room" id = "room" class="form-control" placeholder="Room Number" required value = "<?php echo $_POST['s_Room']; ?>" >
          </div>
        </div> 
        <div class="form-group">          
          <label class = "control-label col-sm-2">Direction:</label>
          <div class="col-sm-9">
             <a href = "#" onClick="direction(this)">&#8592;</a>&nbsp; &nbsp; 
             <a href = "#" onClick="direction(this)">&#8593;</a>&nbsp; &nbsp;
             <a href = "#" onClick="direction(this)">&#8594;</a>&nbsp; &nbsp;
             <a href = "#" onClick="direction(this)">&#8595;</a>&nbsp;&nbsp; 
             <a href = "#" onClick="direction(this)">&#8598;</a>&nbsp;&nbsp;
             <a href = "#" onClick="direction(this)">&#8599;</a>&nbsp; &nbsp;
             <a href = "#" onClick="direction(this)">&#8600;</a>&nbsp; &nbsp;
             <a href = "#" onClick="direction(this)">&#8601;</a> 
          </div>
        </div> 
        
        <div class="form-group">
        <label class = "control-label col-sm-2">Status: </label>
           <div class = "col-sm-9"> 				  
              <table class="table table-hover table-bordered statusTable">        
                <tbody class="sortable1 connectedSortable" >
                <tr>
                  <td class="col-sm-4"><input type="text" name="s_Status[]" class="form-control" placeholder="Status" value = "<?php echo $_POST['s_Status']; ?>" ></td>
                  <td class="col-sm-3">							
                      <div class="input-group date" id="datetimepicker6">
                          <input type="text" class="form-control" placeholder="From" name= "startDate[]" value = "<?php echo $_POST['startDate']; ?>">
                          <span class="input-group-addon">
                              <a href = "javascript:void(0)" onClick = "pickerDate()"><span class="glyphicon glyphicon-calendar"></span></a>
                          </span>
                      </div>							
                  </td>                  
                  <td class="col-sm-3">
                      <div class="input-group date" id="datetimepicker7">
                          <input type="text" class="form-control" placeholder="To" name= "endDate[]" value = "<?php echo $_POST['endDate']; ?>">
                          <span class="input-group-addon">
                              <a href = "javascript:void(0)" onClick = "pickerDate()"><span class="glyphicon glyphicon-calendar"></span></a>
                          </span>
                      </div>
                  </td>
                  <td>
                      <p class="checkbox" style="margin-left:20px;"><input type="checkbox" value="" name = "status[]" data-toggle="tooltip" title="Display"></p>								
                  </td>
                  <td><a href = "javascript:void(0)" onClick = "deleteRow(this,1)" data-toggle="tooltip" title="Delete Status"><span class="glyphicon glyphicon-remove-sign"></span></a></td>
                  <td><a href = "javascript:void(0)" onClick = "addStatus(this,1)" data-toggle="tooltip" title="Add Status"><span class="glyphicon glyphicon-plus-sign"></span></a></td>							
                </tr>
                </tbody>
              </table>
           </div>				  
          </div>         
                      
        <p><br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp  &nbsp; &nbsp
          <input type="submit" name="createButton" class="btn btn-primary" value="CREATE">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp
          <button type="button" class="btn btn-danger" onClick="loader('Home.html')">CANCEL</button>                             
        </p>             
      </form>
  </body>
 </html>
		      