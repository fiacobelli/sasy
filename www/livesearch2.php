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
include ('includes/list_file.inc.php');
//livesearch is used to search the database based off of the search string entered into the search boxes.  when the function calls liveserach, the appropriate search is run depending onthe variables passed and then returned back.


//get the q parameter from URL for search value
$q=$_GET["q"];

$major=$_GET["major"];
$level=$_GET["level"];
$status=$_GET["status"];
$residency=$_GET["residency"];
$admission=$_GET["admission"];
$graduation=$_GET["graduation"];
$keyword=$_GET["keyword"];
$startdate=$_GET["startdate"];
$enddate=$_GET["enddate"];


//get the t parameter from URL for search type
$t=$_GET["t"];

//set student id
$sid=$_GET["id"];

//set search type
$searchtype=$_GET["styp"];

//set user id
$user = $_SESSION['user_id'];

$searchtype2=$_GET["styp2"];
//initialize hint to be blank.
$hint="";
$goAhead=strlen($q);


function closedAptSearch()
{//open closedAptSearch
		//bring in global variables
		global $q,$hint,$goAhead;
		$goAhead=$goAhead+1;
		$q1="select * from appts where apptid = $q";
		$r1 = @mysql_query ($q1);
	if (@mysql_num_rows($r1) !=0) 
	{//open php rows if

		while ($row1 = @mysql_fetch_assoc($r1))
		{//open php while

		$part1="<div><p align='left'><b>Appointment Date:</b> <br/>".$row1['start_date']." <br/><b>Appointment Purpose:</b><br/>".$row1['description']."<br/>";
		$part2="<br/>";
		$q2="select TIME_FORMAT(time,'%h:%i %p') as time,fid,note,date from apptnote where apptid = $q";
		$r2 = @mysql_query ($q2);
		if (@mysql_num_rows($r2) !=0) 
			{//open php rows if 2
			while ($row2 = @mysql_fetch_assoc($r2))
				{//open php while 2
				$startTime = $row2['time'];
				$notedate = $row2['date'];
					$q3 = "select First_Name,Last_Name from users where user_id = ".$row2['fid'];
							$r3 = @mysql_query ($q3);
								$row3 = @mysql_fetch_assoc($r3);
				$part2=$part2.$notedate." ".$startTime." by ".substr($row3['First_Name'],0,1).".".$row3['Last_Name']." <br/><b>Note:</b> ".$row2['note']."<br/><br/>";
				}//close php while 2
			}//close php rows if 2
		}//close php while
	}// close php rows if
//set hint as output
$hint=$part1."<b>Appointment Notes:</b>".$part2;
fileview(closed);

}//close closedAptSearch
	
