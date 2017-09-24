<?php

/**
 * @author		Momo
 * @copyright	2014 Jamiro Productions
**/

class Navigation{
	private $handle;

	public static function get(){
		echo '<div class="tspacer"></div>';
		for ($id = 1; file_exists(INC_DIR.'lib/navi/'.$id.'.php'); $id++){
			include(INC_DIR.'lib/navi/'.$id.'.php');
			echo '<a href="index.php?action='.$navi['action'].'">'.$navi['name'].'</a>';
		}
	}

}

?>