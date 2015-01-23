<?php 

//This page is required in index.php and used on all pages when a session is not active
 // This page defines two functions used by the login/logout process.

 /* This function determines and returns an
absolute URL.
* It takes one argument: the page that
concludes the URL.
* The argument defaults to index.php.
*/
function absolute_url ($page = 'index.php') 
{
	// Start defining the URL...
	// URL is http:// plus the host name plus the current directory: 
	$url = 'http://' . $_SERVER['HTTP_HOST']. dirname($_SERVER['PHP_SELF']);

	// Remove any trailing slashes:
	$url = rtrim($url, '/\\');

	// Add the page:
	$url .= '/' . $page;

	// Return the URL:
	return $url;

} // End of absolute_url() function.


 /* This function validates the form data
(the email address and password).
 * If both are present, the database is
queried.
 * The function requires a database
connection.
 * The function returns an array of
information, including:
 * - a TRUE/FALSE variable indicating
success
 * - an array of either errors or the
database result
 */
function check_login( $uid = '',$pass = '') 
{
	$errors = array(); // Initialize error array.

	// Validate the email address:
	if (empty($uid)) 
	{
		$errors[] = 'You forgot to enter your user ID.';
	} 
	else
	{
		$e =$uid;
	}

	// Validate the password:
	if (empty($pass)) 
	{
		$errors[] = 'You forgot to enter your password.';
	}
	else 
	{
		$p = $pass;
	}

	if (empty($errors)) 
	{ // If everything's OK.
	// Retrieve the user_id and first_name for that username/password combination:
		$q = "select user_id, user_type  from Logins where username = '$e' and pwd = '$p'";
 		$r = @mysql_query ($q); // Run the query.
	// Check the result:
		if (@mysql_num_rows($r) !=0) 
		{
	// Fetch the record:
	// $row = @mysqli_fetch_assoc($r);
			$row = @mysql_fetch_array ($r,MYSQLI_ASSOC);
	// Return true and the record:
			return array(true, $row);
		} 
		else 
		{ // Not a match!
			$errors[] = 'The user id and password entered do not match those on file.';
		}
	} // End of empty($errors) IF.

	// Return false and the errors:
	return array(false, $errors);

} // End of check_login() function.

?>
