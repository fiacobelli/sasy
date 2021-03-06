<?php
// The user is redirected here from login.php.
/*
This page requires mysql_connect.php, login_functions.inc.php
This page uses colorbox.css and jquery.custom.css
*/
require_once ('mysql_connect.php');
// Start the session.
session_start(); 
// If no session value is present,redirect the user:
if (!isset($_SESSION['user_id'])) 
{
	require_once ('includes/login_functions.inc.php');
	$url = absolute_url();
	header("Location: $url");
	exit();
}
//set $uid to be equal to the logged in user id
$uid=$_SESSION['user_id'];
//log the user type of the currently logged in user
$usertype=$_SESSION['u_type'];

//if user is faculty set search type ($stype)
	if($usertype==1)
	{
	$stype="facsrch";
	}
//if user is a student set search type ($stype)
	if($usertype==3)
	{
	$stype="stusrch";
	}
//create queries for sql
$q1="select * from users where user_id = $uid";
$q2="select * from sdtinfo where user_id =$uid";
//run query q1
$r1 = @mysql_query ($q1);
if (@mysql_num_rows($r1) !=0) 
{//open php rows if
	while ($row1 = @mysql_fetch_assoc($r1))
	{//open php while
		// create variables and assign values for name, phone number , office and email.
		$sname = $row1['First_Name']." ". $row1['Last_Name'];
		$phone = $row1['phone'];
		$email = $row1['email'];
		$office = $row1['Add2'];
	}//close php while
}//close php rows if
	
//if the user is a student, run query 2 to pull student info
if ($usertype == 3)
{//open student if
//run query q2
$r2 = @mysql_query ($q2);
	if (@mysql_num_rows($r2) !=0) 
	{//open php rows if

		while ($row2 = @mysql_fetch_assoc($r2))
		{//open php while
		
			// create variables for student major, level, and status
			$major = $row2['major'];
			$level = $row2['level'];
			$status =  $row2['status'];
		}//close php while
	}//close php rows if
}//close student if
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>S.A.Sy</title>

<!--  load JQUERY -->
<script src="./content/jquery.js"></script>
<link href="./content/jquery.custom.css" rel="stylesheet" type="text/css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script>
	//function call used for displaying closed appointments
	$(document).ready(function(){$("#aptinfo").dialog({show: 'slide' ,autoOpen:false,width: 500, buttons: [{text:"Ok", click: function(){$(this).dialog("close")}}]});});
	//functions call used for displaying graphs
    $(document).ready(function(){$("#graphinfo").dialog({show: 'slide' ,autoOpen:false,width: 500, buttons: [{text:"Ok", click: function(){$(this).dialog("close")}}]});});
	  
	/*
	This function accepts a div id, it then calls the graphshow function and passes it the div id
	When the graphshow function is finished populatin the div, it calls the jquery function to display the popup window
	*/
	function showgraph(divid)
	{
		graphshow(divid);
		$('#graphinfo').dialog("open");
	}
	
	/*
	This function accepts an appointment number (anum), it then calls the showResult function and passes it anum, the status
	of closed, and the div id aptinfo
	When the graphshow function is finished populatin the div, it calls the jquery function to display the popup window
	*/
	function showApt(anum)
	{
		showResult(anum,'closed','aptinfo');
		$('#aptinfo').dialog("open");
	}
  
	/*
	set functions used with datepicker, different function used for each input box where the datepicker is needed
	the id of the input is used in the function and the format that the date will take
	*/
	$(function(){$( "#admission" ).datepicker({dateFormat: 'yy-mm-dd'});});
	$(function(){$( "#graduation" ).datepicker({dateFormat: 'yy-mm-dd'});});
	$(function(){$( "#gadmission" ).datepicker({dateFormat: 'yy-mm-dd'});});
	$(function(){$( "#ggraduation" ).datepicker({dateFormat: 'yy-mm-dd'});});
	$(function(){$( "#startdate" ).datepicker({dateFormat: 'yy-mm-dd'});});
	$(function(){$( "#enddate" ).datepicker({dateFormat: 'yy-mm-dd'});});
	

  </script>

<script src="./content/jquery.colorbox.js"></script>
<script>
	$(document).ready(function()
	{
	//assign the ColorBox event to elements
	$(".ajax").colorbox();
	});
	
//setVisibility function is used to toggle the visibility of advanced search divs
//the show variables are used to track the status of the 3 divs that use the setvibility function
//the function acceps the div id to know which div to show/hide	
	var show1=0;
	var show2=0;
	var show3=0;
