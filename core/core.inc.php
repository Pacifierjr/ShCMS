<?php
//CMS CONFIG FILE//
        $SlidesArray = Array();
        $vote_site = array();
		include("core/config.inc.php");
        date_default_timezone_set($date_region);
        if ($item_blacklist == ''){
            $item_blacklist = '(0)';
        }

// HTTPS SYSTEM  //
if (in_array($_SERVER['REMOTE_ADDR'] , $NonSSLip)){
    $UseSSL = false;
}

    if($UseSSL){
        if ($_SERVER['HTTP_HOST'] != $DomainSSL) {
            header("HTTP/1.1 301 Moved");
            header("Location: https://".$DomainSSL.$_SERVER['REQUEST_URI']);
            exit; 
        }
        $protocol = "I LOVE CATS";
        if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
          $protocol = 'https://';
        }
        else {
          $protocol = 'http://';
        }
        if($protocol != "https://"){
            header("HTTP/1.1 301 Moved");
            header("Location: https://".$DomainSSL.$_SERVER['REQUEST_URI']);
            exit; 
        }
    }
	
//HTML Purifier//
        require_once 'core/lib/HTMLPurifier.auto.php';

        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);  
//JBBCode//

		include("core/lib/JBBCode/Parser.php");
//PAGE SYSTEM//
		$url = $_SERVER['REQUEST_URI'];
        $name = basename($url); // to get file name
        $ext = pathinfo($url, PATHINFO_EXTENSION); // to get extension
        $pagename = ucfirst(pathinfo($url, PATHINFO_FILENAME)); //file name without extension
			$arg = null;
		if($ext != ""){
			$arg = $ext;
		}
		if($pagename == '' || $pagename == 'main'){
			$pagename = "Home";	
		}	
		if (file_exists("pages/".$pagename.".php")){
			$pagename = $pagename;
			$pagetoinc = "pages/".$pagename.".php";
		}else{
			$initialpage = $pagename;
			$pagename = "404 Error";
			$pagetoinc = "pages/404.php";
		}
//SQL SERVER PDO//
		include("core/pdoConnect.inc.php");
		include("core/odbConnect.inc.php");

//SYS FUNCTIONS//
		include("core/functions.inc.php");
//CLASSES AUTOLOADER//
        function __autoload($class_name) {
            include "core/classes/" . $class_name . ".class.php";
        }
//STARTING SESSION
		if($pagename == 'Logout'){
			    session_start();
				$_SESSION = array();
				session_destroy();
		}else{
				if (session_id() == null){
					session_start();
				}
		}

		if(!isset($_SESSION['UserUID'])){
				$uid = 0;
				$status = 0;
				$points = 0;
				$username = "";
			} else {
				$uid = $_SESSION['UserUID'];
				$status = $_SESSION['Status'];
			
				$query = $conn->prepare('SELECT Point, UserID FROM PS_UserData.dbo.Users_Master WHERE UserUID=?');
				$query->bindParam(1, $uid, PDO::PARAM_STR);
				$query->execute();
				$row = $query->fetch(PDO::FETCH_NUM);
				$points = $row[0];	
				$username = $row[1];
				$query = $row = null;
		}
        $CurrentUser = new Account($uid);
        $b = $CurrentUser->Get("UserUID");
        $parser = new JBBCode\Parser();
        $parser->addCodeDefinitionSet(new JBBCode\DefaultCodeDefinitionSet());
         // echo item icon exemple:
         // $Sword = new Item(30005);
         // $Sword->PrintIcon();
		

		ob_start();
?>