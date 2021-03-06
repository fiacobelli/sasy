<?php
/*
This page is used to generate the table that will be used in generating the graph
it is called by the showgraph function on begin.php
*/
require_once ('mysql_connect.php');
session_start(); 
if (!isset($_SESSION['user_id'])) 
{
	require_once ('includes/login_functions.inc.php');
	$url = absolute_url();
	header("Location: $url");
	exit();
}
//get name of faculty member the graph will be built for and assign variables using values passed to the page from a get
$q3 = "select First_Name,Last_Name from users where user_id = ".$_SESSION['user_id'];
$r3 = @mysql_query ($q3);
$row3 = @mysql_fetch_assoc($r3);
$name = substr($row3['First_Name'],0,1).$row3['Last_Name'];
$faculty =$_SESSION['user_id'];
$residency=$_GET["residency"];
$major=$_GET["major"];
$level=$_GET["level"];
$status=$_GET["status"];
$aptstatus=$_GET["aptstatus"];
$admission=$_GET["admission"];
$graduation=$_GET["graduation"];




//set graph caption to be students
$caption ="Students ";

//create 4 select statements to be used for generating data for the graph
/*
query 1 will be used to select all distinct user ids from students where 1=1 which will return a count of all students in the system
query 2 starts the same as query 1 but will have additional conditionals added to it based on values in the get statements above
query 3 is the same as query 1 except it will display the number of distinct students that have been advised by the current faculty member
query 4 is the same as query 3 but will have additional conditionals added to it based on values in the get statements above

*/
$query1="SELECT COUNT( DISTINCT user_id ) FROM sdtinfo Left Join appts on sdtinfo.user_id=appts.sid where 1=1";
$query2="Select COUNT( DISTINCT user_id ) from sdtinfo Left Join appts on sdtinfo.user_id=appts.sid where 1=1";
$query3="SELECT COUNT( DISTINCT user_id ) FROM sdtinfo Left Join appts on sdtinfo.user_id=appts.sid where 1=1 and appts.fid =$faculty";
$query4="SELECT COUNT( DISTINCT user_id ) FROM sdtinfo Left Join appts on sdtinfo.user_id=appts.sid where 1=1 and appts.fid =$faculty";

/*
this series of if statments will check to see if a given variable is currently holding a value
if there is a value, it will update queries 2 and 4 with the additional conditionals and add the appropriate wordage to the caption to describe the restuls of the graph
*/
if(isset($residency))
{

	$query2=$query2." and sdtinfo.residency = '".$residency."'";
	$query4=$query4." and sdtinfo.residency = '".$residency."'";
		$caption=$caption." with a residency status of ".strtolower($residency);
}

if (isset($major))
{
	$query2=$query2." and sdtinfo.major like '%".$major."%'";
	$query4=$query4." and sdtinfo.major like '%".$major."%'";
		$caption=$caption." majoring in ".$major."<br/>";
}

if (isset($level))
{
	$query2=$query2." and sdtinfo.level = '".$level."'";
	$query4=$query4." and sdtinfo.level = '".$level."'";
		$caption=$caption." at the ".strtolower($level)." level<br/>";
}

if (isset($status))
{
	$query2=$query2." and sdtinfo.status like '%".$status."%'";
	$query4=$query4." and sdtinfo.status like '%".$status."%'";
		$caption=$caption." ".strtolower($status)." status<br/>";
}

if (isset($admission))
{
	$query2=$query2." and sdtinfo.admissiondate >= '".$admission."'";
	$query4=$query4." and sdtinfo.admissiondate >= '".$admission."'";
		$caption=$caption." admitted since ".$admission;
}

if (isset($graduation))
{
	$query2=$query2." and sdtinfo.graduationdate >= '".$graduation."'";
	$query4=$query4." and sdtinfo.graduationdate >= '".$graduation."'";
		$caption=$caption." graduated since ".$graduation;
}
if(isset($aptstatus))
{	
	//set captioon based on appointment status
	$caption=$caption." with ".strtolower($aptstatus)." appointments<br/>";
	//if status is open, change the value to be 2 to correspond to the status indicator in the db
	//if it is not open, set aptstatus to be 3 to indicate a closed appointment in the db
	if($aptstatus=='Open')
		$aptstatus = 2;
	else
		$aptstatus=3;
	$query2=$query2." and appts.status = '".$aptstatus."'";
	$query4=$query4." and appts.status = '".$aptstatus."'";
}

/*
run the queries
*/
$run1 = @mysql_query ($query1);
$result1 = @mysql_fetch_assoc($run1);
$run2 = @mysql_query ($query2);
$result2 = @mysql_fetch_assoc($run2);
$run3 = @mysql_query ($query3);
$result3 = @mysql_fetch_assoc($run3);
$run4 = @mysql_query ($query4);
$result4 = @mysql_fetch_assoc($run4);

//set the restuls of the queries as the values for the bars on the chart
$v1a = $result1['COUNT( DISTINCT user_id )'];
$v2a = $result2['COUNT( DISTINCT user_id )'];
$v1b = $result3['COUNT( DISTINCT user_id )'];
$v2b = $result4['COUNT( DISTINCT user_id )'];

//lable the colors of the bars
$bar1="Total students";
$bar2="Students who meet the search criteria";
//the graph uses 3 bars but only 2 were necessary for this so the 3rd is not set
$bar3="";
//after all values have been assigned, creat the table that will house the data
$stuff= '

		<div id="wrapper">
			<div class="chart">
				<table id="data-table" border="1" cellpadding="10" cellspacing="0">
					<caption>'.$caption.'</caption>
					<thead>
						<tr>
							<td>&nbsp;</td>
							<th scope="col">All</th>
							<th scope="col">'.$name.'</th>
							
						</tr>
					</thead>
					<tbody>
						<tr>
							<th scope="row">'.$bar1.'</th>
							<td>'.$v1a.'</td>
							<td>'.$v1b.'</td>
							
						</tr>
						<tr>
							<th scope="row">'.$bar2.'</th>
							<td>'.$v2a.'</td>
							<td>'.$v2b.'</td>
							
						</tr>

					</tbody>
				</table>
			</div>
		</div>

		<script src="content/graph.js"></script>	
		<link rel="stylesheet" href="content/graph.css">
	';
	//print the table in the div indicated by function used on the calling page
$stuff = $stuff."<!-- \n".$query1."\n".$query2."\n".$query3."\n".$query4."\,-->";
	 echo $stuff;


	?>

