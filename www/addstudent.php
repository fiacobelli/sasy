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

$user = $_SESSION['user_id'];

?>
<script src="./content/jquery.js"></script>
<!-- JQUERY -->
<link href="./content/jquery.custom.css" rel="stylesheet" type="text/css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script>
$(function() {
    $( "#admission" ).datepicker({dateFormat: 'yy-mm-dd'});
	
});
$(function() {
    $( "#graduation" ).datepicker({dateFormat: 'yy-mm-dd'});
	
});
</script>
<script type="text/javascript">
<!--
function nameSearch(str,divid)
	{
			
		if (str.length<2)
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

			}
		}
	
		//when search function is called, send the search string, the search type (user vs appt), user id, and searcher type (faculty vs student)
		if(divid=="name")
			xmlhttp.open("GET","namesearch.php?name="+str,true);
		if(divid=="idnumber")
			xmlhttp.open("GET","namesearch.php?idn="+str,true);
		xmlhttp.send();
	}
	
function errorcheck()
{//begin inputCheck function
	var inputError=new Array(" "," "," "," "," "," "," "," ",""," ");
	var errorCount=0;
	var fname = document.forms.form1['fname'].value;
	var lname = document.forms.form1['lname'].value;
	var phone = document.forms.form1['phone'].value;
	var email= document.forms.form1['email'].value;
	var major =document.forms.form1['major'].value;
	var status = "TEMPFIX"; //document.forms.form1['status'].value;
	var admission =document.forms.form1['admission'].value;
	var password =document.forms.form1['password'].value;
	var confirmed =document.forms.form1['confirm'].value;
	var username =document.forms.form1['uname'].value;
	var idn =document.forms.form1['idn'].value;
	if (fname.length < 1)
	{
		inputError[0]=("\n Invalid first name.");
		errorCount=errorCount+1;
	}

if (lname.length < 1 )
	{
		inputError[1]=("\n Invalid last name");
		errorCount=errorCount+1;
	}

	if (phone.length < 1)
	{
		inputError[2] = ("\n Phone number must be entered.");
		errorCount=errorCount+1;
	}

	if (email.length < 1)
	{
		inputError[3]=("\n Email must be entered");
		errorCount=errorCount+1;
	}

	if (major.length < 1)
	{
		inputError[4] = ("\n Major must be entered");
		errorCount=errorCount+1;
	}

	
	if (status.length < 1)
	{
		inputError[5] = ("\n Status must be entered");
		errorCount=errorCount+1;
	}
	if (admission.length < 1)
	{
		inputError[6] = ("\n Admission Date must be entered");
		errorCount=errorCount+1;
	}
	if (password.length < 8)
	{
		inputError[7] = ("\n Password is too Short");
		errorCount=errorCount+1;
	}
	if (password.length >= 8 && password != confirmed)
	{
		inputError[7] = ("\n Passwords do not Match");
		errorCount=errorCount+1;
	}
	if (username.length <3)
	{
		inputError[8] = ("\n Username is too short (must be longer than 3 characters)");
		errorCount=errorCount+1;
	}
	if (username.length <1)
	{
		inputError[8] = ("\n Username must be entered");
		errorCount=errorCount+1;
	}
	
	if (document.getElementById('name').innerHTML=="<o>Name already in use</o>")
		{
		inputError[8] = ("\n Username is already in use");
		errorCount=errorCount+1;
		}
		if (idn.length <1)
	{
		inputError[9] = ("\n ID must be entered");
		errorCount=errorCount+1;
	}
	
	if (document.getElementById('idnumber').innerHTML=="<o>ID already in use</o>")
		{
		inputError[9] = ("\n ID number is already in use");
		errorCount=errorCount+1;
		}
	if (errorCount >0)
		alert(errorCount+" Error(s). "+inputError[0]+inputError[1]+inputError[2]+inputError[3]+inputError[4]+inputError[5]+inputError[6]+inputError[7]+inputError[8]+inputError[9]);
	if(errorCount == 0)
	{
		document.forms["form1"].submit();
	}
}// end errorcheck function

function cancel()
{
window.location = 'begin.php';
}



