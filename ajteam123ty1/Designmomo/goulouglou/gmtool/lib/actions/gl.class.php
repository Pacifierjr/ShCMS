<?php

/**
 * @author		Momo
 * @copyright	2014 Jamiro Productions
**/

class glAction{
	private $uid;
	private $gm;
	private $item;
	private $infoArr;
	private $error;
	private $guild;
	
	public function __construct($gm){
		$this->gm = $gm;
	}
	
	public function execute(){
		if (isset($_GET['uid'])){
			if (!Parser::gint($_GET['uid']))
				throw new SystemException('ItemUID muss vom Typ integer sein', 0, 0, __FILE__, __LINE__);
				
			$this->item = new item($_GET['uid'], 2);
			$this->guild = new guild($this->item->getGuildID());
			
			if (isset($_GET['do'])){
				switch($_GET['do']){
					case 'halt':
						if (isset($_POST['halt'])){
							$this->error = $this->item->changeQuality($_POST['halt']);
							if ($this->error == 1)
								echo '<div class="success">La durabilité de l objet '.$this->item->getItemName().' a été changé avec succès.</div>';
							else
								echo '<div class="error">'.$this->error.'</div>';
						}
						else
							echo '<div class="error">Entrez durabilité.</div>';
						break;
					case 'count':
						if (isset($_POST['count'])){
							$this->error = $this->item->changeCount($_POST['count']);
							if ($this->error == 1)
								echo '<div class="success">Le nombre d items '.$this->item->getItemName().' a été changé avec succès.</div>';
							else
								echo '<div class="error">'.$this->error.'</div>';
						}
						else
							echo '<div class="error">S il vous plaît entrer le numéro.</div>';
						break;
					case 'craft':
						if (isset($_POST['stat'])){
							$this->error = $this->item->changeCraftname($_GET['stat'], $_POST['stat']);
							if ($this->error == 1)
								echo '<div class="success">GM Stats des Items '.$this->item->getItemName().' changé avec succès.</div>';
							else
								echo '<div class="error">'.$this->error.'</div>';
						}
						else
							echo '<div class="error">S il vous plaît entrer Stat.</div>';
						break;
					case 'unlinklapis':
						$this->error = $this->item->extractLapis($_GET['slot']);
						if ($this->error == 1)
							echo '<div class="success">Lapis (Slot: '.$_GET['slot'].') avec succès à partir de la pièce '.$this->item->getItemName().' entfernt.</div>';
						else
							echo '<div class="error">'.$this->error.'</div>';
						break;
					case 'linklapis':
						if (isset($_POST['lapis'])){
							$this->error = $this->item->linkLapis($_POST['lapis'], $_GET['slot']);
							if ($this->error == 1)
								echo '<div class="success">Lapis succès dans le Item '.$this->item->getItemName().' gesockelt.</div>';
							else
								echo '<div class="error">'.$this->error.'</div>';
						}
						else
							echo '<div class="error">S il vous plaît entrer Lapis.</div>';
						break;
					case 'delete':
						$this->item->delete();
						?>
						<script language ="JavaScript"> 
						<!-- 
						document.location.href = "index.php?action=guild&GuildID=<?php echo $this->guild->getGuildID();?>"; 
						// --> 
						</script>
						<?php
						exit();
						break;
				}
				$this->item = new item($_GET['uid'], 2);
				$this->guild = new guild($this->item->getGuildID());
			}
			
			$this->infoArr['LapisDia'] = '';
			
			if ($this->item->getLapis1() != 0){
				$this->infoArr['TempLapis']			= new Lapis($this->item->getLapis1());
				$this->infoArr['Lapis1']['Name']	= $this->infoArr['TempLapis']->getName();
				$this->infoArr['Lapis1']['Link']	= '<a href="javascript::void();" id="unlink1">retirer Lapis</a>';
				$this->infoArr['LapisDia']			.= '<div id="unlink1dia" title="Lapis supprimer "> Voulez-vous le Lapis "'.$this->infoArr['TempLapis']->getName().'" des Items "'.$this->item->getItemName().'" (Charakter: "'.$this->char->getName().'", ItemUID: "'.$this->item->getUID().'") wirklich entfernen?</div>';
			} else {
				$this->infoArr['Lapis1']['Name']	= '';
				$this->infoArr['Lapis1']['Link']	= '<a href="javascript::void();" id="link1">vous sertissez Lapis</a>';
				$this->infoArr['LapisDia']			.= '<div id="link1dia" title="Lapis vous sertissez "> Entrez les Lapises TypeID de vous dans lélément "'.$this->item->getItemName().'" (Charakter: "'.$this->char->getName().'", ItemUID: "'.$this->item->getUID().'") sockeln wollen, ein.<form action="index.php?action=inv&amp;uid='.$this->item->getUID().'&amp;do=linklapis&amp;slot=1" method="POST"><br><input type="text" name="lapis" maxlength=3 size=3></form></div>';
			}
			
			if ($this->item->getLapis2() != 0){
				$this->infoArr['TempLapis']			= new Lapis($this->item->getLapis2());
				$this->infoArr['Lapis2']['Name']	= $this->infoArr['TempLapis']->getName();
				$this->infoArr['Lapis2']['Link']	= '<a href="javascript::void();" id="unlink2">retirer Lapis</a>';
				$this->infoArr['LapisDia']			.= '<div id="unlink2dia" title="Lapis supprimer "> Voulez-vous le Lapis "'.$this->infoArr['TempLapis']->getName().'" des Items "'.$this->item->getItemName().'" (Charakter: "'.$this->char->getName().'", ItemUID: "'.$this->item->getUID().'") wirklich entfernen?</div>';
			} else {
				$this->infoArr['Lapis2']['Name']	= '';
				$this->infoArr['Lapis2']['Link']	= '<a href="javascript::void();" id="link2">vous sertissez Lapis</a>';
				$this->infoArr['LapisDia']			.= '<div id="link2dia" title="Lapis vous sertissez "> Entrez les Lapises TypeID de vous dans lélément "'.$this->item->getItemName().'" (Charakter: "'.$this->char->getName().'", ItemUID: "'.$this->item->getUID().'") sockeln wollen, ein.<form action="index.php?action=inv&amp;uid='.$this->item->getUID().'&amp;do=linklapis&amp;slot=2" method="POST"><br><input type="text" name="lapis" maxlength=3 size=3></form></div>';
			}
			
			if ($this->item->getLapis3() != 0){
				$this->infoArr['TempLapis']			= new Lapis($this->item->getLapis3());
				$this->infoArr['Lapis3']['Name']	= $this->infoArr['TempLapis']->getName();
				$this->infoArr['Lapis3']['Link']	= '<a href="javascript::void();" id="unlink3">retirer Lapis</a>';
				$this->infoArr['LapisDia']			.= '<div id="unlink3dia" title="Lapis supprimer "> Voulez-vous le Lapis "'.$this->infoArr['TempLapis']->getName().'" des Items "'.$this->item->getItemName().'" (Charakter: "'.$this->char->getName().'", ItemUID: "'.$this->item->getUID().'") wirklich entfernen?</div>';
			} else {
				$this->infoArr['Lapis3']['Name']	= '';
				$this->infoArr['Lapis3']['Link']	= '<a href="javascript::void();" id="link3">vous sertissez Lapis</a>';
				$this->infoArr['LapisDia']			.= '<div id="link3dia" title="Lapis vous sertissez "> Entrez les Lapises TypeID de vous dans lélément "'.$this->item->getItemName().'" (Charakter: "'.$this->char->getName().'", ItemUID: "'.$this->item->getUID().'") sockeln wollen, ein.<form action="index.php?action=inv&amp;uid='.$this->item->getUID().'&amp;do=linklapis&amp;slot=3" method="POST"><br><input type="text" name="lapis" maxlength=3 size=3></form></div>';
			}
			
			if ($this->item->getLapis4() != 0){
				$this->infoArr['TempLapis']			= new Lapis($this->item->getLapis4());
				$this->infoArr['Lapis4']['Name']	= $this->infoArr['TempLapis']->getName();
				$this->infoArr['Lapis4']['Link']	= '<a href="javascript::void();" id="unlink4">retirer Lapis</a>';
				$this->infoArr['LapisDia']			.= '<div id="unlink4dia" title="Lapis supprimer "> Voulez-vous le Lapis "'.$this->infoArr['TempLapis']->getName().'" des Items "'.$this->item->getItemName().'" (Charakter: "'.$this->char->getName().'", ItemUID: "'.$this->item->getUID().'") wirklich entfernen?</div>';
			} else {
				$this->infoArr['Lapis4']['Name']	= '';
				$this->infoArr['Lapis4']['Link']	= '<a href="javascript::void();" id="link4">vous sertissez Lapis</a>';
				$this->infoArr['LapisDia']			.= '<div id="link4dia" title="Lapis vous sertissez "> Entrez les Lapises TypeID de vous dans lélément"'.$this->item->getItemName().'" (Charakter: "'.$this->char->getName().'", ItemUID: "'.$this->item->getUID().'") sockeln wollen, ein.<form action="index.php?action=inv&amp;uid='.$this->item->getUID().'&amp;do=linklapis&amp;slot=4" method="POST"><br><input type="text" name="lapis" maxlength=3 size=3></form></div>';
			}
			
			if ($this->item->getLapis5() != 0){
				$this->infoArr['TempLapis']			= new Lapis($this->item->getLapis5());
				$this->infoArr['Lapis5']['Name']	= $this->infoArr['TempLapis']->getName();
				$this->infoArr['Lapis5']['Link']	= '<a href="javascript::void();" id="unlink5">retirer Lapis</a>';
				$this->infoArr['LapisDia']			.= '<div id="unlink5dia" title="Lapis supprimer "> Voulez-vous le Lapis "'.$this->infoArr['TempLapis']->getName().'" des Items "'.$this->item->getItemName().'" (Charakter: "'.$this->char->getName().'", ItemUID: "'.$this->item->getUID().'") wirklich entfernen?</div>';
			} else {
				$this->infoArr['Lapis5']['Name']	= '';
				$this->infoArr['Lapis5']['Link']	= '<a href="javascript::void();" id="link5">vous sertissez Lapis</a>';
				$this->infoArr['LapisDia']			.= '<div id="link5dia" title="Lapis vous sertissez "> Entrez les Lapises TypeID de vous dans lélément "'.$this->item->getItemName().'" (Charakter: "'.$this->char->getName().'", ItemUID: "'.$this->item->getUID().'") sockeln wollen, ein.<form action="index.php?action=inv&amp;uid='.$this->item->getUID().'&amp;do=linklapis&amp;slot=5" method="POST"><br><input type="text" name="lapis" maxlength=3 size=3></form></div>';
			}
			
			if ($this->item->getLapis6() != 0){
				$this->infoArr['TempLapis']			= new Lapis($this->item->getLapis6());
				$this->infoArr['Lapis6']['Name']	= $this->infoArr['TempLapis']->getName();
				$this->infoArr['Lapis6']['Link']	= '<a href="javascript::void();" id="unlink6">retirer Lapis</a>';
				$this->infoArr['LapisDia']			.= '<div id="unlink6dia" title="Lapis supprimer "> Voulez-vous le Lapis "'.$this->infoArr['TempLapis']->getName().'" des Items "'.$this->item->getItemName().'" (Charakter: "'.$this->char->getName().'", ItemUID: "'.$this->item->getUID().'") wirklich entfernen?</div>';
			} else {
				$this->infoArr['Lapis6']['Name']	= '';
				$this->infoArr['Lapis6']['Link']	= '<a href="javascript::void();" id="link6">vous sertissez Lapis</a>';
				$this->infoArr['LapisDia']			.= '<div id="link6dia" title="Lapis sockeln">Lapis vous sertissez "> Entrez les Lapises TypeID de vous dans lélément "'.$this->item->getItemName().'" (Charakter: "'.$this->char->getName().'", ItemUID: "'.$this->item->getUID().'") sockeln wollen, ein.<form action="index.php?action=inv&amp;uid='.$this->item->getUID().'&amp;do=linklapis&amp;slot=6" method="POST"><br><input type="text" name="lapis" maxlength=3 size=3></form></div>';
			}
			
			
			echo '<table>';
			echo '<tr><td>GuildID: </td><td>'.$this->guild->getGuildID().'</td><td></td></tr>';
			echo '<tr><td>Guilde: </td><td><a href="index.php?action=guild&amp;GuildID='.$this->guild->getGuildID().'">'.$this->guild->getName().'</a></td><td></td></tr>';
			echo '<tr><td>ItemID: </td><td>'.$this->item->getItemID().'</td><td></td></tr>';
			echo '<tr><td>Item: </td><td>'.$this->item->getItemName().'</td><td></td></tr>';
			echo '<tr><td>Type: </td><td>'.$this->item->getType().'</td><td></td></tr>';
			echo '<tr><td>TypeID: </td><td>'.$this->item->getTypeID().'</td><td></td></tr>';
			echo '<tr><td>Level: </td><td>'.$this->item->getLevel().'</td><td></td></tr>';
			echo '<tr><td>Slots: </td><td>'.$this->item->getSlots().'</td><td></td></tr>';
			echo '<tr><td>Qualite: </td><td>'.Parser::Zahl($this->item->getQuality()).'</td><td><a href="javascript::void();" id="halt">Qualite changer</a></td></tr>';
			echo '<tr><td>Max. Qualite: </td><td>'.Parser::Zahl($this->item->getMaxQuality()).'</td><td></td></tr>';
			echo '<tr><td>Espace: </td><td>'.$this->item->getSlot().'</td><td></td></tr>';
			echo '<tr><td>nombre: </td><td>'.$this->item->getCount().'</td><td><a href="javascript::void();" id="count">Modification du nombre</a></td></tr>';
			echo '<tr><td>obtenir: </td><td>'.Parser::Datum($this->item->getTime()).'</td><td></td></tr>';
			echo '<tr><td>Str: </td><td>'.(int)$this->item->getStr().'</td><td><a href="javascript::void();" id="str">Str Changement</a></td></tr>';
			echo '<tr><td>Dex: </td><td>'.(int)$this->item->getDex().'</td><td><a href="javascript::void();" id="dex">Dex Changement</a></td></tr>';
			echo '<tr><td>Rec: </td><td>'.(int)$this->item->getRec().'</td><td><a href="javascript::void();" id="rec">Rec Changement</a></td></tr>';
			echo '<tr><td>Int: </td><td>'.(int)$this->item->getInt().'</td><td><a href="javascript::void();" id="int">Int Changement</a></td></tr>';
			echo '<tr><td>Wis: </td><td>'.(int)$this->item->getWis().'</td><td><a href="javascript::void();" id="wis">Wis Changement</a></td></tr>';
			echo '<tr><td>Cha: </td><td>'.(int)$this->item->getLuc().'</td><td><a href="javascript::void();" id="luc">Cha Changement</a></td></tr>';
			echo '<tr><td>HP: </td><td>'.Parser::Zahl((int)$this->item->getHP() * 100).'</td><td><a href="javascript::void();" id="hp">HP Changement</a></td></tr>';
			echo '<tr><td>MP: </td><td>'.Parser::Zahl((int)$this->item->getMP() * 100).'</td><td><a href="javascript::void();" id="mp">MP Changement</a></td></tr>';
			echo '<tr><td>SP: </td><td>'.Parser::Zahl((int)$this->item->getSP() * 100).'</td><td><a href="javascript::void();" id="sp">SP Changement</a></td></tr>';
			echo '<tr><td>Lapisa: </td><td>'.(int)$this->item->getLapisa().'</td><td><a href="javascript::void();" id="lapisa">changer Enchantement</a></td></tr>';
			echo '<tr><td>Slot 1: </td><td>'.$this->infoArr['Lapis1']['Name'].'</td><td>'.$this->infoArr['Lapis1']['Link'].'</td></tr>';
			echo '<tr><td>Slot 2: </td><td>'.$this->infoArr['Lapis2']['Name'].'</td><td>'.$this->infoArr['Lapis2']['Link'].'</td></tr>';
			echo '<tr><td>Slot 3: </td><td>'.$this->infoArr['Lapis3']['Name'].'</td><td>'.$this->infoArr['Lapis3']['Link'].'</td></tr>';
			echo '<tr><td>Slot 4: </td><td>'.$this->infoArr['Lapis4']['Name'].'</td><td>'.$this->infoArr['Lapis4']['Link'].'</td></tr>';
			echo '<tr><td>Slot 5: </td><td>'.$this->infoArr['Lapis5']['Name'].'</td><td>'.$this->infoArr['Lapis5']['Link'].'</td></tr>';
			echo '<tr><td>Slot 6: </td><td>'.$this->infoArr['Lapis6']['Name'].'</td><td>'.$this->infoArr['Lapis6']['Link'].'</td></tr>';
			echo '<tr><td>effacer: </td><td></td><td><a href="javascript::void();" id="del">Item effacer</a></td></tr>';
			echo '</table>';
			
			?>
			<script type="text/javascript">
			$(function(){
				$("#haltdia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					width: 400,
					width: 400,
					modal: true,
					buttons: {
						Ändern: function() {
							$("#haltdia > form").submit();
							$(this).dialog('close');
						},
					
						Abbrechen: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#countdia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					width: 400,
					width: 400,
					modal: true,
					buttons: {
						Ändern: function() {
							$("#countdia > form").submit();
							$(this).dialog('close');
						},
					
						Abbrechen: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#strdia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					width: 400,
					modal: true,
					buttons: {
						Ändern: function() {
							$("#strdia > form").submit();
							$(this).dialog('close');
						},
					
						Abbrechen: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#dexdia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					width: 400,
					modal: true,
					buttons: {
						Ändern: function() {
							$("#dexdia > form").submit();
							$(this).dialog('close');
						},
					
						Abbrechen: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#recdia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					width: 400,
					modal: true,
					buttons: {
						Ändern: function() {
							$("#recdia > form").submit();
							$(this).dialog('close');
						},
					
						Abbrechen: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#intdia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					width: 400,
					modal: true,
					buttons: {
						Ändern: function() {
							$("#intdia > form").submit();
							$(this).dialog('close');
						},
					
						Abbrechen: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#wisdia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					width: 400,
					modal: true,
					buttons: {
						Ändern: function() {
							$("#wisdia > form").submit();
							$(this).dialog('close');
						},
					
						Abbrechen: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#lucdia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					width: 400,
					modal: true,
					buttons: {
						Ändern: function() {
							$("#lucdia > form").submit();
							$(this).dialog('close');
						},
					
						Abbrechen: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#hpdia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					width: 400,
					modal: true,
					buttons: {
						Ändern: function() {
							$("#hpdia > form").submit();
							$(this).dialog('close');
						},
					
						Abbrechen: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#mpdia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					width: 400,
					modal: true,
					buttons: {
						Ändern: function() {
							$("#mpdia > form").submit();
							$(this).dialog('close');
						},
					
						Abbrechen: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#spdia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					width: 400,
					modal: true,
					buttons: {
						Ändern: function() {
							$("#spdia > form").submit();
							$(this).dialog('close');
						},
					
						Abbrechen: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#lapisadia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					width: 400,
					modal: true,
					buttons: {
						Ändern: function() {
							$("#lapisadia > form").submit();
							$(this).dialog('close');
						},
					
						Abbrechen: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#unlink1dia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					width: 400,
					modal: true,
					buttons: {
						Ja: function() {
							document.location.href = 'index.php?action=gl&uid=<?php echo $this->item->getUID();?>&do=unlinklapis&slot=1';
							$(this).dialog('close');
						},
					
						Nein: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#unlink2dia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					width: 400,
					modal: true,
					buttons: {
						Ja: function() {
							document.location.href = 'index.php?action=gl&uid=<?php echo $this->item->getUID();?>&do=unlinklapis&slot=2';
							$(this).dialog('close');
						},
					
						Nein: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#unlink3dia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					width: 400,
					modal: true,
					buttons: {
						Ja: function() {
							document.location.href = 'index.php?action=gl&uid=<?php echo $this->item->getUID();?>&do=unlinklapis&slot=3';
							$(this).dialog('close');
						},
					
						Nein: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#unlink4dia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					width: 400,
					modal: true,
					buttons: {
						Ja: function() {
							document.location.href = 'index.php?action=gl&uid=<?php echo $this->item->getUID();?>&do=unlinklapis&slot=4';
							$(this).dialog('close');
						},
					
						Nein: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#unlink5dia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					width: 400,
					modal: true,
					buttons: {
						Ja: function() {
							document.location.href = 'index.php?action=gl&uid=<?php echo $this->item->getUID();?>&do=unlinklapis&slot=5';
							$(this).dialog('close');
						},
					
						Nein: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#unlink6dia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					width: 400,
					modal: true,
					buttons: {
						Ja: function() {
							document.location.href = 'index.php?action=gl&uid=<?php echo $this->item->getUID();?>&do=unlinklapis&slot=6';
							$(this).dialog('close');
						},
					
						Nein: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#link1dia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					width: 400,
					modal: true,
					buttons: {
						Sockeln: function() {
							$("#link1dia > form").submit();
							$(this).dialog('close');
						},
					
						Abbrechen: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#link2dia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					width: 400,
					modal: true,
					buttons: {
						Sockeln: function() {
							$("#link2dia > form").submit();
							$(this).dialog('close');
						},
					
						Abbrechen: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#link3dia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					width: 400,
					modal: true,
					buttons: {
						Sockeln: function() {
							$("#link3dia > form").submit();
							$(this).dialog('close');
						},
					
						Abbrechen: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#link4dia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					width: 400,
					modal: true,
					buttons: {
						Sockeln: function() {
							$("#link4dia > form").submit();
							$(this).dialog('close');
						},
					
						Abbrechen: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#link5dia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					width: 400,
					modal: true,
					buttons: {
						Sockeln: function() {
							$("#link5dia > form").submit();
							$(this).dialog('close');
						},
					
						Abbrechen: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#link6dia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					width: 400,
					modal: true,
					buttons: {
						Sockeln: function() {
							$("#link6dia > form").submit();
							$(this).dialog('close');
						},
					
						Abbrechen: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#deldia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					width: 400,
					modal: true,
					buttons: {
						Ja: function() {
							document.location.href = 'index.php?action=gl&uid=<?php echo $this->item->getUID();?>&do=delete';
							$(this).dialog('close');
						},
					
						Nein: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$('#halt').click(function() {
					$('#haltdia').dialog('open');
				});
				
				$('#count').click(function() {
					$('#countdia').dialog('open');
				});
				
				$('#str').click(function() {
					$('#strdia').dialog('open');
				});
				
				$('#dex').click(function() {
					$('#dexdia').dialog('open');
				});
				
				$('#rec').click(function() {
					$('#recdia').dialog('open');
				});
				
				$('#int').click(function() {
					$('#intdia').dialog('open');
				});
				
				$('#wis').click(function() {
					$('#wisdia').dialog('open');
				});
				
				$('#luc').click(function() {
					$('#ludia').dialog('open');
				});
				
				$('#hp').click(function() {
					$('#hpdia').dialog('open');
				});
				
				$('#mp').click(function() {
					$('#mpdia').dialog('open');
				});
				
				$('#sp').click(function() {
					$('#spdia').dialog('open');
				});
				
				$('#lapisa').click(function() {
					$('#lapisadia').dialog('open');
				});
				
				$('#unlink1').click(function() {
					$('#unlink1dia').dialog('open');
				});
				
				$('#unlink2').click(function() {
					$('#unlink2dia').dialog('open');
				});
				
				$('#unlink3').click(function() {
					$('#unlink3dia').dialog('open');
				});
				
				$('#unlink4').click(function() {
					$('#unlink4dia').dialog('open');
				});
				
				$('#unlink5').click(function() {
					$('#unlink5dia').dialog('open');
				});
				
				$('#unlink6').click(function() {
					$('#unlink6dia').dialog('open');
				});
				
				$('#link1').click(function() {
					$('#link1dia').dialog('open');
				});
				
				$('#link2').click(function() {
					$('#link2dia').dialog('open');
				});
				
				$('#link3').click(function() {
					$('#link3dia').dialog('open');
				});
				
				$('#link4').click(function() {
					$('#link4dia').dialog('open');
				});
				
				$('#link5').click(function() {
					$('#link5dia').dialog('open');
				});
				
				$('#link6').click(function() {
					$('#link6dia').dialog('open');
				});
				
				$('#del').click(function() {
					$('#deldia').dialog('open');
				});
				
			});
			</script>
			
			<div id="haltdia" title="Haltbarkeit ändern">Comment faut-il la nouvelle vie de l'élément '<?php echo $this->item->getItemName();?>' (Account: <?php echo $this->user->getName();?>, ItemUID: <?php echo $this->item->getUID();?>) lauten?<form action="index.php?action=wl&amp;uid=<?php echo $this->item->getUID();?>&amp;do=halt" method="POST"><br><input type="text" name="halt" maxlength=4 size=4></form></div>
			<div id="countdia" title="Anzahl ändern">Comment est le nouveau nombre d'éléments '<?php echo $this->item->getItemName();?>' (Account: <?php echo $this->user->getName();?>, ItemUID: <?php echo $this->item->getUID();?>) lauten?<form action="index.php?action=wl&amp;uid=<?php echo $this->item->getUID();?>&amp;do=count" method="POST"><br><input type="text" name="count" maxlength=4 size=4></form></div>
			<div id="strdia" title="Str ändern">Comment est le nouveau numéro de l'article Str '<?php echo $this->item->getItemName();?>' (Account: <?php echo $this->user->getName();?>, ItemUID: <?php echo $this->item->getUID();?>) lauten?<form action="index.php?action=wl&amp;uid=<?php echo $this->item->getUID();?>&amp;do=craft&amp;stat=Str" method="POST"><br><input type="text" name="stat" maxlength=2 size=2></form></div>
			<div id="dexdia" title="Ges ändern">Comment est le nouveau numéro de l'article Dex '<?php echo $this->item->getItemName();?>' (Account: <?php echo $this->user->getName();?>, ItemUID: <?php echo $this->item->getUID();?>) lauten?<form action="index.php?action=wl&amp;uid=<?php echo $this->item->getUID();?>&amp;do=craft&amp;stat=Dex" method="POST"><br><input type="text" name="stat" maxlength=2 size=2></form></div>
			<div id="recdia" title="Abw ändern">Comment est le nouveau numéro de l'article Rec '<?php echo $this->item->getItemName();?>' (Account: <?php echo $this->user->getName();?>, ItemUID: <?php echo $this->item->getUID();?>) lauten?<form action="index.php?action=wl&amp;uid=<?php echo $this->item->getUID();?>&amp;do=craft&amp;stat=Rec" method="POST"><br><input type="text" name="stat" maxlength=2 size=2></form></div>
			<div id="intdia" title="Int ändern">Comment est le nouveau numéro de l'article Int '<?php echo $this->item->getItemName();?>' (Account: <?php echo $this->user->getName();?>, ItemUID: <?php echo $this->item->getUID();?>) lauten?<form action="index.php?action=wl&amp;uid=<?php echo $this->item->getUID();?>&amp;do=craft&amp;stat=Int" method="POST"><br><input type="text" name="stat" maxlength=2 size=2></form></div>
			<div id="wisdia" title="Wei ändern">Comment est le nouveau numéro de l'article Wis '<?php echo $this->item->getItemName();?>' (Account: <?php echo $this->user->getName();?>, ItemUID: <?php echo $this->item->getUID();?>) lauten?<form action="index.php?action=wl&amp;uid=<?php echo $this->item->getUID();?>&amp;do=craft&amp;stat=Wis" method="POST"><br><input type="text" name="stat" maxlength=2 size=2></form></div>
			<div id="lucdia" title="Glü ändern">Comment est le nouveau numéro de l'article Cha '<?php echo $this->item->getItemName();?>' (Account: <?php echo $this->user->getName();?>, ItemUID: <?php echo $this->item->getUID();?>) lauten?<form action="index.php?action=wl&amp;uid=<?php echo $this->item->getUID();?>&amp;do=craft&amp;stat=Luc" method="POST"><br><input type="text" name="stat" maxlength=2 size=2></form></div>
			<div id="hpdia" title="LP ändern">Comment est le nouveau numéro des articles de HP '<?php echo $this->item->getItemName();?>' (Account: <?php echo $this->user->getName();?>, ItemUID: <?php echo $this->item->getUID();?>) lauten?<form action="index.php?action=wl&amp;uid=<?php echo $this->item->getUID();?>&amp;do=craft&amp;stat=HP" method="POST"><br><input type="text" name="stat" maxlength=2 size=4>00</form></div>
			<div id="mpdia" title="MP ändern">Comment est le nouveau numéro des articles de MP '<?php echo $this->item->getItemName();?>' (Account: <?php echo $this->user->getName();?>, ItemUID: <?php echo $this->item->getUID();?>) lauten?<form action="index.php?action=wl&amp;uid=<?php echo $this->item->getUID();?>&amp;do=craft&amp;stat=MP" method="POST"><br><input type="text" name="stat" maxlength=2 size=4>00</form></div>
			<div id="spdia" title="SP ändern">Comment est le nouveau numéro des articles de SP '<?php echo $this->item->getItemName();?>' (Account: <?php echo $this->user->getName();?>, ItemUID: <?php echo $this->item->getUID();?>) lauten?<form action="index.php?action=wl&amp;uid=<?php echo $this->item->getUID();?>&amp;do=craft&amp;stat=SP" method="POST"><br><input type="text" name="stat" maxlength=2 size=4>00</form></div>
			<div id="lapisadia" title="Verzauberung ändern">Comment le nouveau enchantement de l'article '<?php echo $this->item->getItemName();?>' (Account: <?php echo $this->user->getName();?>, ItemUID: <?php echo $this->item->getUID();?>) lauten?<form action="index.php?action=wl&amp;uid=<?php echo $this->item->getUID();?>&amp;do=craft&amp;stat=Lapisa" method="POST"><br><input type="text" name="stat" maxlength=2 size=4><br>0-20 arme<br>50-70 Armure et boubou</form></div>
			<div id="deldia" title="Item löschen">Souhaitez-vous l'élément '<?php echo $this->item->getItemName();?>' (Account: <?php echo $this->user->getName();?>, ItemUID: <?php echo $this->item->getUID();?>) wirklich löschen?</div>
			
			
			<?php
			echo $this->infoArr['LapisDia'];
		}
	}
}

?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    