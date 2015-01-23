<?php
 require_once ('mysql_connect.php');


session_start(); // Start the session.
// If no session value is present,redirect the user:
if (!isset($_SESSION['user_id'])) {
require_once ('includes/login_functions.inc.php');
$url = absolute_url();
header("Location: $url");
exit();
}
$q=$_GET["q"];
$start = isset($_GET["start"])?$_GET["start"]:NULL;
$aptnum=isset($_GET["a"])?$_GET["a"]:NULL;

$opentot=0;
$user = $_SESSION['user_id'];
$qa = "select apptid,status from appts where sid = $q and fid = $user and status = 2";
$q1="select * from users where user_id = $q";
$q2="select * from sdtinfo where user_id =$q";
$r1 = @mysql_query ($q1);
	if (@mysql_num_rows($r1) !=0) 
	{//open php rows if

		while ($row1 = @mysql_fetch_assoc($r1))
		{//open php while
		
			// create variables for the a items that will be searched and make them all lowercase (what we want to search through)
			$sname = $row1['First_Name']." ". $row1['Last_Name'];
			$phone = $row1['phone'];
			$email = $row1['email'];
		}//close php while
	}//close php rows if
	
$r2 = @mysql_query ($q2);
	if (@mysql_num_rows($r2) !=0) 
	{//open php rows if

		while ($row2 = @mysql_fetch_assoc($r2))
		{//open php while
		
			// create variables for the a items that will be searched and make them all lowercase (what we want to search through)
			$major = $row2['major'];
			$level = $row2['level'];
			$status =  $row2['status'];
			$admissiondate = $row2['admissiondate'];
			$graddate = $row2['graduationdate'];
			$comments = $row2['Comments'];
		}//close php while
	}//close php rows if

$ra = @mysql_query ($qa);
	if (@mysql_num_rows($ra) !=0) 
	{//open php rows if

		while ($rowa = @mysql_fetch_assoc($ra))
		{//open php while
		$apstat = $rowa['status'];
		$openapt = $rowa['apptid'];
		}
	}

 ?>
<title>S.A.Sy</title>
 <script src="./content/jquery.js"></script>
<!-- JQUERY -->
<link href="./content/jquery.custom.css" rel="stylesheet" type="text/css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
 <script type="text/javascript">
var show = 0;
  $(document).ready(function() {
    $("#aptinfo").dialog({show: 'slide' ,autoOpen:false,width: 500, buttons: [{
		text:"Ok", click: function(){$(this).dialog("close")}}]});
  });
  function showApt(anum)
  {		show = 1;
	 showResult(anum,'closed','aptinfo');
	  	
	$('#aptinfo').dialog("open");

  }

function showResult(str,type,divid)
{
	<?php echo'var sid = "'.$q.'";';?>
if (str.length==0)
  { 
  document.getElementById(divid).innerHTML="";
  document.getElementById(divid).style.border="0px";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  console.log("Modern Browser");
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  console.log("Appts for:"+str+" type:"+type+" sid:"+sid+" show:"+show+"\n"+xmlhttp.readyState+"-"+xmlhttp.status+"\n"+xmlhttp.responseText);
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById(divid).innerHTML=xmlhttp.responseText;
			document.getElementById(divid).style.border="1px solid #A5ACB2";
				document.getElementById(divid).style.height="400px";
				document.getElementById(divid).style.overflow="auto";

    }
  }
  if (show ==1)
  {
xmlhttp.open("GET","livesearch2.php?q="+str+"&t="+type+"&id="+sid+"&styp=stusrch",true);
	show = 0;
  }
  else
  {
	   // dummy timestamp so browsers don't cache the request.
	  tmsp = new Date().getTime();
	  console.log("livesearch.php?q="+str+"&t="+type+"&id="+sid+"&styp=stusrch&tmsp="+tmsp);
	  xmlhttp.open("GET","livesearch.php?q="+str+"&t="+type+"&id="+sid+"&styp=stusrch&tmsp="+tmsp,true);
  }
xmlhttp.send();
}



function closewindow()
{
	window.close();
}

