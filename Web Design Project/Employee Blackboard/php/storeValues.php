<?php
session_start();
$value = $_REQUEST["v"];
$name = $_REQUEST["n"];
$_SESSION[$name] =$value;

?>