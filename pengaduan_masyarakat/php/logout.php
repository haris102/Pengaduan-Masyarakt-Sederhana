<?php 
session_start();
$_SESSION['login'] = "";
header("Location: index.php");
session_unset();
session_destroy();

?>