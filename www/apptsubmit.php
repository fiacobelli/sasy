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
$fname=$_POST['Purpose'];
$lname=$_POST['Note'];
$sid=$_POST['studentid'];
$continue=0;
$today =  date('Y-m-d');
$student="";
$faculty="";
?>


<html>

<body>
 <script type="text/javascript">
function closewindow()
{
<?php 
echo "window.location = 'student.php?q=".$_POST['studentid']."';";
?>
}
</script>

<?php
$q1="INSERT INTO appts (sid,fid,start_date,end_date,start_time,stop_time,description,status) VALUES ('".$_POST['studentid']."','".$_SESSION['user_id']."','".$today."','".$today."',CURTIME(),'".$_POST['time']."','".$_POST['Purpose']."',2)";

$results1 = @mysql_query ($q1);
if($results1)
{
	
	$lookup = "select apptid,TIME_FORMAT(start_time,'%H:%i %p') as start_time from appts where sid='".$_POST['studentid']."' and fid ='".$_SESSION['user_id']."' and start_date = '".$today."' and stop_time='".$_POST['time']."'";
	$results2 = @mysql_query ($lookup);
		if (@mysql_num_rows($results2) !=0) 
		{//open php rows if
			while ($row1 = @mysql_fetch_assoc($results2))
			{//open php while
			$time = $row1['start_time'];
			$newaptid = $row1['apptid'];
			}//close php while
		}//close php rows if

	$createnote = "INSERT INTO apptnote (apptid,date,time,fid,note) values ('".$newaptid."','".$today."','".$time."','".$_SESSION['user_id']."','".$_POST['Note']."')";
	$results3 = @mysql_query ($createnote);
	if($results3)
		{
			
		echo "<div align='center'><h3>new appointment created</h3>";
		echo"Appointment #".$newaptid." has been created.";
		//echo'<input name="Continue" type="button" value="Continue" onclick= "closewindow()" /></div>';
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
/*
}//close continue if
*/
$sem="select email from users where user_id ='".$_POST['studentid']."'";
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
$purpose=$_POST['Purpose'];
$note=$_POST['Note'];
$subject = "New advisement appointment";
$body = "Appointment number ".$newaptid." has been created for you with ".$first." ".$last.".\n\nPurpose: ".$purpose."\n\n".$today." ".$time."\n\n Note: ".$note;
sendmail();

?>
 <script type="text/javascript">
 closewindow();
 </script>
</body>
</html>