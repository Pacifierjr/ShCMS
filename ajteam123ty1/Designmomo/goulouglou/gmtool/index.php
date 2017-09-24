<?php

/**
 * @author		Momo
 * @copyright	2014 Jamiro Productions
**/

require_once('main.php');

if (isset($_GET['action']))
	Handle::handleAction($_GET['action'], $gm);
else
	Handle::handleAction('main', $gm);

?>