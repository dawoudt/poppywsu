
<?php
	//Header to specify the type of file in this case csv
	header('Content-Type: text/csv');
	//Specify the filename export.csv
	header('Content-Disposition: attachment; filename="export.csv"');
	
	// admin only page
	require 'session-admin.php';
	require 'mysql-connection-open.php';
	
	//Begin populating the table
	echo "Question No. " . ',' . "Question Text" . ',' . "Answer Given" . ',' .  "Frequency \n";

	//Statement to count all inputs of every answer given by user, grouped by question_id and answer_text
	$sql = "SELECT COUNT(answer_id) AS answer_count, answer_text, question.question_id,question.question_order, question.parent_question_id,question.type, text FROM question
			JOIN answer ON answer.question_id = question.question_id
			GROUP BY answer.question_id, answer_text";

		$result = mysqli_query($conn, $sql)
		or die("Error: " .mysqli_error($conn));
		//$row = mysqli_fetch_array($result, MYSQLI_ASSOC);


	while ($row = mysqli_fetch_assoc($result))
	{
		//IF the question is subquestion of previous activate
		if (strcmp($row["text"], '') == 0)
		{
			//Begin populating the cells of CSV with , delimeter including subquestion text
			echo $row["question_order"] . ',' . "Subquestion" . $row['question_order'] . ',' . $row['answer_text'] . ',' . $row['answer_count'] . "\n";
		}	
		else
		{
			//Else populate table without sub question text if it is not a subquesiton
			echo $row["question_order"]. ',' . $row['text'] . ',' . $row['answer_text'] . ',' . $row['answer_count'] . "\n"; 
		}
	}	
	// close the SQL connection							
	require 'mysql-connection-close.php';
?>