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

$fname=$_POST['Purpose'];
$lname=$_POST['Note'];
$appid=$_POST['appid'];
$sid=$_POST['sid'];
$continue=0;
$today =  date('Y-m-d');
?>
<html>
<body>
 <script type="text/javascript">
function closewindow()
{
<?php 
echo "window.location = 'student.php?q=".$_POST['sid']."&a=".$appid."';";
?>
}
</script>
<?php

$createnote = "INSERT INTO apptnote (apptid,date,time,fid,note) values (".$appid.",'".$today."',CURTIME(),'".$_SESSION['user_id']."','".$_POST['Note']."')";
	$results3 = @mysql_query ($createnote);
	if($results3)
		{
			echo"<div align='center'><h3>Updating</h3></div>";


		}
		else
		{
 		echo "<h3> Update Failure</h3>";  
		echo $qry;
		echo	@mysql_error(); 
		}
		
?>
 <script type="text/javascript">
 closewindow();
 </script>
</body>
</html>