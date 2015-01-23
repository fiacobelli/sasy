<?php
 require_once ('mysql_connect.php');
# Script 11.9 - loggedin.php #2
// The user is redirected here from login.php.
session_start(); // Start the session.
// If no session value is present,redirect the user:
if (!isset($_SESSION['user_id'])) 
{//open isset
	require_once ('includes/login_functions.inc.php');
	$url = absolute_url();
	header("Location: $url");
	exit();
}//close isset
include ('includes/list_file.inc.php');
?>

<script src="./content/jquery.colorbox.js"></script>
		<script>
			$(document).ready(function(){
				//assign the ColorBox event to elements
				$(".ajax").colorbox();
			});
		</script>
<link href="content/colorbox.css" rel="stylesheet" type="text/css" />
</head>
	<body>
<?php
//get the q parameter from URL for search value
$q=$_GET["q"];

//get the t parameter from URL for search type
$t=$_GET["t"];

//set student id
$sid=$_GET["id"];

//set search type
$searchtype=$_GET["styp"];

//set user id
$user = $_SESSION['user_id'];

//initialize hint to be blank.
$hint="";

$goAhead=strlen($q);

$hint="";


function aptcheck()
{global $hint,$q;
$hint= 'New appointment:<br/>
<form id="newappt" name="newappt" method="post"  action="apptsubmit.php">
<input type="hidden" name="studentid" id="studentid" value="'.$q.'"/>
<input type="hidden" name="time" id="time" value=""/>
<label>
Purpose:
<input name="Purpose" id="Purpose" type="text" maxlength="50" />
</label>
<br/>
<br/>
<label>
Initial Note:<br/>
<textarea name="Note" id="Note" rows="5"></textarea>
</label>
</form>
<input name="Submit" type="button" value="Submit" onclick= "errorcheck()" />
';
}

function openApt()
{//open open apt search
		//bring in global variables
		global $q,$hint,$goAhead,$noteAdd,$sid;
		$goAhead=$goAhead+1;
		$q1="select * from appts where apptid=$q";
		$r1 = @mysql_query ($q1);
	if (@mysql_num_rows($r1) !=0) 
	{//open php rows if

		while ($row1 = @mysql_fetch_assoc($r1))
		{//open php while
	//	$sid=$row1['sid'];
		$part1="<p><u>Appointment Date:</u><br/> ".$row1['start_date']." <br/><br/><u>Appointment Purpose: </u><br/>".$row1['description']."<br/><br/>";
		$part2="<br/>";
		$q2="select * ,TIME_FORMAT(time,'%h:%i %p') as time from apptnote where apptid = $q order by date desc, time desc";
		$r2 = @mysql_query ($q2);
		if (@mysql_num_rows($r2) !=0) 
			{//open php rows if 2
			while ($row2 = @mysql_fetch_assoc($r2))
				{//open php while 2
				$q3 = "select First_Name,Last_Name from users where user_id = ".$row2['fid'];
							$r3 = @mysql_query ($q3);
								$row3 = @mysql_fetch_assoc($r3);
				$part2=$part2.$row2['date']."  ".$row2['time']." by  ".substr($row3['First_Name'],0,1).".".$row3['Last_Name']."<br/>     <b>Note:</b> ".$row2['note']."<br/><br/>";
				}//close php while 2
			}//close php rows if 2
		}//close php while
	}// close php rows if
//set hint as output
$hint="<div><o>Your appointment #".$q." is currently open for this student. Please close it before opening another appointment.</o></br>";
$hint=$hint.$part1."<u>Appointment Notes:</u>".$part2;
addNote();

$hint=$hint."</div>";

fileview(open);
$hint=$hint.'<br/><input name="Submit" type="button" value="Submit" onclick= "errorcheck()" />';
}//close openapt search

function viewApt()
{//open view apt search
		//bring in global variables
		global $q,$hint,$goAhead,$sid;
		$goAhead=$goAhead+1;
		$q1="select * from appts where apptid=$q";
		
		$r1 = @mysql_query ($q1);
	if (@mysql_num_rows($r1) !=0) 
	{//open php rows if
	//	$sid=$row1['sid'];
		while ($row1 = @mysql_fetch_assoc($r1))
		{//open php while

		$part1="<p><u>Appointment Date:</u><br/> ".$row1['start_date']."<br/><br/> <u>Appointment Purpose: </u><br/> ".$row1['description']."<br/><br/>";
		$part2="<br/>";
		$q2="select *,TIME_FORMAT(time,'%h:%i %p') as time from apptnote where apptid = $q order by date desc, time desc";
		$r2 = @mysql_query ($q2);
		if (@mysql_num_rows($r2) !=0) 
			{//open php rows if 2
			while ($row2 = @mysql_fetch_assoc($r2))
				{//open php while 2
				$q3 = "select First_Name,Last_Name from users where user_id = ".$row2['fid'];
							$r3 = @mysql_query ($q3);
								$row3 = @mysql_fetch_assoc($r3);
				$part2=$part2.$row2['date']."  ".$row2['time']." by  ".substr($row3['First_Name'],0,1).".".$row3['Last_Name']."<br/>     Note: ".$row2['note']."<br/><br/>";
				}//close php while 2
			}//close php rows if 2
		}//close php while
	}// close php rows if
//set hint as output
$hint=$hint.$part1."<u>Appointment Notes:</u>".$part2;
addNote();
$hint=$hint."</div>";

fileview(open);
$hint=$hint.'<br/><input name="Submit" type="button" value="Submit" onclick= "errorcheck()" />';
}//close viewapt search



function addNote()
{
	global $hint,$q,$sid;
$hint=$hint.'</br>Add Note:<br/>
<form id="newappt" name="newappt" method="post"  action="appupdate.php">
<input type="hidden" name="sid" id="sid" value="'.$sid.'"/>
<input type="hidden" name="time" id="time" value=""/>
<input type ="hidden" name="Purpose" id="Purpose" value="  " />
<input type ="hidden" name="appid" id="appid" value="'.$q.'" />
<br/>
<textarea name="Note" id="Note" rows="5"></textarea>
</form>
';
}


//if $t is ssearch, search for students
if ($t == openapt)
	{
	openApt();
	}
//if $t is aptsearch, search for appointments
if ($t== aptcheck)
	{
	aptCheck();
	}
if ($t== viewapt)
	{
	viewApt();
	}
	
// Set output to "no suggestion" if no hints were found
// or to the correct values
if ($hint=="")
  {//open hint if
  $response="no suggestion";
  }//close hint if
else
  {//open hint else
  $response=$hint;
  }//close hint else

//output the response
if ($goAhead>1)
{//open go head if
echo $response;
}//close go ahead if

?>
</body>