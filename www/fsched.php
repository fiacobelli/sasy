<?php
 require_once ('mysql_connect.php');
# Script 11.9 - loggedin.php #2
// The user is redirected here from login.php.
session_start();// Start the session.
// If no session value is present,redirect the user:
if (!isset($_SESSION['user_id'])){
require_once ('includes/login_functions.inc.php');
$url = absolute_url();
header("Location: $url");
exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Faculty Scheduling</title>
<link rel = "stylesheet" type = "text/css" 
    href = "style.css" />
    <div class = "menu">Site Menu
	<a href = "main.php">Home</a>
	<a href = "fsched.php">Faculty Schedule</a>
    <a href = "apptlist.php">Appointment Management</a>
    <a href = "advising.php">Student Advising</a>
    <?php
	if($user <1999)
	echo("<a href = \"course_sched/main_menu.php\">Course Management</a>");
	?>
    <a href = "enrollment.html">Student Enrollment</a>
    <a href = "logout.php">Log Out</a>
    
</div>   
    
<script type="text/javascript">
<!--
function test()
{
var currentTime = new Date();
var year = currentTime.getFullYear();
var month = currentTime.getMonth() + 1;
document.forms.autopop['submityear'].value = year;
document.forms.autopop['submitmonth'].value = month;
document.forms.autopop['clicked'].value = 0;
document.forms.autopop['selectdate'].value = currentTime;
document.forms["autopop"].submit();
}
//-->
</script>
</head>
<body>
<div align="center">
<h2>Faculty Scheduling</h2>
</div>
<div>
<form id="autopop" action="hours.php" method="post">
<input type="hidden" name="submitmonth" value =""/>
<input type="hidden" name="submityear" value =""/>
<input type="hidden" name="clicked" value ="0"/>
<input type="hidden" name="selectdate" value = ""/>
<input type ="hidden" name="teacher" value = '*'>
</form>
</div>
<script type="text/javascript">
<!--
test();
// -->
</script>
</body>
</html>
