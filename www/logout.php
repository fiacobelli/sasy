<?php # Script 11.11 - logout.php #2
 // This page lets the user logout.

 session_start(); // Access the existing session.

 // If no session variable exists, redirect the user:
 if (!isset($_SESSION['user_id'])) {

 require_once ('includes/login_functions.inc.php');
 $url = absolute_url();
 header("Location: $url");
 exit();

 } else { // Cancel the session.

 $_SESSION = array(); // Clear the variables. 
 session_destroy(); 
 // Destroy the session itself.
 setcookie ('PHPSESSID', '', time()-3600,
'/', '', 0, 0); // Destroy the cookie.

 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
 // Set the page title and include the HTML
header:
 $page_title = 'Logged Out!';
 ?>
<link href="content/colorbox.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700|Droid+Serif:400,700' rel='stylesheet' type='text/css'>
 <body>
 <div>
 <?php
echo("<meta http-equiv=\"Refresh\" content=\"2;url=index.php\" />");


 echo "<h1>Log out successful!</h1>
 <p>You are now logged out!</p>";
 ?>
 </div>
 </body>
 </html>