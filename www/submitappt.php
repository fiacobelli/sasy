<html>
<head><meta http-equiv="Refresh" content="2;url=fsched.php" />
</head></head><body>
<?php require_once("mysql_connect.php");


$q =("insert into appts (sid,fid,start_date,end_date,start_time,stop_time,description,status) values ('" . $_POST['studentid'] . "', '" . $_POST['teachid'] . "', '" . $_POST['submitdate'] . "', '" . $_POST['submitdate'] . "', '" . $_POST['timestamp'] . "', '" . $_POST['timestamp'] . "', '" . $_POST['Description'] . "', '" . $_POST['status'] . "')");

$results = @mysql_query($q);
if ($results)
 echo "<h3> Success.. Redirecting</h3>";
else
{
 echo "<h3> Failure.. Redirecting</h3>";  
echo $qry;
echo	@mysql_error(); 
}	
?>
</body>
</html>