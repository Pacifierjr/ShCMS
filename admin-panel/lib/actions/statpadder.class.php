<?php

/**
 * @author		Trayne & eQuiNox
 * @copyright	2011 - 2017 Shaiya Productions
**/

Class statpadderAction{
	private $gm;
	private $top;
	
	public function __construct($gm){
		$this->gm = $gm;
	}
	
	public function execute(){
		//HTML
		echo '<center>';
		echo '<h2>Statpadder</h2>';
		echo '<br>';
		echo 'This script searches Statspadders. It displays characters, which are not banned with less than 500 kills and more than 20 deaths. and Their KDR is below 0.5. If too many false Chars are displayed, please contact Trayne & Equinox.';
		echo '<br>';
		echo '<br>';
		echo '<table>';
		echo '<tr>';
		echo '<th>CharID</th><th>UserUID</th><th>CharName</th><th>UserID</th><th>Deleted</th><th>Level</th><th>Classe</th><th>Map</th><th>Kills</th><th>Deaths</th><th>KDR</th>';
		echo '</tr>';
		
		$this->top = Top::Statpadder();
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
			echo '<td>'.$this->value['KDR'].'</td>';
			echo '</tr>';
		}}
			
			//HTML
			echo '</table>';
			echo '</center>';
	}
}
?>