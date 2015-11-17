<?php 

// create a random password for the user, and return it
function generate_password() 
{
	// create a string that password characters can be generated from
	$strChars = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
	$intLength = strlen($strChars) - 1;
	$password = array();
	
	for ($intI = 0; $intI < 10; $intI++) 
	{
		$intIndex = rand(0, $intLength);
		$password[] = $strChars[$intIndex];
	}
	return implode($password);
}
			
?>

<!DOCTYPE html>

<html>
	<head>
		<!-- Website Title & Description for Search Engine purposes -->
		<title>Forgot Password</title>
		<meta name="description" content="">
		
		<!-- Mobile viewport optimized -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		
		<!-- Include the jQuery library -->
		<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
 		
		<script src="includes/js/script.js"></script>
		<!-- Bootstrap CSS -->
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="includes/css/bootstrap-glyphicons.css" rel="stylesheet">
		
		<!-- Custom CSS -->
		
		<script src="includes/jQueryValidation/dist/jquery.validate.js"></script>
		<link href="includes/jquery-ui-1.11.4/jquery-ui.css" rel="stylesheet">
		<link href="includes/css/styles.css" rel="stylesheet">
		<!-- Include Modernizr in the head, before any other Javascript -->
		<script src="includes/js/modernizr-2.6.2.min.js"></script>
		
	</head>
	<body class="bodyTheme">
	
	<div class="container" id="main">
		<div class="changepw modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<img class="logo" src="images/Poppy.png" alt="Poppy">
				</div>
				<div class="modal-body">
				<h3 class="text-center heading">Reset your password</h3>
					<form class="form col-md-12 center-block" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id='resetPW'>
						<div class = "pwblock">
							<div class="form-group loginInput">
								<input type='text' class='form-control input-lg' id='strEmail' name='strEmail' placeholder="Please enter the email associated with your poppy account..."/>
							</div>
							<div class="form-group">
								<div class="col-md-4 text-center"> 
									<button class= 'btn btn-poppy btn-lg loginBtn' type='submit' name='resetPassword' >Reset Password</button> 
								</div>
								<a class ='pull-right forgotpw' href="login.htm">Back to Login Page</a>
							</div>	
						</div>

					</form>
				</div>
					<?php 

						// if form is submitted
						if (isset($_POST['resetPassword']))
						{
							// open the SQL connection to the database
							require 'mysql-connection-open.php';
							
							$strEmail = mysqli_real_escape_string($conn, $_POST['strEmail']);
							
							// if username is entered, and not empty
							if ($strEmail != NULL)
							{
								$sql = "SELECT username, email FROM user WHERE email = '$strEmail'";
							
								$result = mysqli_query($conn, $sql)
								or die("Error: " .mysqli_error($conn));
							
								// if a match for the username entered is found in the database
								if (mysqli_num_rows($result) > 0)
								{
									// create a random password, and encrypt that password
									$strGeneratedPassword = generate_password();
									$strEncryptedPassword = crypt($strGeneratedPassword, '$6$rounds=5000$poppysaltforpass$');
									
									// set new encrypted password as the actual password
									$sql = "UPDATE user SET password = '$strEncryptedPassword' WHERE email = '$strEmail' ";
									mysqli_query($conn, $sql)
									or die("Error: " . mysqli_error($conn));
									
									$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

									require 'email.php';
									$m->addAddress($strEmail, $row["username"]);
									
									$m->Subject = 'Poppy - Reset Link';
									$m->Body = "<p>Here are your login details to access the poppy website: </p>";
									$m->Body .= "<p><strong>Username: </strong>" . $row["username"];
									$m->Body .= "<p><strong>Password: </strong> $strGeneratedPassword";
									$m->Body .= "<p>Follow this link ". $url . " and sign in with your username and password";
									
				 					$m->altBody = "Here are your login details to access the poppy website: ";
				 					$m->altBody .= "Username:"  . $row["username"];
				 					$m->altBody .= "Password: $strGeneratedPassword";
				 					$m->altBody .= "Follow this link ". $url . " and sign in with your username and password";
				 					
									if($m->Send()) {
										echo "<div class=\"alert alert-success\" role=\"alert\"> 
										<p><strong>Success! </strong>Password has been reset and sent to the provided email: <i> $strEmail</i>.</p>
										</div>";
									}

									//echo "<h2>Example of Email sent to user (remove in final version)</h2>";
									//echo "<p>Dear " . $row["email"] . " ,";
									//echo "<p>Here are your login details to access the poppy website: </p>";
									//echo "<p><strong>Username:</strong> $strEmail";
									//echo "<p><strong>Password:</strong> $strGeneratedPassword";


									
								}
								else
								{
									echo "<div class=\"alert alert-danger\" role=\"alert\"> 
									<p><strong>Oops! </strong>$strEmail does not exist</p>
									</div>";
								}
							}
							else 
							{
								echo "<div class=\"alert alert-danger\" role=\"alert\"> 
								<p><strong>Oops! </strong>No email entered</p>
								</div>";
							}
							
							// close the SQL connection
							require 'mysql-connection-close.php';
						}
						?>
					<script type="text/JavaScript">
						$("#"+"resetPW").validate();
					</script>
			</div>
		</div>
	</div>


	<footer>
	</footer>

	<!-- All Javascript at the bottom of the page for faster page loading -->
		
	<!-- First try for the online version of jQuery-->
	
	<!-- If no online access, fallback to our hardcoded version of jQuery -->
	<script>window.jQuery || document.write('<script src="includes/js/jquery-1.8.2.min.js"><\/script>')</script>
	
	<!-- Bootstrap JS -->
	<script src="bootstrap/js/bootstrap.min.js"></script>

	<!-- Custom JS -->
	<script src="includes/js/script.js"></script>
	
	</body>
</html>

