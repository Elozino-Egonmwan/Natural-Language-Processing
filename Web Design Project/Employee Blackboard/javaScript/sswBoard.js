// JavaScript Document

var activePageTitle;
var title;
var clickedSave = false;
var countUnsaved;

/**google calender
** Your Client ID can be retrieved from your project in the Google
** Developer Console, https://console.developers.google.com**/
var CLIENT_ID = '523611765417-149gbol6lrl7stt5s0tet0116vegokk4.apps.googleusercontent.com';



/* Only read-only scope allowed */
var SCOPES = ['https://www.googleapis.com/auth/calendar.readonly'];
var statsIds = new Array(); 
var count = 0;
var updates  = 1; //TRUE

/*** Check if current user has authorized this application. */
function checkAuth() {
  gapi.auth.authorize(
	{
	  'client_id': CLIENT_ID,
	  'scope': SCOPES,
	  'immediate': true
	}, handleAuthResult);
}

/**
 * Handle response from authorization server.
 *
 * @param {Object} authResult Authorization result.
 */
 //var immed;
 var loggedOn;
function handleAuthResult(authResult) {
  loggedOn = authResult;
  var authorizeDiv = document.getElementById('authorize-div');
  if (authResult && !authResult.error) {
	// Hide auth UI, then load Calendar client library.
	authorizeDiv.style.display = 'none';
	//immed = true;
	loadCalendarApi();
  } else {
	// Show auth UI, allowing the user to initiate authorization by
	// clicking authorize button.
	//immed = false;
	authorizeDiv.style.display = 'inline';
  }
}

/**
 * Initiate auth flow in response to user clicking authorize button.
 *
 * @param {Event} event Button click event.
 */
function handleAuthClick(event) {
  if(loggedOn)	{
	  var immed = false;
  }
  else{
	  var immed = true;
  }
  gapi.auth.authorize(
	{client_id: CLIENT_ID, scope: SCOPES, immediate: immed}, //prevents pop up
	handleAuthResult);
  //setTimeout(function () { handleAuthClick(event); },30 * 1 * 1000);	
  return false;
}

/**
 * Load Google Calendar client library. List upcoming events
 * once client library is loaded.
 */
function loadCalendarApi() {
  //gapi.client.load('calendar', 'v3', listUpcomingEvents);
  gapi.client.load('calendar', 'v3', showCalenderList);
}

/**
 * Selects a specific target calender of interest from the
 * the authorized user's calendar list. If the calendar is not found an
 * appropriate message is printed.
 */
 
function showCalenderList(){
	var targetCalenderId = null;
	var targetCalendarName = "SSW";
	var request = gapi.client.calendar.calendarList.list({
		'calendarId': 'primary',		
		'showDeleted': false,		
	});
	request.execute(function(resp){
		var calendarList = resp.items;
		for(i = 0; i<calendarList.length; i++){
			var event = calendarList[i];
			//appendPre(event.summary);
			if(event.summary ==  targetCalendarName){
				var targetCalenderId = event.id;
			}			
		}
		if( targetCalenderId == null){
			display( targetCalendarName + " Calendar not found");
		}else{
			gapi.client.load('calendar', 'v3', listUpcomingEvents(targetCalenderId));
		}
	});
}

/**
 * Print the summary and start datetime/date of the events in
 * the authorized user's target calendar. If no events are found an
 * appropriate message is printed.
 */
