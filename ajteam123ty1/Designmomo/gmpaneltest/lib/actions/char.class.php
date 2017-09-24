<?php

/**
 * @author		Momo
 * @copyright	2014 Jamiro Productions
**/

class charAction{
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
			echo '<h2>Gestionnaire de personnages</h2>';
			echo '<br>';
			echo '<form action="index.php?action=char" method="POST">';
			echo '<input type="text" name="Suche" maxlength=18>';
			echo '<input type="submit" name="submit" value="Suchen" style="display: inline">';
			echo '</form>';
			echo '<br>';
			echo '<table>';
			echo '<tr>';
			echo '<th>CharID</th><th>UserUID</th><th>CharName</th><th>UserID</th><th>Deleted</th><th>Level</th><th>Classe</th><th>Map</th><th>Kills</th><th>Mort</th>';
			echo '</tr>';
			
			foreach($this->top as $this->value){
				if ($this->value['Del'])
					$this->deleted = 'Oui';
				else
					$this->deleted = 'Non';
				
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
		} else if (isset($_POST['Suche'])){
			$this->top = Search::Chars($_POST['Suche']);
			
			//HTML
			echo '<center>';
			echo '<h2>Gestionnaire de Personnages</h2>';
			echo '<br>';
			echo '<form action="index.php?action=char" method="POST">';
			echo '<input type="text" name="Suche" maxlength=18>';
			echo '<input type="submit" name="submit" value="Suchen" style="display: inline">';
			echo '</form>';
			echo '<br>';
			echo '<table>';
			echo '<tr>';
			echo '<th>CharID</th><th>UserUID</th><th>CharName</th><th>UserID</th><th>Annulé</th><th>Level</th><th>Classe</th><th>Map</th><th>Kills</th><th>Mort</th>';
			echo '</tr>';
			
			if ($this->top == false)
				echo '</table>La recherche n a donné aucun résultat.</center>';
			else {
				foreach($this->top as $this->value){
					if ($this->value['Del'])
						$this->deleted = 'Oui';
					else
						$this->deleted = 'Non';
					
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
				throw new SystemException('CharID doit être de type entier', 0, 0, __FILE__, __LINE__);
			
			$this->char = new char($_GET['CharID']);
			$this->user = new user($this->char->getUserUID());
			
			if (isset($_GET['do'])){
				switch($_GET['do']){
					case 'name':
						if (isset($_POST['name'])){
							$this->error = $this->char->changeName($_POST['name']);
							if ($this->error == 1)
								echo '<div class="success">'.$this->user->getName().'nom de s a été modifié avec succès.</div>';
							else
								echo '<div class="error">'.$this->error.'</div>';
						}
						else
								echo '<div class="error">Entrez le nom.</div>';
						break;
					case 'gl':
						$this->char->leaveGuild();
							echo '<div class="success">'.$this->char->getName().' a été supprimé de sa guilde.</div>';
						break;
					case 'res':
						$this->error = $this->char->res();
						if ($this->error == 1)
							echo '<div class="success">'.$this->char->getName().' a été réanimé avec succès.</div>';
						else
							echo '<div class="error">'.$this->error.'</div>';
						break;
					case 'del':
						$this->char->kill();
						echo '<div class="success">'.$this->char->getName().' a été supprimé avec succès.</div>';
						break;
					case 'ban':
						$this->char->ban();
						echo '<div class="success">'.$this->char->getName().' (Account: '.$this->user->getName().') est banni avec succès.</div>';	
						break;
					case 'unban':
						$this->char->unban();
						echo '<div class="success">'.$this->char->getName().' (Account: '.$this->user->getName().') a été débanni succès.</div>';	
						break;
					case 'sex':
						$this->char->changeSex($_GET['sex']);
						echo '<div class="success">'.$this->user->getName().'s entre les sexes a été modifié avec succès.</div>';
						break;
					case 'level':
						if (isset($_POST['level'])){
							$this->error = $this->char->changeLevel($_POST['level']);
							if ($this->error == 1)
								echo '<div class="success">'.$this->user->getName().'s niveau a été modifié avec succès.</div>';
							else
								echo '<div class="error">'.$this->error.'</div>';
						}
						else
								echo '<div class="error">Entrez niveau.</div>';
						break;
					case 'changeGrow':
						$this->char->changeGrow($_GET['grow']);
							echo '<div class="success">'.$this->user->getName().'mode de s a été modifié avec succès.</div>';
						break;
					case 'stat':
						if (isset($_POST['stat'])){
							$this->error = $this->char->changeStat($_POST['stat']);
							if ($this->error == 1)
								echo '<div class="success">'.$this->user->getName().'des points de statut ont été modifiées avec succès.</div>';
							else
								echo '<div class="error">'.$this->error.'</div>';
						}
						else
								echo '<div class="error">Entrez points de statut.</div>';
						break;				
					case 'skill':
						if (isset($_POST['skill'])){
							$this->error = $this->char->changeSkill($_POST['skill']);
							if ($this->error == 1)
								echo '<div class="success">'.$this->user->getName().'des points de compétences ont été modifiées avec succès.</div>';
							else
								echo '<div class="error">'.$this->error.'</div>';
						}
						else
								echo '<div class="error">Entrez points de compétence.</div>';
						break;
					case 'kill':
						if (isset($_POST['kill'])){
							$this->error = $this->char->changeKill($_POST['kill']);
							if ($this->error == 1)
								echo '<div class="success">'.$this->user->getName().'s Kills modifiée avec succès.</div>';
							else
								echo '<div class="error">'.$this->error.'</div>';
						}
						else
								echo '<div class="error">S il vous plaît entrer Kills.</div>';
						break;
					case 'tod':
						if (isset($_POST['tod'])){
							$this->error = $this->char->changeTod($_POST['tod']);
							if ($this->error == 1)
								echo '<div class="success">'.$this->user->getName().'s la mort ont été modifiées avec succès.</div>';
							else
								echo '<div class="error">'.$this->error.'</div>';
						}
						else
								echo '<div class="error">Entrez mort.</div>';
						break;
					case 'dkill':
						if (isset($_POST['dkill'])){
							$this->error = $this->char->changeDKill($_POST['dkill']);
							if ($this->error == 1)
								echo '<div class="success">'.$this->user->getName().'s Duell-Kills a été modifié avec succès.</div>';
							else
								echo '<div class="error">'.$this->error.'</div>';
						}
						else
								echo '<div class="error">Entrez nombre Duell-Kills .</div>';
						break;
					case 'dtod':
						if (isset($_POST['dtod'])){
							$this->error = $this->char->changeDTod($_POST['dtod']);
							if ($this->error == 1)
								echo '<div class="success">'.$this->user->getName().'s Duell-Mort a été modifié avec succès.</div>';
							else
								echo '<div class="error">'.$this->error.'</div>';
						}
						else
								echo '<div class="error">Entrez Duell-Mort.</div>';
						break;	
				}
				$this->char = new char($_GET['CharID']);
				$this->user = new user($this->char->getUserUID());
			}
			
			if ($this->char->getGuild()){
				$this->gilde 			= new guild($this->char->getGuild());
				$this->info['Gilde']	= $this->gilde->getName();
			} else
				$this->info['Gilde']	= 'Aucun';
			
			if ($this->char->getDel()){
				$this->info['Deleted'] = 'Oui';
				$this->info['DelLink'] = '<a href="javascript::void();" id="res">Redonez vie</a>';
			} else {
				$this->info['Deleted'] = 'Non';
				$this->info['DelLink'] = '<a href="javascript::void();" id="del">Supprimer</a>';
			}
			
			if ($this->user->isBanned()){
				$this->info['Banned'] = 'Oui';
				$this->info['BanLnk'] = '<a href="javascript::void();" id="unban">débannir</a>';
			} else {
				$this->info['Banned'] = 'Non';
				$this->info['BanLnk'] = '<a href="javascript::void();" id="ban">Bannir</a>';
				
			}
			
			if ($this->char->getSex() == 0)
				$this->info['Geschlecht'] = 'mâle';
			else
				$this->info['Geschlecht'] = 'femelle';
			
			if ($this->char->getLoginStatus())
				$this->info['Login'] = 'Oui';
			else
				$this->info['Login'] = 'Non';
						
			echo '<table>';
			echo '<tr><td>CharID: </td><td>'.Parser::Zahl($this->char->getCharID()).'</td><td></td></tr>';
			echo '<tr><td>UserUID: </td><td>'.Parser::Zahl($this->char->getUserUID()).'</td><td></td></tr>';
			echo '<tr><td>Personage: </td><td>'.$this->char->getName().'</td><td><a href="javascript::void();" id="name">changer le nom</a></td></tr>';
			echo '<tr><td>Account: </td><td><a href="index.php?action=user&amp;UserUID='.$this->char->getUserUID().'">'.$this->user->getName().'</a></td><td></td></tr><tr><td>Guilde: </td><td>';
			if ($this->char->getGuild())
				echo '<a href="index.php?action=guild&amp;GuildID='.$this->char->getGuild().'">'.$this->info['Gilde'].'</a></td><td><a href="javascript::void();" id="gl">Suprimer de la guilde</a></td>';
			else
				echo $this->info['Gilde'].'</td><td></td>';
			echo '</tr><tr><td>Annulé: </td><td>'.$this->info['Deleted'].'</td><td>'.$this->info['DelLink'].'</td></tr>';
			echo '<tr><td>Banni: </td><td>'.$this->info['Banned'].'</td><td>'.$this->info['BanLnk'].'</td></tr>';
			echo '<tr><td>Level: </td><td>'.$this->char->getLevel().'</td><td><a href="javascript::void();" id="level">Changer Level</a></td></tr>';
			echo '<tr><td>Classe: </td><td>'.$this->char->getClassName().'</td><td></td></tr>';
			echo '<tr><td>Mode: </td><td>'.$this->char->getModeName().'</td><td><a href="javascript::void();" id="grow">Changer Mode</a></td></tr>';
			echo '<tr><td>Race: </td><td>'.$this->char->getRaceName().'</td><td></td></tr>';
			echo '<tr><td>sexe: </td><td>'.$this->info['Geschlecht'].'</td><td><a href="javascript::void();" id="sex">Changer Sexe</a></td></tr>';
			echo '<tr><td>Stat Point: </td><td>'.$this->char->getStatPoint().'</td><td><a href="javascript::void();" id="stat">Changer Stat Point</a></td></tr>';
			echo '<tr><td>Skill Point: </td><td>'.$this->char->getSkillPoint().'</td><td><a href="javascript::void();" id="skill">Changer Skill Point</a></td></tr>';
			echo '<tr><td>Map: </td><td>'.Map::get($this->char->getMap()).'</td><td></td></tr>';
			echo '<tr><td>PosX: </td><td>'.Parser::zahl($this->char->getPosX()).'</td><td></td></tr>';
			echo '<tr><td>PosY: </td><td>'.Parser::zahl($this->char->getPosY()).'</td><td></td></tr>';
			echo '<tr><td>PosZ: </td><td>'.Parser::zahl($this->char->getPosZ()).'</td><td></td></tr>';
			echo '<tr><td>Kills: </td><td>'.Parser::Zahl($this->char->getKills()).'</td><td><a href="javascript::void();" id="kill">Modifier Kills</a></td></tr>';
			echo '<tr><td>Mort: </td><td>'.Parser::Zahl($this->char->getTode()).'</td><td><a href="javascript::void();" id="tod">Modifier mort</a></td></tr>';
			echo '<tr><td>KDR: </td><td>'.Parser::divi($this->char->getKills(), $this->char->getTode()).'</td><td></td></tr>';
			echo '<tr><td>Duel SKill: </td><td>'.Parser::Zahl($this->char->getDKills()).'</td><td><a href="javascript::void();" id="dkill">Changer Duel kill</a></td></tr>';
			echo '<tr><td>Duel Mort: </td><td>'.Parser::Zahl($this->char->getDTode()).'</td><td><a href="javascript::void();" id="dtod">Changer Duel mort</a></td></tr>';
			echo '<tr><td>Duell KDR: </td><td>'.Parser::divi($this->char->getDKills(), $this->char->getDTode()).'</td><td></td></tr>';
			echo '<tr><td>connecté: </td><td>'.$this->info['Login'].'</td><td></td></tr>';
			echo '<tr><td>dernière connexion: </td><td>'.Parser::Datum($this->char->getLastLogin()).'</td><td></td></tr>';
			echo '<tr><td>dernière Déconnexion: </td><td>'.Parser::Datum($this->char->getLastLogout()).'</td><td></td></tr>';
			echo '<tr><td>En ligne: </td><td>'.Parser::Zeitspanne($this->char->getLastLoginTime()).'</td><td></td></tr>';
			echo '<tr><td>IP-Adresse: </td><td><a href="index.php?action=ip&amp;ip='.$this->user->getIp().'">'.$this->user->getIp().'</a></td><td></td></tr>';
			echo '<tr><td>AP: </td><td>'.Parser::Zahl($this->user->getPoint()).'</td><td></td></tr>';
			echo '</table>';
			
			$this->items = $this->char->leseCI();
			
			echo '<br><br><br>Inventar:<table>';
			echo '<tr>';
			echo '<th>ItemID</th><th>Name</th><th>Level</th><th>Sac a dos</th><th>emplacement</th><th>Slots</th><th>durabilité</th><th>obtenu le</th>';
			echo '</tr>';
			foreach($this->items as $this->value){
				if ($this->value['Bag'] == 0)
					$this->value['Bag'] = 'Equiper';
				
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
				echo '<td><a href="index.php?action=inv&uid='.$this->value['ItemUID'].'" class="tooltip" title="'.$this->value['ToolTip'].'">'.$this->value['ItemName'].'</a></td>';
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
			<script type="text/javascript">
			 $(function(){
				$("#namedia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					modal: true,
					buttons: {
						Ändern: function() {
							$("#namedia > form").submit();
							$(this).dialog('close');
						},
					
						Abbrechen: function() {
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
						Ja: function() {
							document.location.href = 'index.php?action=char&CharID=<?php echo $this->char->getCharID();?>&do=gl';
							$(this).dialog('close');
						},
					
						Nein: function() {
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
						Ja: function() {
							document.location.href = 'index.php?action=char&CharID=<?php echo $this->char->getCharID();?>&do=del';
							$(this).dialog('close');
						},
					
						Nein: function() {
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
						Ja: function() {
							document.location.href = 'index.php?action=char&CharID=<?php echo $this->char->getCharID();?>&do=res';
							$(this).dialog('close');
						},
					
						Nein: function() {
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
						Ja: function() {
							document.location.href = 'index.php?action=char&CharID=<?php echo $this->char->getCharID();?>&do=ban';
							$(this).dialog('close');
						},
					
						Nein: function() {
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
						Ja: function() {
							document.location.href = 'index.php?action=char&CharID=<?php echo $this->char->getCharID();?>&do=unban';
							$(this).dialog('close');
						},
					
						Nein: function() {
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
						Ändern: function() {
							$("#leveldia > form").submit();
							$(this).dialog('close');
						},
					
						Abbrechen: function() {
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
						Männlich: function() {
							document.location.href = 'index.php?action=char&CharID=<?php echo $this->char->getCharID();?>&do=sex&sex=0';
							$(this).dialog('close');
						},
						
						Weiblich: function() {
							document.location.href = 'index.php?action=char&CharID=<?php echo $this->char->getCharID();?>&do=sex&sex=1';
							$(this).dialog('close');
						},
						
						Abbrechen: function() {
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
						Ultimativ: function() {
							document.location.href = 'index.php?action=char&CharID=<?php echo $this->char->getCharID();?>&do=changeGrow&grow=3';
							$(this).dialog('close');
						},
						
						Hart: function() {
							document.location.href = 'index.php?action=char&CharID=<?php echo $this->char->getCharID();?>&do=changeGrow&grow=2';
							$(this).dialog('close');
						},
						
						Normal: function() {
							document.location.href = 'index.php?action=char&CharID=<?php echo $this->char->getCharID();?>&do=changeGrow&grow=1';
							$(this).dialog('close');
						},
						
						Einfach: function() {
							document.location.href = 'index.php?action=char&CharID=<?php echo $this->char->getCharID();?>&do=changeGrow&grow=0';
							$(this).dialog('close');
						},
						
						Abbrechen: function() {
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
						Ändern: function() {
							$("#statdia > form").submit();
							$(this).dialog('close');
						},
					
						Abbrechen: function() {
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
						Ändern: function() {
							$("#skilldia > form").submit();
							$(this).dialog('close');
						},
					
						Abbrechen: function() {
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
						Ändern: function() {
							$("#killdia > form").submit();
							$(this).dialog('close');
						},
					
						Abbrechen: function() {
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
						Ändern: function() {
							$("#toddia > form").submit();
							$(this).dialog('close');
						},
					
						Abbrechen: function() {
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
						Ändern: function() {
							$("#dkilldia > form").submit();
							$(this).dialog('close');
						},
					
						Abbrechen: function() {
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
						Ändern: function() {
							$("#dtoddia > form").submit();
							$(this).dialog('close');
						},
					
						Abbrechen: function() {
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
				
				$(".tooltip").tipTip({maxWidth: "auto", edgeOffset: 10});
				
			});
			

			
			</script>
			
			<div id="namedia" title="Name ändern">Comment est le nouveau nom de '<?php echo $this->char->getName();?>' lire?<form action="index.php?action=char&amp;CharID=<?php echo $this->char->getCharID();?>&amp;do=name" method="POST"><br><input type="text" name="name" maxlength=18 size=18></form></div>
			<div id="gldia" title="Aus Gilde entfernen">voulez-vous '<?php echo $this->char->getName();?>' vraiment de la guilde '<?php echo $this->info['Gilde'];?>' supprimer?</div>
			<div id="deldia" title="Charakter löschen">voulez-vous '<?php echo $this->char->getName();?>' vraiment envie de supprimer? (Peut être utilisé comme un UM morts relancé)</div>
			<div id="resdia" title="Charakter wiederbeleben">voulez-vous '<?php echo $this->char->getName();?>' vraiment revivre?</div>
			<div id="bandia" title="Benutzer Bannen">voulez-vous '<?php echo $this->char->getName();?>' (Account: <?php echo $this->user->getName();?>) vraiment Bannir?</div>
			<div id="unbandia" title="Benutzer Entbannen">voulez-vous '<?php echo $this->char->getName();?>' (Account: <?php echo $this->user->getName();?>) vraiment debannir?</div>
			<div id="leveldia" title="Level ändern">Comment est le nouveau Level  '<?php echo $this->char->getName();?>' lire?<form action="index.php?action=char&amp;CharID=<?php echo $this->char->getCharID();?>&amp;do=level" method="POST"><br><input type="text" name="level" maxlength=3 size=3></form><br>Statut et compétences points ne sont pas calculées.</div>
			<div id="sexdia" title="Geschlecht ändern">Comment est le nouveau sexe  '<?php echo $this->char->getName();?>' aus.</div>
			<div id="statdia" title="Statuspunkte ändern">Comment est le nouveau Statpoint  '<?php echo $this->char->getName();?>' lire?<form action="index.php?action=char&amp;CharID=<?php echo $this->char->getCharID();?>&amp;do=stat" method="POST"><br><input type="text" name="stat" maxlength=4 size=4></form></div>
			<div id="skilldia" title="Statuspunkte ändern">Comment est le nouveau Skillpoint  '<?php echo $this->char->getName();?>' lire?<form action="index.php?action=char&amp;CharID=<?php echo $this->char->getCharID();?>&amp;do=skill" method="POST"><br><input type="text" name="skill" maxlength=4 size=4></form></div>
			<div id="killdia" title="Kills ändern">Comment est le nouveau Kills  '<?php echo $this->char->getName();?>' lire?<form action="index.php?action=char&amp;CharID=<?php echo $this->char->getCharID();?>&amp;do=kill" method="POST"><br><input type="text" name="kill" maxlength=6 size=6></form></div>
			<div id="toddia" title="Tode ändern">Comment est le nouveau mort  '<?php echo $this->char->getName();?>' lire?<form action="index.php?action=char&amp;CharID=<?php echo $this->char->getCharID();?>&amp;do=tod" method="POST"><br><input type="text" name="tod" maxlength=6 size=6></form></div>
			<div id="dkilldia" title="Duell-Kills ändern">Comment est le nouveau Duell-Kills  '<?php echo $this->char->getName();?>' lire?<form action="index.php?action=char&amp;CharID=<?php echo $this->char->getCharID();?>&amp;do=dkill" method="POST"><br><input type="text" name="dkill" maxlength=6 size=6></form></div>
			<div id="dtoddia" title="Duell-Tode ändern">Comment est le nouveau Duell-mort  '<?php echo $this->char->getName();?>' lire?<form action="index.php?action=char&amp;CharID=<?php echo $this->char->getCharID();?>&amp;do=dtod" method="POST"><br><input type="text" name="dtod" maxlength=6 size=6></form></div>
			<div id="growdia" title="Modus ändern">Comment est le nouveau Modus für '<?php echo $this->char->getName();?>' aus. <br><br>Statut et compétences points ne sont pas calculées.</div>
			
			
			
			<?php
		}
	}
}

?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           