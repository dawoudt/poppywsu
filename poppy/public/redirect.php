<?php

// page requires a logged in user
require 'session-logged-in.php';

?>

<!DOCTYPE html>

<html>
	<head>
		
		<!-- Website Title & Description for Search Engine purposes -->
		<title>POPPY - Homepage</title>
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
	<title>Homepage - Poppy</title>
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
								<a href ="change-password.php">Change Password</a>
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
		
		<div class="modal-content submitalert">
        	<div class="modal-header">
          	<h4 class="modal-title text-center">Form Submitted</h4>
        	</div>
        	<div class="modal-body modbod">
          		<p class = 'text-center'>
					Your form has been successfully submitted.<br />
						Click <a href="homepage.php">here</a> to go to homepage.
				</p>
				<p class = 'text-center'>
					Redirecting to homepage in <span id="timer">5</span> seconds...
				</p>
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
	<script src="includes/js/alert.js"></script>
	
	</body>
</html>

