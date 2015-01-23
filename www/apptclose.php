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
$s=$_GET["s"];
?>
<script type="text/javascript">
<!--

function errorcheck()
{//begin inputCheck function
	document.forms["form1"].submit();
}// end errorcheck function

function cancel()
{
	window.location = '';
}
//-->
</script>
<?php

echo '<div align="center"><p><o>WARNING</o></p><br />
You will not be able to add notes or make changes after closing the appointment.</br>
Are you sure you wish to close the appointment?</br>

<form id="form1" name="form1" method="post"  action="closeit.php">
  <input type="hidden" name="apptid" id="apptid" value="'.$q.'"/>
   <input type="hidden" name="sid" id="sid" value="'.$s.'"/>
  </form>';

echo '<input type = "button" value = "Yes (Close it)" name = "submit" onclick= "errorcheck()" />
    <input type = "button" value = "No (Go Back)" name = "submit" onclick= "cancel()" />
  </p>';
?>