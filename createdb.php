<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<?php
$dbc = @mysql_connect( 'localhost',$_POST['dbun'], $_POST['dbp']) or
die('Could not connect to  MySQL:'. mysql_error());


@mysql_select_db($_POST['dbn']) or
die('Could not select the database: '. mysql_error());

$tablecreate1 ="CREATE TABLE  ".$_POST['dbn'].".`Logins` (`user_id` INT( 12 ) NOT NULL ,`username` VARCHAR( 20 ) NOT NULL ,`pwd` VARCHAR( 16 ) NOT NULL ,`user_type` INT( 1 ) NOT NULL ) ENGINE = MYISAM";
$created1 = @mysql_query ($tablecreate1);

$tablecreate2 ="CREATE TABLE  ".$_POST['dbn'].".`users` (`user_id` INT( 12 ) NOT NULL ,`First_Name` VARCHAR( 15 ) NOT NULL,`Last_Name` VARCHAR( 15 ) NOT NULL,`Add2` VARCHAR( 15 ) NULL DEFAULT NULL,`phone` VARCHAR( 15 ) NOT NULL,`email` VARCHAR( 15 ) NOT NULL ) ENGINE = MYISAM";
$created2 = @mysql_query ($tablecreate2);

$tablecreate3 ="CREATE TABLE  ".$_POST['dbn'].".`sdtinfo` (`user_id` INT( 12 ) NOT NULL,`level` VARCHAR( 15 ) NOT NULL,`major` VARCHAR( 30 ) NOT NULL,`status` VARCHAR( 20 ) NOT NULL,`ethnic` VARCHAR( 20 ) NOT NULL,`residency` VARCHAR( 15 ) NOT NULL,`addby` INT( 12 ) NOT NULL ,`createdate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,`admissiondate` DATE NOT NULL,`graduationdate` DATE NULL DEFAULT NULL ) ENGINE = MYISAM";
$created3 = @mysql_query ($tablecreate3);

$tablecreate4 ="CREATE TABLE  ".$_POST['dbn'].".`appts` (`apptid` INT( 11 ) NOT NULL KEY AUTO_INCREMENT ,`sid` INT( 12 ) NOT NULL ,`fid` INT( 12 ) NOT NULL ,`start_date` DATE NOT NULL,`end_date` DATE NOT NULL,`start_time` TIME NOT NULL,`stop_time` TIME NOT NULL,`description` VARCHAR( 300 ) NOT NULL,`status` INT( 1 ) NOT NULL ) ENGINE = MYISAM";
$created4 = @mysql_query ($tablecreate4);

$tablecreate5 ="CREATE TABLE  ".$_POST['dbn'].".`apptnote` (`primary` INT( 11 ) NOT NULL ,`apptid` INT( 5 ) NOT NULL ,`date` DATE NOT NULL,`time` TIME NOT NULL, `fid` INT( 12 ) NOT NULL ,`note` VARCHAR( 300 ) NOT NULL) ENGINE = MYISAM";
$created5 = @mysql_query ($tablecreate5);

$tablecreate6 ="CREATE TABLE  ".$_POST['dbn'].".`file` (`id` INTEGER AUTO_INCREMENT PRIMARY KEY,`name` VARCHAR( 255 ) NOT NULL ,`mime` VARCHAR( 75 ) NOT NULL ,`size` BIGINT( 20 ) UNSIGNED NOT NULL ,`data` MEDIUMBLOB NOT NULL ,`created` DATETIME NOT NULL ,`apptid` INT( 10 ) NOT NULL ) ENGINE = MYISAM";
$created6 = @mysql_query ($tablecreate6);

$q1="INSERT INTO users (user_id,First_Name, Last_Name,phone, email) VALUES ('000000','Admin','Admin','change me2','change me')";

$results1 = @mysql_query ($q1);

$createLogin = "INSERT INTO Logins (user_id,username,pwd,user_type) values ('000000','root','administrator','2')";
	$results3 = @mysql_query ($createLogin);

$FileName = "mysql_connect.php";
$FileHandle = fopen($FileName, 'w') or die("can't open file");
$code="<?php  # mysql_connect.php
//required for all pages
// Define constants for connection
define ('DB_USER', '".$_POST['dbun']."');      // replace xxxx with your mysql username    
define ('DB_PASSWORD', '".$_POST['dbp']."');  // replace yyyy with your mysql password
define ('DB_HOST', 'localhost');
define ('DB_NAME', '".$_POST['dbn']."');      // replace zzzzzz with your database name

// Connect to DB and select main DB
\$dbc = @mysql_connect( DB_HOST, DB_USER, DB_PASSWORD) or
die('Could not connect to  MySQL: '. mysql_error());

@mysql_select_db(DB_NAME) or
die('Could not select the database: '. mysql_error());

?>
";
fwrite($FileHandle, $code);
fclose($FileHandle);
echo "mysql_connect.php created";

?>
<body>
</body>
</html>