//-->
</script>
<link href="content/colorbox.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700|Droid+Serif:400,700' rel='stylesheet' type='text/css'>
<body
<?php
echo '<p align="center">Enter Student Information</p><br />
<form id="form1" name="form1" method="post"  action="studentsubmit.php">
  <p align="center">
  <input type="hidden" name="updateid" id="updateid" value="'.$user.'"/>';
 ?>  
<table class="tableright"> 
	<tr>  
		<td><label>First Name: </label></td>
		<td align="left"><input type="text" name="fname" id="fname" value=""/></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>    

	<tr>
		<td><label>Last Name: </label></td>
		<td align="left"><input type="text" name="lname" id="lname" value=""/></td>
	</tr>
    
	<tr>
    	<td><label>Phone #: </label></td>
		<td align="left"><input  type="text"  name="phone" id="phone" value=""/></td>
	</tr>
    
	<tr>
    	<td><label>E-mail: </label></td>
		<td align="left"><input  type="text"  name="email" id="email" value="f-iacobelli@neiu.edu"/></td>
	</tr>
    
	<tr>
    	<td><label>Concentration: </label></td>
		<td align="left"><input type="text" name="major" id="major" value="GS01"/></td>
	</tr>
    
	<tr>
		<td><label>Level: </label></td>
		<td align="left"><select name="level">
			<option>Undergraduate</option>
			<option selected="selected">Graduate</option>
			<option>Post-Graduate</option>
			</select></td>
    </tr>
    
	<tr>
		<td><label>Status: </label></td>
		<td align="left"><select name="status" id="status">
		    			 <option>FULL</option>
					 <option>PREQ</option>
					 <option>DENIED</option>
					 <option>DEFERRED</option>
					 <option>INACTIVE</option>
				</select>
		</td>
	</tr>
    
	<tr>
    	<td><label>Ethnicity: </label></td>
		<td align="left"><select name="ethnic">
			<option>Caucasian</option>
			<option>African American</option>
			<option>Hispanic</option>
			<option>Asian</option>
			<option>Middle eastern</option>
			<option>Pacific Islander</option>
			<option>Native American/Alaskan</option>
			<option>Other</option>
			<option selected="selected"> </option>
			</select></td>
	</tr>
    
	<tr>
    	<td><label>Residency: </label></td>
		<td align="left"><select name="residency">
			<option selected="selected">Resident</option>
			<option>Non-Resident</option>
			<option>International</option>
			</select></td>
    </tr>
    
	<tr>
    	<td><label>Admission Date: </label></td>
		<td align="left"><input type="text" name ="admission" id="admission" value=""></td>
		<td align="left"><label>YYYY-MM-DD</label></td>
	</tr>

	<tr>
		<td><label>Graduation Date: </label></td>
        <td align="left"><input type="text" name="graduation" id="graduation"></td>
        <td align="left"><label>YYYY-MM-DD</label></td>
	</tr>
    
    <tr>
    	<td><label>Username: </label></td>
        <td align="left"><input type="text" name="uname" id="uname" onkeyup="nameSearch(this.value,'name')"></td>
		<td align="left"><div id="name"></div></td>
	</tr>
    <tr>
    	<td></td>
		<td align="center"><label>(example: jdoe)</label></td>
	</tr>
     <tr>
    	<td><label>ID number: </label></td>
        <td align="left"><input type="text" name="idn" id="idn" onkeyup="nameSearch(this.value,'idnumber')"></td>
		<td align="left"><div id="idnumber"></div></td>
	</tr>
	
    
    <tr>
		<td><label>Password: </label></td>
		<td align="left"><input type="password" name="password" id="password"></td>
	</tr>
	 
    <tr>
		<td><label>Confirm Password: </label></td>
		<td align="left"><input type="password" name="confirm" id="confirm"></td>
	</tr>
    <tr>
    	<td></td>
		<td><label>(8 characters or more)</label></td>
    </tr>
   <tr>
      <td><label>Comments: </label></td>
      <td align="left"><textarea name="comments" id="comments" rows=3 cols=20></textarea></td>
   </tr>
</p></table>
  </form><p>

<input type = "button" value = "Submit" name = "submit" onclick= "errorcheck()" />
    <input type = "button" value = " Cancel " name = "submit" onclick= "cancel()" />
  </p>
  </body>