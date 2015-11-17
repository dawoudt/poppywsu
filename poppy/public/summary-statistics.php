<?php
// admin only page
require 'session-admin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="widtd=device-widtd, initial-scale=1">
    <meta name="description" content="">
    <meta name="autdor" content="">

    <title>Summary Statistics</title>
	
    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="bootstrap/css/admin.css" rel="stylesheet">

</head>

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
				 
			
			<form action="logout.php" metdod="post">
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
								
						<a href="export.php" class="btn btn-default" > Export CSV</a>
						<h2>Summary Statistics</h2>					
					<?php
						//open SQL connection to database
						require 'mysql-connection-open.php';
						
						//Statement to count all inputs of every answer given by user, grouped by question_id and answer_text
						$sql = "SELECT COUNT(answer_id) AS answer_count, answer_text, question.question_id,question.question_order, question.parent_question_id,question.type, text FROM question
						JOIN answer ON answer.question_id = question.question_id
						GROUP BY answer.question_id, answer_text" ;

						$result = mysqli_query($conn, $sql)
						or die("Error: " .mysqli_error($conn));
					?>
									
					<div class="panel panel-default">
					
					<!-- Default panel contents -->
					<table class="table">

					<tr>
					<td>Question No.</td>
					<td>Question Text</td>
					<td>Answer</td>
					<td>Frequency</td>
					</tr>
					<?php while ($row = mysqli_fetch_assoc($result))
					{
						//IF the question is subquestion of previous activate
						if (strcmp($row["text"], '') == 0)
							{
								echo "<td>" . $row["question_order"] . "</td>";
								//Populate table cell to indicate its a subquestion
								echo "<td>Subquestion " . $row['question_order'] . "</td>";
								echo "<td>" . $row["answer_text"] . "<td>";
								echo $row["answer_count"] . "</td></tr>";
							}else
							{
								//Else populate table without sub question text if it is not a subquesiton
								echo "<td>" . $row["question_order"] . "</td>";	
								echo "<td>" . $row["text"] . "</td>";							
								echo "<td>" . $row["answer_text"] . "<td>";
								echo $row["answer_count"] . "</td></tr>";
							}											
					}
					?>
					</table>
					<?php
						// close the SQL connection
						require 'mysql-connection-close.php';				
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

    <!-- Menu Toggle -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

</body>
</html>


