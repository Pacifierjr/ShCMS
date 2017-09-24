<?php

/**
 * @author		Momo
 * @copyright	2014 Jamiro Productions
**/

class logoutAction{
	private $gm;
	
	public function __construct(&$gm){
		$this->gm = $gm;
	}
	
	public function execute(){
		Session::delete();
		?>
		<script language ="JavaScript"> 
		<!-- 
		document.location.href = "index.php"; 
		// --> 
		</script>
		<?php
		exit();
	}
}

?>