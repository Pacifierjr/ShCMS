<?php

/**
 * @author		Trayne & eQuiNox
 * @copyright	2011 - 2017 Shaiya Productions
**/

Class mainAction{
	private $gm;
	
	public function __construct(&$gm){
		$this->gm = $gm;
	}
	
	public function execute(){
		if (isset($_GET['msg'])){
			if ($_GET['msg'] == 1)
				echo '<div Class="success">You have successfully logged in.</div>';
		}
		echo '<h2>Shaiya Europe Admin Panel</h2>';
		echo 'Welcome in the GM Tool.<br/>';
		echo 'Momos Panel: <a href="ajteam123t\ajteam123t\Designmomo">HERE</a>';
		echo 'You can use the menu on the left to quickly find what you need.<br/>';
		echo 'If whant to return to the main website, click <a href="../">here</a>.';

	}
}

?>