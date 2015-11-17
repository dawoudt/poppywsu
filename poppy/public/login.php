<?php

session_start();

date_default_timezone_set('Australia/Sydney');

if (isset($_POST["login"])) 
{
	// open the SQL connection to the database
	require 'mysql-connection-open.php';
	
	// remove all SQL injection capable characters from the input
	$strUsername = mysqli_real_escape_string($conn, $_POST["strUsername"]);
	$strUserPassword = mysqli_real_escape_string($conn, $_POST["strUserPassword"]);
	
	// compare the hash from the users entered password and the password hash and if they match, the correct password is entered
	$strEncryptedPassword = crypt($strUserPassword, '$6$rounds=5000$poppysaltforpass$');
	$strUserPassword = $strEncryptedPassword;
	
	// select the user and the corresponding password
	$sql = "SELECT * FROM user WHERE username = '$strUsername' AND password = '$strUserPassword' ";
	$result = mysqli_query($conn, $sql)
	or die("Error: " .mysqli_error($conn));
	
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	
	// if query is successful
	if ($result = mysqli_query($conn, $sql))
	{
		// if there is a match
		if ($rowCount = mysqli_num_rows($result) > 0)
		{
			$_SESSION["user_id"] = $row["user_id"];
			$_SESSION["username"] = $strUsername;
			$intIsAdmin = $row["admin"];
			$_SESSION["admin"]= $intIsAdmin;
			$surveyStage = $row["survey_stage"];
			
			// if the user is not an admin
			if ($intIsAdmin == 0)
			{
				// redirect them to the introduction form if they have not completed it
				if ($surveyStage == 'Introduction')
				{
					header("Location: introduction.php");
					$date = date('Y-m-d');
					$current_id = $_SESSION["user_id"];
					
					// update the users last login stored in the database
					$sql = "UPDATE user SET lastLogin = '$date' WHERE user_id = '$current_id'";
					$result = mysqli_query($conn, $sql)
					or die("Error: " .mysqli_error($conn));
				}
				else
				{
					// redirect to homepage if they have completed introduction form
					header("Location: homepage.php");
					$date = date('Y-m-d');
					$current_id = $_SESSION["user_id"];
					
					// update the users last login stored in the database
					$sql = "UPDATE user SET lastLogin = '$date' WHERE user_id = '$current_id'";
					$result = mysqli_query($conn, $sql)
					or die("Error: " .mysqli_error($conn));
				}
			}
			else 
			{
				// if an admin is logging in, redirect to admin section
				header("Location: admin-section.php");
			}		
		}
		else
		{
			// if login is unsuccessful, redirect to login page
			header("Location: login.htm");
		}
	}
	
	// close the SQL connection
	require 'mysql-connection-close.php';
}
else
{
	// if login is unsuccessful, redirect to login page
	header("Location: login.htm");
}

?>
