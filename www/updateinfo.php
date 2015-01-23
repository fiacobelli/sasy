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
$q=$_GET["q"];
$t=$_GET["t"];
$u=$_GET["u"];


// initialize some varibles
$major='';
$level='';
$status='';
$admission='';
$graduation='';
$resident='';
$comments='';

$q1="select * from users where user_id =$q";
$q2="select * from sdtinfo where user_id =$q";

$r1 = @mysql_query ($q1);
	if (@mysql_num_rows($r1) !=0) 
	{//open php rows if

		while ($row1 = @mysql_fetch_assoc($r1))
		{//open php while
		
			// create variables for the a items that will be searched and make them all lowercase (what we want to search through)
			$phone = $row1['phone'];
			$email = $row1['email'];
			$office =  $row1['Add2'];

		}//close php while
	}//close php rows if
	
	if ($t == 2)
	{
		$r2 = @mysql_query ($q2);
			if (@mysql_num_rows($r2) !=0) 
				{//open php rows if

				while ($row2 = @mysql_fetch_assoc($r2))
					{//open php while
		
					// create variables for the a items that will be searched and make them all lowercase (what we want to search through)
					$major = $row2['major'];
					$level = $row2['level'];
					$status =  $row2['status'];
					$admission= $row2['admissiondate'];
					$graduation = $row2['graduationdate'];
					$resident = $row2['residency'];
					$comments = $row2['Comments'];
					}//close php while
				}//close php rows if
	}	
?>
    
<script type="text/javascript">

function setval()
{
	var graddate = "<?php echo $graduation?>";
	document.forms.form1['level'].value = "<?php echo $level?>";
	document.forms.form1['residency'].value = "<?php echo $resident?>";
	document.forms.form1['admission'].value = "<?php echo $admission?>";
	if (graddate == "0000-00-00")
	{
		document.forms.form1['graduation'].value = " ";
	}
	else
	{
		document.forms.form1['graduation'].value = "<?php echo $graduation?>";
	}

}

function errorcheck()
{//begin inputCheck function
	<?php echo 'var utype = '.$t.';';?>
	var inputError=new Array(" "," "," "," "," "," "," ");
	var errorCount=0;
	var office = document.forms.form1['office'].value;
	var phone = document.forms.form1['phone'].value;
	var email= document.forms.form1['email'].value;
	var major =document.forms.form1['major'].value;
	var level =document.forms.form1['level'].value;
	var status =document.forms.form1['status'].value;
	var returnto =document.forms.form1['returnto'].value;
	var newpass =document.forms.form1['newpass'].value;
	var cnewpass =document.forms.form1['cnewpass'].value;
	
	
	if (office.length < 1 && utype ==1)
	{
		inputError[0]=("\n Invalid Office Location.");
		errorCount=errorCount+1;
	}

	if (phone.length < 1)
	{
		inputError[1] = ("\n Phone number must be entered.");
		errorCount=errorCount+1;
	}

	if (email.length < 1)
	{
		inputError[2]=("\n Email must be entered");
		errorCount=errorCount+1;
	}

	if (major.length < 1 && utype ==2)
	{
		inputError[3] = ("\n Major must be entered");
		errorCount=errorCount+1;
	}
	
	if (level.length < 1 && utype ==2)
	{
		inputError[4]=("\n Level must be entered");
		errorCount=errorCount+1;
	}
	
	if (status.length < 1 && utype ==2)
	{
		inputError[5] = ("\n Status must be entered");
		errorCount=errorCount+1;
	}
	if (newpass.length >1 && newpass.length < 8)
	{
		inputError[6] = ("\n Password is too Short");
		errorCount=errorCount+1;
	}
	if (newpass.length >= 8 && newpass != cnewpass)
	{
		inputError[6] = ("\n Passwords do not Match");
		errorCount=errorCount+1;
	}


	if (errorCount >0)
		alert(errorCount+" Error(s). "+inputError[0]+inputError[1]+inputError[2]+inputError[3]+inputError[4]+inputError[5]+inputError[6]);
	if(errorCount == 0)
	{
		document.forms["form1"].submit();
		
	}
}// end errorcheck function

function cancel()
{
window.location = '';
}

</script>
<?php

echo '<p align="center">Update Personal Information</p><br>

