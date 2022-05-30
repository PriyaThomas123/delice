<?php 
session_start(); 
session_destroy();
header("location: staff_login.php");
?>