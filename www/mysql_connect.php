<?php  # mysql_connect.php
//required for all pages
// Define constants for connection
define ('DB_USER', 'sasy');      // replace xxxx with your mysql username    
define ('DB_PASSWORD', 'lwh3059');  // replace yyyy with your mysql password
define ('DB_HOST', 'localhost');
define ('DB_NAME', 'sasy');      // replace zzzzzz with your database name

// Connect to DB and select main DB
$dbc = @mysql_connect( DB_HOST, DB_USER, DB_PASSWORD) or
die('Could not connect to  MySQL: '. mysql_error());

@mysql_select_db(DB_NAME) or
die('Could not select the database: '. mysql_error());

?>