function listUpcomingEvents(calendarId) {  
  var request = gapi.client.calendar.events.list({
	'calendarId': calendarId,
	'timeMin': (new Date()).toISOString(),
	'showDeleted': false,
	'singleEvents': true,	
	'orderBy': 'startTime'
  });

  request.execute(function(resp) {
	var events = resp.items;	
	if (events.length > 0) {
	  for (i = 0; i < events.length; i++) {
		var event = events[i];
		var eventSummary =new Array();		
		eventSummary = isValidStatus(event.summary);	/** event Summary now contains name in index 0, and status in index 1 */	
		//appendPre('Before Parsing:' + event.summary );	
		if(eventSummary != null){
		  //appendPre(' After parsing: ' + eventSummary[0] + ' ' + eventSummary[1]);
		  var staffName = eventSummary [0];	
		  var staffStatus = eventSummary[1];
		  var when = event.start.dateTime;
		  var end = event.end.dateTime;
		  var eventId = event.id;		 
		  if (!when) {
			when = event.start.date;		  
		  }		
		  if (!end) {
			end = event.end.date;
		  }		 
		  addId(event.id);
		  //addGoogleCalenderStatus(insPos,eventSummary[0],when,end);	
		  googleCalendarStatusDB(staffName,staffStatus,when,end,eventId);	
		  //appendPre(staffName + ' ' + staffStatus);	  
		} // end eventSummary == null
	  } // end for loop
	  syncDeletedStatus();		 
	} else { 
	  display('No upcoming events found.');
	}   
  }); 
}


function addId(ID){
	statsIds[count] = ID;
	count++;
}

/* ajax call to delete status from DB if deleted from calendar */
function syncDeletedStatus(){	
	var validStatus = JSON.stringify(statsIds);
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {		
		   location.reload();			
		   display("Google calendar synced");					
		}
	}	
	xmlhttp.open("GET", "deleteSync.php?statuses=" + validStatus, true);
	xmlhttp.send(); 	
}

/** ajax call to update DB */
function googleCalendarStatusDB(staffName,status, startDate, endDate,statusId){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			//display(xmlhttp.responseText)		;
			//syncDeletedStatus();						
		}
	}	
	xmlhttp.open("GET", "googleCalenderSync.php?named=" + staffName+ "&status=" + status + "&startDate=" + startDate + "&endDate=" + endDate + "&statId=" + statusId, true);
	xmlhttp.send(); 	 
}

function hasValidEnd(status){ /** rule 1: status must end with '!!' **/
	if(status.indexOf("!!") != -1)
		return true;
	return false;
}

function hasValidName(status){ /** rule 2 : status must begin with name and end in : */
	var nameSplit = new Array();
	nameSplit = status.split(":"); 
	nameSplit[0] = nameSplit[0].replace(".","");
	if(nameSplit.length != 2){ /* valid status must result in an array with 2 values Zino: Bowling */
		nameSplit =  null;
	}	
	return nameSplit;
}

function isValidStatus(status){
	var trimmedStatus = null;
	var nameNStatus = new Array();	
	if(hasValidEnd(status)){
		trimmedStatus = status.replace("!!",""); /** cut off end indicator */
		nameNStatus = hasValidName(trimmedStatus);	
		trimmedStatus = nameNStatus;		
	}
	return trimmedStatus;
}


/**
 * Append a pre element to the body containing the given message
 * as its text node.
 *
 * @param {string} message Text to be placed in pre element.
 */
function appendPre(message) {
  var pre = document.getElementById('output');
  var textContent = document.createTextNode(message + '\n');
  pre.appendChild(textContent);
} 

/** own functions **/

$(function() {			
	$( ".sortable1" ).sortable({
	  connectWith: ".connectedSortable"
	});			
});

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});

$(document).ready(function(){
    ///document.getElementById("googleCal").click();
	setTimeout(function () { document.getElementById("googleCal").click(); },3 * 60 * 1000);		
});

window.onbeforeunload = function (e) {
	  displayIframe();
	  var chk = hasUnsaved();	 
	  if((chk == true) && (clickedSave == false)){
		var message = "Your confirmation message goes here.",
		e = e || window.event;
		// For IE and Firefox
		if (e) {
		  e.returnValue = message;
		}	  
		// For Safari
		return "You have unsaved changes";
	  }
};


