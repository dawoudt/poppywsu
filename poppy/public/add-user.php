<?php 

// admin only page
require 'session-admin.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Add User</title>

    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="bootstrap/css/admin.css" rel="stylesheet">

</head>

<title>Add User - Poppy Admin</title>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                    <li class="sidebar-brand">
                    <a href="admin-section.php">Administration Section</a>
                </li>              
                <li>
                    <a href="add-user.php">Add Users</a>
                </li>
                <li>
                    <a href="delete-user.php">Delete Users</a>
                </li>
                <li>
                   <a href="view-users.php">View User Data</a>
                </li>
				<li>
                   <a href="view-answers.php">View Answer Data</a>
                </li>
				<li>
                   <a href="summary-statistics.php">Summary Statistics</a>
                </li>
				<li>
                   <a href="admin-account-management.php">Admin Account Management</a>
                </li>

			<form action="logout.php" method="post">
			<p>
			<button type="submit" name="logout" value="Logout">Logout</button>
			</p>
			</form>
	
			
                
            </ul>
        </div>
		
		
 <!-- /#sidebar-wrapper -->
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">                  
                        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Menu</a>
						
              
					<h2>Add User</h2>

					<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

					<p>Enter Username: 
					<input type="text" class="form-control" style="width: 200px" name="strUsername" id="strUsername" value="<?php if (isset($_POST['strUsername'])){ echo htmlspecialchars($_POST['strUsername']);} ?>" />
					</p>

					<p>Enter User's Email:
					<input type="text" class="form-control" style="width: 200px"name="strUserEmail" id="strUserEmail" value="<?php if (isset($_POST['strUserEmail'])){ echo htmlspecialchars($_POST['strUserEmail']);} ?>" />
					</p>

					<p>
					<input type="submit" class="btn btn-default" name="addUser" id="addUser" value="Insert User" />
					</p>

					</form>

					<?php 

					// if the form is submitted
					if (isset($_POST["addUser"]))
					{
						// open SQL connection to database
						require 'mysql-connection-open.php';
						
						// form is valid unless one of the invalid statuses are triggered
						$formValid = true;
						// remove all SQL injection capable characters from the input
						$strUsername = mysqli_real_escape_string($conn, $_POST["strUsername"]);
						$email = $_POST["strUserEmail"];
						$strUserEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
						
						// if username was not entered
						if ($strUsername == NULL)
						{
							echo "<p>Username was not entered</p>";
							$formValid = false;
						}
						else 
						{
							// check to see if the username entered already exists in database
							$sql = "SELECT * FROM user WHERE username = '$strUsername'";
							$result = mysqli_query($conn, $sql)
							or die("Error: " . mysqli_error($conn));
							$rows = mysqli_num_rows($result);
						
							// if username entered matches username in database
							if (mysqli_num_rows($result) > 0)
							{
								echo "<p>Username $strUsername already exists.</p>";
								$formValid = false;
							}
						}
						
						// check to see if the email entered already exists in the database
						$sql = "SELECT * FROM user WHERE email = '$strUserEmail'";
						$result = mysqli_query($conn, $sql)
						or die("Error: " .mysqli_error($conn));
						
						// if email entered matches email stored in database
						if (mysqli_num_rows($result) > 0)
						{
							echo "<p>Email $strUserEmail already exists.</p>";
							$formValid = false;
						}
						
						// validate the email, and filter out any illegal characters
						if ($strUserEmail == NULL)
						{
							echo "<p>Email was not entered</p>";
							$formValid = false;
						}
						else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
						{
							echo "<p>Incorrect email format.</p>";
							$formValid = false;
						}

						// if the form is valid, and passes all validation checks
						if ($formValid)
						{
							// create a random password for the user, and store it in a string
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
							
							// generate the random password, encrypt it and insert it into the database (when creating the user)
							$strGeneratedPassword = generate_password();
							$strEncryptedPassword = crypt($strGeneratedPassword, '$6$rounds=5000$poppysaltforpass$');
							$sql = "INSERT INTO user VALUES ('','$strUsername', '$strEncryptedPassword','$strUserEmail', '0','Introduction', '0000-00-00')";
							$result = mysqli_query($conn, $sql)
							or die("Error: " .mysqli_error($conn));
							
							require 'email.php';

							$m->addAddress($strUserEmail, $strUsername);
							$m->Subject = 'Welcome to POPPY!';
							$m->Body = "<p>Here are your login details to access the POPPY website: </p>";
							$m->Body .= "<p><strong>Username:</strong> $strUsername";
							$m->Body .= "<p><strong>Password:</strong> $strGeneratedPassword";
							$m->Body .= "<p>Follow this link ". $url . " and sign in with your username and password";
							$m->Body .= "<p>Remember to change your password after intial login</p>";
							
							
		 					$m->altBody = "Here are your login details to access the POPPY website: ";
		 					$m->altBody .= "Username: $strUsername";
		 					$m->altBody .= "Password: $strGeneratedPassword";
		 					$m->altBody .= "Follow this link ". $url . " and sign in with your username and password";
		 					$m->altBody .= "<p>Remember to change your password after intial login</p>";
		 					
							// if the mail is successfully sent
							if($m->Send()) 
							{
								echo "<p><strong>Success!</strong> User $strUsername created.</p>";
								echo "<p>Email sent to <strong>$strUsername</strong> at <strong>$strUserEmail</strong> with login credentials.</p>";
								// echo "<p>User's password: $strGeneratedPassword</p>";
							}
						}
						// close the SQL connection
						require 'mysql-connection-close.php';
					}

					?>

                </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="bootstrap/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Menu Toggle -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
</body>
</html>