<?php # Script 11.8 - login.php #3
if (isset($_POST['submitted'])){
require_once ('includes/login_functions.inc.php');
require_once ('mysql_connect.php');
list ($check, $data) = check_login($_POST['uid'], $_POST['pass']);
if ($check){// OK!
session_start();
// Set the session data:.
$_SESSION['id'] = $data['user_id'];
 // Redirect:
$url = absolute_url ('main.php');
header("Location: $url");
exit();
} else { // Unsuccessful!
$errors = $data;
}
} // End of the main submit conditional.
include ('includes/login_page.inc.php');
?>