function activePage(pageIndex,pageTitle){
	activePageTitle = pageTitle;	
	document.getElementsByClassName("menU").item(pageIndex).className = "active";
	formatPage();
	/*if(pageTitle != "Directory"){
		var reformatHeader = document.getElementById("collapseSSW");
	    reformatHeader.className = "collapse navbar-collapse sswNavBar";	
	}*/	
	//setTimeout(function () { document.getElementById("googleCal").click(); },2 * 5 * 1000);		
	//handleAuthClick();
}

function addStatus(indx,ID){	
	var trgtForm = document.getElementById("staffTable"+ID);
	var childTable=trgtForm.getElementsByClassName("statusTable").item(0);
	var insPos = (indx.parentNode.parentNode.rowIndex) + 1;		
	var newRow = childTable.insertRow(insPos);		
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {	
			newRow.innerHTML = xmlhttp.responseText;				
			showControlBtns(ID);
			hasUnsaved();
			storeFormState(ID,"changed");							
		}
	}
	xmlhttp.open("GET", "dynamicNewStatus.php?id=" + ID+ "&pos=" + insPos, true);
	xmlhttp.send();    
}	

function addStaff(){
	document.getElementById("form0").style.display = "block";	
	hasUnsaved();
}

function attemptManualStatusChange(){	
    alert("READ ONLY! These values are synced from SSW Google Calendar");
	/*var alrt = document.getElementById("alert");	
	alrt.innerHTML = '<p class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a><span class="glyphicon glyphicon-warning-sign"></span> READ ONLY. These Values are synchronized from SSW Google Calendar</p>';	*/
}

function blurForm(ID){
	var trgtForm = document.getElementById("form"+ID);
	var formElmnts = trgtForm.elements.length;
	for(i = 0; i < formElmnts; i++){
		trgtForm.elements[i].disabled = true;
		if( (trgtForm.elements[i].id == "hide"+ID) || (trgtForm.elements[i].id == "show"+ID)){
			trgtForm.elements[i].disabled = false;
		}
	}		
}

function clearSearch(){
	document.getElementById("searchField").value = "";	
	searchEmployeeBtn();
}

function deleteStaffRecord(indx,ID){	
	var parent = document.getElementById("EmployeesTable");
	var child = document.getElementById("form" + ID);
	if (confirm("Permanently delete Staff Record?") == false) {	  	  
	} else {
		  var xmlhttp = new XMLHttpRequest();
		  xmlhttp.onreadystatechange = function() {
			  if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {		
				display(xmlhttp.responseText);	
				hasUnsaved();			 									
			  }
		   }
		  xmlhttp.open("GET", "deleteStaffDB.php?id=" +ID , true);
		  xmlhttp.send();
		  parent.removeChild(child);			    
	}	
}

function deleteStatus(indx,ID,statusID){	
	var trgtForm = document.getElementById("staffTable"+ID);
	var childTable=trgtForm.getElementsByClassName("statusTable").item(0);	
	var delPos = indx.parentNode.parentNode.rowIndex;
	var childRows = childTable.rows.length;  		
	if(childRows <= 1){		
		alert("You must have at least one Status to enable delete!");
	}
	else{
	  var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {		
			  display(xmlhttp.responseText);
			   childTable.deleteRow(delPos);  
			   hasUnsaved();	
	           //showControlBtns(ID);				 									
			}
		 }
		xmlhttp.open("GET", "deleteStatusDB.php?id=" +statusID , true);
		xmlhttp.send(); 	  	  	
	}	
}

function directions(pntr,oldRmVal,ID){		
	var parentRow = document.getElementById("staffTable"+ID);
	var rm = parentRow.getElementsByClassName("s_Room").item(0);	
	if(rm.value.length == 0){		
		rm.value += pntr.innerHTML;		
	}else{
		if(rm.value.match(/^[0-9a-z]+$/)){ //alphanumeric only : direction not inserted yet
			rm.value += pntr.innerHTML;
		}
		else{			
			rm.value = rm.value.slice(0,-1) + pntr.innerHTML;// direction already inserted, so slice off 
		}		
	}
	var rmID = "rm"+ID;
	var rmEvt = document.getElementById(rmID);
	saveState(rmEvt,oldRmVal,rmID,ID);
	return false;	
}

