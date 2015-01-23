<?php
 require_once ('mysql_connect.php');
session_start(); // Start the session.
// If no session value is present,redirect the user:
if (!isset($_SESSION['user_id'])) 
{//open isset
	require_once ('includes/login_functions.inc.php');
	$url = absolute_url();
	header("Location: $url");
	exit();
}//close isset
//livesearch is used to search the database based off of the search string entered into the search boxes.  when the function calls liveserach, the appropriate search is run depending onthe variables passed and then returned back.


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
function aptList()
{//open student search
global $q,$hint,$openapt;
$q1="select *,TIME_FORMAT(start_time,'%h:%i %p') as start_time from appts,users where appts.sid = $q and users.user_id = appts.fid order by start_date desc, start_time desc";
$r1 = @mysql_query ($q1);

	if (@mysql_num_rows($r1) !=0) 
		{//open php rows if
		while ($row1 = @mysql_fetch_assoc($r1))
			{//open php while
		
			// create variables for the a items that will be searched and make them all lowercase (what we want to search through)
			$apptstatus = $row1['status'];
			$string = $row1['apptid'];

			$string6=$row1['description'];
			$infostring = substr($string6, 0, 100);
				if (strlen($string6)>100)
				{//open strlen if
					$infostring=$infostring."...";
				}//close strlen if
 
			
$output1="<o title='Faculty can close the appointment at the bottom of the appointment window after viewing the appointmnet.'>Open </o><a href='student.php?q=".$row1['sid']."&a=".$row1['apptid']."' target='_blank' title='$infostring'> Appt # ".$row1['apptid'].' with '.$row1['Last_Name'].', '.substr($row1['First_Name'],0,1).' on '.$row1['start_date'].' at '.$row1['start_time']."</a>";

$output2="<br/><o title='Faculty can close the appointment at the bottom of the appointment window after viewing the appointmnet.'>Open </o><a href='student.php?q=".$row1['sid']."&a=".$row1['apptid']."' target='_blank' title='$infostring'> Appt # ".$row1['apptid'].' with '.$row1['Last_Name'].', '.substr($row1['First_Name'],0,1).' on '.$row1['start_date'].' at '.$row1['start_time']."</a>";

$output3="<a href='javascript:showApt(".$row1['apptid'].");' title='$infostring'> Appt # ".$row1['apptid'].' with '.$row1['Last_Name'].', '.substr($row1['First_Name'],0,1).' on '.$row1['start_date'].' at '.$row1['start_time']."</a>";

$output4="<br/><a href='javascript:showApt(".$row1['apptid'].");'title='$infostring'> Appt # " . $row1['apptid'].' with ' . $row1['Last_Name'].', '. substr($row1['First_Name'],0,1).' on ' . $row1['start_date']. ' at '. $row1['start_time'] ."</a>";
			
					if ($hint=="")
					{//open if 2 (if the $hint variable is blank)
							if($apptstatus==3)
							{
					        $hint=$output3;
							}
							else
							{
					        $hint=$output1;
							}
					}//close if 2

			 		else
        	     	{//open else if hint is not blank, add to it
							if($apptstatus==3)
							{
		        			$hint=$hint.$output4;
							}
							else
							{
							$hint=$hint.$output2;
							}
	          		}//close else
				
		
			}//close php while
		}//close php if
}//close sutdent search




//if $t is ssearch, search for students
if ($t == aptlist)
	{
	aptList();
	}
//if $t is aptsearch, search for appointments
if ($t== aptCheck)
	{
	aptChecn();
	}
if ($t== closed)
	{
	closedAptSearch();
	}
	
// Set output to "no suggestion" if no hints were found
// or to the correct values
if ($hint=="")
  {//open hint if
  $response="no appointments found";
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