function studentSearch()
{
	global $q,$hint,$major,$level,$status,$ethnic,$residency,$admission,$graduation;
	$qpart2=" ";
	if (isset($major))
	{
		$qpart2=$qpart2." and sdtinfo.major like '%".$major."%'";
		$advcount=$advcount+1;
	}
	if (isset($level))
	{
		$qpart2=$qpart2." and sdtinfo.level = '".$level."'";
		$advcount=$advcount+1;
	}
	if (isset($status))
	{
		$qpart2=$qpart2." and sdtinfo.status like '%".$status."%'";
		$advcount=$advcount+1;
	}
	if (isset($residency))
	{
		$qpart2=$qpart2." and sdtinfo.residency = '".$residency."'";
		$advcount=$advcount+1;
	}
	if (isset($admission))
	{
		$qpart2=$qpart2." and sdtinfo.admissiondate = '".$admission."'";
		$advcount=$advcount+1;
	}
	if (isset($graduation))
	{
		$qpart2=$qpart2." and sdtinfo.graduationdate = '".$graduation."'";
		$advcount=$advcount+1;
	}
	
$qpart1="select * from users,Logins,sdtinfo where users.user_id = Logins.user_id and Logins.user_id=sdtinfo.user_id and Logins.user_type = 3"; 
$qpart3="order by Last_Name";

//if the length of the search string is greater than 1, search the database
$q1=$qpart1.$qpart2.$qpart3;
if (strlen($q)>1)
{//open main php if

	
	
	$r1 = @mysql_query ($q1);
	if (@mysql_num_rows($r1) !=0) 
	{//open php rows if

		while ($row1 = @mysql_fetch_assoc($r1))
		{//open php while
		
			// create variables for the a items that will be searched and make them all lowercase (what we want to search through)
			$string = strtolower($row1['First_Name']);
			$string2 = strtolower($row1['Last_Name']);
			$string3 = strtolower($row1['user_id']);
 
			// assign a lowercase version of the search string to
			//the variable $find (what we want to search for)
			$find = strtolower($q);
 
 			if($q=='adv@nc3d5earch' && $advcount>=1)
				{
				$position = 1;
				$position2 =1;
				$position3 =1;
				}
				else
				{
				// perform the search
				//return the position of the string we are looking
				//for if it exists
			
				$position = substr_count($string, $find);
				$position2 = substr_count($string2, $find);
				$position3 = substr_count($string3, $find);
				}
 
$output1="<a href='".'student.php?q='. $row1['user_id']."'target='_blank' >". $row1['user_id'].' '.$row1['First_Name'].' '.$row1['Last_Name']."</a>";
$output2="<br/><a href='".'student.php?q='.$row1['user_id']."'target='_blank' >".$row1['user_id'].' '.$row1['First_Name'].' '.$row1['Last_Name'] ."</a>";

			//if position is valid, a match has been found
			if ($position or $position2 or $position3 !=0)
			{//open if 1
				if ($hint=="")
    	    	{//open if 2 (if the $hint variable is blank)
			        $hint=$output1;
	          	}//close if 2
			 	  else
        	     {//open else if hing is not blank, add to it
		        $hint=$hint.$output2;
	          	}//close else
			}//close if 1
		
		}//close php while
	}//close php rows if
}//close main php if
}



