<?php
  function serverConnection(){	 
	  $servername = "fdb3.biz.nf";
	  $username = "1869469_project";
	  $password ="1869469_project";
	  $dbname = "1869469_project";	  
	  $conn = new mysqli($servername, $username, $password, $dbname);	  
	  return $conn;
  }
?> 