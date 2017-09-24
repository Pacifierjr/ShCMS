<?php

/**
 * @author		Trayne & eQuiNox
 * @copyright	2011 - 2017 Shaiya Productions
**/

Class userAction{
	private $gm;
	private $top;
	private $value;
	private $status;
	private $user;
	private $banned;
	private $isgm;
	private $chars;
	private $char;
	private $fraktion;
	private $gilde;
	private $banlin;
	private $degm;
	private $items;
	
	public function __construct(&$gm){
		$this->gm = $gm;
	}
	
	public function execute(){
		if (!isset($_GET['UserUID']) && !isset($_POST['Suche'])){
			if (isset($_GET['top'])){
				if (Parser::gint($_GET['top']))
					$this->top = Top::Accounts($_GET['top']);
				else
					$this->top = Top::Accounts(10000);
			}
			else
				$this->top = Top::Accounts(10000);
			
			//HTML
			echo '<center>';
			echo '<h2>Account Management</h2>';
			echo '<br>';
			echo '<form action="index.php?action=user" method="POST">';
			echo '<input type="text" name="Suche" maxlength=18>';
			echo '<input type="submit" name="submit" value="Search" style="display: inline">';
			echo '</form>';
			echo '<br>';
			echo '<table>';
			echo '<tr>';
			echo '<th>UserUID</th><th>Name</th><th>Status</th><th>IP-Adress</th><th>Last login</th><th>AP</th>';
			echo '</tr>';
				if(!empty($this->top)){
			foreach($this->top as $this->value){
				if ($this->value['Status'] > 15 && $this->value['Admin'] == 1 && $this->value['AdminLevel'] = 255)
					$this->status = 'Game Master';
				else if ($this->value['Status'] == -5)
					$this->status = 'Banned';
				else
					$this->status = 'Normal';
			
				echo '<tr>';
				echo '<td>'.Parser::Zahl($this->value['UserUID']).'</td>';
				echo '<td><a href="index.php?action=user&amp;UserUID='.$this->value['UserUID'].'">'.$this->value['UserID'].'</a></td>';
				echo '<td>'.$this->status.'</td>';
				echo '<td><a href="index.php?action=ip&amp;ip='.$this->value['UserIP'].'">'.$this->value['UserIP'].'</a></td>';
				echo '<td>'.Parser::Datum($this->value['JoinDate']).'</td>';
				echo '<td>'.Parser::zahl($this->value['Point']).'</td>';
				echo '</tr>';
			}}
			
			//HTML
			echo '</table>';
			echo '</center>';
			
		} else if (isset($_POST['Suche'])){
			$this->top = Search::Accounts($_POST['Suche']);
			echo '<center>';
			echo '<h2>Account Management</h2>';
			echo '<br>';
			echo '<form action="index.php?action=user" method="POST">';
			echo '<input type="text" name="Suche" maxlength=18>';
			echo '<input type="submit" name="submit" value="Search" style="display: inline">';
			echo '</form>';
			echo '<br>';
			echo '<table>';
			echo '<tr>';
			echo '<th>UserUID</th><th>Name</th><th>Status</th><th>IP-Adress</th><th>Last login</th><th>AP</th>';
			echo '</tr>';
			if ($this->top == false)
				echo '</table>The search returned no results.</center>';
			else {
				foreach($this->top as $this->value){
					if ($this->value['Status'] > 15 && $this->value['Admin'] == 1 && $this->value['AdminLevel'] = 255)
						$this->status = 'Game Master';
					else if ($this->value['Status'] == -5)
						$this->status = 'Banned';
					else
						$this->status = 'Normal';
				
					echo '<tr>';
					echo '<td>'.Parser::Zahl($this->value['UserUID']).'</td>';
					echo '<td><a href="index.php?action=user&amp;UserUID='.$this->value['UserUID'].'">'.$this->value['UserID'].'</a></td>';
					echo '<td>'.$this->status.'</td>';
					echo '<td><a href="index.php?action=ip&amp;ip='.$this->value['UserIP'].'">'.$this->value['UserIP'].'</a></td>';
					echo '<td>'.Parser::Datum($this->value['JoinDate']).'</td>';
					echo '<td>'.Parser::zahl($this->value['Point']).'</td>';
					echo '</tr>';
				}
				echo '</table>';
				echo '</center>';
			}
			
		} else if (isset($_GET['UserUID'])){
			if (!Parser::gint($_GET['UserUID']))
				throw new SystemException('UserUID must be an integer', 0, 0, __FILE__, __LINE__);
			
			$this->user = new user($_GET['UserUID']);
			
			if (isset($_GET['do'])){
				switch($_GET['do']){
					case 'ban':
						if ($this->user->ban())
							echo '<div Class="success">'.$this->user->getName().' has been banned.</div>';
						break;
					case 'unban':
						if ($this->user->unban())
							echo '<div Class="success">'.$this->user->getName().' has been unbanned.</div>';
						break;
					case 'pw':
						if (isset($_POST['PW'])){
							if ($this->user->changePw($_POST['PW']))
								echo '<div Class="success">'.$this->user->getName().'s password has been changed.</div>';
						}
						else
								echo '<div Class="error">Please put a password.</div>';
							
						break;
					case 'giveGM':
						if ($this->user->makeGM($_GET['Status'])){
							if ($_GET['Status'] > 0)
								echo '<div Class="success">'.$this->user->getName().' is a new Game Master.</div>';
							else
								echo '<div Class="success">'.$this->user->getName().' is no longer a Game Master</div>';
						}
						break;
					case 'giveAp':
						if (isset($_POST['AP'])){
							if ($this->user->giveAp($_POST['AP']))
								echo '<div Class="success"> '.$_POST['AP'].' APs were given to'.$this->user->getName().' </div>';
						}
						break;
					case 'takeAp':
						if (isset($_POST['AP'])){
							if($this->user->takeAp($_POST['AP']))
								echo '<div Class="success">'.$_POST['AP'].'APs were taken to '.$this->user->getName().'</div>';
						}
						break;
				}
				$this->user = new user($_GET['UserUID']);
			}
			
			if ($this->user->isBanned()){
				$this->banned = 'Yes';
				$this->banlin = '<a href="javascript::void();" id="unban">Unbann</a>';
			} else{
				$this->banned = 'No';
				$this->banlin = '<a href="javascript::void();" id="ban">Ban</a>';
			}
			
			if ($this->user->isGm()){
				$this->isgm = 'Yes ('.$this->user->getStatus().')';
				$this->degm = '<a href="javascript::void();" id="ungm">GM Remove</a>';
			} else{
				$this->isgm = 'No';
				$this->degm = '';
			}
			
			if ($this->user->getFraktion() == 0)
				$this->fraktion = 'Light';
			else
				$this->fraktion = 'Dark';
			
			
			echo '<table>';
			echo '<tr><td>Account: </td><td>'.$this->user->getName().'</td><td></td><td></td></tr>';
			echo '<tr><td>UserUID: </td><td>'.Parser::Zahl($this->user->getUserUID()).'</td><td></td><td></td></tr>';
			echo '<tr><td>Password: </td><td>*****</td><td></td><td><a href="javascript::void();" id="pwf">Change password</a></td></tr>';
			echo '<tr><td>IP-Adress: </td><td><a href="index.php?action=ip&amp;ip='.$this->user->getIp().'">'.$this->user->getIp().'</a></td><td></td><td></td></tr>';
			echo '<tr><td>Faction: </td><td>'.$this->fraktion.'</td><td></td><td></td></tr>';
			echo '<tr><td>AP: </td><td>'.Parser::Zahl($this->user->getPoint()).'</td><td><a href="javascript::void();" id="apg">Give AP</a></td><td><a href="javascript::void();" id="apa">Take AP</a></td></tr>';
			echo '<tr><td>Banned: </td><td>'.$this->banned.'</td><td></td><td>'.$this->banlin.'</td></tr>';
			echo '<tr><td>Game Master: </td><td>'.$this->isgm.'</td><td>'.$this->degm.'</td><td><a href="javascript::void();" id="gm">Make GM</a></td></tr>';
			echo '</table>';
			
			$this->chars = $this->user->getChars();
			
			
			
			echo '<br>';
			echo '<br>';
			echo 'Characters:';
			if (!$this->chars)
				echo '<br>No Chars available.';
			else {
				echo '<table>';
				echo '<tr><th>Char ID</th><th>Char Name</th><th>Level</th><th>Classe</th><th>Gild</th></tr>';
				foreach($this->chars as $this->value){
					$this->char = new char($this->value);
					if ($this->char->getGuild()){
						$this->gilde = new guild($this->char->getGuild());
						$this->gilde = $this->gilde->getName();
					} else
						$this->gilde = 'No';
					echo '<tr>';
					echo '<td>'.Parser::Zahl($this->char->getCharID()).'</td>';
					echo '<td><a href="index.php?action=char&amp;CharID='.$this->char->getCharID().'">'.$this->char->getName().'</a></td>';
					echo '<td>'.$this->char->getLevel().'</td>';
					echo '<td>'.$this->char->getClassName().'</td><td>';
					if ($this->char->getGuild())
						echo '<a href="index.php?action=guild&amp;GuildID='.$this->char->getGuild().'">';
					echo $this->gilde;
					if ($this->char->getGuild())
						echo '</a>';
					echo '</td></tr>';
				}
				echo '</table>';
			}
			
			$this->items = $this->user->leseWL();
			
			echo '<br><br><br>Warehouse:<table>';
			echo '<tr>';
			echo '<th>ItemID</th><th>Name</th><th>Level</th><th>Page</th><th>Slots</th><th>Durability</th><th>Obtain</th>';
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
				echo '<td><a href="index.php?action=wl&amp;uid='.$this->value['ItemUID'].'" Class="tooltip" title="'.$this->value['ToolTip'].'">'.$this->value['ItemName'].'</a></td>';
				echo '<td>'.$this->value['ReqLevel'].'</td>';
				echo '<td>'.$this->value['Slot'].'</td>';
				echo '<td>'.$this->value['MaxSlot'].'</td>';
				echo '<td>'.$this->value['MaxQuality'].'</td>';
				echo '<td>'.Parser::Datum($this->value['MakeTime']).'</td>';
				echo '</tr>';
			}
			echo '</tr>';
			echo '</table>';
			
			?>
			<script type="text/javascript">
			 $(function(){
				$("#bandia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					modal: true,
					buttons: {
						Yes: function() {
							document.location.href = 'index.php?action=user&UserUID=<?php echo $this->user->getUserUID();?>&do=ban';
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
							document.location.href = 'index.php?action=user&UserUID=<?php echo $this->user->getUserUID();?>&do=unban';
							$(this).dialog('close');
						},
					
						No: function() {
							$(this).dialog('close');
						}

					}

				});
				
				$("#gmdia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					width: 400,
					modal: true,
					buttons: {
						16: function() {
							document.location.href = 'index.php?action=user&UserUID=<?php echo $this->user->getUserUID();?>&do=giveGM&Status=16';
							$(this).dialog('close');
						},
						
						32: function() {
							document.location.href = 'index.php?action=user&UserUID=<?php echo $this->user->getUserUID();?>&do=giveGM&Status=32';
							$(this).dialog('close');
						},
						
						48: function() {
							document.location.href = 'index.php?action=user&UserUID=<?php echo $this->user->getUserUID();?>&do=giveGM&Status=48';
							$(this).dialog('close');
						},
						
						64: function() {
							document.location.href = 'index.php?action=user&UserUID=<?php echo $this->user->getUserUID();?>&do=giveGM&Status=64';
							$(this).dialog('close');
						},
						
						80: function() {
							document.location.href = 'index.php?action=user&UserUID=<?php echo $this->user->getUserUID();?>&do=giveGM&Status=80';
							$(this).dialog('close');
						},
					
						Cancel: function() {
							$(this).dialog('close');
						}

					}
				});
				
				
				$("#ungmdia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					modal: true,
					buttons: {
						Yes: function() {
							document.location.href = 'index.php?action=user&UserUID=<?php echo $this->user->getUserUID();?>&do=giveGM&Status=0';
							$(this).dialog('close');
						},
					
						No: function() {
							$(this).dialog('close');
						}

					}

				});
				
				$("#apgdia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					modal: true,
					buttons: {
						Send: function() {
							$("#apgdiaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
							$(this).dialog('close');
						}

					}
				});
				
				$("#apadia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					modal: true,
					buttons: {
						Remove: function() {
							$("#apadiaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
							$(this).dialog('close');
						}

					}
				});
				
				$("#pwfdia").dialog({
					bgiframe: true,
					autoOpen: false,
					height: 300,
					modal: true,
					buttons: {
						Change: function() {
							$("#pwfdiaform").submit();
							$(this).dialog('close');
						},
					
						Cancel: function() {
							$(this).dialog('close');
						}

					}
				});

				$('#ban').click(function() {
					$('#bandia').dialog('open');
				});
				
				$('#unban').click(function() {
					$('#unbandia').dialog('open');
				});
				
				$('#gm').click(function() {
					$('#gmdia').dialog('open');
				});
				
				$('#apg').click(function() {
					$('#apgdia').dialog('open');
				});
				
				$('#apa').click(function() {
					$('#apadia').dialog('open');
				});
				

				$('#pwf').click(function() {
					$('#pwfdia').dialog('open');
				});
				
				$('#ungm').click(function() {
					$('#ungmdia').dialog('open');
				});
				
				//$(".tooltip").tipTip({maxWidth: "auto", edgeOffset: 10});
				

			});
			
			</script>
			
			<div id="bandia" title="User Ban">Do you want to ban '<?php echo $this->user->getName();?>' ?</div>
			<div id="unbandia" title="User Unban">Do you want to unban '<?php echo $this->user->getName();?>' ?</div>
			<div id="gmdia" title="Status Change">Wich status do you want to give to '<?php echo $this->user->getName();?>' ?</div>
			<div id="apgdia" title="Add AP">How many AP do you want to give to '<?php echo $this->user->getName();?>' ?<form action="index.php?action=user&amp;UserUID=<?php echo $this->user->getUserUID();?>&amp;do=giveAp" method="POST"  id="apgdiaform"><br><input type="text" name="AP" maxlength=6 size=6></form></div>
			<div id="apadia" title="Remove AP">How many AP do you want to remove from '<?php echo $this->user->getName();?>' ?<form action="index.php?action=user&amp;UserUID=<?php echo $this->user->getUserUID();?>&amp;do=takeAp" method="POST" id="apadiaform"><br><input type="text" name="AP" maxlength=6 size=6></form></div>
			<div id="pwfdia" title="Password Change">Please provide the new password for '<?php echo $this->user->getName();?>'<form action="index.php?action=user&amp;UserUID=<?php echo $this->user->getUserUID();?>&amp;do=pw" method="POST" id="pwfdiaform"><br><input type="text" name="PW" maxlength=12 size=12></form></div>
			<div id="ungmdia" title="Make GM">Do you want to remove the GM privileges to '<?php echo $this->user->getName();?>'?</div>
			
			<?php
			
				
		}
		
	}
}

?>