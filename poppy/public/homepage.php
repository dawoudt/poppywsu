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
		<div class="carousel slide" id="myCarousel">

		<!-- Indicators -->
			<ol class="carousel-indicators">
				<li class="active" data-slide-to="0" data-target="#myCarousel"></li>
				<li data-slide-to="1" data-target="#myCarousel"></li>
				<li data-slide-to="2" data-target="#myCarousel"></li>
			</ol>

			<!-- Wrapper for slides -->
			
			<?php 
			
			// open the SQL connection to the database
			require 'mysql-connection-open.php';
			
			// get the messages stored in the database, ordered by the order
			$sql = "SELECT * FROM message ORDER BY message_order";
			$result = mysqli_query($conn, $sql)
			or die("Error: " . mysqli_error($conn));
			
			$rows = mysqli_num_rows($result);
			
			$intNum = 1;
			
			// if a message if found in the table
			if($rows > 0)
			{	
				while($row = mysqli_fetch_assoc($result))
				{
					if ($intNum == 1)
					{
			?>
			
			<div class="carousel-inner">
				<div class="item active" id="slide<?php echo $intNum; ?>">
					<div class="carousel-caption">
						<h4><?php echo $row["title"]; ?></h4>
						<p><?php echo $row["text"]; ?></p>
					</div><!--end carousel caption-->
				</div><!--end item -->
				
				<?php 
					$intNum++;
					} 
					else 
					{
				?>
				
				<div class="item" id="slide<?php echo $intNum; ?>">
					<div class="carousel-caption">
						<h4><?php echo $row["title"]; ?></h4>
						<p><?php echo $row["text"]; ?></p>
					</div>
				</div>
				<?php 
					$intNum++;
					} 
				}
				
				// close the SQL connection
				require 'mysql-connection-close.php';
			}
			else 
			{
				echo "<p>No messages found.</p>";
			}
			?>
			
			</div>
			
			
			<!--controls-->
			<a class="left carousel-control" data-slide="prev" href="#myCarousel"><span class="icon-prev"></span></a>
			<a class="right carousel-control" data-slide="next" href="#myCarousel"><span class="icon-next"></span></a>
	

		</div> <!-- end carousel -->
		<div class="row" id="bigCallout">

			<div class="btn-section">


				<div class="panel panel-danger panel-menu">
					 <div class="panel-heading">
    					<h3 class="panel-title text-center">Forms</h3>
  					</div>
  					<div class="hmBtn col-md-4 text-center" > 
						<a class="btn btn-poppy btn-lg btn-block" href="introduction.php">Introduction</a>
					</div>
					<div class="hmBtn col-md-4 text-center" > 
						<a class="btn btn-poppy btn-lg btn-block" href="in-hospital.php">In Hospital Form</a>
					</div>
					<div class="hmBtn col-md-4 text-center" > 
						<a class="btn btn-poppy btn-lg btn-block" href="at-home-in-community.php">At Home/In Community Form</a>
					</div>
				</div>
				
			</div>
		</div> <!--end bigCallout --> 
		<div class="row" id="featuresHeading">
		</div> <!--end featuresHeading -->
		<div class="row" id="features"> 
		</div> <!--end features-->
	</div> <!-- end container -->
	

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

