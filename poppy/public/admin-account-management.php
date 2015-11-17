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

    <title>Adminstrator Change Password</title>

    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="bootstrap/css/admin.css" rel="stylesheet">

</head>
<title>Admin Account Management - Poppy Admin</title>
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
                        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Menu </a>
						<h2>Adminstrator Change Password</h2>
						
					<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
						
					<p>Enter new password:
					<input type="password" class="form-control" style="width: 200px" name="strNewPassword" id="strNewPassword" required /> 	
					</p>
					
					<p>Re-enter new password:
					<input type="password" class="form-control" style="width: 200px" name="strNewPasswordConfirm" id="strNewPasswordConfirm" required />					
					</p>
					
					<p>
					<input type="submit" class="btn btn-default" name="changePassword" id="changePassword" value="Change Password" />
					</p>
					
					</form>
					 	
					</div>	
					</div>
					
					

					<?php

				// if the form is submitted
				if (isset($_POST["changePassword"])) // form has been submitted
				{
					// open SQL connection to database
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
							
							// update the admin's password with the newly entered password
						 	$sql = "UPDATE user SET password = '$strEncryptedPassword' WHERE username = '$strUsername' ";
						 	mysqli_query($conn, $sql)
							or die ("Error: " .mysqli_error($conn));
						
							// alert user that password change is successful
						 	echo "<div> 
								<p><strong>Success! </strong>$strUsername's password has been changed.</p>
						 		</div>";
						 }
						
					}
					else
					{
						// alert if passwords do not match
						echo "<div> 
							<p><strong>Oops! </strong>Passwords entered do not match.</p>
							</div>";
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

    <!-- Menu Toggle-->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

</body>

</html>