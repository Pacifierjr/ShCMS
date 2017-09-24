<?php

/**
 * @author		Momo
 * @copyright	2014 Jamiro Productions
**/

class ipAction{
	private $gm;
	private $users;
	private $user;
	private $foreachDummy;
	private $infoArr;
	
	public function __construct($gm){
		$this->gm = $gm;
	}
	
	public function execute(){
		if (isset($_GET['ip'])){
			$this->users = UserUID::byUserIP($_GET['ip']);
			
			//HTML
			echo '<center>';
			echo '<h2>Comptes avec la meme IP: '.$_GET['ip'].' </h2>';
			echo '<br>';
			echo '<table>';
			echo '<tr>';
			echo '<th>UserUID</th><th>Name</th><th>Status</th><th>IP-Adresse</th><th>derniere connexion</th><th>AP</th>';
			echo '</tr>';
			if ($this->users == false)
				echo '</table>Cette adresse IP ne compte a ete cree.';
			else{
				foreach($this->users as $this->foreachDummy){
					$this->user = new user($this->foreachDummy);
					
					if ($this->user->getStatus() > 15)
						$this->infoArr['Status'] = 'Game Master';
					else if ($this->user->getStatus() == -5)
						$this->infoArr['Status'] = 'Gebannt';
					else
						$this->infoArr['Status'] = 'Normal';
				
					echo '<tr>';
					echo '<td>'.Parser::Zahl($this->user->getUserUID()).'</td>';
					echo '<td><a href="index.php?action=user&amp;UserUID='.$this->user->getUserUID().'">'.$this->user->getName().'</a></td>';
					echo '<td>'.$this->infoArr['Status'].'</td>';
					echo '<td>'.$this->user->getIp().'</td>';
					echo '<td>'.Parser::Datum($this->user->getLastLogin()).'</td>';
					echo '<td>'.Parser::Zahl($this->user->getPoint()).'</td>';
					echo '</tr>';
				}
				echo '</table>';
			}
			echo '</center>';
			
		}
	}
	
}