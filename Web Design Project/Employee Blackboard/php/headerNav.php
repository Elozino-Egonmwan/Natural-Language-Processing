
<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">   
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapseSSW">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>      
        </div>      
		<div class = "collapse navbar-collapse" id = "collapseSSW">
			<ul class="nav navbar-nav">
				<li class = "menU"><a href="Home.html"><span class="glyphicon glyphicon-home"></span> Home</a></li>		
				<li class = "menU"><a href="EmployeeDirectory.html"><span class="glyphicon glyphicon-list-alt"></span> Employees</a></li>          		  
				<li class = "menU"><a href="#"><span class="glyphicon glyphicon-pencil"></span> Groups</a></li>
				<li class = "menU"><a href="#"><span class="glyphicon glyphicon-pencil"></span> News</a></li>
				<li class = "menU"><a href="#"><span class="glyphicon glyphicon-eye-open"></span> View Board</a></li>		
				<?php
				if($_SESSION["Location"] == "EmployeeDirectory.html"){?>					
					<li> <iframe name="formFrame" style="border:none; height: 40px; width:10px; font-color: #FFF" id= "feedbackFrame"></iframe> </li>												
					<li><a href="javascript:void(0)" onClick = "addStaff()"><span class="glyphicon glyphicon-user"></span>Add New</a></li>
                    <li onClick = "handleAuthClick(event)"><a href="javascript:void(0)"><span class="glyphicon glyphicon-calendar"></span>Sync Google Calendar</a></li>
                    <!--<button onClick = "handleAuthClick(event)" class = "btn btn-primary btn-md" id = "googleCal">Sync Google Calendar</button></li>--> 
                    <li style="position:absolute; right: 185px; top:10px"><input type="text" name= "searchDB" value="<?php echo htmlspecialchars($_SESSION['srch']); ?>" class="form-control " id = "searchField" placeholder="Search" onkeyup = "searchEmployee(event,this)" >                               	
                    </li>
                    <li style="position:absolute; right: 115px; top:5px"><a onClick = "clearSearch()"><span class= "glyphicon glyphicon-remove"></span></a></li>
                    <li style="position:absolute; right: 145px; top:5px"><a onClick = "searchEmployeeBtn()"><span class= "glyphicon glyphicon-search"></span></a></li>
                    <li id = "unSavedChangesRevert" onClick = "revertAll()"> </li>	
                    <li id = "display" style="position:relative; top: 15px"> </li>                     
				<?php		 			
				} ?>			         	                     
			</ul>		 
		</div>
	</div>
</nav>