function aptSearch()
{//open function aptsearch
	global $hint,$q,$t,$sid,$searchtype,$user,$startdate,$enddate,$keyword,$searchtype2,$goAhead;
		
$qpart1="select *,TIME_FORMAT(start_time,'%h:%i %p') as start_time from appts,users where ";
$qpart4="order by start_date desc, start_time desc";
$qpart3=" ";
$advcount=0;
$goAhead=0;

	if ($searchtype=="stusrch")
	{
		$qpart2="sid = $sid and user_id = fid"; 
	
	}

	if ($searchtype=="facsrch")
	{
		if($searchtype2==1)
		$qpart2="user_id = sid";
		else
		$qpart2="fid = $user and user_id = sid";
	
	}
	if (isset($startdate))
	{
		$qpart3=$qpart3." and start_date > '".$startdate."' ";
		$advcount=$advcount+1;
	}
	if (isset($enddate))
	{
		$qpart3=$qpart3." and start_date < '".$enddate."' ";
		$advcount=$advcount+1;
	}

$q1=$qpart1.$qpart2.$qpart3.$qpart4;
	//if the length of the search string is greater than 1, search the database
	if (strlen($q)>1)
	{//open main php if
	

		$r1 = @mysql_query ($q1);
		if (@mysql_num_rows($r1) !=0) 
		{//open php rows if

			while ($row1 = @mysql_fetch_assoc($r1))
			{//open php while
			
			// create variables for the a items that will be searched and make them all lowercase (what we want to search through)
			$apptstatus = $row1['status'];
			$startTime = $row1['start_time'];
			$string = strtolower($row1['apptid']);
			$string1 = strtolower($row1['user_id']);
			$string2 = strtolower($row1['First_Name']);
			$string3 = strtolower($row1['Last_Name']);
			$string4 = strtolower($row1['start_date']);
			$string5 = strtolower($startTime);
			$string6=$row1['description'];
			$infostring = substr($string6, 0, 100);
			if (strlen($string6)>100)
			{
				$infostring=$infostring."...";
			}
 
			// assign a lowercase version of the search string to
			//the variable $find (what we want to search for)
			$find = strtolower($q);
 
		
			
$output1="<o title='Faculty can close the appointment at the bottom of the appointment window after viewing the appointmnet.'>Open </o><a href='student.php?q=".$row1['user_id']."&a=".$row1['apptid']."' target='_blank' title='$infostring'> Appt # ".$row1['apptid'].' with '.$row1['Last_Name'].', '.substr($row1['First_Name'],0,1).' on '.$row1['start_date'].' at '.$startTime."</a>";

$output2="<br/><o title='Faculty can close the appointment at the bottom of the appointment window after viewing the appointmnet.'>Open </o><a href='student.php?q=".$row1['user_id']."&a=".$row1['apptid']."' target='_blank' title='$infostring'> Appt # ".$row1['apptid'].' with '.$row1['Last_Name'].', '.substr($row1['First_Name'],0,1).' on '.$row1['start_date'].' at '.$startTime."</a>";

$output3="<a href='javascript:showApt(".$row1['apptid'].");' title='$infostring'> Appt # ".$row1['apptid'].' with '.$row1['Last_Name'].', '.substr($row1['First_Name'],0,1).' on '.$row1['start_date'].' at '.$startTime."</a>";

$output4="<br/><a href='javascript:showApt(".$row1['apptid'].");'title='$infostring'> Appt # " . $row1['apptid'].' with ' . $row1['Last_Name'].', '. substr($row1['First_Name'],0,1).' on ' . $row1['start_date']. ' at '.$startTime."</a>";
			
			if(isset($keyword) && strlen($keyword)>=2)
			{
			$keyfound=0;
			$goAhead=$goAhead+1;
			$advcount=$advcount+1;
			$keysearch="select * from apptnote,appts where apptnote.apptid = ".$row1['apptid']." and apptnote.apptid = appts.apptid and ( appts.description like '%".$keyword."%' or apptnote.note like '%".$keyword."%')";
			
				$keyresult = @mysql_query ($keysearch);
					if (@mysql_num_rows($keyresult) !=0) 
					{//open php rows if
					$keyfound=1;
					}

			
			}
			else
			{
			$keyfound=1;
			$goAhead=$goAhead+1;
			
			}
			
			// perform the search
			//return the position of the string we are looking
			//for if it exists
			if($q=='adv@nc3d5earch' && $advcount>=1)
			{
			$position = 1;
			$position1 =1;
			$position2 =1;
			$position3 =1;
			$position4 =1;
			$position5 =1;
			}
			else
			{
			$position = substr_count($string, $find);
			$position1 = substr_count($string1, $find);
			$position2 = substr_count($string2, $find);
			$position3 = substr_count($string3, $find);
			$position4 = substr_count($string4, $find);
			$position5 = substr_count($string5, $find);
			}
				//if position is valid, a match has been found
				if (($position or $position1 or $position2 or $position3 or $position4) and $keyfound !=0)
				{//open if 1
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
				}//close if 1
			$keyfound=0;
			}//close php while
		}//close php rows if
	}//close main php if
}//close function apt search




//if $t is ssearch, search for students
if ($t == ssearch)
	{
	studentSearch();
	}
//if $t is aptsearch, search for appointments
if ($t== aptsearch)
	{
	aptSearch();
	}
if ($t== closed)
	{
	closedAptSearch();
	}
	
// Set output to "no suggestion" if no hints were found
// or to the correct values
if ($goAhead<2)
{
	$hint="Search term must be longer";
}

if ($hint=="")
  {
  $response="no suggestion";
  }
else
  {
  $response=$hint;
  }

//output the response
//if ($goAhead>1)
//{
echo $response;
//}

?>
<link href="content/colorbox.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700|Droid+Serif:400,700' rel='stylesheet' type='text/css'>