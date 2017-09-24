<?php include('core/core.inc.php'); ?>

<!DOCTYPE html>

<html>

<? 	include('template/head.php'); ?>

	<body>
		<div id='container'>
			<? include('template/top-menu.php'); ?>
			<!--- paveikslelis --->
			<div class="tarpastarpnaujienu"></div>
			<center><?include('template/slider.php')?></center>
			<!--- paveikslelio pabaiga --->
			<div id="kontentas">
				<div id="k_1"></div>
				<div id="k_2">
                  <? if(! in_array( $pagename, $container_blacklist )){?>
                     <div id="Mcontainer">
                        <center>
                                <a href="/Home"><?=$SiteName?></a>
                                →
                                <a href="/<?=$pagename?>"><?=$pagename?></a>
                            
                        </center>
                         <br/>
                   <? }?>
                   
				<?php
						include($pagetoinc); 
				?>
						 <? if(! in_array( $pagename, $container_blacklist )){?>	
					</div>	 <? }?>
</div>
				<div id="k_3"></div>	
			</div>
				
			<?include('template/right-bar.php');?>
		
			<?include('template/footer.php');?>
		</div>
	</body>
</html>