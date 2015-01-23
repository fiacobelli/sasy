<?php
/*
This page is used for downloading files, the file id is passed by the link
the users click on  using get
*/
 require_once ('mysql_connect.php');
// Make sure an ID was passed
if(isset($_GET['id'])) 
{//open main if
// Get the ID
    $id = intval($_GET['id']);
 
    // Make sure the ID is in fact a valid ID
    if($id <= 0) 
	{//open id if
        die('The ID is invalid!');
    }//close id if
    else 
	{//open else
       session_start(); 
		if (!isset($_SESSION['user_id'])) 
		{//open session if
			require_once ('includes/login_functions.inc.php');
			$url = absolute_url();
			header("Location: $url");
			exit();
		}//close session if
     }//close else
 
        // Fetch the file information
        $query = "
            SELECT `mime`, `name`, `size`, `data`
            FROM `file`
            WHERE `id` = {$id}";
       	$result = @mysql_query($query);
 
// Check if it was successfull
	if (@mysql_num_rows($result) ==1) 
		{//open if result
            // Make sure the result is valid
            // Get the row
			$row = @mysql_fetch_assoc($result);
            
                // Print headers
                header("Content-Type: ". $row['mime']);
                header("Content-Length: ". $row['size']);
                header("Content-Disposition: attachment; filename=". $row['name']);
 
                // Print data
                echo $row['data'];

        }//close if result
        else 
		{//open else
            echo "Error! Query failed: <pre>{$dbc->error}</pre>";
        }//close else
       

}
else 
{//open else
    echo 'Error! No ID was passed.';
}//close else
?>