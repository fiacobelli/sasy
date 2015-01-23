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
?><html>
 <script type="text/javascript">
function closewindow()
{
window.location = 'begin.php';
}
</script>
<body>
<?php 
$_POST['semester'];
$semester = $_POST['semester'];
if ($semester ==1)
{
	$startdate = date("Y-m-d",mktime(0, 0, 0, 1, 2, 2012));
	$enddate = date("Y-m-d",mktime(0, 0, 0, 5, 16, 2012));
}
if ($semester ==2)
{
$startdate = date("Y-m-d",mktime(0, 0, 0, 5, 23, 2012));
$enddate = date("Y-m-d",mktime(0, 0, 0, 8, 16, 2012));
}


$teacher = $_POST['teachid'];
$_POST['Sundaystart'];
$_POST['Sundaystop'];
$_POST['Mondaystart'];
$_POST['Mondaystop'];
$_POST['Tuesdaystart'];
$_POST['Tuesdaystop'];
$_POST['Wednesdaystart'];
$_POST['Wednesdaystop'];
$_POST['Thursdaystart'];
$_POST['Thursdaystop'];
$_POST['Fridaystart'];
$_POST['Fridaystop'];
$_POST['Saturdaystart'];
$_POST['Saturdaystop'];
$q1="select * from sched where fid = $teacher and category = 1 and semcode = $semester";
$r1 = @mysql_query ($q1);
if (@mysql_num_rows($r1) !=0)
{
$d1=("update sched set start_time ='" . $_POST['Sundaystart'] . "' ,stop_time = '" . $_POST['Sundaystop'] . "' where day = '0' and fid = '" . $_POST['teachid'] . "' and semcode = $semester");

$d2=("update sched set start_time ='" . $_POST['Mondaystart'] . "' ,stop_time = '" . $_POST['Mondaystop'] . "' where day = '1' and fid = '" . $_POST['teachid'] . "' and semcode = $semester");

$d3=("update sched set start_time ='" . $_POST['Tuesdaystart'] . "' ,stop_time = '" . $_POST['Tuesdaystop'] . "' where day = '2' and fid = '" . $_POST['teachid'] . "' and semcode = $semester");

$d4=("update sched set start_time ='" . $_POST['Wednesdaystart'] . "' ,stop_time = '" . $_POST['Wednesdaystop'] . "' where day = '3' and fid = '" . $_POST['teachid'] . "' and semcode = $semester");

$d5=("update sched set start_time ='" . $_POST['Thursdaystart'] . "' ,stop_time = '" . $_POST['Thursdaystop'] . "' where day = '4' and fid = '" . $_POST['teachid'] . "' and semcode = $semester");

$d6=("update sched set start_time ='" . $_POST['Fridaystart'] . "' ,stop_time = '" . $_POST['Fridaystop'] . "' where day = '5' and fid = '" . $_POST['teachid'] . "' and semcode = $semester");

$d7=("update sched set start_time ='" . $_POST['Saturdaystart'] . "' ,stop_time = '" . $_POST['Saturdaystop'] . "' where day = '6' and fid = '" . $_POST['teachid'] . "' and semcode = $semester");

}
else
{
$d1=("insert into sched (fid,start_date,end_date,start_time,stop_time,day,category,semcode,status) values ('" . $_POST['teachid'] . "', '" . $startdate . "', '" . $enddate . "', '" . $_POST['Sundaystart'] . "', '" . $_POST['Sundaystop'] . "', '" . 0 . "', '" . 1 . "', '" . $_POST['semester'] . "', '" . 1 . "');");
$d2=("insert into sched (fid,start_date,end_date,start_time,stop_time,day,category,semcode,status) values ('" . $_POST['teachid'] . "', '" . $startdate . "', '" . $enddate . "', '" . $_POST['Mondaystart'] . "', '" . $_POST['Mondaystop'] . "', '" . 1 . "', '" . 1 . "', '" . $_POST['semester'] . "', '" . 1 . "');");
$d3=("insert into sched (fid,start_date,end_date,start_time,stop_time,day,category,semcode,status) values ('" . $_POST['teachid'] . "', '" . $startdate . "', '" . $enddate . "', '" . $_POST['Tuesdaystart'] . "', '" . $_POST['Tuesdaystop'] . "', '" . 2 . "', '" . 1 . "', '" . $_POST['semester'] . "', '" . 1 . "');");
$d4=("insert into sched (fid,start_date,end_date,start_time,stop_time,day,category,semcode,status) values ('" . $_POST['teachid'] . "', '" . $startdate . "', '" . $enddate . "', '" . $_POST['Wednesdaystart'] . "', '" . $_POST['Wednesdaystop'] . "', '" . 3 . "', '" . 1 . "', '" . $_POST['semester'] . "', '" . 1 . "');");
$d5=("insert into sched (fid,start_date,end_date,start_time,stop_time,day,category,semcode,status) values ('" . $_POST['teachid'] . "', '" . $startdate . "', '" . $enddate . "', '" . $_POST['Thursdaystart'] . "', '" . $_POST['Thursdaystop'] . "', '" . 4 . "', '" . 1 . "', '" . $_POST['semester'] . "', '" . 1 . "');");
$d6=("insert into sched (fid,start_date,end_date,start_time,stop_time,day,category,semcode,status) values ('" . $_POST['teachid'] . "', '" . $startdate . "', '" . $enddate . "', '" . $_POST['Fridaystart'] . "', '" . $_POST['Fridaystop'] . "', '" . 5 . "', '" . 1 . "', '" . $_POST['semester'] . "', '" . 1 . "');");
$d7=("insert into sched (fid,start_date,end_date,start_time,stop_time,day,category,semcode,status) values ('" . $_POST['teachid'] . "', '" . $startdate . "', '" . $enddate . "', '" . $_POST['Saturdaystart'] . "', '" . $_POST['Saturdaystop'] . "', '" . 6 . "', '" . 1 . "', '" . $_POST['semester'] . "', '" . 1 . "');");
}


$results1 = @mysql_query($d1);
$results2 = @mysql_query($d2);
$results3 = @mysql_query($d3);
$results4 = @mysql_query($d4);
$results5 = @mysql_query($d5);
$results6 = @mysql_query($d6);
$results7 = @mysql_query($d7);

if ($results7)
 echo "<h3> Success.. Redirecting</h3>";
else
{
 echo "<h3> Failure.. Redirecting</h3>";  
echo $qry;
echo	@mysql_error(); 
}	
?>
 <script type="text/javascript">
 closewindow();
 </script>
</body>
</html>