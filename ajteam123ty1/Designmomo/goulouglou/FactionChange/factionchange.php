<?php

require_once('db.config.php');

$character = '';

?>
-- Script From [Dev]Alex Modifier par Jamiro

<html>
	<head>
		<title>[Dev]Alex Faction Change</title>
	<style type="text/css">
		h2 		{text-align:center; color:yellow;}
		h4 		{text-align:center; color:white;}
		div#adminLogin	{background-color:#111111; width:160px; padding:10px;}
		div#formArea	{background-color:#595959; padding:5px; position:relative; left:0px;}
		.submitButton	{position:relative; left:40px;}
		
	</style>
	</head>
	<body>
		<div id="adminLogin">
			
			<div id="factionChange"><h4>Faction Change</h4>

				<div id="formArea">
					<form action="factionchange.php" method="POST">
						Character:<br/><input type="text" name="character" value="<?php echo $character; ?>"><br/>
						<br/><input type="submit" name="formSubmit" value="Submit" class="submitButton">
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
<?php

if ($_POST['formSubmit'] == "Submit") {
	$character = $_POST['character'];

	$dbhost = $_ENV['LOCAL_DOMAIN'];

	$sql = "SELECT UserUID FROM PS_GameData.dbo.Chars WHERE CharName = ?";
	$stmt = odbc_prepare($GLOBALS['dbConn'],$sql);
	$args = array($character);
	odbc_execute($stmt,$args);
	'<br/>';
	$userUID = odbc_result($stmt,'UserUID');
	
	$sql = "SELECT Country FROM PS_GameData.dbo.UserMaxGrow WHERE UserUID = ?";
	$stmt = odbc_prepare($GLOBALS['dbConn'],$sql);
	$args = array($userUID);
	odbc_execute($stmt,$args);
	'<br/>';
	$country = odbc_result($stmt,'Country');
	
	if ($country==0) {
		$sql = "UPDATE PS_GameData.dbo.UserMaxGrow
			SET Country = 1
			WHERE UserUID = ?";
		$stmt = odbc_prepare($GLOBALS['dbConn'],$sql);
		$args = array($userUID );
		odbc_execute($stmt,$args);
		echo $character.' was successfully factioned changed from light to fury!';
	}

	if ($country==1) {
		$sql = "UPDATE PS_GameData.dbo.UserMaxGrow
			SET Country = 0
			WHERE UserUID = ?";
		$stmt = odbc_prepare($GLOBALS['dbConn'],$sql);
		$args = array($userUID );
		odbc_execute($stmt,$args);
		echo $character.' was successfully factioned changed from fury to light!';
	}

	odbc_close($GLOBALS['dbConn']);
}

?> 