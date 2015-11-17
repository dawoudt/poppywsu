<?php

session_start();

// if logout button is submitted
if (isset($_POST["logout"])) 
{
	// unset all session variables
	unset($_SESSION["user_id"]);
	unset($_SESSION["username"]);
	unset($_SESSION["admin"]);
	
	// destroy the session completely
	session_destroy();
}

header("Location: login.htm");

?>
