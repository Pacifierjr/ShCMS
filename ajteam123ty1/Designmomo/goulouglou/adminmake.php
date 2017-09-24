<?php
// Database configuration parameters
include "db_connect.php";
//Form Data
$ip = $_SERVER['REMOTE_ADDR'];
$char  = trim($_REQUEST['char']);
$count = 0;
if ((isset($_POST['submit'])) || strlen($char) > 1) {
	if (strlen($char) < 1) {
		die("Invalid Char Name.\n ");
	}
	$res     = mssql_query("SELECT * FROM PS_UserData.dbo.Users_Master WHERE UserID = '$char'");
	$detail  = mssql_fetch_array($res);
	$list    = array(
		3,
		4,
		6,
		7,
		13,
		14,
		15,
		16,
		17,
		18,
		19,
		20,
		21,
		22,
		23,
		27,
		29,
		30,
		31,
		32,
		33,
		39,
		40,
		43,
		44
	);
	$coloums = array(
		'UserID',
		'Pw',
		'JoinDate',
		'Admin',
		'AdminLevel',
		'Status',
		'UserType',
		'UserIp',
	);
	$greyed  = array(
		'UserID',
		'Pw',
		'JoinDate',
		'UserIp',
	);
	if (mssql_num_rows($res) == 0) {
		die("User $char does not exist");
	} else {
		echo "<b>Current Status of $char<p>
		[GM]+ should be <p>
		Admin = 1, AdminLevel = 255, Status = 16, UserType = A<p>
		Reguler player should be<p>
		Admin = 0, AdminLevel = 0, Status = 0, UserType = 1<p></b>  <form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"POST\"><font face=\"Trebuchet MS\">

			<table cellspacing=1 cellpadding=2 border=1 style=\"border-style:hidden;\">
			<tr><td>NO.</td><td>Name</td><td>Value</td>";
		foreach ($coloums as $value) {
			echo "<tr>
				<td>$count</td>
				<td>$value :</td>";
			if (in_array($value, $greyed))
				echo "<td><input type=\"text\" readonly=\"readonly\" style=\"background:#D0D0D0;\" name=\"$value\" value=\"$detail[$value]\" /></td></tr>";
			else
				echo "<td><input type=\"text\" name=\"$value\" value=\"$detail[$value]\" /></td></tr>";
			$count++;
		}
		echo "</table><input type=\"submit\" name=\"submit2\" value=\"Submit\"></form></font>";
	}
} else if (isset($_POST['submit2'])) {
	$charid  = $_POST['UserID'];
	$coloums = array(
		'UserID',
		'Pw',
		'JoinDate',
		'Admin',
		'AdminLevel',
		'UseQueue',
		'Status',
		'Leave',
		'LeaveDate',
		'UserType',
		'UserIp',
		'ModiIp',
		'ModiDate',
		'Point',
		'Enpassword',
		'Birth'
	);
	foreach ($coloums as $value) {
		mssql_query('UPDATE PS_UserData.dbo.Users_Master SET UserID = \'' . $_POST['UserID'] . '\',Pw = \'' . $_POST['Pw'] . '\',JoinDate = \'' . $_POST['JoinDate'] . '\',Admin = \'' . $_POST['Admin'] . '\',AdminLevel = \'' . $_POST['AdminLevel'] . '\',UseQueue = \'' . $_POST['UseQueue'] . '\',Status = \'' . $_POST['Status'] . '\',Leave = \'' . $_POST['Leave'] . '\',LeaveDate = \'' . $_POST['LeaveDate'] . '\',UserType = \'' . $_POST['UserType'] . '\',UserIp = \'' . $_POST['UserIp'] . '\',ModiIp = \'' . $_POST['ModiIp'] . '\',ModiDate = GETDATE(),Point = \'' . $_POST['Point'] . '\',Enpassword = \'' . $_POST['Enpassword'] . '\',Birth = \'' . $_POST['Birth'] . '\' WHERE UserID=\'' . $_POST['UserID'] . '\'');
		echo "</html>";
	}
	//create_log
		$INSERT = mssql_query('SELECT * FROM  GM_Stuff.dbo.Login WHERE IP = \'' . $ip . '\'');
		if (mssql_num_rows($INSERT) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log = mssql_fetch_assoc($INSERT))
		mssql_query('INSERT INTO GM_Stuff.dbo.Log (StaffID,StaffIP,Account,Actiondef,Date) 
	VALUES 
	(\''.$Log['UserID'].'\',\''.$ip.'\',\'' . $charid . '\',\'  ' .$charid. ' Admin Account Created \',GETDATE())');
	foreach ($_POST as $Name => $Value) {
		echo $Name . '=' . $Value . '<br>';
}}
?>
	<html>
	<head>
	<title>Add GM+ Account</title>
	</head>
	<font face="Trebuchet MS">
	<center><body><br /><br />
	<b>Add GM+ Account<br>
	<form action="<?php
	echo $_SERVER['PHP_SELF'];
?>" method="POST">
	<table>
	<tr>
	<td>Account Name:</td><td><input type="text" name="char" /></td>
	</tr>
	</table>
	<p><input type="submit" value="Submit" name="submit" /></p>
	</form>
	</body></center>
	</html>