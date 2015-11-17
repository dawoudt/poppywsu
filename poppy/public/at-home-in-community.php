<?php

session_start();

if (!$_SESSION["username"])
{
	header("Location: login.htm");
}
else 
{
	$intUserId = $_SESSION["user_id"];
	
	// open the SQL connection to the database
	require 'mysql-connection-open.php';
	
	// if form is submitted
	if (isset($_POST["submit"]))
	{
		// for each value submitted in the $_POST array
		foreach($_POST as $key=>$value)
		{
			// ignore default values and hidden fields
			if ($key != 'submit' && $key != 'NextSurveyStage' && $value != '' && $value != '---')
			{
				// submit the answers to the database
				$sql = "INSERT INTO answer(answer_id, user_id, question_id, answer_text, submit_time) VALUES ('','$intUserId','$key','$value', NOW()) ";
				$result = mysqli_query($conn, $sql)
				or die("Error: " .mysqli_error($conn));
			}
		}
		
		// after form is processed, direct user to the homepage
		header("Location: redirect.php");
	}
	?>
	<html>
	<head>
		
		<!-- Website Title & Description for Search Engine purposes -->
		<meta name="description" content="">
		
		<!-- Mobile viewport optimized -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		
		
		<!-- Include the jQuery library -->
		<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
 		
		
		<!-- Bootstrap CSS -->
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="includes/css/bootstrap-glyphicons.css" rel="stylesheet">
		<link href="inclides/css/bootstrapValidator.css">
		
		
		<!-- Custom CSS -->
		
		<script src="includes/jQueryValidation/dist/jquery.validate.js"></script>
		<link href="includes/jquery-ui-1.11.4/jquery-ui.css" rel="stylesheet">
		<link href="includes/css/styles.css" rel="stylesheet">
		<!-- Include Modernizr in the head, before any other Javascript -->
		<script src="includes/js/modernizr-2.6.2.min.js"></script>
		<script src="includes/js/jquery.chained.min.js"></script>
		<script type="text/javascript" src="includes/js/bootstrapValidator.js"></script>
		
	</head>
	<title>At Home/In Community - Poppy</title>
	<body class="bodyTheme">


	<?php		
	
	// select all the questions from the database
	$sql = "SELECT * FROM question"; 
	$result = mysqli_query($conn, $sql)
	or die("Error: " .mysqli_error($conn));
	
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	
	if ($result = mysqli_query($conn, $sql))
	{
		$intTextNo = 0;
		$intTextAreaNo = 0;

		echo "<div class=\"container\" id=\"main\">"; ?>

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
				
				
				<?php 
				
				// if the user is logged in, show the logout button
				if ($_SESSION['username'])
				{ 
				?>
					<form action="logout.php" class="navbar-form pull-right" method="post">
						<div class="col-md-4 text-center">
						<button class = "btn btn-poppy" type="submit" name="logout" value="Logout">Logout <span class="badge">User: <?php echo $_SESSION['username']; ?></span></button>
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
		<?php

			echo "<div class=\"modal-dialog\">";
			echo "<div class=\"modal-content form-content\">";
			echo "<div class=\"modal-body\">";?>
			<form class="form col-md-12 center-block" id = "thirdForm" action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			<?php
			echo "<h2 class=\"text-center heading\">In Home & Community</h2>";
	
			// assign all the database variables to other php variables
			while ($row = mysqli_fetch_assoc($result))
			{
				$questionId = $row["question_id"]; 
				$questionText = $row["text"];
				$questionOrder = $row["question_order"];
				$questionOptions = $row["options"];
				$questionType = $row["type"];
				$surveyId = $row["survey_id"];
				$depOrder = $row["dependant_question_order"];
				$depValue = $row["dependant_value"];
				$parentId = $row["parent_question_id"];

				
				// if the question is apart of the appropriate survey
				if($surveyId == 3)
				{
					// explode the string options into an array for outputting through a loop 
					$strOptions = $questionOptions;
					$strDBentry = explode("#", $strOptions);

					// if question type is dropdownlist
					if ( (strcmp($questionType, 'dropdownlist') == 0) ) 
					{

						echo "<div class= \"form-group\">";
						echo "<h4 class = 'questionHeading'>$questionText</h4>";
	  					echo "<select id='$questionId' name='$questionId' class='form-control' required>";
	  					echo "<option value=\"\">--</option>";
						
						// output each individual option as a dropdownlist option
						for ($intI = 0; $intI < count($strDBentry); $intI++)
						{
							echo"<option value='$strDBentry[$intI]' class='$depValue'>$strDBentry[$intI]</option>";
						}
						echo "</select>";
						echo "<div class=\"alert alert-danger validate\" role=\"alert\" style=\"display:none\"></div>";
						echo "</div>";
					}
					// If the dropdown has a parent, link child dropdown to parent
					if($parentId > 0)
					{
						echo "<script type=\"text/JavaScript\">";
	
						echo "$(\"#\"+\"$questionId\").chained(\"#\"+\"$parentId\")";
					
						echo "</script>";
					}

					// if the question type is a slider
					if (strcmp($questionType, 'slider') == 0)
					{
						echo "<div class= \"form-group\">";
						echo "<h4 class = 'questionHeading'>$questionText</h4>";
							echo 		"<div class='form-group'>";
							echo			"<div class='slider' id='slider'></div>";
							echo            	"<input type='hidden' class='sliderInput' name='$questionId'>";
							echo        		"<label for='slider' class='sliderLabel'></label>";
						echo			"<output for='slider' class='sliderOutput' value = '' id='sliderOut'></output>";
							echo		"</div>";
						echo	"</div>";
					}
					
					// if the question type is text area
					if (strcmp($questionType, 'textarea') == 0)
					{

						echo "<div class= \"form-group\">";
						echo 	"<h4 class = 'questionHeading'>$questionText</h4>";
	  					echo	"<div class='row'>";
	  					echo		"<div class='col-lg-6'>";
	    				echo			"<div class='input-group divText'>";
	    				echo				"<input type='hidden' class='textInput' name='$questionId'>";
	      				echo				"<textarea type='text'  class='form-control textArea' placeholder='Desribe complications here..' row ='3'></textarea>";
	    				echo			"</div>";
	  					echo		"</div>";
	  					echo	"</div>";					
						echo "</div>";


					}
				}
		
			}

		}


		echo "<div class=\"form-group\">";
		echo  "<div class=\"col-md-4 text-center\">"; 
		echo		"<input class='btn btn-primary submit' name='submit' value='Submit' type='submit' />"; 
		echo	"</div>";
		echo "</div>";	
		echo "</form>";
		echo "<script type=\"text/JavaScript\">";
		echo "$(\"#\"+\"thirdForm\").validate()";
		echo "</script>";
		echo "</div>";
		echo "</div>";
		echo "</div>";
		echo "</div>";
		
		// close the SQL connection to the database
		require 'mysql-connection-close.php';
		}
	?>			
	</form>
	</div>


	<footer>
	</footer>


	<!-- If no online access, fallback to our hardcoded version of jQuery -->
	<script>window.jQuery || document.write('<script src="includes/js/jquery-1.8.2.min.js"><\/script>')</script>
	
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="includes/js/script.js"></script>




    </body>
</html>