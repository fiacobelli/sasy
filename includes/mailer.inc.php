<?php
/*
This file is inclued in pages that send emails to faculty and students when appointements are created or closed or new user accounts are created.

*/
require_once "Mail.php";
//create mail send function
function sendmail()
{
	//bring in global variables that will be used by the pages that include this file
	global $faculty,$student,$subject,$body;
    $from = "student-advisement@neiu.edu";
    //create to list using faculty and student global variables
	$to = $faculty.','.$student;
	//create boy of email using body global variable and attach automated system disclaimer
    $body = $body."\n\n\nDo NOT reply to this email.\nThis is an automated system and replies will not be read.";
	//set host and port info
    $host = "smtp.neiu.edu";
    $port = "25";
	//create headers
    $headers = array ('From' => $from,'To' => $to,'Subject' => $subject);
	$smtp = Mail::factory('smtp',array ('host' => $host,'port' => $port,'auth' => false,));
	$mail = $smtp->send($to, $headers, $body);

    if (PEAR::isError($mail)) 
	{
		echo("<p>" . $mail->getMessage() . "</p>");
	} 
	else 
	{
		echo("<p>Message successfully sent!</p>");
	}

}
?>
