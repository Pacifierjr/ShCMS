<?php

/**
 * @author		Trayne & eQuiNox
 * @copyright	2011 - 2017 Shaiya Productions
**/

Class Navigation{
	private $handle;

	public static function get(){
		echo '<div Class="tspacer"></div>';
		for ($id = 1; file_exists(INC_DIR.'lib/navi/'.$id.'.php'); $id++){
			include(INC_DIR.'lib/navi/'.$id.'.php');
			echo '<a href="index.php?action='.$navi['action'].'">'.$navi['name'].'</a>';
		}
	}

}

?>