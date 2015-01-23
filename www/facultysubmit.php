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
include ('includes/mailer.inc.php');


$_POST['updateid'];
$_POST['fname'];
$_POST['lname'];
$_POST['phone'];
$_POST['email'];
$_POST['office'];
$_POST['password'];
$_POST['uname'];


$person=$_POST['updateid'];
$fname=$_POST['fname'];
$lname=$_POST['lname'];
$phone=$_POST['phone'];
$email=$_POST['email'];
$office=$_POST['office'];
$pwd=$_POST['password'];
$username=$POST['uname'];
$type=1;
$continue=0;




echo '<html>

<body>';
?>
 <script type="text/javascript">
function closewindow()
{
window.location = 'begin.php';
}
</script>
<?php

$dup = "select * from users where First_Name = '".$_POST['fname']."' and Last_Name = '".$_POST['lname']."' and phone = '".$_POST['phone']."'and email = '".$_POST['email']."'";
	$r = @mysql_query ($dup);
		if (@mysql_num_rows($r) !=0) 
		{//open php rows if
			while ($row1 = @mysql_fetch_assoc($r))
			{//open php while
			echo "<h3 align='center'>User ".$_POST['fname']." ".$_POST['lname']." already exists</h3>";
			echo '<div align="center"><FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"></FORM></div>';
			$continue = 0;
			}//close php while
		}//close php rows if
		else
		{
			$continue = 1;
		}
if($continue ==1)
{//continue if
$q1="INSERT INTO users (user_id,First_Name, Last_Name,Add2,phone, email) VALUES ('".$_POST['idn']."','".$_POST['fname']."','".$_POST['lname']."','".$office."','".$phone."','".$_POST['email']."')";

$results1 = @mysql_query ($q1);
if($results1)
{
	$lookup = "select user_id from users where First_Name = '".$_POST['fname']."' and Last_Name = '".$_POST['lname']."' and phone = '".$_POST['phone']."'and email = '".$_POST['email']."'";
	$results2 = @mysql_query ($lookup);
		if (@mysql_num_rows($results2) !=0) 
		{//open php rows if
			while ($row1 = @mysql_fetch_assoc($results2))
			{//open php while
			$newid = $row1['user_id'];
			}//close php while
		}//close php rows if

	$createLogin = "INSERT INTO Logins (user_id,username,pwd,user_type) values ('".$_POST['idn']."','".$_POST['uname']."','".$_POST['password']."','".$type."')";
	$results3 = @mysql_query ($createLogin);
	if($results3)
		{
		echo "<div align='center'><h3>new faculty member created</h3>";
		echo"New user id ".$newid." has been created for ".$_POST['fname']." ".$lname=$_POST['lname'].".";
		echo'<input name="Continue" type="button" value="Continue" onclick= "closewindow()" /></div>';
		}
		else
		{
 		echo "<h3> Update Failure</h3>";  
		echo $qry;
		echo	@mysql_error(); 
		}

}
else
{
 echo "<h3> Update Failure</h3>";  
echo $qry;
echo	@mysql_error(); 
}
}//close continue if
$subject = "New user account created";
$body = "Your account for the Student Advisement System has been created. Your user name is ".$_POST['uname'].".";
$faculty = $_POST['email'];
sendmail();
?>
<script type="text/javascript">
 closewindow();
 </script>
</body>
</html>