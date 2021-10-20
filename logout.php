<?php
session_start(); 
$_SESSION = array(); 
session_unset();
session_destroy();
echo"<script>window.location='login.php' </script>";
exit();
?>