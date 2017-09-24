<?php

/**
 * @author		Trayne & eQuiNox
 * @copyright	2011 - 2017 Shaiya Productions
**/

Class charAction{
	private $gm;
	private $top;
	private $deleted;
	private $char;
	private $user;
	private $info;
	private $gilde;
	private $error;
	private $items;
	
	public function __construct($gm){
		$this->gm = $gm;
	}
	
	public function execute(){
		if (!isset($_GET['CharID']) && !isset($_POST['Suche'])){
			if (isset($_GET['top'])){
				if (Parser::gint($_GET['top']))
					$this->top = Top::Chars($_GET['top']);
				else
					$this->top = Top::Chars(5000);
			}
			else
				$this->top = Top::Chars(5000);
		
			//HTML
			echo '<center>';
			echo '<h2>Character Management</h2>';
			echo '<br>';
			echo '<form action="index.php?action=char" method="POST">';
			echo '<input type="text" name="Suche" maxlength=18>';
			echo '<input type="submit" name="submit" value="Search" style="display: inline">';
			echo '</form>';
			echo '<br>';
			echo '<table>';
			echo '<tr>';
			echo '<th>CharID</th><th>UserUID</th><th>CharName</th><th>UserID</th><th>deleted</th><th>Level</th><th>Classe</th><th>Map</th><th>Kills</th><th>Death</th>';
			echo '</tr>';
				if(!empty($this->top)){
			foreach($this->top as $this->value){
				if ($this->value['Del'])
					$this->deleted = 'Yes';
				else
					$this->deleted = 'No';
				
				$this->user = new user($this->value['UserUID']);
				$this->char = new char($this->value['CharID']);
				
				echo '<tr>';
				echo '<td>'.Parser::Zahl($this->value['CharID']).'</td>';
				echo '<td>'.Parser::Zahl($this->value['UserUID']).'</td>';
				echo '<td><a href="index.php?action=char&amp;CharID='.$this->value['CharID'].'">'.$this->value['CharName'].'</a></td>';
				echo '<td><a href="index.php?action=user&amp;UserUID='.$this->value['UserUID'].'">'.$this->user->getName().'</a></td>';
				echo '<td>'.$this->deleted.'</td>';
				echo '<td>'.$this->value['Level'].'</td>';
				echo '<td>'.$this->char->getClassName().'</td>';
				echo '<td>'.Map::get($this->value['Map']).'</td>';
				echo '<td>'.Parser::Zahl($this->value['k1']).'</td>';
				echo '<td>'.Parser::Zahl($this->value['k2']).'</td>';
				echo '</tr>';
			}}
			
			//HTML
			echo '</table>';
			echo '</center>';
		} else if (isset($_POST['Suche'])){
			$this->top = Search::Chars($_POST['Suche']);
			
			//HTML
			echo '<center>';
			echo '<h2>Character Management</h2>';
			echo '<br>';
			echo '<form action="index.php?action=char" method="POST">';
			echo '<input type="text" name="Suche" maxlength=18>';
			echo '<input type="submit" name="submit" value="Search" style="display: inline">';
			echo '</form>';
			echo '<br>';
			echo '<table>';
			echo '<tr>';
			echo '<th>CharID</th><th>UserUID</th><th>CharName</th><th>UserID</th><th>deleted</th><th>Level</th><th>Classe</th><th>Map</th><th>Kills</th><th>Death</th>';
			echo '</tr>';
			
			if ($this->top == false)
				echo '</table>The search returned no results.</center>';
			else {
				foreach($this->top as $this->value){
					if ($this->value['Del'])
						$this->deleted = 'Yes';
					else
						$this->deleted = 'No';
					
					$this->user = new user($this->value['UserUID']);
					$this->char = new char($this->value['CharID']);
					
					echo '<tr>';
					echo '<td>'.Parser::Zahl($this->value['CharID']).'</td>';
					echo '<td>'.Parser::Zahl($this->value['UserUID']).'</td>';
					echo '<td><a href="index.php?action=char&amp;CharID='.$this->value['CharID'].'">'.$this->value['CharName'].'</a></td>';
					echo '<td><a href="index.php?action=user&amp;UserUID='.$this->value['UserUID'].'">'.$this->user->getName().'</a></td>';
					echo '<td>'.$this->deleted.'</td>';
					echo '<td>'.$this->value['Level'].'</td>';
					echo '<td>'.$this->char->getClassName().'</td>';
					echo '<td>'.Map::get($this->value['Map']).'</td>';
					echo '<td>'.Parser::Zahl($this->value['k1']).'</td>';
					echo '<td>'.Parser::Zahl($this->value['k2']).'</td>';
					echo '</tr>';
				}
				//HTML
				echo '</table>';
				echo '</center>';
			}
			
		} else if (isset($_GET['CharID'])){
			if (!Parser::gint($_GET['CharID']))
				throw new SystemException('CharID must be an intergrer', 0, 0, __FILE__, __LINE__);
			
			$this->char = new char($_GET['CharID']);
			$this->user = new user($this->char->getUserUID());
			
			if (isset($_GET['do'])){
				switch($_GET['do']){
					case 'name':
						if (isset($_POST['name'])){
							$this->error = $this->char->changeName($_POST['name']);
							if ($this->error == 1)
								echo '<div Class="success">'.$this->user->getName().'s name has been changed successfully.</div>';
							else
								echo '<div Class="error">'.$this->error.'</div>';
						}
						else
								echo '<div Class="error">Please provide a name.</div>';
						break;
					case 'gl':
						$this->char->leaveGuild();
							echo '<div Class="success">'.$this->char->getName().' was successfully removed from his guild.</div>';
						break;
					case 'res':
						$this->error = $this->char->res();
						if ($this->error == 1)
							echo '<div Class="success">'.$this->char->getName().' has been successfully resurrected.</div>';
						else
							echo '<div Class="error">'.$this->error.'</div>';
						break;
					case 'del':
						$this->char->kill();
						echo '<div Class="success">'.$this->char->getName().' was successfully deleted.</div>';
						break;
					case 'ban':
						$this->char->ban();
						echo '<div Class="success">'.$this->char->getName().' (Account: '.$this->user->getName().') was successfully banned.</div>';	
						break;
					case 'unban':
						$this->char->unban();
						echo '<div Class="success">'.$this->char->getName().' (Account: '.$this->user->getName().') was successfully unbanned.</div>';	
						break;
					case 'sex':
						$this->char->changeSex($_GET['sex']);
						echo '<div Class="success">'.$this->user->getName().'s Gender has been changed successfully.</div>';
						break;
					case 'level':
						if (isset($_POST['level'])){
							$this->error = $this->char->changeLevel($_POST['level']);
							if ($this->error == 1)
								echo '<div Class="success">'.$this->user->getName().'s Level has been changed successfully.</div>';
							else
								echo '<div Class="error">'.$this->error.'</div>';
						}
						else
								echo '<div Class="error">Please provide a level.</div>';
						break;
					case 'changeGrow':
						$this->char->changeGrow($_GET['grow']);
							echo '<div Class="success">'.$this->user->getName().'s Mode has been changed successfully.</div>';
						break;
					case 'stat':
						if (isset($_POST['stat'])){
							$this->error = $this->char->changeStat($_POST['stat']);
							if ($this->error == 1)
								echo '<div Class="success">'.$this->user->getName().'s Stats were successfully changed.</div>';
							else
								echo '<div Class="error">'.$this->error.'</div>';
						}
						else
								echo '<div Class="error">Please provide a correct value for statpoints.</div>';
						break;				
					case 'skill':
						if (isset($_POST['skill'])){
							$this->error = $this->char->changeSkill($_POST['skill']);
							if ($this->error == 1)
								echo '<div Class="success">'.$this->user->getName().'s Skillpoints were successfully changed</div>';
							else
								echo '<div Class="error">'.$this->error.'</div>';
						}
						else
								echo '<div Class="error">Please provide a correct value for skillpoints.</div>';
						break;
					case 'kill':
						if (isset($_POST['kill'])){
							$this->error = $this->char->changeKill($_POST['kill']);
							if ($this->error == 1)
								echo '<div Class="success">'.$this->user->getName().'s Kills were successfully changed.</div>';
							else
								echo '<div Class="error">'.$this->error.'</div>';
						}
						else
								echo '<div Class="error">Please provide a correct value for kills.</div>';
						break;
					case 'tod':
						if (isset($_POST['tod'])){
							$this->error = $this->char->changeTod($_POST['tod']);
							if ($this->error == 1)
								echo '<div Class="success">'.$this->user->getName().'s Deaths were successfully changed.</div>';
							else
								echo '<div Class="error">'.$this->error.'</div>';
						}
						else
								echo '<div Class="error">Please provide a correct value for deaths.</div>';
						break;
					case 'dkill':
						if (isset($_POST['dkill'])){
							$this->error = $this->char->changeDKill($_POST['dkill']);
							if ($this->error == 1)
								echo '<div Class="success">'.$this->user->getName().'s Duell-Kills were successfully changed..</div>';
							else
								echo '<div Class="error">'.$this->error.'</div>';
						}
						else
								echo '<div Class="error">Please provide a correct value for Duel-Kills.</div>';
						break;
					case 'dtod':
						if (isset($_POST['dtod'])){
							$this->error = $this->char->changeDTod($_POST['dtod']);
							if ($this->error == 1)
								echo '<div Class="success">'.$this->user->getName().'s Duel-Deaths were successfully changed..</div>';
							else
								echo '<div Class="error">'.$this->error.'</div>';
						}
						else
								echo '<div Class="error">Please provide a correct value for Duel-Deaths.</div>';
						break;	
				}
				$this->char = new char($_GET['CharID']);
				$this->user = new user($this->char->getUserUID());
			}
			
			if ($this->char->getGuild()){
				$this->gilde 			= new guild($this->char->getGuild());
				$this->info['Gilde']	= $this->gilde->getName();
			} else
				$this->info['Gilde']	= 'No';
			
			if ($this->char->getDel()){
				$this->info['Deleted'] = 'Yes';
				$this->info['DelLink'] = '<a href="javascript::void();" id="res">Res</a>';
			} else {
				$this->info['Deleted'] = 'No';
				$this->info['DelLink'] = '<a href="javascript::void();" id="del">Delete</a>';
			}
			
			if ($this->user->isBanned()){
				$this->info['Banned'] = 'Yes';
				$this->info['BanLnk'] = '<a href="javascript::void();" id="unban">Unban</a>';
			} else {
				$this->info['Banned'] = 'No';
				$this->info['BanLnk'] = '<a href="javascript::void();" id="ban">Ban</a>';
				
			}
			
			if ($this->char->getSex() == 0)
				$this->info['Geschlecht'] = 'Man';
			else
				$this->info['Geschlecht'] = 'Woman';
			
			if ($this->char->getLoginStatus())
				$this->info['Login'] = 'Yes';
			else
				$this->info['Login'] = 'No';
						
			echo '<table>';
			echo '<tr><td>CharID: </td><td>'.Parser::Zahl($this->char->getCharID()).'</td><td></td></tr>';
			echo '<tr><td>UserUID: </td><td>'.Parser::Zahl($this->char->getUserUID()).'</td><td></td></tr>';
			echo '<tr><td>Character: </td><td>'.$this->char->getName().'</td><td><a href="javascript::void();" id="name">Change name</a></td></tr>';
			echo '<tr><td>Account: </td><td><a href="index.php?action=user&amp;UserUID='.$this->char->getUserUID().'">'.$this->user->getName().'</a></td><td></td></tr><tr><td>Gild: </td><td>';
			if ($this->char->getGuild())
				echo '<a href="index.php?action=guild&amp;GuildID='.$this->char->getGuild().'">'.$this->info['Gilde'].'</a></td><td><a href="javascript::void();" id="gl">Remove from Guild</a></td>';
			else
				echo $this->info['Gilde'].'</td><td></td>';;
			echo '</tr><tr><td>Deleted: </td><td>'.$this->info['Deleted'].'</td><td>'.$this->info['DelLink'].'</td></tr>';
			echo '<tr><td>Banned: </td><td>'.$this->info['Banned'].'</td><td>'.$this->info['BanLnk'].'</td></tr>';
			echo '<tr><td>Level: </td><td>'.$this->char->getLevel().'</td><td><a href="javascript::void();" id="level">Change level</a></td></tr>';
			echo '<tr><td>Classe: </td><td>'.$this->char->getClassName().'</td><td></td></tr>';
			echo '<tr><td>Mode: </td><td>'.$this->char->getModeName().'</td><td><a href="javascript::void();" id="grow">Change mode</a></td></tr>';
			echo '<tr><td>Race: </td><td>'.$this->char->getRaceName().'</td><td></td></tr>';
			echo '<tr><td>Gender: </td><td>'.$this->info['Geschlecht'].'</td><td><a href="javascript::void();" id="sex">Change gender</a></td></tr>';
			echo '<tr><td>Statpoints: </td><td>'.$this->char->getStatPoint().'</td><td><a href="javascript::void();" id="stat">Change statpoints</a></td></tr>';
			echo '<tr><td>Skillpoints: </td><td>'.$this->char->getSkillPoint().'</td><td><a href="javascript::void();" id="skill">Change skillpoints</a></td></tr>';
			echo '<tr><td>Map: </td><td>'.Map::get($this->char->getMap()).'</td><td></td></tr>';
			echo '<tr><td>PosX: </td><td>'.Parser::zahl($this->char->getPosX()).'</td><td></td></tr>';
			echo '<tr><td>PosY: </td><td>'.Parser::zahl($this->char->getPosY()).'</td><td></td></tr>';
			echo '<tr><td>PosZ: </td><td>'.Parser::zahl($this->char->getPosZ()).'</td><td></td></tr>';
			echo '<tr><td>Kills: </td><td>'.Parser::Zahl($this->char->getKills()).'</td><td><a href="javascript::void();" id="kill">Change kills</a></td></tr>';
			echo '<tr><td>Deaths: </td><td>'.Parser::Zahl($this->char->getTode()).'</td><td><a href="javascript::void();" id="tod">Change Deaths</a></td></tr>';
			echo '<tr><td>KDR: </td><td>'.Parser::divi($this->char->getKills(), $this->char->getTode()).'</td><td></td></tr>';
			echo '<tr><td>Duel Kills: </td><td>'.Parser::Zahl($this->char->getDKills()).'</td><td><a href="javascript::void();" id="dkill">Change Duel Kills</a></td></tr>';
			echo '<tr><td>Duel Deaths: </td><td>'.Parser::Zahl($this->char->getDTode()).'</td><td><a href="javascript::void();" id="dtod">Change Duel Deaths</a></td></tr>';
			echo '<tr><td>Duel KDR: </td><td>'.Parser::divi($this->char->getDKills(), $this->char->getDTode()).'</td><td></td></tr>';
			echo '<tr><td>Logged: </td><td>'.$this->info['Login'].'</td><td></td></tr>';
			echo '<tr><td>Lastest Login: </td><td>'.Parser::Datum($this->char->getLastLogin()).'</td><td></td></tr>';
			echo '<tr><td>Lastest Logout: </td><td>'.Parser::Datum($this->char->getLastLogout()).'</td><td></td></tr>';
			echo '<tr><td>Last login time: </td><td>'.Parser::Zeitspanne($this->char->getLastLoginTime()).'</td><td></td></tr>';
			echo '<tr><td>IP Adress: </td><td><a href="index.php?action=ip&amp;ip='.$this->user->getIp().'">'.$this->user->getIp().'</a></td><td></td></tr>';
			echo '<tr><td>AP: </td><td>'.Parser::Zahl($this->user->getPoint()).'</td><td></td></tr>';
			echo '</table>';
			
			$this->items = $this->char->leseCI();
			
			echo '<br><br><br>Inventory:<table>';
			echo '<tr>';
			echo '<th>ItemID</th><th>Name</th><th>Level</th><th>backpack</th><th>Space</th><th>Slots</th><th>Durability</th><th>Obtain</th>';
			echo '</tr>';
			foreach($this->items as $this->value){
				if ($this->value['Bag'] == 0)
					$this->value['Bag'] = 'wearing';
				
				$this->value['ToolTip'] = '';
				
				if ($this->value['Lapis1'] != 0){
					$this->value['TempLapis']	= new lapis($this->value['Lapis1']);
					$this->value['ToolTip'] 	.= 'Slot 1: '.$this->value['TempLapis']->getName().'<br>';
				}
				
				if ($this->value['Lapis2'] != 0){
					$this->value['TempLapis']	= new lapis($this->value['Lapis2']);
					$this->value['ToolTip'] 	.= 'Slot 2: '.$this->value['TempLapis']->getName().'<br>';
				}
				
				if ($this->value['Lapis3'] != 0){
					$this->value['TempLapis']	= new lapis($this->value['Lapis3']);
					$this->value['ToolTip'] 	.= 'Slot 3: '.$this->value['TempLapis']->getName().'<br>';
				}
				
				if ($this->value['Lapis4'] != 0){
					$this->value['TempLapis']	= new lapis($this->value['Lapis4']);
					$this->value['ToolTip'] 	.= 'Slot 4: '.$this->value['TempLapis']->getName().'<br>';
				}
				
				if ($this->value['Lapis5'] != 0){
					$this->value['TempLapis']	= new lapis($this->value['Lapis5']);
					$this->value['ToolTip'] 	.= 'Slot 5: '.$this->value['TempLapis']->getName().'<br>';
				}
				
				if ($this->value['Lapis6'] != 0){
					$this->value['TempLapis']	= new lapis($this->value['Lapis6']);
					$this->value['ToolTip'] 	.= 'Slot 6: '.$this->value['TempLapis']->getName().'<br>';
				}
				
				echo '<tr>';
				echo '<td>'.$this->value['ItemID'].'</td>';
				echo '<td><a href="index.php?action=inv&uid='.$this->value['ItemUID'].'" Class="tooltip" title="'.$this->value['ToolTip'].'">'.$this->value['ItemName'].'</a></td>';
				echo '<td>'.$this->value['ReqLevel'].'</td>';
				echo '<td>'.$this->value['Bag'].'</td>';
				echo '<td>'.$this->value['Slot'].'</td>';
				echo '<td>'.$this->value['MaxSlot'].'</td>';
				echo '<td>'.$this->value['MaxQuality'].'</td>';
				echo '<td>'.Parser::Datum($this->value['MakeTime']).'</td>';
				echo '</tr>';
			}			
			echo '</table>';
			
			?>
			<script>
		$(function() {
				$("#namedia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					modal: true,
					buttons: {
						Change: function() {
							$("#namediaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
							$(this).dialog('close');
						}
					}
				});
				$("#gldia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					modal: true,
					buttons: {
						Yes: function() {
							document.location.href = 'index.php?action=char&CharID=<?php echo $this->char->getCharID();?>&do=gl';
							$(this).dialog('close');
						},
					
						No: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#deldia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					modal: true,
					buttons: {
						Yes: function() {
							document.location.href = 'index.php?action=char&CharID=<?php echo $this->char->getCharID();?>&do=del';
							$(this).dialog('close');
						},
					
						No: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#resdia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					modal: true,
					buttons: {
						Yes: function() {
							document.location.href = 'index.php?action=char&CharID=<?php echo $this->char->getCharID();?>&do=res';
							$(this).dialog('close');
						},
					
						No: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#bandia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					modal: true,
					buttons: {
						Yes: function() {
							document.location.href = 'index.php?action=char&CharID=<?php echo $this->char->getCharID();?>&do=ban';
							$(this).dialog('close');
						},
					
						No: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#unbandia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					modal: true,
					buttons: {
						Yes: function() {
							document.location.href = 'index.php?action=char&CharID=<?php echo $this->char->getCharID();?>&do=unban';
							$(this).dialog('close');
						},
					
						No: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#leveldia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					modal: true,
					buttons: {
						Change: function() {
							$("#leveldiaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#sexdia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					modal: true,
					buttons: {
						Man: function() {
							document.location.href = 'index.php?action=char&CharID=<?php echo $this->char->getCharID();?>&do=sex&sex=0';
							$(this).dialog('close');
						},
						
						Woman: function() {
							document.location.href = 'index.php?action=char&CharID=<?php echo $this->char->getCharID();?>&do=sex&sex=1';
							$(this).dialog('close');
						},
						
						Cancel: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#growdia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					width: 400,
					modal: true,
					buttons: {
						Ultimate: function() {
							document.location.href = 'index.php?action=char&CharID=<?php echo $this->char->getCharID();?>&do=changeGrow&grow=3';
							$(this).dialog('close');
						},
						
						Hard: function() {
							document.location.href = 'index.php?action=char&CharID=<?php echo $this->char->getCharID();?>&do=changeGrow&grow=2';
							$(this).dialog('close');
						},
						
						Normal: function() {
							document.location.href = 'index.php?action=char&CharID=<?php echo $this->char->getCharID();?>&do=changeGrow&grow=1';
							$(this).dialog('close');
						},
						
						Easy: function() {
							document.location.href = 'index.php?action=char&CharID=<?php echo $this->char->getCharID();?>&do=changeGrow&grow=0';
							$(this).dialog('close');
						},
						
						Cancel: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#statdia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					modal: true,
					buttons: {
						Change: function() {
							$("#statdiaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#skilldia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					modal: true,
					buttons: {
						Change: function() {
							$("#skilldiaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#killdia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					modal: true,
					buttons: {
						Change: function() {
							$("#killdiaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#toddia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					modal: true,
					buttons: {
						Change: function() {
							$("#toddiaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#dkilldia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					modal: true,
					buttons: {
						Change: function() {
							$("#dkilldiaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#dtoddia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					modal: true,
					buttons: {
						Change: function() {
							$("#dtoddiaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$('#name').click(function() {
					$('#namedia').dialog('open');
				});
				
				$('#gl').click(function() {
					$('#gldia').dialog('open');
				});
				
				$('#del').click(function() {
					$('#deldia').dialog('open');
				});
				
				$('#res').click(function() {
					$('#resdia').dialog('open');
				});
				
				$('#ban').click(function() {
					$('#bandia').dialog('open');
				});
				
				$('#unban').click(function() {
					$('#unbandia').dialog('open');
				});
				
				$('#level').click(function() {
					$('#leveldia').dialog('open');
				});
				
				$('#grow').click(function() {
					$('#growdia').dialog('open');
				});
				
				$('#sex').click(function() {
					$('#sexdia').dialog('open');
				});
				
				$('#stat').click(function() {
					$('#statdia').dialog('open');
				});
				
				$('#skill').click(function() {
					$('#skilldia').dialog('open');
				});
				
				$('#kill').click(function() {
					$('#killdia').dialog('open');
				});
				
				$('#tod').click(function() {
					$('#toddia').dialog('open');
				});
				
				$('#dkill').click(function() {
					$('#dkilldia').dialog('open');
				});
				
				$('#dtod').click(function() {
					$('#dtoddia').dialog('open');
				});				
			});
			

			
			</script>
			<div id="namedia" title="Name Change">Please provide the new name for '<?php echo $this->char->getName();?>' <form action="index.php?action=char&amp;CharID=<?php echo $this->char->getCharID();?>&amp;do=name" method="POST" id="namediaform"><br><input type="text" name="name" maxlength=18 size=18></form></div>
			<div id="gldia" title="Aus Gilde entfernen">Do you want '<?php echo $this->char->getName();?>' to leave his guild '<?php echo $this->info['Gilde'];?>'?</div>
			<div id="deldia" title="Charakter l�schen">Do you want to delete '<?php echo $this->char->getName();?>'?</div>
			<div id="resdia" title="Charakter wiederbeleben">Do you want to res '<?php echo $this->char->getName();?>'?</div>
			<div id="bandia" title="Benutzer Bannen">Do you want to ban '<?php echo $this->char->getName();?>' (Account: <?php echo $this->user->getName();?>)?</div>
			<div id="unbandia" title="Benutzer Entbannen">Do you want to unban'<?php echo $this->char->getName();?>' (Account: <?php echo $this->user->getName();?>)?</div>
			<div id="leveldia" title="Level Change">Please put the new level of '<?php echo $this->char->getName();?>' <form action="index.php?action=char&amp;CharID=<?php echo $this->char->getCharID();?>&amp;do=level" method="POST" id="leveldiaform"><br><input type="text" name="level" maxlength=3 size=3></form><br>Stats and Skillpoints will not change.</div>
			<div id="sexdia" title="Geschlecht Change">Select the new sex for '<?php echo $this->char->getName();?>'.</div>
			<div id="statdia" title="StatusPoints Change">Please provide the statpoints for '<?php echo $this->char->getName();?>' <form action="index.php?action=char&amp;CharID=<?php echo $this->char->getCharID();?>&amp;do=stat" method="POST" id="statdiaform"><br><input type="text" name="stat" maxlength=4 size=4></form></div>
			<div id="skilldia" title="StatusPoints Change">Please provide the skillspoints for '<?php echo $this->char->getName();?>' <form action="index.php?action=char&amp;CharID=<?php echo $this->char->getCharID();?>&amp;do=skill" method="POST" id="skilldiaform"><br><input type="text" name="skill" maxlength=4 size=4></form></div>
			<div id="killdia" title="Kills Change">Please provide new Kills for '<?php echo $this->char->getName();?>' <form action="index.php?action=char&amp;CharID=<?php echo $this->char->getCharID();?>&amp;do=kill" method="POST" id="killdiaform"><br><input type="text" name="kill" maxlength=6 size=6></form></div>
			<div id="toddia" title="Tode Change">Please provide new Deaths for '<?php echo $this->char->getName();?>' <form action="index.php?action=char&amp;CharID=<?php echo $this->char->getCharID();?>&amp;do=tod" method="POST" id="toddiaform"><br><input type="text" name="tod" maxlength=6 size=6></form></div>
			<div id="dkilldia" title="Duell-Kills Change">Please provide new Duel Kills for '<?php echo $this->char->getName();?>' <form action="index.php?action=char&amp;CharID=<?php echo $this->char->getCharID();?>&amp;do=dkill" method="POST" id="dkilldiaform"><br><input type="text" name="dkill" maxlength=6 size=6></form></div>
			<div id="dtoddia" title="Duell-Tode Change">Please provide new Duel Deaths for '<?php echo $this->char->getName();?>' <form action="index.php?action=char&amp;CharID=<?php echo $this->char->getCharID();?>&amp;do=dtod" method="POST" id="dtoddiaform"><br><input type="text" name="dtod" maxlength=6 size=6></form></div>
			<div id="growdia" title="Modus Change">Select the new mode for '<?php echo $this->char->getName();?>'<br><br>Stats and skillpoints will not change.</div>
			
			
			
			<?php
		}
	}
}

?>