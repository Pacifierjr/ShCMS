<?php

class guildAction{
	private $gm;
	private $gid;
	private $top;
	private $infoArr;
	private $guild;
	private $char;
	private $user;
	private $chars;
	private $error;
	private $items;
	
	public function __construct($gm){
		$this->gm = $gm;
	}
	
	public function execute(){
		if (!isset($_GET['GuildID']) && !isset($_POST['Suche'])){
			if (isset($_GET['top'])){
				if (Parser::gint($_GET['top']))
					$this->top = Top::Guild($_GET['top']);
				else
					$this->top = Top::Guild(20);
			}
			else
				$this->top = Top::Guild(20);
		
			//HTML
			echo '<center>';
			echo '<h2>Gestionnaire de personnages</h2>';
			echo '<br>';
			echo '<form action="index.php?action=guild" method="POST">';
			echo '<input type="text" name="Suche" maxlength=18>';
			echo '<input type="submit" name="submit" value="Suchen" style="display: inline">';
			echo '</form>';
			echo '<br>';
			echo '<table>';
			echo '<tr>';
			echo '<th>GuildID</th><th>Name</th><th>points</th><th>Faction</th><th>membres</th><th>Etabli</th><th>Annule</th>';
			echo '</tr>';
			foreach($this->top as $this->value){
				if ($this->value['Del'] == 1)
					$this->infoArr['Del'] = 'Oui';
				else
					$this->infoArr['Del'] = 'Non';
				
				if ($this->value['Country'] == 0)
					$this->infoArr['Fraktion'] = 'Light';
				else
					$this->infoArr['Fraktion'] = 'Dark';
				
				echo '<tr>';
				echo '<td>'.$this->value['GuildID'].'</td>';
				echo '<td><a href="index.php?action=guild&amp;GuildID='.$this->value['GuildID'].'">'.$this->value['GuildName'].'</a></td>';
				echo '<td>'.Parser::Zahl($this->value['GuildPoint']).'</td>';
				echo '<td>'.$this->infoArr['Fraktion'].'</td>';
				echo '<td>'.$this->value['TotalCount'].'</td>';
				echo '<td>'.Parser::Datum($this->value['CreateDate']).'</td>';
				echo '<td>'.$this->infoArr['Del'].'</td>';
				echo '</tr>';
			}
			echo '</table>';
			echo '</center>';
		} else if (isset($_POST['Suche'])){
			$this->top = Search::Guilds($_POST['Suche']);
			//HTML
			echo '<center>';
			echo '<h2>Gestionnaire de personnages</h2>';
			echo '<br>';
			echo '<form action="index.php?action=guild" method="POST">';
			echo '<input type="text" name="Suche" maxlength=18>';
			echo '<input type="submit" name="submit" value="Suchen" style="display: inline">';
			echo '</form>';
			echo '<br>';
			echo '<table>';
			echo '<tr>';
			echo '<th>GuildID</th><th>Name</th><th>Points</th><th>Faction</th><th>Membres</th><th>Etabli</th><th>Annule</th>';
			echo '</tr>';
			if ($this->top == false)
				echo '</table>La recherche n a donné aucun résultat.</center>';
			else {
				foreach($this->top as $this->value){
					if ($this->value['Del'] == 1)
						$this->infoArr['Del'] = 'Oui';
					else
						$this->infoArr['Del'] = 'Non';
						
					if ($this->value['Country'] == 0)
						$this->infoArr['Fraktion'] = 'Light';
					else
						$this->infoArr['Fraktion'] = 'Dark';
					
					echo '<tr>';
					echo '<td>'.$this->value['GuildID'].'</td>';
					echo '<td><a href="index.php?action=guild&amp;GuildID='.$this->value['GuildID'].'">'.$this->value['GuildName'].'</a></td>';
					echo '<td>'.Parser::Zahl($this->value['GuildPoint']).'</td>';
					echo '<td>'.$this->infoArr['Fraktion'].'</td>';
					echo '<td>'.$this->value['TotalCount'].'</td>';
					echo '<td>'.Parser::Datum($this->value['CreateDate']).'</td>';
					echo '<td>'.$this->infoArr['Del'].'</td>';
					echo '</tr>';
				}
				echo '</table>';
				echo '</center>';
			}
		} else if (isset($_GET['GuildID'])){
			if (!Parser::gint($_GET['GuildID']))
				throw new SystemException('GuildID muss vom Typ integer sein', 0, 0, __FILE__, __LINE__);
			
			$this->guild	= new guild($_GET['GuildID']);
			$this->char		= new char($this->guild->getMasterCharID());
			$this->user		= new user($this->char->getUserUID());
			
			if (isset($_GET['do'])){
				switch($_GET['do']){
					case 'del':
						$this->guild->delete();
						echo '<div class="success">Die Gilde '.$this->guild->getName().' a été supprimé avec succès.</div>';
						break;
					case 'point':
						if (isset($_POST['point'])){
							$this->error = $this->guild->changePoint($_POST['point']);
							if ($this->error == 1)
								echo '<div class="success">Les points de la Guilde '.$this->guild->getName().' a été changé avec succès.</div>';
							else
								echo '<div class="error">'.$this->error.'</div>';
						}
						else
								echo '<div class="error">Entrez les points.</div>';
						break;
					case 'name':
						if (isset($_POST['name'])){
							$this->error = $this->guild->changeName($_POST['name']);
							if ($this->error == 1)
								echo '<div class="success">Le nom de la guilde '.$this->guild->getName().' a été changé avec succès.</div>';
							else
								echo '<div class="error">'.$this->error.'</div>';
						}
						else
								echo '<div class="error">Entrez le nom.</div>';
						break;
					case 'leader':
						if (isset($_POST['leader'])){
							$this->error = $this->guild->changeLeader($_POST['leader']);
							if ($this->error == 1)
								echo '<div class="success">Le chef de la guilde '.$this->guild->getName().' a été changé avec succès.</div>';
							else
								echo '<div class="error">'.$this->error.'</div>';
						}
						else
								echo '<div class="error">S il vous plaît entrer chef.</div>';
						break;
				}
				$this->guild	= new guild($_GET['GuildID']);
				$this->char		= new char($this->guild->getMasterCharID());
				$this->user		= new user($this->char->getUserUID());
			}
			
			
			
			if ($this->guild->getCountry() == 0)
				$this->infoArr['Fraktion'] = 'Light';
			else
				$this->infoArr['Fraktion'] = 'Dark';
				
			if ($this->guild->getDel() == 0){
				$this->infoArr['Del']		= 'Non';
				$this->infoArr['DelLink']	= '<a href="javascript::void();" id="del">effacer</a>';
			} else{
				$this->infoArr['Del']		= 'Oui';	
				$this->infoArr['DelLink']	= '';
			}
			
			echo '<table>';
			echo '<tr><td>Guilde ID: </td><td>'.$this->guild->getGuildID().'</td><td></td></tr>';
			echo '<tr><td>Guilde: </td><td>'.$this->guild->getName().'</td><td><a href="javascript::void();" id="name">Changer nom</a></td></tr>';
			echo '<tr><td>Points: </td><td>'.Parser::Zahl($this->guild->getGuildPoint()).'</td><td><a href="javascript::void();" id="point">Changer Point</a></td></tr>';
			echo '<tr><td>Faction: </td><td>'.$this->infoArr['Fraktion'].'</td><td></td></tr>';
			echo '<tr><td>Nombre de membres: </td><td>'.$this->guild->getMitgliederZahl().'</td><td></td></tr>';
			echo '<tr><td>établi: </td><td>'.Parser::Datum($this->guild->getCreateDatum()).'</td><td></td></tr>';
			echo '<tr><td>Leader CharID: </td><td>'.Parser::Zahl($this->guild->getMasterCharID()).'</td><td></td></tr>';
			echo '<tr><td>Leader UserUID: </td><td>'.Parser::Zahl($this->char->getUserUID()).'</td><td></td></tr>';
			echo '<tr><td>Leader Name: </td><td><a href="index.php?action=char&amp;CharID='.$this->char->getCharID().'">'.$this->char->getName().'</a></td><td><a href="javascript::void();" id="leader">changer chef</a></td></tr>';
			echo '<tr><td>Leader Account: </td><td><a href="index.php?action=user&amp;UserUID='.$this->user->getUserUID().'">'.$this->user->getName().'</td><td></td></tr>';
			echo '<tr><td>Notice: </td><td>'.$this->guild->getRemark().'</td><td></td></tr>';
			echo '<tr><td>Annulé: </td><td>'.$this->infoArr['Del'].'</td><td>'.$this->infoArr['DelLink'].'</td></tr>';
			echo '</table>';
			
			$this->chars = $this->guild->getMitglieder();
			
			echo '<br><br><br>membres';
			echo '<table>';
			echo '<tr>';
			echo '<th>CharID</th><th>UserUID</th><th>CharName</th><th>UserID</th><th>G-Level</th><th>Level</th><th>Classe</th><th>Map</th><th>Kills</th><th>Mort</th>';
			echo '</tr>';
			if (!$this->chars)
				echo '</table>Pas de membres présents.';
			else{
				foreach($this->chars as $this->infoArr['Member']){
					$this->char = new char($this->infoArr['Member']['CharID']);
					$this->user	= new user($this->char->getUserUID());
					
					echo '<tr>';
					echo '<td>'.Parser::Zahl($this->char->getCharID()).'</td>';
					echo '<td>'.Parser::Zahl($this->char->getUserUID()).'</td>';
					echo '<td><a href="index.php?action=char&amp;CharID='.$this->char->getCharID().'">'.$this->char->getName().'</a></td>';
					echo '<td><a href="index.php?action=user&amp;UserUID='.$this->user->getUserUID().'">'.$this->user->getName().'</a></td>';
					echo '<td>'.$this->infoArr['Member']['GuildLevel'].'</td>';
					echo '<td>'.$this->char->getLevel().'</td>';
					echo '<td>'.$this->char->getClassName().'</td>';
					echo '<td>'.Map::get($this->char->getMap()).'</td>';
					echo '<td>'.Parser::Zahl($this->char->getKills()).'</td>';
					echo '<td>'.Parser::Zahl($this->char->getTode()).'</td>';
				}
				echo '</table>';
			}
			
			
			
			$this->items = $this->guild->readWH();
			echo '<br><br><br>entrepôt de guilde:<table>';
			echo '<tr>';
			echo '<th>ItemID</th><th>Name</th><th>Level</th><th>Espace</th><th>Slots</th><th>Durabilite</th><th>obtenir</th>';
			echo '</tr>';
			foreach($this->items as $this->value){
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
				echo '<td><a href="index.php?action=gl&uid='.$this->value['ItemUID'].'" class="tooltip" title="'.$this->value['ToolTip'].'">'.$this->value['ItemName'].'</a></td>';
				echo '<td>'.$this->value['ReqLevel'].'</td>';
				echo '<td>'.$this->value['Slot'].'</td>';
				echo '<td>'.$this->value['MaxSlot'].'</td>';
				echo '<td>'.$this->value['MaxQuality'].'</td>';
				echo '<td>'.Parser::Datum($this->value['MakeTime']).'</td>';
				echo '</tr>';
			}
			echo '</tr>';
			echo '</table>';
			echo '</table>';
			
			?>
			<script type="text/javascript">
			$(function(){
				$("#deldia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					modal: true,
					buttons: {
						Ja: function() {
							document.location.href = 'index.php?action=guild&GuildID=<?php echo $this->guild->getGuildID();?>&do=del';
							$(this).dialog('close');
						},
					
						Nein: function() {
							$(this).dialog('close');
						}
					}
				});
				
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
				
				$("#pointdia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					modal: true,
					buttons: {
						Ändern: function() {
							$("#pointdia > form").submit();
							$(this).dialog('close');
						},
					
						Abbrechen: function() {
							$(this).dialog('close');
						}
					}
				});
				
				$("#leaderdia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					modal: true,
					buttons: {
						Ändern: function() {
							$("#leaderdia > form").submit();
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
				
				$('#point').click(function() {
					$('#pointdia').dialog('open');
				});
				
				$('#leader').click(function() {
					$('#leaderdia').dialog('open');
				});
				
				$('#del').click(function() {
					$('#deldia').dialog('open');
				});
				
				$(".tooltip").tipTip({maxWidth: "auto", edgeOffset: 10});
			});
			
			</script>
			
			
			<div id="namedia" title="Name ändern">Comment est le nouveau nom de la guilde '<?php echo $this->guild->getName();?>' Lire?<form action="index.php?action=guild&amp;GuildID=<?php echo $this->guild->getGuildID();?>&amp;do=name" method="POST"><br><input type="text" name="name" maxlength=18 size=18></form><br>Ne prendra effet qu'apres le reboot Serveur.</div>
			<div id="pointdia" title="Punkte ändern">Comment les nouveaux points de la Guilde '<?php echo $this->guild->getName();?>' Lire?<form action="index.php?action=guild&amp;GuildID=<?php echo $this->guild->getGuildID();?>&amp;do=point" method="POST"><br><input type="text" name="point" maxlength=6 size=6></form><br>Ne prendra effet qu'apres le reboot Serveur.</div>
			<div id="leaderdia" title="Leader ändern">Comment est le nouveau leader de la guilde '<?php echo $this->guild->getName();?>'?<form action="index.php?action=guild&amp;GuildID=<?php echo $this->guild->getGuildID();?>&amp;do=leader" method="POST"><br><input type="text" name="leader" maxlength=18 size=18></form><br>Ne prendra effet qu'apres le reboot Serveur.</div>
			<div id="deldia" title="Gilde löschen">Voulez-vous Guild '<?php echo $this->guild->getName();?>' vraiment supprimer?<br><br>Ne prendra effet qu'apres le reboot Serveur</div>
			<?php
			
		}
	}
}

?>