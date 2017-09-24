<?php

/**
 * @author		Trayne & eQuiNox
 * @copyright	2011 - 2017 Shaiya Productions
**/ 

require_once('main.php');

if (isset($_GET['action']))
	Handle::handleAction($_GET['action'], $gm);
else
	Handle::handleAction('main', $gm);

?> 