function display(message){	
	var target = document.getElementById("display");
	target.innerHTML = message;
	target.style.color = "red";	
	
	if(message.indexOf("Success") != -1){				
		target.style.color = "#0C0";
		var addGly = document.createElement("span");
		addGly.className = "glyphicon glyphicon-ok";
		target.appendChild(addGly);			 
	}		 
}

function displayFoto(idRow, fotoName){	
	if(fotoName.length > 0){	
	  var trgtFile = "uploads/" + fotoName;
	  document.getElementById(idRow).src = trgtFile;		  
	}
}

function displayChangesCnt(count){
	if (count > 0){
		document.getElementById("unSavedChangesRevert").innerHTML = "<a href='javascript:void(0)'><span class = 'glyphicon glyphicon-refresh'></span>Revert All(" + "<span style='color:red'>" + count +"</span>" + ")</a>";
		/*document.getElementById("unSavedChangesSave").innerHTML = "<a href='javascript:void(0)'><span class = 'glyphicon glyphicon-save'></span>Save All(" + "<span style='color:#0C0'>" + count +"</span>" + ")</a>";*/
		displayIframe();
	}else{
		document.getElementById("unSavedChangesRevert").innerHTML = " ";
		//document.getElementById("unSavedChangesSave").innerHTML = " ";
	}
}

function displayIframe(){ /**display iframe content in main window */
	document.getElementById("feedbackFrame").style.display = "none";	
	var a = document.getElementById("feedbackFrame").contentDocument.body.innerHTML;
	if(a==""){
		setTimeout(function () { displayIframe(); },1 * 1 * 1000);
	}else{
		display(a); 
		setTimeout(function () { document.getElementById("feedbackFrame").contentDocument.body.innerHTML = ""; },1 * 1 * 1000);			
	}	
}

/*make input field bold*/
function formatPage(){
  // Find its child `input` elements  
  if(activePageTitle == "Directory"){	
	var inputs = document.getElementsByTagName('input');
	for (index = 0; index < inputs.length; ++index) {	
		if(inputs[index].id != "searchField")	
		  inputs[index].style.fontWeight= "bold";		
	}
	hasUnsaved();	
  }  
}

function formIsChanged(ID){
	var isChangd = false;	
	if(document.getElementById("foto"+ID+"Checker").value == "yes"){isChangd = true;}
	if(document.getElementById("email"+ID+"Checker").value == "yes"){isChangd = true;}
	if(document.getElementById("prefixTitle"+ID+"Checker").value == "yes"){isChangd = true;}
	if(document.getElementById("fName"+ID+"Checker").value == "yes"){isChangd = true;}
	if(document.getElementById("lName"+ID+"Checker").value == "yes"){isChangd = true;}
	if(document.getElementById("postfixTitle"+ID+"Checker").value == "yes"){isChangd = true;}
	if(document.getElementById("fnction"+ID+"Checker").value == "yes"){isChangd = true;}
	if(document.getElementById("grpID"+ID+"Checker").value == "yes"){isChangd = true;}
	if(document.getElementById("rm"+ID+"Checker").value == "yes"){isChangd = true;}		
	//if(document.getElementById("status"+ID+"Checker").value == "yes"){isChangd = true;}
	var isStatChngd = statusTableIsChanged(ID);
	if((isChangd == false) && (isStatChngd==false)){
		storeFormState(ID,"unchanged");		
	}else{isChangd = true; }	
	return isChangd;
}

function hasUnsaved(){
	var isUnsaved = false;
	countUnsaved =0;
	var tables = document.getElementsByClassName("staffTable");
	var n = tables.length;	
	for(var i = 0; i < n; i++){
		if(tables[i].getElementsByClassName("saveMe").item(0).style.visibility == "visible"){		
			isUnsaved = true;
			countUnsaved++;
		}
	}
	displayChangesCnt(countUnsaved);
	return isUnsaved;
}


