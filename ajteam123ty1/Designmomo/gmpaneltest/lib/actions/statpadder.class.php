<?php

/**
 * @author		Momo
 * @copyright	2014 Jamiro Productions
**/

class statpadderAction{
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
		echo 'Ce script recherche Statpadder. Les Joueurs suivant qui ne sont pas interdits, les tués sont moins de 500, dont les décès sont plus de 20 et leur KDR est inférieur à 0,5. Si trop de faux Joueurs sont affichés, sil vous plaît contacter Jamiro.';
		echo '<br>';
		echo '<br>';
		echo '<table>';
		echo '<tr>';
		echo '<th>CharID</th><th>UserUID</th><th>CharName</th><th>UserID</th><th>Annulé</th><th>Level</th><th>Classe</th><th>Map</th><th>Kills</th><th>décès</th><th>KDR</th>';
		echo '</tr>';
		
		$this->top = Top::Statpadder();
		
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
			echo '<td>'.$this->value['KDR'].'</td>';
			echo '</tr>';
		}
			
			//HTML
			echo '</table>';
			echo '</center>';
	}
}
?>