function showAppointment(str,type,divid)
{
	<?php echo'var sid = '.$q.';';?>
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp2=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp2.onreadystatechange=function()
  {
  if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
    {
    document.getElementById(divid).innerHTML=xmlhttp2.responseText;
    }
  }

xmlhttp2.open("GET","aptview.php?q="+str+"&t="+type+"&id="+sid+"&styp=stusrch",true);
xmlhttp2.send();
}


function errorcheck()
{//begin inputCheck function
	var inputError=new Array(" "," ");
	var errorCount=0;
	var note= document.forms.newappt['Note'].value;
	var purpose = document.forms.newappt['Purpose'].value;
	
	
	if (note.length < 1)
	{
		inputError[0]=("\n No Comments Entered.");
		errorCount=errorCount+1;
	}

	if (purpose.length < 1)
	{
		inputError[1] = ("\n Appointment purpose must be entered.");
		errorCount=errorCount+1;
	}

	if (errorCount >0)
		alert(errorCount+" Error(s). "+inputError[0]+inputError[1]);
	if(errorCount == 0)
	{
		getTime();
		document.newappt.submit();
	}
}// end errorcheck function
function getTime()
{
var d = new Date();
var c_hour = d.getHours();
var c_min = d.getMinutes();
var t = c_hour + "." + c_min ;
document.forms.newappt['time'].value = t;
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
		<script src="./content/jquery.colorbox.js"></script>
		<script>
			$(document).ready(function(){
				//assign the ColorBox event to elements
				$(".ajax").colorbox();
			});
		</script>
<link href="content/colorbox.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700|Droid+Serif:400,700' rel='stylesheet' type='text/css'>
</head>
	<body>
	<div class="header">
    <p class="floattitle"><p1>S.A.Sy</p1> <p2>(Sutdent Advisement System)</p2></p>
    <?php
	if (!isset($start))
	echo '<input name="Close" type="button" value="Close Window" onclick= "closewindow()" />';
	else
	echo '<a href = "logout.php" title="logout">Log Out</a>';
	?>
	</div>
	<div class = "info">
		<div class="contentheader">
			<h1>Student Information</h1>
		</div>
		<div class="content">
<?php
echo "Name: $sname<br />";
echo "Student ID: $q<br/>";
echo "Phone #: $phone<br />";
echo 'E-Mail: <a href="mailto:'.$email.'">'.$email.'</a><br /> ';
echo "Concentration: $major<br />";
echo "Level: $level<br />";
echo "Status: $status<br />";
echo "Processed On: $admissiondate<br />";
echo "Graduated On: $graddate <br />";
echo "Comments : $comments <br/>";
?>
 <?php echo "<p><a class='ajax' href='updateinfo.php?q=".$q."&t=2&u=3' title='update info'>Update Info</a></p><br/>";?>
	</div>
</div>
<?php 
if(isset($aptnum))
{
	
	$stype="viewapt";
	$openapt = $aptnum;
}
else
if(!isset($openapt))
{
		if(!isset($start))
	{
	$stype = "aptcheck";
	$openapt = $q;
	}
}
else
{

	$stype = "openapt";
	$aptnum=$openapt;

}
echo "<script type='text/javascript'>showAppointment('".$openapt."','".$stype."','aptarea');</script>";

echo "<script type='text/javascript'>showResult('".$q."','aptlist','aptdisplay');</script>";

?>


<div id="aptinfo"></div>

<div class="appointmenthistory">
	<div class="contentheader">
		<h1>Appointment History</h1>
	</div>
	<div class="content">
		<div id="aptdisplay" class="aptdisplay"></div>
	<div class="aptnew">
			<div id="apt"></div>
			<div id="aptarea" ></div>
            <?php
			if(isset($aptnum))
			{ 
			echo "<div class='floatlink'>";
				if($_SESSION['u_type']!=3)
			echo "<a class='ajax' href='apptclose.php?q=".$aptnum."&s=".$q."' title='Close Appointment'><o>Close Appointment</o></a>";
			echo "</div><br/>";
			}
			?>
           
		</div>
	</div>
<div class="bottom"></div>
</div>
</body>
</html>