function hideControlBtns(ID){
	var saveBtn = "saveMe" + ID;
	var revertBtn = "revert" + ID;	
	document.getElementById(saveBtn).style.visibility = "hidden";
	document.getElementById(revertBtn).style.visibility = "hidden";	
}

function hideImage(ids){	
	//First create an event
	var click_ev = document.createEvent("MouseEvents");
	//initialize the event
	click_ev.initEvent("click", true /* bubble */, true /* cancelable */,window);
	//trigger the evevnt
	document.getElementById(ids).dispatchEvent(click_ev);
	//((document.getElementById(ids).click()) || (document.getElementById(ids).onClick()));
}

function imgPreview(pic,imgId,oldPic,ID,named) {	  
    if (pic.files && pic.files[0]) {
		var reader = new FileReader();
        reader.onload = function (e) {
			//display(imgId)	;
		    saveState(pic,oldPic,named,ID);			
			//display(pic.value);
			document.getElementById(imgId).src = e.target.result;	
						
        }
        reader.readAsDataURL(pic.files[0]);
    }
}

function loader(page){	
   	window.open(page,"_self");	
}	

function resetNewEmployee(){
	document.getElementById("newEmployeeForm").reset();
	document.getElementById("newEmployee").style.display = "none";
}

function revert(evt,ID){	
	if(ID == 0){
		document.getElementById("form0").style.display = "none";	
	}
	hideControlBtns(ID);
	storeFormState(ID, "unchanged");
	hasUnsaved();		
}

function revertAll(){
	var tables = document.getElementsByClassName("staffTable");
	var n = tables.length;	
	for(var i = 0; i < n; i++){
		if(tables[i].getElementsByClassName("saveMe").item(0).style.visibility == "visible"){					
			tables[i].getElementsByClassName("revert").item(0).click();			
		}		
	}
	//loader("EmployeeDirectory.html");
}

function saveAll(start){	
	var tables = document.getElementsByClassName("staffTable");
	var n = tables.length;	
	if(start < n){		
		if(tables[start].getElementsByClassName("saveMe").item(0).style.visibility == "visible"){		
			simulateSave(start);				
		}else{
			start = start + 1;
			saveAll(start);
		}
	}else{display("Saved" + saved);}	
}

function saveChanges(ID){ 
	clickedSave = true;
	//hideControlBtns(ID);	
	storeFormState(ID,"saved");	
}

function saveState(evt,oldVal,named,ID){		
	if(evt.type == 'checkbox')	{
		if(evt.checked){
			newVal = 1;
		}
		else{
			newVal = 0;
		}
	}else{ //evt not checkbox
		 newVal = evt.value;
	}
	
	//display(newVal + ' ' + oldVal);
	if(newVal != oldVal){		
		document.getElementById(named + "Checker").value = "yes";	
		showControlBtns(ID);
		storeFormState(ID,"changed");
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {                
				display(xmlhttp.responseText);			  		
			}
		}		  
		xmlhttp.open("GET", "storeValues.php?v=" + newVal + "&n=" + named, true);
		xmlhttp.send();	
	}
	if((ID == 0 && newVal == "")  || (ID != 0 && newVal == oldVal)){			
		document.getElementById(named + "Checker").value = "no";
		var isChanged = formIsChanged(ID);		
		if(isChanged == false){
			hideControlBtns(ID);
		}
	}
	hasUnsaved();		
}

function searchEmployee(e, val){	
	if(e.keyCode == 13 ){ /**enter key pressed */	
		var searchString = val.value;		
		var xmlhttp = new XMLHttpRequest();		
		xmlhttp.onreadystatechange = function() {			
		  if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			   if(val.value.length == 0){
				  location.reload();				  //return;
			  }else{
				  document.getElementById("EmployeesTable").innerHTML = xmlhttp.responseText;	
				  formatPage();
			  }	  	  
		  }
		}		  
		xmlhttp.open("GET", "searchEmployeeDB.php?search=" + searchString, true);
		xmlhttp.send();	
	}
		//return false;
}

