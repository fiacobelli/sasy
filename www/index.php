<?php 
//This pages requires login_functions.inc.php, mysql_connect.php
//This page includes login_page.inc.php
//uses colorbox.css

/*
This function checks if the login form was submitted,
it then tests the user id and password and either redirects the users to main.php
or it outputs login errors
*/
if (isset($_POST['submitted']))
{
	require_once ('includes/login_functions.inc.php');
	require_once ('mysql_connect.php');
	list ($check, $data) = check_login($_POST['uid'], $_POST['pass']);
		if ($check)
		{// OK!
			session_start();
			// Set the session data:.
			//init_set('session.gc_maxlifetime','3600');
			$_SESSION['id'] = $data['user_id'];
			$_SESSION['user_id'] = $data['user_id'];
			if ($data['user_type']== 1);
				$_SESSION['admin'] = 'true';
			// Redirect:
			$url = absolute_url ('main.php');
			header("Location: $url");
			exit();
		} else 
		{ // Unsuccessful!
			$errors = $data;
		}
} // End of the main submit conditional.
//include login page
include ('includes/login_page.inc.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="content/colorbox.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700|Droid+Serif:400,700' rel='stylesheet' type='text/css'>
</head>
<body>
<title>S.A.Sy</title>

</body>
</html>