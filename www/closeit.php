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
$apptid=$_POST['apptid'];
$sid=$_POST['sid'];
include ('includes/mailer.inc.php');
?>


<html>

<body>

<?php

$d1=("update appts set status =3 where apptid =".$_POST['apptid']);
$results1 = @mysql_query ($d1);
$d2=("select description from appts where apptid =".$_POST['apptid']);
$results2 = @mysql_query ($d2);
if (@mysql_num_rows($results2) !=0)
{
	while ($prow = @mysql_fetch_assoc($results2))
	{
		$purpose=$prow['description'];
	}
}
/*if($results1)
{

		echo "<div align='center'><h3>Appointment Close Notification</h3>";
		echo"Appointment #".$_POST['apptid']." has been closed.";
		echo'<input name="Continue" type="button" value="Continue" onclick= "closewindow()" /></div>';
		}
		else
		{
 		echo "<h3> Update Failure</h3>";  
		echo $qry;
		echo	@mysql_error(); 
		}
		*/
$sem="select email from users where user_id ='".$_POST['sid']."'";
$semresults = @mysql_query ($sem);
if (@mysql_num_rows($semresults) !=0)
{
	while ($row1 = @mysql_fetch_assoc($semresults))
			{//open php while
			$student = $row1['email'];
			}//close php while
}
$sem="select * from users where user_id ='".$_SESSION['user_id']."'";
$semresults = @mysql_query ($sem);
if (@mysql_num_rows($semresults) !=0)
{
	while ($row1 = @mysql_fetch_assoc($semresults))
			{//open php while
			$faculty = $row1['email'];
			$first =  $row1['First_Name'];
			$last =  $row1['Last_Name'];
			}//close php while
}

$q2="select * ,TIME_FORMAT(time,'%h:%i %p') as time from apptnote where apptid = '".$_POST['apptid']."' order by date desc, time desc";
$note='';
$r2 = @mysql_query ($q2);
		if (@mysql_num_rows($r2) !=0) 
			{//open php rows if 2
			while ($row2 = @mysql_fetch_assoc($r2))
				{//open php while 2
				$note=$note.$row2['date']."  ".$row2['time']."\nNote: ".$row2['note']."\n\n";
				}//close php while 2
			}//close php rows if 2
$subject = "Advisement appointment closed";
$body = "Appointment number ".$_POST['apptid']." has been closed.\n\nPurpose: ".$purpose."\n\n".$note;
sendmail();

?>

 <script type="text/javascript">

<?php 
echo "window.location = 'student.php?q=".$_POST['sid']."';";
?>

</script>

</body>
</html>