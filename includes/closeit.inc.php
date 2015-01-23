<?php
/*
This function is used to close appointments
*/
function closeappt()
{
	global $q,$s;
	$d1=("update appts set status =3 where apptid =".$q);
	$results1 = @mysql_query ($d1);

	$sem="select email from users where user_id ='".$s."'";
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

	$q2="select * from apptnote where apptid = '".$q."' order by date desc, time desc";
	$r2 = @mysql_query ($q2);
	if (@mysql_num_rows($r2) !=0) 
	{//open php rows if 2
		while ($row2 = @mysql_fetch_assoc($r2))
		{//open php while 2
			$note=$note.$row2['date']."  ".$row2['time']."\nNote: ".$row2['note']."\n\n";
		}//close php while 2
	}//close php rows if 2
	$subject = "Advisement appointment closed";
	$body = "Appointment number ".$q." has been closed.\n\nPurpose: ".$purpose."\n\nNote: ".$note;
//	sendmail();
}
?>
