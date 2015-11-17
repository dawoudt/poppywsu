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

    <title>Delete User</title>

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
                        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Menu</a>
						

					<h2>Delete User</h2>
				

					<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

					<?php

					// open the SQL connection to the database
					require 'mysql-connection-open.php';

					// display all users, but not other admins
					$sql = "SELECT username,admin FROM user WHERE admin = 0";
					$result = mysqli_query($conn, $sql)
					or die("Error: " .mysqli_error($conn));

					// if there is a non-admin user in the database
					if ($result = mysqli_query($conn, $sql))
					{
						$rows = mysqli_num_rows($result);
							
						if ($rows > 0)
						{
							// display a dropdownlist with all the users in the database
							echo "<p>Please select the user to delete: </p>";	
							echo "<select class='form-control' style='width: 140px' name='strUsername' id='strUsername'>";
						
							while ($row = mysqli_fetch_assoc($result))
							{
								if (strcmp($row[username],$_SESSION['username']) != 0)
								{
									echo "<option value='$row[username]'>$row[username]</option>";
								}
							}
						}
						else
						{
							echo "<p>There are no users in the database.</p>";
						}
						
						echo "</select></p>";
						echo "<input type='submit' class='btn btn-default' name='deleteUser' id='deleteUser' value='Delete User' />";
						
						// close the SQL connection
						require 'mysql-connection-close.php';
					}

					// if form is submitted
					if (isset($_POST["deleteUser"]))
					{
						// open the SQL connection to the database
						require 'mysql-connection-open.php';
						
						$strUsername = $_POST["strUsername"];
						
						// delete the username entered in the dropdownlist
						$sql = "DELETE FROM user WHERE username ='$strUsername'";
						$result = mysqli_query($conn, $sql)
						or die("Error: " .mysqli_error($conn));
							
						echo "<p>The account <strong>$strUsername</strong> has been deleted.</p>";
						
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
