<?php

// start the session
session_start();

// if the user is not logged in
if (!$_SESSION["username"])
{
	// redirect to the login page
	header("Location: login.htm");
}
else 
{
	// assign a username session variable
	$strUsername = $_SESSION['username'];
	
	// if the user is not an admin
	if ($_SESSION["admin"] != 0)
	{
		// redirect to homepage
		header("Location: admin-section.php");
	}
}

?>