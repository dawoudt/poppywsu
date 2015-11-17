<?php

// Configuration file for notification system
// Cron is run daily and execute wget on this file.
// Once executed, it checks database for users out side of the required period 
// for filling out a form, then send them an email notifying them of the form that
// needs to be filled. 
require_once '../vendor/autoload.php';

require 'mysql-connection-open.php';

// grap all users
$sql = "SELECT * FROM user ";
$result = mysqli_query($conn, $sql)
or die("Error: " .mysqli_error($conn));

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

if ($result = mysqli_query($conn, $sql))
{
	while ($row = mysqli_fetch_assoc($result))
	{	
							
		if ($rowCount = mysqli_num_rows($result) > 0)
		{
			$strUserId = $row["user_id"];
			$strUsername = $row["username"];
			$intIsAdmin = $row["admin"];
			$_SESSION["admin"]= $intIsAdmin;
			$lastLoginDate = $row["lastLogin"];
			$surveyStage = $row["survey_stage"];
			$email = $row["email"];
			
			// if user is not an admin
			if ($intIsAdmin == 0)
			{
				// if user is at the hospital stafe
				if ($surveyStage == 'Hospital')
				{
					// if user has not filled out form in the last 3 days and logged in at least once
					if (strtotime($lastLoginDate) < strtotime('-3 days') && strtotime($lastLoginDate) != strtotime('0000-00-00') )
					{	 
						sendEmail($strUsername, $surveyStage, $email);
					}
				}
				// if user is at the home and community stage
				if ($surveyStage == 'HomeAndCommunity')
				{
					// if user has not filled out form in the last 7 and logged in at least once
					if (strtotime($lastLoginDate) < strtotime('-1 week') && strtotime($lastLoginDate) != strtotime('0000-00-00') )
					{	 
						sendEmail($strUsername, $surveyStage, $email);
					}
				}
				
			}
		}
	}
}
require 'mysql-connection-close.php';	

// this function is called when checking form section

function sendEmail($username, $surveyStage, $email){

	$m = new PHPMailer;

	$m->isSMTP();
	$m->SMTPAuth = true;
	$m->IsHTML(true);
	//$m->SMTPDebug = 1;


	// this is dummy information for a gmail account used for testing purposes
	// the gmail is not owned by us and can be utilised by the clients if they wish
	// else they can just change the following details to their respecitve email service
	$m->Host = 'smtp.gmail.com';
	$m->Username = 'poppywsu@gmail.com';
	$m->Password = 'poppypassword';

	// This may need to be removed or modified depending on the clients choice of mail service. 
	$m->SMPTSecure = 'ssl';
	$m->Port = 587;

	$m->From = 'poppywsu@gmail.com';
	$m->FromName = 'WSU Poppy';
	$m->addReplyTo('poppywsu@gmail.com','Reply address');
	$m->addAddress($email, $username);
	$url = "http://localhost:80/login.htm";
	//$m->addCC('poppywsu@gmail.com','WSU Poppy');



	// This is the messages that are sent in the email 
	if ($surveyStage == 'Hospital')
	{
		$m->Subject = 'Hi, ' .$username .'. Its been a while';
		$m->Body = '<p>Weve noticed that you havent filled the '. $surveyStage . ' form in over 3 days</p><p> Please follow this link to use Poppy: '.$url . '</p>';
		$m->altBody = 'Weve noticed that you havent filled the '. $surveyStage . ' form in over 3 days. Please follow this link to use Poppy: '.$url;
		
		if($m->Send()) {
		echo "Message sent!";
		}

	}
	else if ($surveyStage == 'HomeAndCommunity')
	{
		$m->Subject = 'Hi, ' .$username .'. Its been a while';
		$m->Body = '<p>Weve noticed that you havent filled the '. $surveyStage . ' form in over a week </p><p> Please follow this link: '.$url . '</p>';
		$m->altBody = 'Weve noticed that you havent filled the '. $surveyStage . ' form in over a week \n Please follow this link: '.$url . '';
		
		if($m->Send()) {
		echo "Message sent!";
		}
	}
	else
		return;

}