function setVisibility(ids) 
{//set setVisibility function
	//if the advanced appointments div being hiddne/shown
	if(ids=="advappts")
	{
		//if not showing, set it to visible and set show to be 1
		if (show1 ==0)
		{
 		 document.getElementById(ids).style.display = 'inline';
 	 	show1=1;
		}
		else
		//if visible, set it to be hidden, change show to 0 and reset the form
		if (show1 ==1)
		{
  		document.getElementById(ids).style.display = 'none';
  		show1=0;
		document.forms.advappts['keyword'].value="";
		document.forms.advappts['enddate'].value="";
		document.forms.advappts['startdate'].value="";
		//after resetting, run showresult again to update results to nolonger contain the advanced appointment search strings
		showResult(document.forms.advappts['s2'].value,'aptsearch','appointments');
		}
	}
	//if the advanced search div is being hidden/shown
	if(ids=="advsrch")
	{
		if (show2 ==0)
		{
 		 document.getElementById(ids).style.display = 'inline';
 	 	show2=1;
		}
		else
		if (show2 ==1)
		{
  		document.getElementById(ids).style.display = 'none';
  		show2=0;
		document.forms.advsrch['major'].value="";
		document.forms.advsrch['level'].value="";
		document.forms.advsrch['status'].value="";
		document.forms.advsrch['residency'].value="";
		document.forms.advsrch['admission'].value="";
		document.forms.advsrch['graduation'].value="";
		showResult(document.forms.advsrch['s1'].value,'ssearch','livesearch');
		}
	}
	//if the graph generater div is being hidden/shown
	if(ids=="charts")
	{
		if (show3 ==0)
		{
 		 document.getElementById(ids).style.display = 'inline';
 	 	show3=1;
		}
		else
		if (show3 ==1)
		{
  		document.getElementById(ids).style.display = 'none';
  		show3=0;
		}
	}

}//end setVisibility function
</script>
<script type="text/javascript">

/*
This function is called by showGraph
it accepts the div id being passed and uses it to pull values from the form fields inside the div
after gathering the values, it then passes them to graph.php and the results from graph.php are displayed in the 
graphinfo div
*/
function graphshow(divid)
{
//initialize adlsrch to be blank, adl search is used to pass values to graph.php
adlsrch="";
//create variables for each search term and pull in the values from the form fields
	var residency = document.forms.graphgen['residency'].value;
	var major = document.forms.graphgen['major'].value;
	var level = document.forms.graphgen['level'].value;
	var status = document.forms.graphgen['status'].value;
	var aptstatus = document.forms.graphgen['aptstatus'].value;
	var admission = document.forms.graphgen['gadmission'].value;
	var graduation = document.forms.graphgen['ggraduation'].value;
//if the variables are populated with info other than blanks, add the appropriate values to adlsrch	
if (major.length >=1)
	adlsrch=adlsrch+"&major="+major;
if (level.length >=1)
	adlsrch=adlsrch+"&level="+level;
if (status.length >=1)
	adlsrch=adlsrch+"&status="+status;
if (aptstatus.length >=1)
	adlsrch=adlsrch+"&aptstatus="+aptstatus;
if (residency.length >=1)
	adlsrch=adlsrch+"&residency="+residency;
if (admission.length >=1)
	adlsrch=adlsrch+"&admission="+admission;
if (graduation.length >=1)
	adlsrch=adlsrch+"&graduation="+graduation;

	
	if (divid.length<1)
		{ 
		
			document.getElementById(divid).innerHTML="";
			document.getElementById(divid).style.border="0px";
			return;
		}
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				//populate the div with the response received from graph.php
				document.getElementById(divid).innerHTML=xmlhttp.responseText;
				//set style elements of the div
				document.getElementById(divid).style.height="500px";
				document.getElementById(divid).style.width="580px";
				

			}
		}
//after gathering adlsrch values, open graph.php and send the values
xmlhttp.open("GET","graph.php?go=1"+adlsrch,true);
		xmlhttp.send();
}

