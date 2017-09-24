<?php

/**
 * @author		Momo
 * @copyright	2014 Jamiro Productions
**/

class Design{
	private static $gm;

	public static function head(){
		?>
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
		"http://www.w3.org/TR/html4/loose.dtd">
		<html>
			<head>
				<title>GM Tool v. <?php echo GM_TOOL_VERSION;?></title>
				<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
				<meta name="language" content="de">
				<meta name="Robots" content="noindex, nofollow">
				<meta http-equiv="expires" content="0">
				<meta name="copyright" content="Fucking Damage | http://atoto57.wix.com/shaiyator">
				<meta name="copyright" content="Fucking Damage | http://atoto57.wix.com/shaiyator">
				<meta http-equiv="content-type" content="text/html; charset=UTF-8">
				<meta http-equiv="content-script-type" content="text/javascript">
				<meta http-equiv="content-style-type" content="text/css">
				<link rel="stylesheet" type="text/css" href="css/style.css">
				<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.7.1.custom.css">
				<link rel="stylesheet" href="css/jquery-ui-1.7.1.custom.css" type="text/css" media="screen" />
				<link rel="stylesheet" href="css/tipTip.css" type="text/css" media="screen" />
				<script type="text/javascript" src="http://www.google.com/jsapi"></script>
				<script type="text/javascript">
					google.load("jquery", "1.3.1");
				</script>
				<script type="text/javascript" src="js/jquery-ui-1.7.1.custom.min.js"></script>
				<script type="text/javascript" src="js/jquery.tipTip.js"></script>
				<script type="text/javascript" src="js/jquery.tipTip.minified.js"></script>
				<link rel="SHORTCUT ICON" href="images/favicon.ico" type="image/x-icon">
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
			<div class="ci">
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
		<div id="footer"><div class="fi">&copy; 2014 Jamiro momo Productions</div></div>
		</body>
		</html>
		<?php
	}
	
	public static function auf($gm){
		self::$gm = $gm;
		self::head();
		self::top();
		self::InfoAuf();
		echo '<div class="ii">';
		echo 'Connecté en tant que '.$gm->getName().'. <a href="index.php?action=logout">Deco</a>';
		echo '<div class="right">'.parser::datum(time()).'</div>';
		echo '<div class="clear"></div>';
		echo '<center>';
		echo 'Charakter: '.Count::Chars();
		echo ' Accounts: '.Count::Accounts();
		echo ' Chars interdits: '.Count::BannedChars();
		echo ' Comptes bannis: '.Count::BannedAccounts();
		echo ' Chars supprimés: '.Count::DeletedChars();
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