<?php
session_start();
?>

<?php

$employeeState = $_SESSION["EmployeeAdded"];

echo $employeeState;

?>