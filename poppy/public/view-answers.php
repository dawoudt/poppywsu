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

    <title>View Answers</title>

    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	
    <!-- Custom CSS -->
    <link href="bootstrap/css/admin.css" rel="stylesheet">
							
</head>

<title>View Answer Data - Poppy Admin</title>

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
						<h2>Search by User and/or Question and/or Answer</h2>						
						 </div>								
										
						<form class="navbar-form navbar-left" role="search" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">								
						<input class="form-control" placeholder="Search User" type="text"  id="strUsername" name="strUsername" />	
						<input class="form-control" placeholder="Search Question" type="text"  id="searchQuestion" name="searchQuestion" />	
						<input class="form-control" placeholder="Search Answer" type="text"  id="searchAnswer" name="searchAnswer" />											
						<input type="submit" name="view_question"  class="btn btn-default" id="view_question" value="Go" />
						<a href="#" class="export">Export Table data into Excel</a>
						</div>	
						
 	
 
						<?php
						
						// if form has been submitted
						if (isset($_POST["view_question"])) 
						{
							//open SQL connection to database
							require 'mysql-connection-open.php';
								
							//Multiple search input can be user,question, and answer
							$searchQuestion = mysqli_real_escape_string($conn, $_POST["searchQuestion"]);
							$searchAnswer = mysqli_real_escape_string($conn, $_POST["searchAnswer"]);
							$strUsername = mysqli_real_escape_string($conn, $_POST["strUsername"]);
							
							if ($searchQuestion == NULL && $searchAnswer == NULL && $strUsername == NULL)
							{
								echo "<p>Please enter a search input.</p>";
							}
							else
							{
							
							
							//Statement that grabs all answers based on search input whether its user,question, answer and then orders it by time/date and question_order
							$sql = "SELECT answer.submit_time,user.username,question.question_id, question.text, question.question_order, answer.user_id, answer.answer_text
							FROM question
							JOIN answer ON answer.question_id = question.question_id
							JOIN user ON user.user_id=answer.user_id
							WHERE answer.question_id = question.question_id AND question.text LIKE '%$searchQuestion%' AND answer.answer_text LIKE '%$searchAnswer%'
							AND username LIKE '%$strUsername%'
							ORDER BY answer.submit_time DESC, question.question_order ASC";

							$result = mysqli_query($conn, $sql)
							or die("Error: " .mysqli_error($conn));

							$rows = mysqli_num_rows($result);
							
							//If search input exist within the database
							if ($rows > 0)
							{								
								if ($result = mysqli_query($conn, $sql))								
								{   							
									//Begin generating the table
									echo "<div class='panel panel-default'>";
									echo "<div class=\"table-responsive\" id='dvData'>";								
									echo "<table class='table'>";									
									echo "<tr><td>Question No.</td>";
									echo "<td>Question Text</td>";
									echo "<td>Answer Text</td>";
									echo "<td>Username</td>";
									echo "<td>Date</td>";
									echo "<td>Time</td><tr>";
									
								
									while ($row = mysqli_fetch_assoc($result))
									{	
										//Formating the time
										//Then begin populating table with data from database 
										$date = date('j/n/Y',strtotime($row["submit_time"]));
										$time = date('H:i:s',strtotime($row["submit_time"]));
										echo "<tr>";										
										echo "<td>" . $row["question_order"] . "</td>";
										
										//IF the question is subquestion of previous activate
										if (strcmp($row["text"], '') == 0)
										{
											//Populate table cell to indicate its a subquestion
											echo "<td>Subquestion " . $row['question_order'] . "</td>";
										}
										else
										{
											echo "<td>" . $row["text"] . "</td>";
										}
										
										echo "<td>" . $row["answer_text"] . "</td>";
										echo "<td>" . $row["username"] . "</td>";
										echo "<td>$date</td>";	
										echo "<td>$time</td></tr>";
										
										}
								echo "</table></div>";
								}
							}
							else
							{
								//Error message to be displayed if the search input does not exist
								echo "<p>Could not find that entry</p>";
							}	
							// close the SQL connection							
							require 'mysql-connection-close.php';
							}
						}

						?>
				</div>
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
	<script src="includes/js/script.js"></script>
	<!--<script src="includes/js/jquery.table2excel.js"></script>-->

    <!-- Menu Toggle-->
    <script>
   $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });	
    </script>
	
</body>
</html>
