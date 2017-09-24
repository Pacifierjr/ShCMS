<?php

Class guildAction{
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
			echo '<h2>Guild Management</h2>';
			echo '<br>';
			echo '<form action="index.php?action=guild" method="POST">';
			echo '<input type="text" name="Suche" maxlength=18>';
			echo '<input type="submit" name="submit" value="Search" style="display: inline">';
			echo '</form>';
			echo '<br>';
			echo '<table>';
			echo '<tr>';
			echo '<th>GuildID</th><th>Name</th><th>Points</th><th>Faction</th><th>Members</th><th>Created</th><th>Deleted</th>';
			echo '</tr>';
				if(!empty($this->top)){
			foreach($this->top as $this->value){
				if ($this->value['Del'] == 1)
					$this->infoArr['Del'] = 'Yes';
				else
					$this->infoArr['Del'] = 'No';
				
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
			}}
			echo '</table>';
			echo '</center>';
		} else if (isset($_POST['Suche'])){
			$this->top = Search::Guilds($_POST['Suche']);
			//HTML
			echo '<center>';
			echo '<h2>Guild Management</h2>';
			echo '<br>';
			echo '<form action="index.php?action=guild" method="POST">';
			echo '<input type="text" name="Suche" maxlength=18>';
			echo '<input type="submit" name="submit" value="Search" style="display: inline">';
			echo '</form>';
			echo '<br>';
			echo '<table>';
			echo '<tr>';
			echo '<th>GuildID</th><th>Name</th><th>Points</th><th>Faction</th><th>Members</th><th>Created</th><th>Deleted</th>';
			echo '</tr>';
			if ($this->top == false)
				echo '</table>The search returned no results.</center>';
			else {
				foreach($this->top as $this->value){
					if ($this->value['Del'] == 1)
						$this->infoArr['Del'] = 'Yes';
					else
						$this->infoArr['Del'] = 'No';
						
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
				throw new SystemException('GuildID must be an integrer.', 0, 0, __FILE__, __LINE__);
			
			$this->guild	= new guild($_GET['GuildID']);
			$this->char		= new char($this->guild->getMasterCharID());
			$this->user		= new user($this->char->getUserUID());
			
			if (isset($_GET['do'])){
				switch($_GET['do']){
					case 'del':
						$this->guild->delete();
						echo '<div Class="success">The guild '.$this->guild->getName().' has been deleted.</div>';
						break;
					case 'point':
						if (isset($_POST['point'])){
							$this->error = $this->guild->changePoint($_POST['point']);
							if ($this->error == 1)
								echo '<div Class="success">Points of the guild '.$this->guild->getName().' were changed.</div>';
							else
								echo '<div Class="error">'.$this->error.'</div>';
						}
						else
								echo '<div Class="error">Please provide a correct value for Points.</div>';
						break;
					case 'name':
						if (isset($_POST['name'])){
							$this->error = $this->guild->changeName($_POST['name']);
							if ($this->error == 1)
								echo '<div Class="success">The name of the guild '.$this->guild->getName().' has been successfully changed.</div>';
							else
								echo '<div Class="error">'.$this->error.'</div>';
						}
						else
								echo '<div Class="error">Please provide a correct value the name of the guild.</div>';
						break;
					case 'leader':
						if (isset($_POST['leader'])){
							$this->error = $this->guild->changeLeader($_POST['leader']);
							if ($this->error == 1)
								echo '<div Class="success">The leader of '.$this->guild->getName().' has been successfully changed.</div>';
							else
								echo '<div Class="error">'.$this->error.'</div>';
						}
						else
								echo '<div Class="error">Please provide a correct guild leader.</div>';
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
				$this->infoArr['Del']		= 'No';
				$this->infoArr['DelLink']	= '<a  id="del">Delete</a>';
			} else{
				$this->infoArr['Del']		= 'Yes';	
				$this->infoArr['DelLink']	= '';
			}
			
			echo '<table>';
			echo '<tr><td>GildID: </td><td>'.$this->guild->getGuildID().'</td><td></td></tr>';
			echo '<tr><td>Gild: </td><td>'.$this->guild->getName().'</td><td><a  id="name">Name Change</a></td></tr>';
			echo '<tr><td>Points: </td><td>'.Parser::Zahl($this->guild->getGuildPoint()).'</td><td><a  id="point">Points Change</a></td></tr>';
			echo '<tr><td>Faction: </td><td>'.$this->infoArr['Fraktion'].'</td><td></td></tr>';
			echo '<tr><td>Members: </td><td>'.$this->guild->getMitgliederZahl().'</td><td></td></tr>';
			echo '<tr><td>Create Date: </td><td>'.Parser::Datum($this->guild->getCreateDatum()).'</td><td></td></tr>';
			echo '<tr><td>Leader CharID: </td><td>'.Parser::Zahl($this->guild->getMasterCharID()).'</td><td></td></tr>';
			echo '<tr><td>Leader UserUID: </td><td>'.Parser::Zahl($this->char->getUserUID()).'</td><td></td></tr>';
			echo '<tr><td>Leader Name: </td><td><a href="index.php?action=char&amp;CharID='.$this->char->getCharID().'">'.$this->char->getName().'</a></td><td><a  id="leader">Change Lader</a></td></tr>';
			echo '<tr><td>Leader Account: </td><td><a href="index.php?action=user&amp;UserUID='.$this->user->getUserUID().'">'.$this->user->getName().'</td><td></td></tr>';
			echo '<tr><td>Remark: </td><td>'.$this->guild->getRemark().'</td><td></td></tr>';
			echo '<tr><td>Deleted: </td><td>'.$this->infoArr['Del'].'</td><td>'.$this->infoArr['DelLink'].'</td></tr>';
			echo '</table>';
			
			$this->chars = $this->guild->getMitglieder();
			
			echo '<br><br><br>Members';
			echo '<table>';
			echo '<tr>';
			echo '<th>CharID</th><th>UserUID</th><th>CharName</th><th>UserID</th><th>G-Level</th><th>Level</th><th>Casse</th><th>Map</th><th>Kills</th><th>Deaths</th>';
			echo '</tr>';
			if (!$this->chars)
				echo '</table>No members found.';
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
			echo '<br><br><br>Guild Warehouse:<table>';
			echo '<tr>';
			echo '<th>ItemID</th><th>Name</th><th>Level</th><th>Page</th><th>Slots</th><th>Durability</th><th>Obtain</th>';
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
				echo '<td><a href="index.php?action=gl&uid='.$this->value['ItemUID'].'" Class="tooltip" title="'.$this->value['ToolTip'].'">'.$this->value['ItemName'].'</a></td>';
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
						Yes: function() {
							document.location.href = 'index.php?action=guild&GuildID=<?php echo $this->guild->getGuildID();?>&do=del';
							$(this).dialog('close');
						},
					
						No: function() {
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
						Change: function() {
							$("#namediaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
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
						Change: function() {
							$("#pointdiaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
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
						Change: function() {
							$("#leaderdiaform").submit();
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
			
			
			<div id="namedia" title="Name Change">Please provide the new name for '<?php echo $this->guild->getName();?>' <form action="index.php?action=guild&amp;GuildID=<?php echo $this->guild->getGuildID();?>&amp;do=name" method="POST"><br><input type="text" name="name" maxlength=18 size=18></form><br>Require server restart.</div>
			<div id="pointdia" title="Points Change">Please provide points for '<?php echo $this->guild->getName();?>' <form action="index.php?action=guild&amp;GuildID=<?php echo $this->guild->getGuildID();?>&amp;do=point" method="POST"><br><input type="text" name="point" maxlength=6 size=6></form><br>Require server restart.</div>
			<div id="leaderdia" title="Leader Change">Please provide the new lader name for '<?php echo $this->guild->getName();?>'<form action="index.php?action=guild&amp;GuildID=<?php echo $this->guild->getGuildID();?>&amp;do=leader" method="POST"><br><input type="text" name="leader" maxlength=18 size=18></form><br>Require server restart.</div>
			<div id="deldia" title="Gilde löschen">Do you want to delete '<?php echo $this->guild->getName();?>' ?<br><br>Require server restart.</div>
			<?php
			
		}
	}
}

?>