function searchEmployeeBtn(){
		var val = document.getElementById("searchField");		
	    var searchString = val.value;		
		var xmlhttp = new XMLHttpRequest();		
		xmlhttp.onreadystatechange = function() {			
		  if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			  if(val.value.length == 0){
				  location.reload();			  //return;
			  }else{
				  document.getElementById("EmployeesTable").innerHTML = xmlhttp.responseText;	
				  formatPage();
			  }			  	  	  
		  }
		}		  
		xmlhttp.open("GET", "searchEmployeeDB.php?search=" + searchString, true);
		xmlhttp.send();	
		//return false;
}

function showControlBtns(ID){
	var saveBtn = "saveMe" + ID;
	var revertBtn = "revert" + ID;	
	document.getElementById(saveBtn).style.visibility = "visible";
	document.getElementById(revertBtn).style.visibility = "visible";	
}

function showForm(ID){
	var trgtForm = document.getElementById("form"+ID);
	var formElmnts = trgtForm.elements.length;
	for(i = 0; i < formElmnts; i++){
		trgtForm.elements[i].disabled = false;
	}	
}

function simulateSave(indx){
	display("Saving...");
	var tables = document.getElementsByClassName("staffTable");
	tables[indx].getElementsByClassName("saveMe").item(0).click();
	indx = indx + 1;	
	setTimeout(function () { saveAll(indx); },1 * 2 * 1000);	
}

function statusTableIsChanged(ID){
	var statIsChanged = false;
	//var statusFrm = document.getElementById("subform"+ID);
	var statusFrm = document.getElementById("staffTable"+ID);
	var statusTab= statusFrm.getElementsByClassName("statusTable").item(0);
	var nStats = statusTab.rows.length;
	if(ID == 0 && nStats > 1){return true; }
	for(var i = 0; i < nStats; i++){
		if(document.getElementById("status"+i+ID+"Checker").value == "yes"){return true; }
		if(document.getElementById("display"+i+ID+"Checker").value == "yes"){return true;}
		if(document.getElementById("start"+i+ID+"Checker").value == "yes"){return true;}
		if(document.getElementById("stop"+i+ID+"Checker").value == "yes"){return true;}	
	}	
	//display(nStats);				
	return statIsChanged;	//display(nStats);	
}

function storeFormState(ID, state){
	var xmlhttp = new XMLHttpRequest();		
	xmlhttp.onreadystatechange = function() {			
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {  			        
			display(xmlhttp.responseText);			  		
		}
	}		  
	xmlhttp.open("GET", "formState.php?id=" + ID + "&state=" + state, true);
	xmlhttp.send();
}

function toggleDisplay(evt,ID){
	//var clickedSave = true;
	var val = evt.innerHTML;
	var isVis;
	if(val == "HIDE"){
		evt.innerHTML = "SHOW";
		evt.className = "btn btn-info btn-sm";
		blurForm(ID);	
		isVis = 0;	
	}
	if(val == "SHOW"){
		evt.innerHTML = "HIDE";
		evt.className = "btn btn-default btn-sm";	
		showForm(ID);
		isVis = 1;
	}
	var xmlhttp = new XMLHttpRequest();		
	xmlhttp.onreadystatechange = function() {			
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {			            
			display(xmlhttp.responseText);			  		
		}
	}		  
	xmlhttp.open("GET", "employeeVisibility.php?id=" + ID + "&v=" + isVis, true);
	xmlhttp.send();	
}

function updateDisplay(val, ID){
	if(val.checked){
		val = 1;
	}
	else{
		val = 0;
	}	
	var xmlhttp = new XMLHttpRequest();		
	xmlhttp.onreadystatechange = function() {			
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {			            
			display(xmlhttp.responseText);			  		
		}
	}		  
	xmlhttp.open("GET", "updateStatusDisplay.php?val=" + val + "&id=" + ID, true);
	xmlhttp.send();	
}