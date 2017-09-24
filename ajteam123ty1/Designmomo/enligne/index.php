<?php 
include('function-player_online.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="<?=str_replace(basename($_SERVER['PHP_SELF']),'',$_SERVER['SCRIPT_NAME']);?>players_online.css" />
<title>Total Players Online</title>
</head>

<body>

<span style="float:center;">

<table class="playerOnlineTable" style="display:block;">
<?=playersOnline('','1','blueGlassBoxShadow blueTextShadow')?>
</table>





</span>


<div style="clear:both;"></div>
</body>
</html>