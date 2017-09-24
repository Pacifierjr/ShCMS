<?php

/**
 * @author		Momo
 * @copyright	2014 Jamiro Productions
**/

class mainAction{
	private $gm;
	
	public function __construct(&$gm){
		$this->gm = $gm;
	}
	
	public function execute(){
		if (isset($_GET['msg'])){
			if ($_GET['msg'] == 1)
				echo '<div class="success">Vous  etes connecte avec succes .</div>';
		}
		echo '<center><h1><B><FONT color="red">Bienvenue sur le GM Tool de Fucking Damage Modifier par</FONT><FONT color="green"><FONT size="10pt"> Jamiro momo.</FONT></FONT><B> </B></h1></center>.';
	}
} 

?>