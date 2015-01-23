<?php
/*
included in pages
This function is used to display files that have been uploaded as well as create
the form used for uploading files
*/
//the function received a status describing the appointment (closed or open)
function fileview($status)
{
	/*
	bring in global variables ($q is the appiontment id, $sid is the id of the student
	$hint is the output variable that has already been created by the calling page, the file upload will be appended
	to that variable
	*/
	global $q,$hint,$sid;
	//set part1 to be blank
	$part1="";
	//set part 2 to be blank
	$part2="";
	
	//if the appointment is still open, create the form for uploading files and attach it to $hint
	if ($status=="open")
	{
		$hint=$hint.'
			<p >File Upload:</p>
			<form action="add_file.php" method="post" enctype="multipart/form-data">
			<input type="file" name="uploaded_file"><br>
			<input type="submit" value="Upload file">
			<input type="hidden" name="apptid" id="apptid" value="'.$q.'"/>
			<input type="hidden" name="studentid" id="studentid" value="'.$sid.'"/>
			</form>
			<br/><br/>';
	}
	//create title for uploaded files and attach to $hint
	$hint=$hint.'<p><u>Uploaded Files:</u><br/>';
	// Query for a list of all existing files and format the date
	$sql = "select *,Date_FORMAT(created,'%Y-%d-%m %h:%m %p') as created from file where apptid = ".$q;
	//run the query
	$result = @mysql_query($sql);
	// Check if it was successfull
	if (@mysql_num_rows($result) !=0) 
	{//open php rows if
 		// Print the top of a table
        $part1= '<table>
                <tr>
					<td></td>
                    <td><b>Name</b></td>
                    <td><b>Size (bytes)</b></td>
                    <td><b>Created</b></td>
                    <td><b>&nbsp;</b></td>
                </tr>';
 
		while ($row = @mysql_fetch_assoc($result))
		{//open php while
		
			//pick icon
			//set $mime to be the mimetype of the file in the db
			$mime=$row['mime'];
			//check to see if the uploaded files matches the description of the known file types
			$position1 = substr_count($mime, 'word');
			$position2= substr_count($mime, 'text');
			$position3 = substr_count($mime, 'pdf');
			$position4 = substr_count($mime, 'presentation');
			$position5 = substr_count($mime, 'spre');
			if ($position1 != 0)
			{
				$iconLocation = "./icons/doc.bmp";
				$doctype = "Word Document";
			}
			else
			if ($position2 != 0)
			{
				$iconLocation = "./icons/text.bmp";
				$doctype = "Text Document";
			}
			else
			if ($position3 != 0)
			{
				$iconLocation = "./icons/pdf.bmp";
				$doctype = "PDF";
			}
			else
			if ($position4 != 0)
			{
				$iconLocation = "./icons/ppt.bmp";
				$doctype = "PowerPoint Document";
			}
			else
			if ($position5 != 0)
			{
				$iconLocation = "./icons/xls.bmp";
				$doctype = "Excel Document";
			}
			else
			{
				$iconLocation = "./icons/file.bmp";
				$doctype = "Document";
			}
			//once icon is determined, create the link and output file info in the table, do for each file found during loop
			$part2=$part2. "
                <tr>
					<td align='right'><a href='get_file.php?id={$row['id']}'><img src='".$iconLocation."' title='".$doctype."' width='25' height='25' /></a></td>
                    <td align='left'>{$row['name']}</td>
                    <td>{$row['size']}</td>
                    <td>{$row['created']}</td>
                    <td><a href='get_file.php?id={$row['id']}'>Download</a></td>
					";
			if($status == "open")
			{
				//if the appointment is still open, give link for deleting file, no file deleting after appointment is closed
				$part2=$part2."<td><a href='delete_file.php?id={$row['id']}&student=".$sid."'>Delete</a></td>";
			}
            $part2=$part2."</tr>";
		}//close php while
		// Close table
        $part3='</table>';
		//add all parts to $hint
		$hint=$hint.$part1.$part2.$part3;
	}//close php rows if
	//if no files have been uploaded
	else
	{	
		$hint=$hint."No uploaded files found for appointment number ".$q;
	}
	
}
?>