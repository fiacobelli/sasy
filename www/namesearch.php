<?php
 require_once ('mysql_connect.php');
# Script 11.9 - loggedin.php #2
// The user is redirected here from login.php.
session_start(); // Start the session.
// If no session value is present,redirect the user:
if (!isset($_SESSION['user_id'])) {
require_once ('includes/login_functions.inc.php');
$url = absolute_url();
header("Location: $url");
exit();
}
include ('includes/list_file.inc.php');
//livesearch is used to search the database based off of the search string entered into the search boxes.  when the function calls liveserach, the appropriate search is run depending onthe variables passed and then returned back.


//get the q parameter from URL for search value
$name=$_GET["name"];
$id=$_GET['idn'];
$idtrim = ltrim($id, "0");

//initialize hint to be blank.
$hint="";
if(isset($name))
{
$q1="select username from Logins where username = '".$name."'";
		$r1 = @mysql_query ($q1);
	if (@mysql_num_rows($r1) !=0) 
	{//open php rows if
		$hint='<o>Name already in use</o>';
	}
	else
	{
	$hint = '';
	}
}
if(isset($id))
{
$q1="select user_id from Logins where user_id = '".$id."'";
		$r1 = @mysql_query ($q1);
	if (@mysql_num_rows($r1) !=0) 
	{//open php rows if
		$hint='<o>ID already in use</o>';
	}
	else
	{
	$hint = '';
	}
}
$response=$hint;
 

//output the response
//if ($goAhead>1)
//{
echo $response;

//}

?>