//function showResult used for returning search results, it accepts a string to search, a type to identify what type of search, and a divid to know which div to display the results in.
function showResult(str,type,divid)
{
	if (show1==1 && str=="")
		str="adv@nc3d5earch";
	if (show2==1 && str=="")
		str="adv@nc3d5earch";
	//str=str.replace(/^0+/, '');
	var adlsrch = " ";
	var major = document.forms.advsrch['major'].value;
	var level = document.forms.advsrch['level'].value;
	var status = document.forms.advsrch['status'].value;
	var residency = document.forms.advsrch['residency'].value;
	var admission = document.forms.advsrch['admission'].value;
	var graduation = document.forms.advsrch['graduation'].value;
	var keyword = document.forms.advappts['keyword'].value;
	var enddate= document.forms.advappts['enddate'].value;
	var startdate =	document.forms.advappts['startdate'].value;
	if (major.length >=1)
	{
		adlsrch=adlsrch+"&major="+major;
	}
	if (level.length >=1)
		adlsrch=adlsrch+"&level="+level;
	if (status.length >=1)
		adlsrch=adlsrch+"&status="+status;
	if (residency.length >=1)
		adlsrch=adlsrch+"&residency="+residency;
	if (admission.length >=1)
		adlsrch=adlsrch+"&admission="+admission;
	if (graduation.length >=1)
		adlsrch=adlsrch+"&graduation="+graduation;
	if (keyword.length >=1)
{
	adlsrch=adlsrch+"&keyword="+keyword;
}
if (startdate.length >=1)
{
	adlsrch=adlsrch+"&startdate="+startdate;
}
if (enddate.length >=1)
{
	adlsrch=adlsrch+"&enddate="+enddate;
}

				
		if (str.length<1)
		{ 
			document.getElementById(divid).innerHTML="";
			document.getElementById(divid).style.border="0px";
			return;
		}
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById(divid).innerHTML=xmlhttp.responseText;
//sets style broder around results, currenlty commented out but left in incase I feel like putting it back in
//				document.getElementById(divid).style.border="1px solid #A5ACB2";
			if (divid=="livesearch")
			{
				document.getElementById(divid).style.height="200px";
			}
			else
			{
				document.getElementById(divid).style.height="290px";
			}
			document.getElementById(divid).style.overflow="auto";
			}
		}
	
		//when search function is called, send the search string, the search type (user vs appt), user id, and searcher type (faculty vs student)
		xmlhttp.open("GET","livesearch2.php?q="+str+"&t="+type+"&id=<?php echo $uid;?>"+adlsrch+"&styp=<?php echo $stype;?>",true);
		xmlhttp.send();
	}
	

</script>
<link href="content/colorbox.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700|Droid+Serif:400,700' rel='stylesheet' type='text/css'>
</head>
<body>
  <div class="header">
<p class="floattitle"><p1>S.A.Sy</p1> <p2>(Sutdent Advisement System)</p2></p>
<a href = "logout.php" title="logout">Log Out</a>
</div>

<!-- This div gets populated by graphshow function and used with displaying the graph-->
<div id="graphinfo"></div>
<!-- This div gets populated by the showResult function and used with displaying closed appointments-->
<div id="aptinfo"></div>


<div class="info">
	<div class="contentheader">
		<h1>Personal Information</h1>
	</div>
<div class="content">
<div class="floatlink">
<?php
if($usertype==1 || $usertype==2)
{
echo "<a  href='addfac.php' title='Add Faculty'>Add Faculty</a><br/>";
}
?>
</div>
<?php
//print default personal information
echo "Name: $sname<br />";
echo "Phone #: $phone<br />";
echo 'E-Mail: <a href="mailto:'.$email.'">'.$email.'</a><br /> ';
//is user is faculty print office location
if ($usertype==1)
	{
	echo "Office: $office<br />";
	}
//is user is a student print student info
if ($usertype==3)
	{
	echo "Concentration: $major<br />";
	echo "Level: $level<br />";
	echo "Status: $status<br />";
	}
//create update info link to pass user id, user type. class is ajax and uses colorbox
echo "<p><a class='ajax' href='updateinfo.php?q=".$uid."&t=$usertype&u=".$usertype."' title='update info'>Update Info</a>&nbsp;&nbsp;&nbsp;<br/><br/>";
if ($usertype==1)
	{
	//echo '<a class="ajax" href="hourset.php" title="Set Office Hours">Set Office Hours</a><br/><br/></p>';
	echo'<label>Chart Bulider</label><input type=checkbox id="btn" value=\'Show Layer\' onclick="setVisibility(\'charts\')" ><br/><br/>';
	echo'<div id="charts" style="display:none"><br/>';
	echo'<form id="graphgen"><table>';
	echo'
			<tr>
				<td align="right"><label>Residency: </label></td>
				<td><select name="residency">
					<option >Resident</option>
					<option>Non-Resident</option>
					<option>International</option>
					<option selected="selected"> </option>
					</select></td>';
	echo'<td align="right"><label>Student Status: </label></td>
				<td><input type="text" name="status" id="status" value=""/></td>
				<td><label>Graduation Date: </label></td>
			<td><input type="text" name="ggraduation" id="ggraduation" placeholder="Graduated since.." ></td>
				</tr>';
	echo'<tr>
			<td align="right"><label>Concentration: </label></td>
			<td><input type="text" name="major" id="major" value="" /></td>';
	echo'	<td align="right"><label>Level: </label></td> 
			<td><select name="level" >
					<option >Undergraduate</option>
					<option selected="selected">Graduate</option>
					<option>Post-Graduate</option>
			 		</select></td>
			<td><label>Admission Date: </label></td>
			<td><input type="text" name ="gadmission" id="gadmission" value="" placeholder="Admitted since..."></td>
		</tr>';
	echo'<tr>
			<td align="right"><label>Appointment Status: </label></td>
			<td><select name="aptstatus" id="aptstatus">
					<option >Open</option>
					<option>Closed</option>
					<option selected="selected"> </option>
					</select></td>
			
		</tr>';
		



		
	echo'</table>';
	echo '<a href="javascript:showgraph(\'graphinfo\');" title="Show Charts" class="floatlink">Show Charts</a><br/><br/>';
	echo'</form></div>';
	}
 ?>
