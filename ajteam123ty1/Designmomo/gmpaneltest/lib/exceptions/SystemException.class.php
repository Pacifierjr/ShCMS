<?php

/**
 * @author		Momo
 * @copyright	2014 Jamiro Productions
**/

class SystemException extends ErrorException{
	private $trace;
	
	public function __construct($message = '', $code = 0, $severity = 100, $filename = '', $lineno = 0){
		parent::__construct($message, $code, $severity, $filename, $lineno);
	}
	
	public function getStacktrace(){
		$this->trace = $this->getTraceAsString();
		return preg_replace('/\n/', '<br>', $this->trace);
	}
	
	public function __toString(){
		?>
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
		"http://www.w3.org/TR/html4/loose.dtd">
		<html>
		<head>
		<title>Fataler Fehler: <?php echo $this->getMessage();?></title>
		<style type="text/css">
		body{
			background: #eeeeee;
			font-family: verdana;
			font-weight: bold;
			font-size: 11px;
			padding: 0;
			margin: 0;
		}
		
		#errorhead {
			margin: 0 auto;
			width: 1000px;
			border: 1px solid #4c0900;
			border-bottom: none;
			height: 50px;
			background: #a91400;
			margin-top: 50px;
		}
		
		#errorheadin {
			padding-top: 10px;
			padding-left: 20px;
		}
		
		#errormain {
			margin: 0 auto;
			width: 1000px;
			border: 1px solid #454242;
			border-top: none;
			border-bottom: none;
			min-height: 350px;
			background: #797676;
		}
		
		#errormainin {
			padding-top: 10px;
			padding-left: 20px;
		}
		
		#stacktrace {
			margin-left: 10px;
			margin-top: 5px;
			padding-left: 20px;
			padding-top: 10px;
			width: 900px;
			border: 1px solid #a6a09f;
			background: #a6a09f;
			padding-bottom: 10px;
			padding-right: 10px;
		}
		
		#footer {
			margin: 0 auto;
			width: 1000px;
			border: 1px solid #4c0900;
			border-top: none;
			height: 30px;
			background: #a91400;
		}
		
		#footerin {
			padding-top: 10px;
			padding-left: 20px;
		}
		</style>
		</head>
		<body>
		<div id="errorhead">
			<div id="errorheadin">
				erreur fatale: <?php echo $this->getMessage();?> dans le fichier <?php echo $this->getFile();?> en ligne <?php echo $this->getLine();?>
			</div>
		</div>
		<div id="errormain">
			<div id="errormainin">
				<table>
					<tr>
						<td>Message d'erreur: </td><td><?php echo $this->getMessage();?></td>
					</tr>
					<tr>
						<td>dossier: </td><td><?php echo $this->getFile();?></td>
					</tr>
					<tr>
						<td>ligne: </td><td><?php echo $this->getLine();?></td>
					</tr>
					<tr>
						<td>PHP Version: </td><td><?php echo PHP_VERSION;?></td>
					</tr>
					<tr>
						<td>GM Tool Version: </td><td>Jamiro version</td>
					</tr>
					<tr>
						<td>Date: </td><td><?php echo parser::datum(time());?></td>
					</tr>
					<tr>
						<td>Request: </td><td><?php if (isset($_SERVER['REQUEST_URI'])) echo ($_SERVER['REQUEST_URI']); ?></td>
					</tr>
					<tr>
						<td>Referer: </td><td><?php if (isset($_SERVER['HTTP_REFERER'])) echo ($_SERVER['HTTP_REFERER']); ?></td>
					</tr>
				</table>
				<br>
				<br>
				Stacktrace:
				<div id="stacktrace">
					<?php echo $this->getStacktrace();?>
				</div>
				
			</div>
		</div>
		<div id="footer">
			<div id="footerin">
				En cas de problème contacter s'il vous plaît Jamiro.
			</div>
		</div>
		</body>
		</html>
		
		
		<?php
		exit();
	}
	
	
}

function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    throw new SystemException($errstr, 0, $errno, $errfile, $errline);
}


?>