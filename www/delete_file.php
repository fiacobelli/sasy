<?php
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
		// If no session value is present,redirect the user:
		if (!isset($_SESSION['user_id'])) 
		{//open session if
			require_once ('includes/login_functions.inc.php');
			$url = absolute_url();
			header("Location: $url");
			exit();
		}//close session if
     }//close else
	

}
 else 
{//open else
    echo 'Error! No ID was passed.';
}//close else	 

 // Fetch the file information
	$query = "SELECT * FROM file WHERE id = ".$id;
   	$result = @mysql_query($query);
 
// Check if it was successfull
	if (@mysql_num_rows($result) ==1) 
		{//open if result
            // Make sure the result is valid
            // Get the row
			$d1=("update file set apptid ='0' where id =".$id);
			$results2 = @mysql_query($d1);
			if ($results2)
			 echo "<h3> file deleted </h3>";
			else
			{
				echo "<h3> Update Failure</h3>";  
				echo $qry;
				echo	@mysql_error(); 
			}
        }//close if result
        else 
		{//open else
            echo "Error! Query failed: <pre>{$dbc->error}</pre>";
        }//close else
	

	
echo '<script type="text/javascript">';
echo "window.location = 'student.php?q=".$_GET['student']."';";
echo '</script>';


       
?>
