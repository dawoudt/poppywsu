<?php

require 'session-admin.php';

?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>View User</title>

    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="bootstrap/css/admin.css" rel="stylesheet">

</head>

<title>View User Data - Poppy Admin</title>

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
						<h2>Search User</h2>
						 </div>								
						<form class="navbar-form navbar-left" role="search" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">						
						<div class="form-group">					
						<input class="form-control" placeholder="Search User" type="text"  id="strUsername" name="strUsername" />	
						<input type="submit" name="view_user"  class="btn btn-default" id="view_user" value="Go" />				
						</form>
 		
					 </div>		
					 </div>		
 	
 
						<?php
						
						if (isset($_POST["view_user"])) // form has been submitted
						{
							$strUsername = $_POST["strUsername"];
							//open SQL connection to database
							require 'mysql-connection-open.php';
							
							//Select statement based on entry of the search box, check if that user is present in database
							$sql = "SELECT * FROM user WHERE username LIKE '%$strUsername%' AND admin = 0";
							
							$result = mysqli_query($conn, $sql)
							or die("Error: " .mysqli_error($conn));
							$rows = mysqli_num_rows($result);
							
							//if the user exist activate, as there is data for the user within the database
							if ($rows > 0)
							{								
								if ($result = mysqli_query($conn, $sql))								
								{   
									//Begin generating table
									echo "<div class='panel panel-default'>";
									echo "<table class='table'>";
									echo "<tr><td>User ID</td>";
									echo "<td>Username</td>";									
									echo "<td>Email</td>";									
									echo "<td>Survey Stage</td>";
									echo "<td>Last Login</td></tr>";
								
									//Populate the table with the user information
									while ($row = mysqli_fetch_assoc($result))
									{
										echo "<tr><td>" . $row["user_id"] . "</td>";
										echo "<td>" . $row["username"] . "</td>";										
										echo "<td>" . $row["email"] . "</td>";									
										echo "<td>" . $row["survey_stage"] . "</td>";
										echo "<td>" . $row["lastLogin"] . "</td></tr>";
									}
								echo "</table>","</div>";
								}
							}
							else 
							{
								//If user does not exist return error message of rechecking the input
								echo "<p>Please check your input for $strUsername</p>";
							}
							
							require 'mysql-connection-close.php';
						}
						
						//This section generates table of all users
						echo "<h2>All Users</h2>";
						
						$intUserId = $_SESSION['username'];
						require 'mysql-connection-open.php';
						
						//Selecting all users from the database, but not admin
						$sql = "SELECT * FROM user WHERE admin = 0";
						$result = mysqli_query($conn, $sql);
						$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
						
						
						if ($result = mysqli_query($conn, $sql))
						{	
							//Begin generating user table
							echo "<div class='panel panel-default'>";
							echo "<table class='table'>";
							echo "<tr><td>User ID</td>";
							echo "<td>Username</td>";							
							echo "<td>Email</td>";
							echo "<td>Survey Stage</td>";
							echo "<td>Last Login</td></tr>";
							
							//Begin populating the table with the data that has been grabbed form the user database
							while ($row = mysqli_fetch_assoc($result))
							{
								echo "<tr><td>" . $row["user_id"] . "</td>";
								echo "<td>" . $row["username"] . "</td>";								
								echo "<td>" . $row["email"] . "</td>";
								echo "<td>" . $row["survey_stage"] . "</td>";
								echo "<td>" . $row["lastLogin"] . "</td></tr>";
							}
							echo "</table>","</div>";
						}
						
						// close the SQL connection
						require 'mysql-connection-close.php';					
					
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
		


