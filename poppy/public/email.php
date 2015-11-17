
<?php
//  Configuration file for the email system required in add-user.php and forgot-password.php 
// 	Currently employs a default gmail client but can be change to whatever is necessary


require_once '../vendor/autoload.php';


require 'mysql-connection-open.php';

	$m = new PHPMailer;

	$m->isSMTP();
	$m->SMTPAuth = true;
	$m->IsHTML(true);
	//$m->SMTPDebug = 1;

	// Gmail SMTP
	$m->Host = 'smtp.gmail.com';
	// Username
	$m->Username = 'poppywsu@gmail.com';
	// Password
	$m->Password = 'poppypassword';
	// This depends on the mail server, currently it is set to gmail requirements
	$m->SMPTSecure = 'ssl';
	$m->Port = 587;

	// Who the email is from
	$m->From = 'poppywsu@gmail.com';
	// Name of the sender
	$m->FromName = 'WSU Poppy';
	// Reply to address
	$m->addReplyTo('poppywsu@gmail.com','Reply address');
	// Url of a link to the POPPY website e.g. http://www.poppy.uws.edu.au
	$url = "http://localhost:80/login.htm";
	//$m->addCC('poppywsu@gmail.com','WSU Poppy');
?>