</div>

</div>
<div class="appointment"><!-- start appointment class div -->
	<div class="contentheader"><!-- start content header class div -->
		<h1>Appointments</h1>
	</div><!-- close content header class div-->
	<div class="content"> <!-- start content div -->
		<label>Advanced Search</label>
		<input type=checkbox id="btn" value='Show Layer' onclick="setVisibility('advappts')" >
		<br/>
		<div id="advappts" style="display:none"><!--start advanced search div-->
			<form id="advappts">
				<label>Word or phrase in Notes/Purpose:
					<input type="text" name="keyword" id="keyword" value="" onkeyup="showResult(document.forms.advappts['s2'].value,'aptsearch','appointments')">
				</label>
				<br />
				<label>Date Range: <br/>After<input type="text" name ="startdate" id="startdate" value="" onchange="showResult(document.forms.advappts['s2'].value,'aptsearch','appointments')">
				</label>
				<br/>
				<label>Before
				<input type="text" name="enddate" id="enddate" onchange="showResult(document.forms.advappts['s2'].value,'aptsearch','appointments')">
				</label>	
				<br/>
		</div><!-- close advanced search div-->
		<label>Search:</label>
		<input type="text" size="30" id="s2" onkeyup="showResult(this.value,'aptsearch','appointments')" />
		</form>
	</div><!-- end content div -->
	<div id="appointments" ></div><!-- create div for appointment display -->
	<br />
</div> <!-- end appointment class div-->


<div class="studentsearch" > <!--start student search class div -->
	<div class="contentheader"> <!--start content header div -->
		<h1>StudentSearch</h1><br/>
        <p class="floatlink" align="right"><a  href='addstudent.php' title='Add Student'>Add Student</a></p>
	</div> <!-- end content header div-->
	<div class="content"> <!-- start content div-->
		<label>Advanced Search</label>
		<input type=checkbox id="btn" value='Show Layer' onclick="setVisibility('advsrch')" >
		<br/>
		<div id="advsrch" style="display:none"><!-- start advanced search div -->
			<form id=advsrch>
				<label>Concentration:
				<input type="text" name="major" id="major" value="" onchange="showResult(document.forms.advsrch['s1'].value,'ssearch','livesearch')" onkeyup="showResult(document.forms.advsrch['s1'].value,'ssearch','livesearch')"/><br/>
				</label>
				<label>Level:  <select name="level" onChange="showResult(document.forms.advsrch['s1'].value,'ssearch','livesearch')">
					<option >Undergraduate</option>
					<option>Graduate</option>
					<option>Post-Graduate</option>
					<option selected="selected"> </option>
			 		</select></label> <br />
				<label>Status:
				<input type="text" name="status" id="status" value="" onchange="showResult(document.forms.advsrch['s1'].value,'ssearch','livesearch')" onkeyup="showResult(document.forms.advsrch['s1'].value,'ssearch','livesearch')"/>
				</label>
				<br />
				<label>Residency:  <select name="residency" onChange="showResult(document.forms.advsrch['s1'].value,'ssearch','livesearch')">
					<option >Resident</option>
					<option>Non-Resident</option>
					<option selected="selected"> </option>
					</select></label> <br />
				<label>Admission Date:
				<input type="text" name ="admission" id="admission" value="" onkeyup="showResult(document.forms.advsrch['s1'].value,'ssearch','livesearch')">
			    </label>
				<br />
				<label>Graduation Date:
				<input type="text" name="graduation" id="graduation" onkeyup="showResult(document.forms.advsrch['s1'].value,'ssearch','livesearch')">
			    </label>
				<br/>
		</div><!-- end advanced search div-->
			<label>Search:</label>
			<input type="text" id="s1" size="30" onkeyup="showResult(this.value,'ssearch','livesearch')" /></p>
			<div id="livesearch"></div><br/> <!-- created div for search results-->
			
			<br />
			</form>
		</div><!-- end content div-->
</div><!-- end student search div -->

<div class="bottom"></div>
</body>
</html>