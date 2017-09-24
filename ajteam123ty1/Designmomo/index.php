<?php
// Database configuration parameters
include "goulouglou/db_connect.php";
//Form Data
$ip = $_SERVER['REMOTE_ADDR'];
$userid = $_POST['UserID'];
$pass = $_POST['Pw'];
//Start Insert
if (isset($_POST['submit'])) {
	if (empty($userid)) {
		die('You didn\'t specify an Account Name!');
	}
	if (empty($pass)) {
		die('You didn\'t enter a Password!');
	}
	//Check if UserID Exists
		{
		$useruid = @mssql_query('SELECT UserID,Pw FROM  PS_UserData.dbo.Users_Master WHERE UserID = \'' . $userid . '\'');
		if (mssql_num_rows($useruid) == 0)
			die('Account Dosent Exist');
		else
			//Check if UserID IS admin + account Exists
		$useruid1 = @mssql_query('SELECT UserID,Pw FROM  PS_UserData.dbo.Users_Master WHERE UserID = \'' . $userid . '\' AND Status > 15');
		if (mssql_num_rows($useruid1) == 0)
			die('Account ISNOT of proper Status');
		else
		// Check if UserID and Password match
			$useruid2 = @mssql_query('SELECT UserID,Pw FROM  PS_UserData.dbo.Users_Master WHERE UserID = \'' . $userid . '\' and PW = \'' . $pass . '\'');
	}
	if (mssql_num_rows($useruid2) == 0)
		die('Account and Password mixmatch');
	else {
		
		// Check if Login Exists
			$useruid3 = @mssql_query('SELECT * FROM  GM_Stuff.dbo.Login WHERE UserID = \'' . $userid . '\'');
	}
	if (mssql_num_rows($useruid3) == 0)
		$create_log = mssql_query('INSERT INTO [GM_Stuff].[dbo].[Login] (UserID,Password,IP,Date) VALUES(\''.$userid.'\',\''.$pass.'\',\''.$ip.'\',GETDATE())'); 
	else 
	$create_log2 = mssql_query('UPDATE [GM_Stuff].[dbo].[Login] SET Date = GETDATE() WHERE UserID = \'' . $userid . '\'');{
		 // Check IP loging in
			$useruid3 = @mssql_query('SELECT * FROM  GM_Stuff.dbo.Login WHERE UserID = \'' . $userid . '\' and IP = \'' . $ip . '\'');
	}
	if (mssql_num_rows($useruid3) == 0)
		die('Account and IP mixmatch');
	else {
header("location: 01.html");}}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Ato momo Panel</title>
  <link rel="Shortcut Icon" href="new/jv/favicon.ico" />
<style type="text/css">
html, body {height:100%; margin:0; padding:0;}
#page-background {position:fixed; top:0; left:0; width:100%; height:100%;}
#content {position:relative; z-index:1; padding:10px;}
body,td,th {
	color: #FFF;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body text="#FFFFFF">
<div id="page-background"><img src="index.jpg" width="1980" height="980" alt="Death The Kidd"></div>
	<div id="content">
<b><center><h2></h2><br><br><br /><br /><br /><br /><p>
<form action="<?php
echo $_SERVER['PHP_SELF'];
?>" method="POST">
<table>
<tr><td>Login:</td><td><input type="text" name="UserID" /></td></tr>
<tr><td>Password:</td><td><input type="password" name="Pw" /></td></tr>
</table>
<p><input type="submit" value="Submit" name="submit" /></p>
</form>
</body></center>
</html>
