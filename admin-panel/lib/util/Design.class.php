<?php

/**
 * @author		Trayne & eQuiNox
 * @copyright	2011 - 2017 Shaiya Productions
**/

Class Design{
	private static $gm;

	public static function head(){
		?>
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
		"http://www.w3.org/TR/html4/loose.dtd">
		<html>
			<head>
				<title>GM Tool v. <?php echo GM_TOOL_VERSION;?></title>
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
				<meta name="language" content="en">
				<meta name="Robots" content="noindex, nofollow">
				<meta http-equiv="expires" content="0">
				<meta name="copyright" content="Trayne & eQuiNox | www.shaiya.pf-control.de">
				<meta name="copyright" content="Trayne & eQuiNox | www.shaiya.pf-control.de">
				<meta http-equiv="content-type" content="text/html; charset=UTF-8">
				<meta http-equiv="content-script-type" content="text/javascript">
				<meta http-equiv="content-style-type" content="text/css">
				<link rel="stylesheet" type="text/css" href="css/style.css">	
				<link rel="SHORTCUT ICON" href="images/favicon.ico" type="image/x-icon">
				<link rel="stylesheet" href="js/jquery-ui.min.css">
				<script type="text/javascript" src="js/jquery-latest.min.js"></script>
				<script src="js/jquery-ui.min.js"></script>
			</head>
		<?php
	}
	
	public static function top(){
		?>
		<div id="header"></div>
		<?php
	}
	
	public static function infoAuf(){
		?>
		<div id="infos">
		<?php
	}
	
	public static function infoZu(){
		?>
		</div>
		<?php
	}

	public static function MainAuf(){
		?>
		<div id="main">
			<div id="subnav">
			<?php Navigation::get();?>
			</div>
			<div Class="ci">
		<?php
	}
	
	public static function mainZu(){
		?>
		</div>
		</div>
		<?php
	}

	public static function footer(){
		?>
		<div id="footer"><div Class="fi">&copy; 2012 - 2017 Software for <a href="http://www.elitepvpers.com">E*PVP</a></div></div>
		</body>
		</html>
		<?php
	}
	
	public static function auf($gm){
		self::$gm = $gm;
		self::head();
		self::top();
		self::InfoAuf();
		echo '<div Class="ii">';
		echo 'logged in as '.$gm->getName().'. <a href="index.php?action=logout">Logout</a>';
		echo '<div Class="right">'.parser::datum(time()).'</div>';
		echo '<div Class="clear"></div>';
		echo '<br/><center>';
		echo 'Characters: '.Count::Chars();
		echo ' | Accounts: '.Count::Accounts();
		echo ' | Banned Chars: '.Count::BannedChars();
		echo ' | Banned Accounts: '.Count::BannedAccounts();
		echo ' | Deleted Chars: '.Count::DeletedChars();
		echo '</center>';
		echo '</div>';
		self::InfoZu();
		self::MainAuf();
	}
	
	public static function zu(){
		self::MainZu();
		self::Footer();
	}
}

?>