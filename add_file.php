<?php
require_once ('mysql_connect.php');
// Check if a file has been uploaded
if(isset($_FILES['uploaded_file'])) {
    // Make sure the file was sent without errors
    if($_FILES['uploaded_file']['error'] == 0) 
	{
      session_start(); 
// If no session value is present,redirect the user:
	if (!isset($_SESSION['user_id'])) 
	{
	require_once ('includes/login_functions.inc.php');
	$url = absolute_url();
	header("Location: $url");
	exit();
	}
        // Gather all required data
		$apptid = $_POST['apptid'];
        $name = @mysql_real_escape_string($_FILES['uploaded_file']['name']);
        $mime = @mysql_real_escape_string($_FILES['uploaded_file']['type']);
        $data = @mysql_real_escape_string(file_get_contents($_FILES  ['uploaded_file']['tmp_name']));
        $size = intval($_FILES['uploaded_file']['size']);
 
        // Create the SQL query
        $query = "
            INSERT INTO `file` (
                `name`, `mime`, `size`, `data`, `created`,`apptid`
            )
            VALUES (
                '{$name}', '{$mime}', {$size}, '{$data}', NOW(), '{$apptid}'
            )";
 
        // Execute the query
        $result = @mysql_query($query);
 
        // Check if it was successfull
        if($result) {
            echo 'Success! Your file was successfully added!';
        }
        else {
            echo 'Error! Failed to insert the file'
               . "<pre>{$dbLink->error}</pre>";
        }
    }
    else {
        echo 'An error accured while the file was being uploaded. '
           . 'Error code: '. intval($_FILES['uploaded_file']['error']);
    }
 

}
else {
    echo 'Error! A file was not sent!';
}
 
// Echo a link back to the main page
?>
<script type="text/javascript">
<?php echo "window.location = 'student.php?q=".$_POST['studentid']."&a=".$apptid."';";
?>
</script>
 