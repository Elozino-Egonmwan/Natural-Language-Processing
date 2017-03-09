<?php
session_start();
$id= $_REQUEST["id"];
$state = $_REQUEST["state"];
$form = "form" . $id;
$_SESSION[$form] = $state;
if ($state == "changed"){
	$_SESSION["Changes"] = "Multiple";
}else {$_SESSION["Changes"] = "";}
//session_destroy(); 

?>