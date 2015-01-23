<?php
 require_once ('mysql_connect.php');
# Script 11.9 - loggedin.php #2
// The user is redirected here from login.php.
session_start();// Start the session.
// If no session value is present,redirect the user:
if (!isset($_SESSION['user_id'])){
require_once ('includes/login_functions.inc.php');
$url = absolute_url();
header("Location: $url");
exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="content/colorbox.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700|Droid+Serif:400,700' rel='stylesheet' type='text/css'>
<title>Faculty Calendar</title>
<a href = "begin.php" title="go back">Close</a>
<script type="text/javascript">
<!--
var weekDay=new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
function clearval()
{
document.forms.form1['Sundaystart'].value = 0;
document.forms.form1['Sundaystop'].value = 0;
document.forms.form1['Mondaystart'].value = 0;
document.forms.form1['Mondaystop'].value = 0;
document.forms.form1['Tuesdaystart'].value = 0;
document.forms.form1['Tuesdaystop'].value = 0;
document.forms.form1['Wednesdaystart'].value = 0;
document.forms.form1['Wednesdaystop'].value = 0;
document.forms.form1['Thursdaystart'].value = 0;
document.forms.form1['Thursdaystop'].value = 0;
document.forms.form1['Fridaystart'].value = 0;
document.forms.form1['Fridaystop'].value = 0;
document.forms.form1['Saturdaystart'].value = 0;
document.forms.form1['Saturdaystop'].value = 0;
retreiveHours();
}

function retreiveHours()
{
if(document.forms.form1['semester'].value == 1)
{
var d=new Date("1/2/2012");
}
if(document.forms.form1['semester'].value == 2)
{
var d=new Date("5/23/2012");
}
var gett = d.getTime();
var startdate=(gett/1000);
<?php
$user_id = $_SESSION['user_id'];
$facultyid = $user_id;
$timestart = array("Sundaystart", "Mondaystart", "Tuesdaystart", "Wednesdaystart", "Thursdaystart", "Fridaystart", "Saturdaystart");
$timestop = array("Sundaystop", "Mondaystop", "Tuesdaystop", "Wednesdaystop", "Thursdaystop", "Fridaystop", "Saturdaystop"); 
$q1="select * from sched where fid = $facultyid and category = 1";
$r1 = @mysql_query ($q1);
if (@mysql_num_rows($r1) !=0) {//open php rows if
while ($row1 = @mysql_fetch_assoc($r1))
{//open php while
$tempday = $row1['day'];
$tempstart =str_pad((int)$row1['start_time'],2,"0",STR_PAD_LEFT);
$tempstop = str_pad((int)$row1['stop_time'],2,"0",STR_PAD_LEFT);
$sdate = $row1['start_date'];
$tStartdate = strtotime($sdate);
echo ("if ($tempday ==0 && $tStartdate==startdate){");
echo("document.forms.form1['$timestart[$tempday]'].value = '$tempstart';");
echo("document.forms.form1['$timestop[$tempday]'].value = '$tempstop';}");


echo ("if ($tempday ==1&& $tStartdate==startdate){");
echo("document.forms.form1['$timestart[$tempday]'].value = '$tempstart';");
echo("document.forms.form1['$timestop[$tempday]'].value = '$tempstop';}");

echo ("if ($tempday ==2&& $tStartdate==startdate){");
echo("document.forms.form1['$timestart[$tempday]'].value = '$tempstart';");
echo("document.forms.form1['$timestop[$tempday]'].value = '$tempstop';}");

echo ("if ($tempday ==3&& $tStartdate==startdate){");
echo("document.forms.form1['$timestart[$tempday]'].value = '$tempstart';");
echo("document.forms.form1['$timestop[$tempday]'].value = '$tempstop';}");

echo ("if ($tempday ==4&& $tStartdate==startdate){");
echo("document.forms.form1['$timestart[$tempday]'].value = '$tempstart';");
echo("document.forms.form1['$timestop[$tempday]'].value = '$tempstop';}");

echo ("if ($tempday ==5&& $tStartdate==startdate){");
echo("document.forms.form1['$timestart[$tempday]'].value = '$tempstart';");
echo("document.forms.form1['$timestop[$tempday]'].value = '$tempstop';}");

echo ("if ($tempday ==6&& $tStartdate==startdate){");
echo("document.forms.form1.$timestart[$tempday].value = '$tempstart';");
echo("document.forms.form1.$timestop[$tempday].value = '$tempstop';}");
}//close php while
}//close php rows if
?>
}


function inputCheck()
{//begin inputCheck function
	var dayError=new Array(" "," "," "," "," "," "," ");
	var errorCount=0;
	var sustart = document.forms.form1['Sundaystart'].value;
	var sustop = document.forms.form1['Sundaystop'].value;
	var mostart= document.forms.form1['Mondaystart'].value;
	var mostop =document.forms.form1['Mondaystop'].value;
	var tustart =document.forms.form1['Tuesdaystart'].value;
	var tustop =document.forms.form1['Tuesdaystop'].value;
	var westart =document.forms.form1['Wednesdaystart'].value;
	var westop =document.forms.form1['Wednesdaystop'].value;
	var thstart =document.forms.form1['Thursdaystart'].value;
	var thstop =document.forms.form1['Thursdaystop'].value;
	var frstart =document.forms.form1['Fridaystart'].value;
	var frstop =document.forms.form1['Fridaystop'].value;
	var sastart =document.forms.form1['Saturdaystart'].value;
	var sastop =document.forms.form1['Saturdaystop'].value;
	
	if (sustop < sustart)
	{
		dayError[0]=("\n"+weekDay[0]+" stop time must be AFTER start time.");
		errorCount=errorCount+1;
	}

	if (sustop >0 && sustart == 0)
	{
		dayError[0] = ("\n"+weekDay[0]+" start time must be entered.");
		errorCount=errorCount+1;
	}

	if (mostop < mostart)
	{
		dayError[1]=("\n"+weekDay[1]+" stop time must be AFTER start time.");
		errorCount=errorCount+1;
	}

	if (mostop >0 && mostart == 0)
	{
		dayError[1] = ("\n"+weekDay[1]+" start time must be entered.");
		errorCount=errorCount+1;
	}
	
	if (tustop < tustart)
	{
		dayError[2]=("\n"+weekDay[2]+" stop time must be AFTER start time.");
		errorCount=errorCount+1;
	}
	
	if (tustop >0 && tustart == 0)
	{
		dayError[2] = ("\n"+weekDay[2]+" start time must be entered.");
		errorCount=errorCount+1;
	}
	if (westop < westart)
	{
		dayError[3]=("\n"+weekDay[3]+" stop time must be AFTER start time.");
		errorCount=errorCount+1;
	}
	if (westop >0 && westart == 0)
	{
		dayError[3] = ("\n"+weekDay[3]+" start time must be entered.");
		errorCount=errorCount+1;
	}
	if (thstop < thstart)
	{
		dayError[4]=("\n"+weekDay[4]+" stop time must be AFTER start time.");
		errorCount=errorCount+1;
	}
	if (thstop >0 && thstart == 0)
	{
		dayError[4] = ("\n"+weekDay[4]+" start time must be entered.");
		errorCount=errorCount+1;
	}
	if (frstop < frstart)
	{
		dayError[5]=("\n"+weekDay[5]+" stop time must be AFTER start time.");
		errorCount=errorCount+1;
	}
	if (frstop >0 && frstart == 0)
	{
		dayError[5] = ("\n"+weekDay[5]+" start time must be entered.");
		errorCount=errorCount+1;
	}
	if (sastop < sastart)
	{
		dayError[6]=("\n"+weekDay[6]+" stop time must be AFTER start time.");
		errorCount=errorCount+1;
	}
	if (sastop >0 && sastart == 0)
	{
		dayError[6] = ("\n"+weekDay[6]+" start time must be entered.");
		errorCount=errorCount+1;
	}

	if (errorCount >0)
		alert(errorCount+" Error(s). "+dayError[0]+dayError[1]+dayError[2]+dayError[3]+dayError[4]+dayError[5]+dayError[6]);
	if(errorCount == 0)
	{
		document.forms["form1"].submit();
	}
}// end inputCheck function
//-->
</script>
<body>
<div align="center">
<h2>Set Office Hours</h2>
</div>
</div>
<div>


<form id="form1" name="form1" method="post" action="submitsched.php">
<p>
<table>
<?php echo("<input type=\"hidden\" id=\"teachid\"name=\"teachid\"value=\"$user_id\"/>");
?>
<tr>
<td></td>
	<td><label for="semester" >Semester</label></td>
	<td><select onChange="clearval()" name="semester" id="semester">
		<option value="1" selected="selected">Spring 2012</option>
		<option value="2">Summer 2012</option>
		</select></td>
</tr>
</table>
</p>
<table>
<tr>
	<td align="right">Sunday: </td>
   <td><label for="Sunday"> Start Time</label></td>
<td><select name="Sundaystart" id="Sundaystart">
<option value="0" selected>NONE</option>
	<option value ="08">8:00</option>
	<option value ="08.5">8:30</option>
    <option value ="09">9:00</option>
    <option value ="09.5">9:30</option>
    <option value ="10">10:00</option>
    <option value ="10.5">10:30</option>
    <option value ="11">11:00</option>
    <option value ="11.5">11:30</option>
    <option value ="12">12:00</option>
    <option value ="12.5">12:30</option>
    <option value ="13">13:00</option>
    <option value ="13.5">13:30</option>
    <option value ="14">14:00</option>
    <option value ="14.5">14:30</option>
    <option value ="15">15:00</option>
    <option value ="15.5">15:30</option>
    <option value ="16">16:00</option>
    <option value ="16.5">16:30</option>
    <option value ="17">17:00</option>
    <option value ="17.5">17:30</option>
    <option value ="18">18:00</option>
    <option value ="18.5">18:30</option>
    <option value ="19">19:00</option>
    <option value ="19.5">19:30</option>
    <option value ="20">20:00</option>
    <option value ="20.5">20:30</option>
    <option value ="21">21:00</option>
 </select></td>
<td>Stop Time</td>   
    <td><select name="Sundaystop" id="Sundaystop">
	<option value="0" selected>NONE</option>
	<option value ="08">8:00</option>
	<option value ="08.5">8:30</option>
    <option value ="09">9:00</option>
    <option value ="09.5">9:30</option>
    <option value ="10">10:00</option>
    <option value ="10.5">10:30</option>
    <option value ="11">11:00</option>
    <option value ="11.5">11:30</option>
    <option value ="12">12:00</option>
    <option value ="12.5">12:30</option>
    <option value ="13">13:00</option>
    <option value ="13.5">13:30</option>
    <option value ="14">14:00</option>
    <option value ="14.5">14:30</option>
    <option value ="15">15:00</option>
    <option value ="15.5">15:30</option>
    <option value ="16">16:00</option>
    <option value ="16.5">16:30</option>
    <option value ="17">17:00</option>
    <option value ="17.5">17:30</option>
    <option value ="18">18:00</option>
    <option value ="18.5">18:30</option>
    <option value ="19">19:00</option>
    <option value ="19.5">19:30</option>
    <option value ="20">20:00</option>
    <option value ="20.5">20:30</option>
    <option value ="21">21:00</option>
 </select></td>
</tr>

<tr>
	<td align="right">Monday: </td>
 	<td><label for="Monday">Start Time</label></td>
	<td><select name="Mondaystart" id="Mondaystart">
	<option value="0" selected>NONE</option>
	<option value ="08">8:00</option>
	<option value ="08.5">8:30</option>
    <option value ="09">9:00</option>
    <option value ="09.5">9:30</option>
    <option value ="10">10:00</option>
    <option value ="10.5">10:30</option>
    <option value ="11">11:00</option>
    <option value ="11.5">11:30</option>
    <option value ="12">12:00</option>
    <option value ="12.5">12:30</option>
    <option value ="13">13:00</option>
    <option value ="13.5">13:30</option>
    <option value ="14">14:00</option>
    <option value ="14.5">14:30</option>
    <option value ="15">15:00</option>
    <option value ="15.5">15:30</option>
    <option value ="16">16:00</option>
    <option value ="16.5">16:30</option>
    <option value ="17">17:00</option>
    <option value ="17.5">17:30</option>
    <option value ="18">18:00</option>
    <option value ="18.5">18:30</option>
    <option value ="19">19:00</option>
    <option value ="19.5">19:30</option>
    <option value ="20">20:00</option>
    <option value ="20.5">20:30</option>
    <option value ="21">21:00</option>
 	</select></td>
	<td>Stop Time</td>   
    <td><select name="Mondaystop" id="Mondaystop">
	<option value="0" selected>NONE</option>
	<option value ="08">8:00</option>
	<option value ="08.5">8:30</option>
    <option value ="09">9:00</option>
    <option value ="09.5">9:30</option>
    <option value ="10">10:00</option>
    <option value ="10.5">10:30</option>
    <option value ="11">11:00</option>
    <option value ="11.5">11:30</option>
    <option value ="12">12:00</option>
    <option value ="12.5">12:30</option>
    <option value ="13">13:00</option>
    <option value ="13.5">13:30</option>
    <option value ="14">14:00</option>
    <option value ="14.5">14:30</option>
    <option value ="15">15:00</option>
    <option value ="15.5">15:30</option>
    <option value ="16">16:00</option>
    <option value ="16.5">16:30</option>
    <option value ="17">17:00</option>
    <option value ="17.5">17:30</option>
    <option value ="18">18:00</option>
    <option value ="18.5">18:30</option>
    <option value ="19">19:00</option>
    <option value ="19.5">19:30</option>
    <option value ="20">20:00</option>
    <option value ="20.5">20:30</option>
    <option value ="21">21:00</option>
 	</select></td>
</tr>

<tr>
	<td align="right">Tuesday: </td>
    <td><label for="Tuesday">Start Time</label></td>
	<td><select name="Tuesdaystart" id="Tuesdaystart">
	<option value="0" selected>NONE</option>
	<option value ="08">8:00</option>
	<option value ="08.5">8:30</option>
    <option value ="09">9:00</option>
    <option value ="09.5">9:30</option>
    <option value ="10">10:00</option>
    <option value ="10.5">10:30</option>
    <option value ="11">11:00</option>
    <option value ="11.5">11:30</option>
    <option value ="12">12:00</option>
    <option value ="12.5">12:30</option>
    <option value ="13">13:00</option>
    <option value ="13.5">13:30</option>
    <option value ="14">14:00</option>
    <option value ="14.5">14:30</option>
    <option value ="15">15:00</option>
    <option value ="15.5">15:30</option>
    <option value ="16">16:00</option>
    <option value ="16.5">16:30</option>
    <option value ="17">17:00</option>
    <option value ="17.5">17:30</option>
    <option value ="18">18:00</option>
    <option value ="18.5">18:30</option>
    <option value ="19">19:00</option>
    <option value ="19.5">19:30</option>
    <option value ="20">20:00</option>
    <option value ="20.5">20:30</option>
    <option value ="21">21:00</option>
	</select></td>
	<td>Stop Time</td>   
    <td><select name="Tuesdaystop" id="Tuesdaystop">
	<option value="0" selected>NONE</option>
	<option value ="08">8:00</option>
	<option value ="08.5">8:30</option>
    <option value ="09">9:00</option>
    <option value ="09.5">9:30</option>
    <option value ="10">10:00</option>
    <option value ="10.5">10:30</option>
    <option value ="11">11:00</option>
    <option value ="11.5">11:30</option>
    <option value ="12">12:00</option>
    <option value ="12.5">12:30</option>
    <option value ="13">13:00</option>
    <option value ="13.5">13:30</option>
    <option value ="14">14:00</option>
    <option value ="14.5">14:30</option>
    <option value ="15">15:00</option>
    <option value ="15.5">15:30</option>
    <option value ="16">16:00</option>
    <option value ="16.5">16:30</option>
    <option value ="17">17:00</option>
    <option value ="17.5">17:30</option>
    <option value ="18">18:00</option>
    <option value ="18.5">18:30</option>
    <option value ="19">19:00</option>
    <option value ="19.5">19:30</option>
    <option value ="20">20:00</option>
    <option value ="20.5">20:30</option>
    <option value ="21">21:00</option>
 	</select></td>
</tr>
<tr>
	<td align="right">Wednesday: </td>
    <td><label for="Wednesday">Start Time</label></td>
	<td><select name="Wednesdaystart" id="Wednesdaystart">
	<option value="0" selected>NONE</option>
	<option value ="08">8:00</option>
	<option value ="08.5">8:30</option>
    <option value ="09">9:00</option>
    <option value ="09.5">9:30</option>
    <option value ="10">10:00</option>
    <option value ="10.5">10:30</option>
    <option value ="11">11:00</option>
    <option value ="11.5">11:30</option>
    <option value ="12">12:00</option>
    <option value ="12.5">12:30</option>
    <option value ="13">13:00</option>
    <option value ="13.5">13:30</option>
    <option value ="14">14:00</option>
    <option value ="14.5">14:30</option>
    <option value ="15">15:00</option>
    <option value ="15.5">15:30</option>
    <option value ="16">16:00</option>
    <option value ="16.5">16:30</option>
    <option value ="17">17:00</option>
    <option value ="17.5">17:30</option>
    <option value ="18">18:00</option>
    <option value ="18.5">18:30</option>
    <option value ="19">19:00</option>
    <option value ="19.5">19:30</option>
    <option value ="20">20:00</option>
    <option value ="20.5">20:30</option>
    <option value ="21">21:00</option>
	 </select></td>
	<td>Stop Time</td>   
    <td><select name="Wednesdaystop" id="Wednesdaystop">
	<option value="0" selected>NONE</option>
	<option value ="08">8:00</option>
	<option value ="08.5">8:30</option>
    <option value ="09">9:00</option>
    <option value ="09.5">9:30</option>
    <option value ="10">10:00</option>
    <option value ="10.5">10:30</option>
    <option value ="11">11:00</option>
    <option value ="11.5">11:30</option>
    <option value ="12">12:00</option>
    <option value ="12.5">12:30</option>
    <option value ="13">13:00</option>
    <option value ="13.5">13:30</option>
    <option value ="14">14:00</option>
    <option value ="14.5">14:30</option>
    <option value ="15">15:00</option>
    <option value ="15.5">15:30</option>
    <option value ="16">16:00</option>
    <option value ="16.5">16:30</option>
    <option value ="17">17:00</option>
    <option value ="17.5">17:30</option>
    <option value ="18">18:00</option>
    <option value ="18.5">18:30</option>
    <option value ="19">19:00</option>
    <option value ="19.5">19:30</option>
    <option value ="20">20:00</option>
    <option value ="20.5">20:30</option>
    <option value ="21">21:00</option>
	</select></td>
</tr>
<tr>
	<td align="right">Thursday: </td>
    <td><label for="Thursday">Start Time</label></td>
	<td><select name="Thursdaystart" id="Thursdaystart">
	<option value="0" selected>NONE</option>
	<option value ="08">8:00</option>
	<option value ="08.5">8:30</option>
    <option value ="09">9:00</option>
    <option value ="09.5">9:30</option>
    <option value ="10">10:00</option>
    <option value ="10.5">10:30</option>
    <option value ="11">11:00</option>
    <option value ="11.5">11:30</option>
    <option value ="12">12:00</option>
    <option value ="12.5">12:30</option>
    <option value ="13">13:00</option>
    <option value ="13.5">13:30</option>
    <option value ="14">14:00</option>
    <option value ="14.5">14:30</option>
    <option value ="15">15:00</option>
    <option value ="15.5">15:30</option>
    <option value ="16">16:00</option>
    <option value ="16.5">16:30</option>
    <option value ="17">17:00</option>
    <option value ="17.5">17:30</option>
    <option value ="18">18:00</option>
    <option value ="18.5">18:30</option>
    <option value ="19">19:00</option>
    <option value ="19.5">19:30</option>
    <option value ="20">20:00</option>
    <option value ="20.5">20:30</option>
    <option value ="21">21:00</option>
	 </select></td>
	<td>Stop Time</td>   
    <td><select name="Thursdaystop" id="Thursdaystop">
	<option value="0" selected>NONE</option>
	<option value ="08">8:00</option>
	<option value ="08.5">8:30</option>
    <option value ="09">9:00</option>
    <option value ="09.5">9:30</option>
    <option value ="10">10:00</option>
    <option value ="10.5">10:30</option>
    <option value ="11">11:00</option>
    <option value ="11.5">11:30</option>
    <option value ="12">12:00</option>
    <option value ="12.5">12:30</option>
    <option value ="13">13:00</option>
    <option value ="13.5">13:30</option>
    <option value ="14">14:00</option>
    <option value ="14.5">14:30</option>
    <option value ="15">15:00</option>
    <option value ="15.5">15:30</option>
    <option value ="16">16:00</option>
    <option value ="16.5">16:30</option>
    <option value ="17">17:00</option>
    <option value ="17.5">17:30</option>
    <option value ="18">18:00</option>
    <option value ="18.5">18:30</option>
    <option value ="19">19:00</option>
    <option value ="19.5">19:30</option>
    <option value ="20">20:00</option>
    <option value ="20.5">20:30</option>
    <option value ="21">21:00</option>
	 </select></td>
	</tr>
<tr>
	<td align="right">Friday: </td>
    <td><label for="Friday">Start Time</label></td>
	<td><select name="Fridaystart" id="Fridaystart">
	<option value="0" selected>NONE</option>
	<option value ="08">8:00</option>
	<option value ="08.5">8:30</option>
    <option value ="09">9:00</option>
    <option value ="09.5">9:30</option>
    <option value ="10">10:00</option>
    <option value ="10.5">10:30</option>
    <option value ="11">11:00</option>
    <option value ="11.5">11:30</option>
    <option value ="12">12:00</option>
    <option value ="12.5">12:30</option>
    <option value ="13">13:00</option>
    <option value ="13.5">13:30</option>
    <option value ="14">14:00</option>
    <option value ="14.5">14:30</option>
    <option value ="15">15:00</option>
    <option value ="15.5">15:30</option>
    <option value ="16">16:00</option>
    <option value ="16.5">16:30</option>
    <option value ="17">17:00</option>
    <option value ="17.5">17:30</option>
    <option value ="18">18:00</option>
    <option value ="18.5">18:30</option>
    <option value ="19">19:00</option>
    <option value ="19.5">19:30</option>
    <option value ="20">20:00</option>
    <option value ="20.5">20:30</option>
    <option value ="21">21:00</option>
	 </select></td>
	<td>Stop Time</td>   
    <td><select name="Fridaystop" id="Fridaystop">
	<option value="0" selected>NONE</option>
	<option value ="08">8:00</option>
	<option value ="08.5">8:30</option>
    <option value ="09">9:00</option>
    <option value ="09.5">9:30</option>
    <option value ="10">10:00</option>
    <option value ="10.5">10:30</option>
    <option value ="11">11:00</option>
    <option value ="11.5">11:30</option>
    <option value ="12">12:00</option>
    <option value ="12.5">12:30</option>
    <option value ="13">13:00</option>
    <option value ="13.5">13:30</option>
    <option value ="14">14:00</option>
    <option value ="14.5">14:30</option>
    <option value ="15">15:00</option>
    <option value ="15.5">15:30</option>
    <option value ="16">16:00</option>
    <option value ="16.5">16:30</option>
    <option value ="17">17:00</option>
    <option value ="17.5">17:30</option>
    <option value ="18">18:00</option>
    <option value ="18.5">18:30</option>
    <option value ="19">19:00</option>
    <option value ="19.5">19:30</option>
    <option value ="20">20:00</option>
    <option value ="20.5">20:30</option>
    <option value ="21">21:00</option>
	 </select></td>
</tr>
<tr>
	<td align="right">Saturday: </td>
    <td><label for="Saturday">Start Time</label></td>
	<td><select name="Saturdaystart" id="Saturdaystart">
	<option value="0" selected>NONE</option>
	<option value ="08">8:00</option>
	<option value ="08.5">8:30</option>
    <option value ="09">9:00</option>
    <option value ="09.5">9:30</option>
    <option value ="10">10:00</option>
    <option value ="10.5">10:30</option>
    <option value ="11">11:00</option>
    <option value ="11.5">11:30</option>
    <option value ="12">12:00</option>
    <option value ="12.5">12:30</option>
    <option value ="13">13:00</option>
    <option value ="13.5">13:30</option>
    <option value ="14">14:00</option>
    <option value ="14.5">14:30</option>
    <option value ="15">15:00</option>
    <option value ="15.5">15:30</option>
    <option value ="16">16:00</option>
    <option value ="16.5">16:30</option>
    <option value ="17">17:00</option>
    <option value ="17.5">17:30</option>
    <option value ="18">18:00</option>
    <option value ="18.5">18:30</option>
    <option value ="19">19:00</option>
    <option value ="19.5">19:30</option>
    <option value ="20">20:00</option>
    <option value ="20.5">20:30</option>
    <option value ="21">21:00</option>
	 </select></td>
	<td>Stop Time</td>   
    <td><select name="Saturdaystop" id="Saturdaystop">
	<option value="0" selected >NONE</option>
	<option value ="08">8:00</option>
	<option value ="08.5">8:30</option>
    <option value ="09">9:00</option>
    <option value ="09.5">9:30</option>
    <option value ="10">10:00</option>
    <option value ="10.5">10:30</option>
    <option value ="11">11:00</option>
    <option value ="11.5">11:30</option>
    <option value ="12">12:00</option>
    <option value ="12.5">12:30</option>
    <option value ="13">13:00</option>
    <option value ="13.5">13:30</option>
    <option value ="14">14:00</option>
    <option value ="14.5">14:30</option>
    <option value ="15">15:00</option>
    <option value ="15.5">15:30</option>
    <option value ="16">16:00</option>
    <option value ="16.5">16:30</option>
    <option value ="17">17:00</option>
    <option value ="17.5">17:30</option>
    <option value ="18">18:00</option>
    <option value ="18.5">18:30</option>
    <option value ="19">19:00</option>
    <option value ="19.5">19:30</option>
    <option value ="20">20:00</option>
    <option value ="20.5">20:30</option>
    <option value ="21">21:00</option>
	</select></td>
</tr>
<p>
</table>
 <input type = "button" value = "Submit Office Hours" onclick= "inputCheck()" />
</form>
</p>
<script type="text/javascript">
<!--
retreiveHours();
//-->
</script>
</body>
</html>
