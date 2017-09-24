<?php
// Database configuration parameters
include "db_connect.php";
//Form Data
$ip = $_SERVER['REMOTE_ADDR'];
$QuaryID = $_POST['QuaryID']; {
	if ($QuaryID == 1) {
		//create_log
		$INSERT = mssql_query('SELECT * FROM  GM_Stuff.dbo.Login WHERE IP = \'' . $ip . '\'');
		if (mssql_num_rows($INSERT) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log = mssql_fetch_assoc($INSERT))
		mssql_query('INSERT INTO GM_Stuff.dbo.Log (StaffID,StaffIP,Account,Actiondef,Date) 
	VALUES 
	(\''.$Log['UserID'].'\',\''.$ip.'\',\'Ban\',\'3Day Ban Search.\',GETDATE())');
		$res = mssql_query("SELECT UserUID,UserID,Pw,JoinDate,UserIp FROM PS_UserData.dbo.Users_Master  WHERE (Status) = ('-5') ORDER BY UserUID");
		if (mssql_num_rows($res) == 0) {
			echo 'Search returned no results.';
		}
		echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
		echo '<table border="1"><tr>
		<th>UserUID</th>
		<th>UserID</th>
		<th>PassWord</th>
		<th>JoinDate</th>
		<th>IP</th></tr>';
		while ($Row = mssql_fetch_assoc($res)) {
			echo '<tr><td>' . $Row['UserUID'] . '</td>
		<td>' . $Row['UserID'] . '</td>
		<td>' . $Row['Pw'] . '</td>
		<td>' . $Row['JoinDate'] . '</td>
		<td>' . $Row['UserIp'] . '</td>
		</tr>';
		}
		echo '</table>';
		echo '</form>';
	} {
		if ($QuaryID == 2) {
				$INSERT = mssql_query('SELECT * FROM  GM_Stuff.dbo.Login WHERE IP = \'' . $ip . '\'');
		if (mssql_num_rows($INSERT) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log = mssql_fetch_assoc($INSERT))
		mssql_query('INSERT INTO GM_Stuff.dbo.Log (StaffID,StaffIP,Account,Actiondef,Date) 
	VALUES 
	(\''.$Log['UserID'].'\',\''.$ip.'\',\'Ban\',\'2 Week Ban Search.\',GETDATE())');
			$res = mssql_query("SELECT UserUID,UserID,Pw,JoinDate,UserIp FROM PS_UserData.dbo.Users_Master  WHERE (Status) = ('-4') ORDER BY UserUID");
			if (mssql_num_rows($res) == 0) {
				echo 'Search returned no results.';
			}
			echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
			echo '<table border="1"><tr>
		<th>UserUID</th>
		<th>UserID</th>
		<th>PassWord</th>
		<th>JoinDate</th>
		<th>IP</th></tr>';
			while ($Row = mssql_fetch_assoc($res)) {
				echo '<tr><td>' . $Row['UserUID'] . '</td>
		<td>' . $Row['UserID'] . '</td>
		<td>' . $Row['Pw'] . '</td>
		<td>' . $Row['JoinDate'] . '</td>
		<td>' . $Row['UserIp'] . '</td>
		</tr>';
			}
			echo '</table>';
			echo '</form>';
		} {
			if ($QuaryID == 3) {
					$INSERT = mssql_query('SELECT * FROM  GM_Stuff.dbo.Login WHERE IP = \'' . $ip . '\'');
		if (mssql_num_rows($INSERT) == 0)
			die('Admin Account Log returned no results');
		else
		while ($Log = mssql_fetch_assoc($INSERT))
		mssql_query('INSERT INTO GM_Stuff.dbo.Log (StaffID,StaffIP,Account,Actiondef,Date) 
	VALUES 
	(\''.$Log['UserID'].'\',\''.$ip.'\',\'Ban\',\'I.P. Ban Search.\',GETDATE())');
				$res = mssql_query("SELECT UserUID,UserID,Pw,JoinDate,UserIp FROM PS_UserData.dbo.Users_Master  WHERE (Status) = ('-2') ORDER BY UserUID");
				if (mssql_num_rows($res) == 0) {
					echo 'Search returned no results.';
				}
				echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
				echo '<table border="1"><tr>
		<th>UserUID</th>
		<th>UserID</th>
		<th>PassWord</th>
		<th>JoinDate</th>
		<th>IP</th></tr>';
				while ($Row = mssql_fetch_assoc($res)) {
					echo '<tr><td>' . $Row['UserUID'] . '</td>
		<td>' . $Row['UserID'] . '</td>
		<td>' . $Row['Pw'] . '</td>
		<td>' . $Row['JoinDate'] . '</td>
		<td>' . $Row['UserIp'] . '</td>
		</tr>';
				}
				echo '</table>';
				echo '</form>';
			}
			require_once('ban_search.php');
}}}
?>
<html>
	<head>
	<title>ACCOUNT BAN Search</title>
	</head>
	<font face="Trebuchet MS">
	<center><body><br /><br />
	<b>ACCOUNT BAN Search</b>
    <form action="<?php
echo $_SERVER['PHP_SELF'];
?>" method="POST">
    <table>
    <tr><td>Ban Type:</td><td><select name="QuaryID">
  <option value="1">3 Day Ban</option>
  <option value="2">2 Week Ban</option>
  <option value="3">IP Bann</option>
</select></td></tr>
	</table>
<p><input type="submit" value="Submit" name="submit" /></p>
	</form>
	</body></center>
	</html>