<form id="form1" name="form1" method="post"  action="infosubmit.php">
  <p>
  <input type="hidden" name="updateid" id="updateid" value="'.$q.'"/>
  <input type="hidden" name="usertype" id="usertype" value="'.$u.'"/>
   <input type="hidden" name="returnto" id="returnto" value="'.$t.'"/>

  <table class="tablecenter">';
  
   if ($t == 1)
   {
    echo '<tr>
			<td align="right"><label>Office: </label></td>
      		<td><input name="office" type="text" id="office" value="'.$office.'" /></td>
		</tr>';
   }
   else
   	 {
   	 echo '<input type="hidden" name="office"  id="office" value="'.$office.'" />';
 	  }
   echo '<tr>
   			<td align="right"><label>Phone #: </label></td>
      		<td><input  type="text"  name="phone" id="phone" value="'.$phone.'"/></td>
		</tr>
    	<tr>
			<td align="right"><label>E-mail:</label></td>
     		<td> <input  type="text"  name="email" id="email" value="'.$email.'"/></td>
		</tr>
		';
if ($t == 2)
{	
 echo '	a<tr>
 			<td align="right"><label>Concentration: </label></td>
      		<td><input type="text" name="major" id="major" value="'.$major .'"/></td>
		</tr>
		<tr>
			<td align="right"><label>Level: </label></td> 
		 	<td><select name="level" id="level">
	      		<option>Undergraduate</option>
	      		<option>Graduate</option>
	      		<option>Post-Graduate</option>
				</select></td>
		</tr>
 
    	<tr>
			<td align="right"><label>Status: </label></td>
       		<td><select name="status" id="status" value='.$status.'>
                                         <option '.($status=="FULL"?"selected":"").'>FULL</option>
                                         <option '.($status=="PREQ"?"selected":"").'>PREQ</option>
                                         <option '.($status=="DENIED"?"selected":"").'>DENIED</option>
                                         <option '.($status=="DEFERRED"?"selected":"").'>DEFERRED</option>
                                         <option '.($status=="INACTIVE"?"selected":"").'>INACTIVE</option>
                                </select>
		<!--<input type="text" name="status" id="status" value="'.$status.'"/>-->
</td>
		</tr>
 	 	<tr>
			<td align="right"> <label>Residency:</label></td>
	    	<td><select name="residency" id="residency">
      			<option selected="selected">Resident</option>
      			<option>Non-Resident</option>
			<option>International</option>
				</select></td>
		</tr>
	    <tr>
			<td align="right"><label>Admission Date: </label></td>
			<td><input type="text" name ="admission" id="admission" value=""></td>
  			<td><label>YYYY-MM-DD</label></td>
		</tr>
	    <tr>
			<td align="right"><label>Graduation Date: </label></td>
       		<td><input type="text" name="graduation" id="graduation"></td>
   		   <td><label>YYYY-MM-DD</label></td>
		</tr>
	    <tr>
	       <td align="right"><label>Comments: </label></td>
	       <td><textarea name="comments" id="comments">'.$comments.'</textarea></td>
	    </tr>
		
/>';
}
else
{	
 echo '
      <input  type="hidden"  name="major" id="major" value="'.$major .'"/>
      <input  type="hidden"  name="level" id="level"value="'.$level.'" />
      <input  type="hidden"  name="status" id="status" value="'.$status.'"/>
      <input  type="hidden"  name="residency" id="residency" value="'.$resident.'"/>
      <input  type="hidden"  name="admission" id="admission" value="'.$admission.'"/>
      <input  type="hidden"  name="graduation" id="graduation" value="'.$graduation.'"/>';
}
echo'<tr>
			<td align="right"><label>New Password: </label></td>
       		<td><input type="password" name="newpass" id="newpass"></td>
		</tr>
		 <tr>
			<td align="right"><label>Confirm New Password: </label></td>
       		<td><input type="password" name="cnewpass" id="cnewpass"></td>
		</tr>
		<tr>
		<td></td>
		<td>Password must be </td>
		</tr>
		<tr>
		<td></td>
		<td>at least 8 characters</td>
		</tr>
 </p></table>
  </form><p align = "center">';

echo '<input type = "button" value = "Submit" name = "submit" onclick= "errorcheck()" />
    <input type = "button" value = " Cancel " name = "submit" onclick= "cancel()" />
  </p>';
?>
<script type="text/javascript">
setval();
</script>