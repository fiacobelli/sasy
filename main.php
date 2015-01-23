<?php
//This page requires mysql_connect.php
/*Users are redirected here after a successful login. the welcome is displayed
and then the users is redirected to begin.php
*/

require_once ('mysql_connect.php');


session_start(); // Start the session.

// If no session value is present,redirect the user:
	if (!isset($_SESSION['user_id'])) 
	{
		require_once ('includes/login_functions.inc.php');
		$url = absolute_url();
		header("Location: $url");
		exit();
	}
//set $user to be the session user id
$user = $_SESSION['user_id'];
//create search for users first name based on the user_id
$q1="select First_Name, user_type from users,Logins where Logins.user_id = users.user_id and users.user_id= $user";

$r1 = @mysql_query ($q1);
if (@mysql_num_rows($r1) !=0) 
{//open php rows if
	while ($row1 = @mysql_fetch_assoc($r1))
	{//open php while
		$name = $row1['First_Name'];
		$u_type = $row1['user_type'];

		$_SESSION['f_name']=$name;
		$_SESSION['u_type']=$u_type;
		//check the user type returned by the search, if users is a student, set start=1 and redirect to student.php
		//if users is admin or faculty, redirect to begin.php
		if ($u_type == 3)
		{
			$_SESSION['stu_id']=$user;
			$meta = '<meta http-equiv="Refresh" content="3;url=student.php?q='.$_SESSION["user_id"].'&start=1" />';
		}
		else
		if ($u_type == 1)
		{
			$_SESSION['stu_id']=0;
			$meta = '<meta http-equiv="Refresh" content="3;url=begin.php" />';
		}
		else
		if ($u_type == 2)
		{
			$_SESSION['stu_id']=0;
			$meta = '<meta http-equiv="Refresh" content="3;url=begin.php" />';
		}
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="content/colorbox.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700|Droid+Serif:400,700' rel='stylesheet' type='text/css'>
<?php
//print the meta html tag created when checking user type 
echo $meta;
?>

<div align="center">
<?php
//print welcome with users name
echo ("<h3>Welcome to the Student Advisement System {$_SESSION['f_name']}.</h3>");
?>
<p>Please remember to log out of the system when finished.</p>
<p>Report all issues to the site administrator.</p>
</body>
</html>
