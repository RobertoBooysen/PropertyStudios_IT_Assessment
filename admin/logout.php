<?php
//Starting the session
session_start();

//Unsetting all session variables
$_SESSION = array();

//Destroying the session
session_destroy();

//Redirecting to index page
header("Location: ../index.php");
exit();
?>