<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<form method="post" action="createdb.php">
<table>
<tr>
		<td><label>Database user name: </label></td>
		<td align="left"><input type="text" name="dbun" id="dbun" value=""/></td>
	</tr>
    <tr>
		<td><label>Database password: </label></td>
		<td align="left"><input type="password" name="dbp" id="dbp" value=""/></td>
	</tr>
    <tr>
		<td><label>Database name: </label></td>
		<td align="left"><input type="text" name="dbn" id="dbn" value=""/></td>
	</tr>
    </table>
    <button onclick="submit">Create</button>
    </form>
<body>
</body>
</html>