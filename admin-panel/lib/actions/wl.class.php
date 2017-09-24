<?php

/**
 * @author		Trayne & eQuiNox
 * @copyright	2011 - 2017 Shaiya Productions
**/

Class wlAction{
	private $uid;
	private $gm;
	private $item;
	private $infoArr;
	private $error;
	private $user;
	
	public function __construct($gm){
		$this->gm = $gm;
	}
	
	public function execute(){
		if (isset($_GET['uid'])){
			if (!Parser::gint($_GET['uid']))
				throw new SystemException('ItemUID must be an integer.', 0, 0, __FILE__, __LINE__);
				
			$this->item = new item($_GET['uid'], 1);
			$this->user = new user($this->item->getUserUID());
			
			if (isset($_GET['do'])){
				switch($_GET['do']){
					case 'halt':
						if (isset($_POST['halt'])){
							$this->error = $this->item->changeQuality($_POST['halt']);
							if ($this->error == 1)
								echo '<div Class="success">The durability of '.$this->item->getItemName().' has been changed.</div>';
							else
								echo '<div Class="error">'.$this->error.'</div>';
						}
						else
							echo '<div Class="error">Please provide a correct value for the durability.</div>';
						break;
					case 'count':
						if (isset($_POST['count'])){
							$this->error = $this->item->changeCount($_POST['count']);
							if ($this->error == 1)
								echo '<div Class="success">The count of '.$this->item->getItemName().' has been changed.</div>';
							else
								echo '<div Class="error">'.$this->error.'</div>';
						}
						else
							echo '<div Class="error">Pleaseprovide a correct count value.</div>';
						break;
					case 'craft':
						if (isset($_POST['stat'])){
							$this->error = $this->item->changeCraftname($_GET['stat'], $_POST['stat']);
							if ($this->error == 1)
								echo '<div Class="success">EP-4 (OJ) Stats of '.$this->item->getItemName().' have been changed.</div>';
							else
								echo '<div Class="error">'.$this->error.'</div>';
						}
						else
							echo '<div Class="error">Please provide a correct stats value.</div>';
						break;
					case 'unlinklapis':
						$this->error = $this->item->extractLapis($_GET['slot']);
						if ($this->error == 1)
							echo '<div Class="success">Lapis (Slot: '.$_GET['slot'].') has been unlinked from '.$this->item->getItemName().'</div>';
						else
							echo '<div Class="error">'.$this->error.'</div>';
						break;
					case 'linklapis':
						if (isset($_POST['lapis'])){
							$this->error = $this->item->linkLapis($_POST['lapis'], $_GET['slot']);
							if ($this->error == 1)
								echo '<div Class="success">Lapis has been linked to '.$this->item->getItemName().'.</div>';
							else
								echo '<div Class="error">'.$this->error.'</div>';
						}
						else
							echo '<div Class="error">Please provide a correct lapis value.</div>';
						break;
					case 'delete':
						$this->item->delete();
						?>
						<script language ="JavaScript"> 
						<!-- 
						document.location.href = "index.php?action=user&UserUID=<?php echo $this->user->getUserUID();?>"; 
						// --> 
						</script>
						<?php
						exit();
						break;
				}
				$this->item = new item($_GET['uid'], 1);
				$this->user = new user($this->item->getUserUID());
			}
			
			$this->infoArr['LapisDia'] = '';
			
				if ($this->item->getLapis1() != 0){
				$this->infoArr['TempLapis']			= new Lapis($this->item->getLapis1());
				$this->infoArr['Lapis1']['Name']	= $this->infoArr['TempLapis']->getName();
				$this->infoArr['Lapis1']['Link']	= '<a  id="unlink1">Unlink a Lapis</a>';
				$this->infoArr['LapisDia']			.= '<div id="unlink1dia" title="Unlink a Lapis">Would you like remove the Lapis "'.$this->infoArr['TempLapis']->getName().'" of the item "'.$this->item->getItemName().' ?" (Account: "'.$this->user->getName().'", ItemUID: "'.BIntString($this->item->getUID()).'")</div>';
			} else {
				$this->infoArr['Lapis1']['Name']	= '';
				$this->infoArr['Lapis1']['Link']	= '<a  id="link1">Link a lapis</a>';
				$this->infoArr['LapisDia']			.= '<div id="link1dia" title="Link a lapis">Please put the lapis ID that you want to link to the item "'.$this->item->getItemName().'" (Account: "'.$this->user->getName().'", ItemUID: "'.BIntString($this->item->getUID()).'") in slot 1.<form action="index.php?action=wl&amp;uid='.BIntString($this->item->getUID()).'&amp;do=linklapis&amp;slot=1" method="POST" id="link1diaform"><br><input type="text" name="lapis" maxlength=3 size=3></form></div>';
			}
			
			if ($this->item->getLapis2() != 0){
				$this->infoArr['TempLapis']			= new Lapis($this->item->getLapis2());
				$this->infoArr['Lapis2']['Name']	= $this->infoArr['TempLapis']->getName();
				$this->infoArr['Lapis2']['Link']	= '<a  id="unlink2">Unlink a Lapis</a>';
				$this->infoArr['LapisDia']			.= '<div id="unlink2dia" title="Unlink a Lapis">Would you like remove the Lapis "'.$this->infoArr['TempLapis']->getName().'" of the item "'.$this->item->getItemName().' ?" (Account: "'.$this->user->getName().'", ItemUID: "'.BIntString($this->item->getUID()).'")</div>';
			} else {
				$this->infoArr['Lapis2']['Name']	= '';
				$this->infoArr['Lapis2']['Link']	= '<a  id="link2">Link a lapis</a>';
				$this->infoArr['LapisDia']			.= '<div id="link2dia" title="Link a lapis">Please put the lapis ID that you want to link to the item "'.$this->item->getItemName().'" (Account: "'.$this->user->getName().'", ItemUID: "'.BIntString($this->item->getUID()).'") in slot 2.<form action="index.php?action=wl&amp;uid='.BIntString($this->item->getUID()).'&amp;do=linklapis&amp;slot=1" method="POST" id="link2diaform"><br><input type="text" name="lapis" maxlength=3 size=3></form></div>';
			}
			
			if ($this->item->getLapis3() != 0){
				$this->infoArr['TempLapis']			= new Lapis($this->item->getLapis3());
				$this->infoArr['Lapis3']['Name']	= $this->infoArr['TempLapis']->getName();
				$this->infoArr['Lapis3']['Link']	= '<a  id="unlink3">Unlink a Lapis</a>';
				$this->infoArr['LapisDia']			.= '<div id="unlink3dia" title="Unlink a Lapis">Would you like remove the Lapis "'.$this->infoArr['TempLapis']->getName().'" of the item "'.$this->item->getItemName().' ?" (Account: "'.$this->user->getName().'", ItemUID: "'.BIntString($this->item->getUID()).'")</div>';
			} else {
				$this->infoArr['Lapis3']['Name']	= '';
				$this->infoArr['Lapis3']['Link']	= '<a  id="link3">Link a lapis</a>';
				$this->infoArr['LapisDia']			.= '<div id="link3dia" title="Link a lapis">Please put the lapis ID that you want to link to the item "'.$this->item->getItemName().'" (Account: "'.$this->user->getName().'", ItemUID: "'.BIntString($this->item->getUID()).'") in slot 3.<form action="index.php?action=wl&amp;uid='.BIntString($this->item->getUID()).'&amp;do=linklapis&amp;slot=1" method="POST" id="link3diaform"><br><input type="text" name="lapis" maxlength=3 size=3></form></div>';
			}
			
			if ($this->item->getLapis4() != 0){
				$this->infoArr['TempLapis']			= new Lapis($this->item->getLapis4());
				$this->infoArr['Lapis4']['Name']	= $this->infoArr['TempLapis']->getName();
				$this->infoArr['Lapis4']['Link']	= '<a  id="unlink4">Unlink a Lapis</a>';
				$this->infoArr['LapisDia']			.= '<div id="unlink4dia" title="Unlink a Lapis">Would you like remove the Lapis "'.$this->infoArr['TempLapis']->getName().'" of the item "'.$this->item->getItemName().' ?" (Account: "'.$this->user->getName().'", ItemUID: "'.BIntString($this->item->getUID()).'")</div>';
			} else {
				$this->infoArr['Lapis4']['Name']	= '';
				$this->infoArr['Lapis4']['Link']	= '<a  id="link4">Link a lapis</a>';
				$this->infoArr['LapisDia']			.= '<div id="link4dia" title="Link a lapis">Please put the lapis ID that you want to link to the item "'.$this->item->getItemName().'" (Account: "'.$this->user->getName().'", ItemUID: "'.BIntString($this->item->getUID()).'") in slot 4.<form action="index.php?action=wl&amp;uid='.BIntString($this->item->getUID()).'&amp;do=linklapis&amp;slot=1" method="POST" id="link4diaform"><br><input type="text" name="lapis" maxlength=3 size=3></form></div>';
			}
			
			if ($this->item->getLapis5() != 0){
				$this->infoArr['TempLapis']			= new Lapis($this->item->getLapis5());
				$this->infoArr['Lapis5']['Name']	= $this->infoArr['TempLapis']->getName();
				$this->infoArr['Lapis5']['Link']	= '<a  id="unlink5">Unlink a Lapis</a>';
				$this->infoArr['LapisDia']			.= '<div id="unlink5dia" title="Unlink a Lapis">Would you like remove the Lapis "'.$this->infoArr['TempLapis']->getName().'" of the item "'.$this->item->getItemName().' ?" (Account: "'.$this->user->getName().'", ItemUID: "'.BIntString($this->item->getUID()).'")</div>';
			} else {
				$this->infoArr['Lapis5']['Name']	= '';
				$this->infoArr['Lapis5']['Link']	= '<a  id="link5">Link a lapis</a>';
				$this->infoArr['LapisDia']			.= '<div id="link5dia" title="Link a lapis">Please put the lapis ID that you want to link to the item "'.$this->item->getItemName().'" (Account: "'.$this->user->getName().'", ItemUID: "'.BIntString($this->item->getUID()).'") in slot 5.<form action="index.php?action=wl&amp;uid='.BIntString($this->item->getUID()).'&amp;do=linklapis&amp;slot=1" method="POST" id="link5diaform"><br><input type="text" name="lapis" maxlength=3 size=3></form></div>';
			}
			
			if ($this->item->getLapis6() != 0){
				$this->infoArr['TempLapis']			= new Lapis($this->item->getLapis6());
				$this->infoArr['Lapis6']['Name']	= $this->infoArr['TempLapis']->getName();
				$this->infoArr['Lapis6']['Link']	= '<a  id="unlink6">Unlink a Lapis</a>';
				$this->infoArr['LapisDia']			.= '<div id="unlink6dia" title="Unlink a Lapis">Would you like remove the Lapis "'.$this->infoArr['TempLapis']->getName().'" of the item "'.$this->item->getItemName().' ?" (Account: "'.$this->user->getName().'", ItemUID: "'.BIntString($this->item->getUID()).'")</div>';
			} else {
				$this->infoArr['Lapis6']['Name']	= '';
				$this->infoArr['Lapis6']['Link']	= '<a  id="link6">Link a lapis</a>';
				$this->infoArr['LapisDia']			.= '<div id="link6dia" title="Link a lapis">Please put the lapis ID that you want to link to the item "'.$this->item->getItemName().'" (Account: "'.$this->user->getName().'", ItemUID: "'.BIntString($this->item->getUID()).'") in slot 6.<form action="index.php?action=wl&amp;uid='.BIntString($this->item->getUID()).'&amp;do=linklapis&amp;slot=6" method="POST" id="link6diaform"><br><input type="text" name="lapis" maxlength=3 size=3></form></div>';
			}			
			
			
			echo '<table>';
			echo '<tr><td>UserUID: </td><td>'.$this->user->getUserUID().'</td><td></td></tr>';
			echo '<tr><td>Account: </td><td><a href="index.php?action=user&amp;UserUID='.$this->user->getUserUID().'">'.$this->user->getName().'</a></td><td></td></tr>';
			echo '<tr><td>ItemID: </td><td>'.$this->item->getItemID().'</td><td></td></tr>';
			echo '<tr><td>Item: </td><td>'.$this->item->getItemName().'</td><td></td></tr>';
			echo '<tr><td>Type: </td><td>'.$this->item->getType().'</td><td></td></tr>';
			echo '<tr><td>TypeID: </td><td>'.$this->item->getTypeID().'</td><td></td></tr>';
			echo '<tr><td>Level: </td><td>'.$this->item->getLevel().'</td><td></td></tr>';
			echo '<tr><td>Slots: </td><td>'.$this->item->getSlots().'</td><td></td></tr>';
			echo '<tr><td>Durability: </td><td>'.Parser::Zahl($this->item->getQuality()).'</td><td><a  id="halt">Change durability</a></td></tr>';
			echo '<tr><td>Max. Durability: </td><td>'.Parser::Zahl($this->item->getMaxQuality()).'</td><td></td></tr>';
			echo '<tr><td>Slot: </td><td>'.$this->item->getSlot().'</td><td></td></tr>';
			echo '<tr><td>Count: </td><td>'.$this->item->getCount().'</td><td><a  id="count">Change count</a></td></tr>';
			echo '<tr><td>Obtain: </td><td>'.Parser::Datum($this->item->getTime()).'</td><td></td></tr>';
			echo '<tr><td>Str: </td><td>'.(int)$this->item->getStr().'</td><td><a  id="str">Change str</a></td></tr>';
			echo '<tr><td>Dex: </td><td>'.(int)$this->item->getDex().'</td><td><a  id="dex">Change dex</a></td></tr>';
			echo '<tr><td>Rec: </td><td>'.(int)$this->item->getRec().'</td><td><a  id="rec">Change rec</a></td></tr>';
			echo '<tr><td>Int: </td><td>'.(int)$this->item->getInt().'</td><td><a  id="int">Change int</a></td></tr>';
			echo '<tr><td>Wis: </td><td>'.(int)$this->item->getWis().'</td><td><a  id="wis">Change wis</a></td></tr>';
			echo '<tr><td>Luc: </td><td>'.(int)$this->item->getLuc().'</td><td><a  id="luc">Change luc</a></td></tr>';
			echo '<tr><td>HP: </td><td>'.Parser::Zahl((int)$this->item->getHP() * 100).'</td><td><a  id="hp">Change HP</a></td></tr>';
			echo '<tr><td>MP: </td><td>'.Parser::Zahl((int)$this->item->getMP() * 100).'</td><td><a  id="mp">Change MP</a></td></tr>';
			echo '<tr><td>SP: </td><td>'.Parser::Zahl((int)$this->item->getSP() * 100).'</td><td><a  id="sp">Change SP</a></td></tr>';
			echo '<tr><td>Lapisa: </td><td>'.(int)$this->item->getLapisa().'</td><td><a  id="lapisa">Change lapisia value</a></td></tr>';
			echo '<tr><td>Slot 1: </td><td>'.$this->infoArr['Lapis1']['Name'].'</td><td>'.$this->infoArr['Lapis1']['Link'].'</td></tr>';
			echo '<tr><td>Slot 2: </td><td>'.$this->infoArr['Lapis2']['Name'].'</td><td>'.$this->infoArr['Lapis2']['Link'].'</td></tr>';
			echo '<tr><td>Slot 3: </td><td>'.$this->infoArr['Lapis3']['Name'].'</td><td>'.$this->infoArr['Lapis3']['Link'].'</td></tr>';
			echo '<tr><td>Slot 4: </td><td>'.$this->infoArr['Lapis4']['Name'].'</td><td>'.$this->infoArr['Lapis4']['Link'].'</td></tr>';
			echo '<tr><td>Slot 5: </td><td>'.$this->infoArr['Lapis5']['Name'].'</td><td>'.$this->infoArr['Lapis5']['Link'].'</td></tr>';
			echo '<tr><td>Slot 6: </td><td>'.$this->infoArr['Lapis6']['Name'].'</td><td>'.$this->infoArr['Lapis6']['Link'].'</td></tr>';
			echo '<tr><td>Delete: </td><td></td><td><a  id="del">Delete Item</a></td></tr>';
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
						Change: function() {
							$("#haltdiaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
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
						Change: function() {
							$("#countdiaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
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
						Change: function() {
							$("#strdiaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
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
						Change: function() {
							$("#dexdiaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
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
						Change: function() {
							$("#recdiaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
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
						Change: function() {
							$("#intdiaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
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
						Change: function() {
							$("#wisdiaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
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
						Change: function() {
							$("#lucdiaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
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
						Change: function() {
							$("#hpdiaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
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
						Change: function() {
							$("#mpdiaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
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
						Change: function() {
							$("#spdiaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
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
						Change: function() {
							$("#lapisadiaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
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
						Yes: function() {
							document.location.href = 'index.php?action=wl&uid=<?php echo BIntString($this->item->getUID());?>&do=unlinklapis&slot=1';
							$(this).dialog('close');
						},
					
						No: function() {
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
						Yes: function() {
							document.location.href = 'index.php?action=wl&uid=<?php echo BIntString($this->item->getUID());?>&do=unlinklapis&slot=2';
							$(this).dialog('close');
						},
					
						No: function() {
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
						Yes: function() {
							document.location.href = 'index.php?action=wl&uid=<?php echo BIntString($this->item->getUID());?>&do=unlinklapis&slot=3';
							$(this).dialog('close');
						},
					
						No: function() {
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
						Yes: function() {
							document.location.href = 'index.php?action=wl&uid=<?php echo BIntString($this->item->getUID());?>&do=unlinklapis&slot=4';
							$(this).dialog('close');
						},
					
						No: function() {
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
						Yes: function() {
							document.location.href = 'index.php?action=wl&uid=<?php echo BIntString($this->item->getUID());?>&do=unlinklapis&slot=5';
							$(this).dialog('close');
						},
					
						No: function() {
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
						Yes: function() {
							document.location.href = 'index.php?action=wl&uid=<?php echo BIntString($this->item->getUID());?>&do=unlinklapis&slot=6';
							$(this).dialog('close');
						},
					
						No: function() {
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
						Link: function() {
							$("#link1diaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
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
						Link: function() {
							$("#link2diaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
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
						Link: function() {
							$("#link3diaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
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
						Link: function() {
							$("#link4diaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
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
						Link: function() {
							$("#link5diaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
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
						Link: function() {
							$("#link6diaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
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
						Yes: function() {
							document.location.href = 'index.php?action=wl&uid=<?php echo BIntString($this->item->getUID());?>&do=delete';
							$(this).dialog('close');
						},
					
						No: function() {
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
			
			<div id="haltdia" title="Durability Change">Please provide de new durability '<?php echo $this->item->getItemName();?>' (Character: <?php echo $this->user->getName();?>, ItemUID: <?php echo BIntString($this->item->getUID());?>) <form action="index.php?action=wl&amp;uid=<?php echo BIntString($this->item->getUID());?>&amp;do=halt" method="POST" id="haltdiaform"><br><input type="text" name="halt" maxlength=4 size=4></form></div>
			<div id="countdia" title="Count Change">Please provide the new count for '<?php echo $this->item->getItemName();?>' (Character: <?php echo $this->user->getName();?>, ItemUID: <?php echo BIntString($this->item->getUID());?>) <form action="index.php?action=wl&amp;uid=<?php echo BIntString($this->item->getUID());?>&amp;do=count" method="POST" id=""><br><input type="text" name="count" maxlength=4 size=4></form></div>
			<div id="strdia" title="Str Change">Please provide the new STR for '<?php echo $this->item->getItemName();?>' (Character: <?php echo $this->user->getName();?>, ItemUID: <?php echo BIntString($this->item->getUID());?>) <form action="index.php?action=wl&amp;uid=<?php echo BIntString($this->item->getUID());?>&amp;do=craft&amp;stat=Str" method="POST" id="strdiaform"><br><input type="text" name="stat" maxlength=2 size=2></form></div>
			<div id="dexdia" title="Dex Change">Please provide the new DEX for '<?php echo $this->item->getItemName();?>' (Character: <?php echo $this->user->getName();?>, ItemUID: <?php echo BIntString($this->item->getUID());?>) <form action="index.php?action=wl&amp;uid=<?php echo BIntString($this->item->getUID());?>&amp;do=craft&amp;stat=Dex" method="POST" id="dexdiaform"><br><input type="text" name="stat" maxlength=2 size=2></form></div>
			<div id="recdia" title="Rec Change">Please provide the new REC for '<?php echo $this->item->getItemName();?>' (Character: <?php echo $this->user->getName();?>, ItemUID: <?php echo BIntString($this->item->getUID());?>) <form action="index.php?action=wl&amp;uid=<?php echo BIntString($this->item->getUID());?>&amp;do=craft&amp;stat=Rec" method="POST" id="recdiaform"><br><input type="text" name="stat" maxlength=2 size=2></form></div>
			<div id="intdia" title="Int Change">Pleace provide the new INT for '<?php echo $this->item->getItemName();?>' (Character: <?php echo $this->user->getName();?>, ItemUID: <?php echo BIntString($this->item->getUID());?>) <form action="index.php?action=wl&amp;uid=<?php echo BIntString($this->item->getUID());?>&amp;do=craft&amp;stat=Int" method="POST" id="intdiaform"><br><input type="text" name="stat" maxlength=2 size=2></form></div>
			<div id="wisdia" title="Wis Change">Please provide the new WIS for '<?php echo $this->item->getItemName();?>' (Character: <?php echo $this->user->getName();?>, ItemUID: <?php echo BIntString($this->item->getUID());?>) <form action="index.php?action=wl&amp;uid=<?php echo BIntString($this->item->getUID());?>&amp;do=craft&amp;stat=Wis" method="POST" id="wisdiaform"><br><input type="text" name="stat" maxlength=2 size=2></form></div>
			<div id="lucdia" title="Luc Change">Please provide the new LUC for '<?php echo $this->item->getItemName();?>' (Character: <?php echo $this->user->getName();?>, ItemUID: <?php echo BIntString($this->item->getUID());?>) <form action="index.php?action=wl&amp;uid=<?php echo BIntString($this->item->getUID());?>&amp;do=craft&amp;stat=Luc" method="POST"id="lucdiaform"><br><input type="text" name="stat" maxlength=2 size=2></form></div>
			<div id="hpdia" title="LP Change">Please provide the new HP for '<?php echo $this->item->getItemName();?>' (Character: <?php echo $this->user->getName();?>, ItemUID: <?php echo BIntString($this->item->getUID());?>) <form action="index.php?action=wl&amp;uid=<?php echo BIntString($this->item->getUID());?>&amp;do=craft&amp;stat=HP" method="POST" id="hpdiaform"><br><input type="text" name="stat" maxlength=2 size=4>00</form></div>
			<div id="mpdia" title="MP Change">Please provide the new MP for '<?php echo $this->item->getItemName();?>' (Character: <?php echo $this->user->getName();?>, ItemUID: <?php echo BIntString($this->item->getUID());?>) <form action="index.php?action=wl&amp;uid=<?php echo BIntString($this->item->getUID());?>&amp;do=craft&amp;stat=MP" method="POST" id="mpdiaform"><br><input type="text" name="stat" maxlength=2 size=4>00</form></div>
			<div id="spdia" title="SP Change">Please provide the new SP for '<?php echo $this->item->getItemName();?>' (Character: <?php echo $this->user->getName();?>, ItemUID: <?php echo BIntString($this->item->getUID());?>) <form action="index.php?action=wl&amp;uid=<?php echo BIntString($this->item->getUID());?>&amp;do=craft&amp;stat=SP" method="POST" id="spdiaform"><br><input type="text" name="stat" maxlength=2 size=4>00</form></div>
			<div id="lapisadia" title="Lapisia">Please provide the new lapisia value for '<?php echo $this->item->getItemName();?>' (Character: <?php echo $this->user->getName();?>, ItemUID: <?php echo BIntString($this->item->getUID());?>) <form action="index.php?action=wl&amp;uid=<?php echo BIntString($this->item->getUID());?>&amp;do=craft&amp;stat=Lapisa" method="POST" id="lapisadiaform"><br><input type="text" name="stat" maxlength=2 size=4><br>0-20 for weapons<br>50-70 for armors</form></div>
			<div id="deldia" title="Item Delete">Do you want to delete this item '<?php echo $this->item->getItemName();?>' (Character: <?php echo $this->user->getName();?>, ItemUID: <?php echo BIntString($this->item->getUID());?>)?</div>
			
			
			<?php
			echo $this->infoArr['LapisDia'];
		}
	}
}

?>