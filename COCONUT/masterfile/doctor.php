<?php
include("../../myDatabase.php");
$username = $_GET['username'];
$show = $_GET['show'];
$ro = new database();

$ro->getMasterListDoctor($show,"",$username);


?>
