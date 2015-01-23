<?php 

	// This page prints any errors associated with logging in
	// and it creates the entire login page, including the form.
	//included in index.php

 // Include the header:
$page_title = 'Login';


 // Print any error messages, if they
exist:
 if (!empty($errors)) 
 {
 	echo '<h1>Error!</h1>
		 <p class="error">The following error(s)
		occurred:<br />';
	 foreach ($errors as $msg) 
	 {
		 echo " - $msg<br />\n";
	 }
	 echo '</p><p>Please try again.</p>';
 }

 // Display the form:
 ?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <div>
 <h1>S.A.Sy</h1>
 <h2>(Student Advisement System)</h2>
 <h1>Login</h1>
 <form action="index.php" method="post">
 <p>User ID: 
   <input type="text" name="uid" size="20" maxlength="80" />
</p>
 <p>Password: <input type="password" name="pass" size="20" maxlength="20"
/></p>
 <p><input type="submit" name="submit" value="Login" /></p>

<input type="hidden" name="submitted"
value="TRUE" />
 </form>
</div>
</html>