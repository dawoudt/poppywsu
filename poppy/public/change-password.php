<?php 

// page requires a logged in user
require 'session-logged-in.php';

?>

<!DOCTYPE html>

<html>
	<head>
		<!-- Website Title & Description for Search Engine purposes -->
		<title>Change Password - Poppy</title>
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
		<div class="navbar navbar-fixed-top">
			<div class="container"> 
			
			<button class="navbar-toggle" data-target=".navbar-responsive-collapse" data-toggle="collapse" type="button">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			
			<a class ="navbar-brand" href="homepage.php"><img src="images/Poppy.png" alt="Poppy"></a> <!--Logo-->
			<div class="nav-collapse collapse navbar-responsive-collapse">
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="homepage.php">Homepage</a>
					</li>
					 <li role="separator" class="divider"></li>	
					<li class="dropdown" id="Help">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Profile<strong class = "caret"></strong></a>
						<ul class = "dropdown-menu" id="ddmenu"> 
							<li>
								<a href ="change-password.php">Change PW</a>
							</li>							
						</ul>
					</li>
				</ul>
				
				<!-- new php code below:
				- doesnt show login button when user is already logged in,
				- provides a logout button on homepage
				-->
				<?php 
				
				// if the user is logged in, show the logout button
				if ($_SESSION['username'])
				{ ?>
					<form action="logout.php" class="navbar-form pull-right" method="post">
						<div class="col-md-4 text-center">
						<button class = "btn btn-poppy" type="submit" name="logout" value="Logout">Logout <span class="badge"> user: <?php echo $_SESSION['username']; ?></span></button>
						</div>
					</form>
				<?php
				}
				?>
				
				<ul class="nav navbar-nav pull-right" id="myAccount">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> My Account <strong class="caret"></strong></a>
					<ul class="dropdown-menu">
						<li>
							<a href="#"><span class="glyphicon glyphicon-briefcase"></span> Profile</a>
						</li>
						<li>
							<a href="#"><span class="glyphicon glyphicon-wrench"></span> Settings</a>
						</li>
						<li>
						<li class = "divider"></li>
						<li>
							<a href="#"><span class="glyphicon glyphicon-off"></span> Sign out</a>
						</li>
					</ul>
					</li>
				</ul>
			
			</div> <!--end nav-collapse -->
			
			</div><!--end container-->
		</div><!-- end navbar -->
		

				<div class="changepw modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<?php
					// display the username of the logged in user
					echo "<h3>Profile - " . $_SESSION['username'] . "</h3>";
				
				?>

			</div>

				<form class="form col-md-12 center-block" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id = "changePW">
					<div class = "pwblock">
						
						<div class="form-group loginInput">
							<input type="password" name="strNewPassword" id="strNewPassword" class="form-control input-lg" placeholder="New Password" required>
						</div>
						<div class="form-group loginInput">
							<input type="password" class="form-control input-lg" name="strNewPasswordConfirm" id="strNewPasswordConfirm" placeholder="Confirm Password" required>
						</div>
						<div class="form-group">
							<div class="col-md-4 text-center"> 
								<button class="btn btn-poppy btn-lg loginBtn" name="changePassword" id="changePassword" type="submit">Submit</button> 
							</div>
						</div>	
					</div>

				</form>
				<script type="text/JavaScript">
						$("#"+"changePW").validate();

				</script>

				<?php

				// if the form is submitted
				if (isset($_POST["changePassword"])) 
				{
					// open the SQL connection to the database
					require 'mysql-connection-open.php';
					
					// remove all SQL injection capable characters from the input
					$strNewPassword = mysqli_real_escape_string($conn, $_POST["strNewPassword"]);
					$strNewPasswordConfirm = mysqli_real_escape_string($conn, $_POST["strNewPasswordConfirm"]);

					// if the first password entered matches the second password field
					if (strcmp($strNewPassword, $strNewPasswordConfirm) === 0)
					{
						 // encrypt the password
						 $strEncryptedPassword = crypt($strNewPassword, '$6$rounds=5000$poppysaltforpass$');
						 
						 // check that the user is present in the database
						 $sql = "SELECT username FROM user WHERE username = '$strUsername'";
						 $result = mysqli_query($conn, $sql)
						 or die("Error: " .mysqli_error($conn));

						 if (mysqli_num_rows($result) > 0)
						 {
						    // password entered matches current password for current user
							$strNewPassword = mysqli_real_escape_string($conn, $_POST["strNewPassword"]);
						 	$strEncryptedPassword = crypt($strNewPassword, '$6$rounds=5000$poppysaltforpass$');
							
							// update the user's password with the newly entered password
						 	$sql = "UPDATE user SET password = '$strEncryptedPassword' WHERE username = '$strUsername' ";
						 	mysqli_query($conn, $sql)
							or die ("Error: " .mysqli_error($conn));
						
							// alert user that password change is successful
						 	echo "<div class=\"alert alert-success\" role=\"alert\"> 
								<p><strong>Success! </strong>Your password has been changed.</p>
						 		</div>";
						 }
						
					}
					else
					{
						// alert if passwords do not match
						echo "<div class=\"alert alert-danger\" role=\"alert\"> 
							<p><strong>Oops! </strong>Passwords do not match.</p>
							</div>";
					}
		
					// close the SQL connection
					require 'mysql-connection-close.php';
				}
				?>
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

