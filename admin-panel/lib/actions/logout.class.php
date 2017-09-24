<?php

/**
 * @author		Trayne & eQuiNox
 * @copyright	2011 - 2017 Shaiya Productions
**/

Class logoutAction{
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