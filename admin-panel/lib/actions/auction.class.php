<?php

Class auctionAction{
	private $gm;
	private $sql;
	private $res;
	private $fet;
	private $mid;
	private $auction;
	private $user;
	private $char;
	private $foreachDummy;
	private $top;
	private $bieter;
	
	public function __construct($gm){
		$this->gm = $gm;
	}
	
	public function execute(){
		if (!isset($_GET['mid']) && !isset($_POST['Suche'])){
			if (isset($_GET['top'])){
				if (Parser::gint($_GET['top'])){					$this->top = Top::Auctions($_GET['top']);
}
				else{					$this->top = Top::Auctions(20);
}
			}
			else{
			$this->top = Top::Auctions(20);
			}
				
			
			//HTML
			echo '<center>';
			echo '<h2>Auction House</h2>';
			echo '<br>';
			echo '<form action="index.php?action=auction" method="POST">';
			echo '<input type="text" name="Suche" maxlength=18>';
			echo '<input type="submit" name="submit" value="Search" style="display: inline">';
			echo '</form>';
			echo '<br>';
			echo '<table>';
			echo '<tr>';
			echo '<th>Market-ID</th><th>Char-ID</th><th>User-UID</th><th>Char-Name</th><th>Username</th><th>Item-Name</th><th>Runs until</th>';
			echo '</tr>';
				if(!empty($this->top)){
			foreach($this->top as $this->foreachDummy){
				$this->char = new char($this->foreachDummy['CharID']);
				$this->user = new user($this->char->getUserUID());
				
				echo '<tr>';
				echo '<td><a href="index.php?action=auction&amp;mid='.$this->foreachDummy['MarketID'].'">'.$this->foreachDummy['MarketID'].'</a></td>';
				echo '<td>'.$this->foreachDummy['CharID'].'</td>';
				echo '<td>'.$this->char->getUserUID().'</td>';
				echo '<td><a href="index.php?action=char&amp;CharID='.$this->char->getCharID().'">'.$this->char->getName().'</a></td>';
				echo '<td><a href="index.php?action=user&amp;UserUID='.$this->char->getUserUID().'">'.$this->user->getName().'</a></td>';
				echo '<td>'.$this->foreachDummy['ItemName'].'</td>';
				echo '<td>'.Parser::Datum($this->foreachDummy['EndDate']).'</td>';
				echo '</tr>';
			}}
			echo '</table>';
		} else if (isset($_POST['Suche'])){
			$this->top = Search::Auctions($_POST['Suche']);
			
			//HTML
			echo '<center>';
			echo '<h2>Action House</h2>';
			echo '<br>';
			echo '<form action="index.php?action=auction" method="POST">';
			echo '<input type="text" name="Suche" maxlength=18>';
			echo '<input type="submit" name="submit" value="Search" style="display: inline">';
			echo '</form>';
			echo '<br>';
			echo '<table>';
			echo '<tr>';
			echo '<th>Market-ID</th><th>Char-ID</th><th>User-UID</th><th>Char-Name</th><th>Username</th><th>Item-Name</th><th>Runs until</th>';
			echo '</tr>';
			
			if (!$this->top){
				echo '</table>The search returned no results..</center>';
			} else {
				foreach($this->top as $this->foreachDummy){
					$this->char = new char($this->foreachDummy['CharID']);
					$this->user = new user($this->char->getUserUID());
					
					echo '<tr>';
					echo '<td><a href="index.php?action=auction&amp;mid='.$this->foreachDummy['MarketID'].'">'.$this->foreachDummy['MarketID'].'</a></td>';
					echo '<td>'.$this->foreachDummy['CharID'].'</td>';
					echo '<td>'.$this->char->getUserUID().'</td>';
					echo '<td><a href="index.php?action=char&amp;CharID='.$this->char->getCharID().'">'.$this->char->getName().'</a></td>';
					echo '<td><a href="index.php?action=user&amp;UserUID='.$this->char->getUserUID().'">'.$this->user->getName().'</a></td>';
					echo '<td>'.$this->foreachDummy['ItemName'].'</td>';
					echo '<td>'.Parser::Datum($this->foreachDummy['EndDate']).'</td>';
					echo '</tr>';
				}
				echo '</table></center>';
			}
		}  else if (isset($_GET['mid'])){
			$this->auction	= new auction($_GET['mid']);
			$this->char		= new char($this->auction->getCharID());
			$this->user		= new user($this->char->getUserUID());
			
			if ($this->auction->getBieterCharID() != 0){
				$this->bieter				= new char($this->auction->getBieterCharID());
				$this->infoArr['Bieter']	= '<a href="index.php?action=char&amp;CharID='.$this->bieter->getCharID().'">'.$this->bieter->getName().'</a>';
			} else
				$this->infoArr['Bieter'] = '';
			
			echo '<table>';
			echo '<tr><td>Market-ID: </td><td>'.$this->auction->getMarketID().'</td></tr>';
			echo '<tr><td>Item-ID: </td><td>'.Parser::Zahl($this->auction->getItemID()).'</td></tr>';
			echo '<tr><td>Char-ID: </td><td>'.Parser::Zahl($this->auction->getCharID()).'</td></tr>';
			echo '<tr><td>User-UID: </td><td>'.Parser::Zahl($this->char->getUserUID()).'</td></tr>';
			echo '<tr><td>Item: </td><td><a href="index.php?action=ai&amp;uid='.$this->auction->getItemUID().'">'.$this->auction->getItemName().'</a></td></tr>';
			echo '<tr><td>Anzahl: </td><td>'.$this->auction->getCount().'</td></tr>';
			echo '<tr><td>Charakter: </td><td><a href="index.php?àction=char&amp;CharID='.$this->auction->getCharID().'">'.$this->char->getName().'</a></td></tr>';
			echo '<tr><td>Level: </td><td>'.$this->char->getLevel().'</td></tr>';
			echo '<tr><td>Account: </td><td><a href="index.php?action'.$this->user->getUserUID().'">'.$this->user->getName().'</td></tr>';
			echo '<tr><td>AP: </td><td>'.Parser::Zahl($this->user->getPoint()).'</td></tr>';
			echo '<tr><td>Mind. Gebot: </td><td>'.Parser::Zahl($this->auction->getMinMoney()).'</td></tr>';
			echo '<tr><td>Sofort-Preis: </td><td>'.Parser::Zahl($this->auction->getDirectMoney()).'</td></tr>';
			echo '<tr><td>Auktionskosten: </td><td>'.Parser::Zahl($this->auction->getKosten()).'</td></tr>';
			echo '<tr><td>Höchstbietener: </td><td>'.$this->infoArr['Bieter'].'</td></tr>';
			echo '<tr><td>Höchstgebot: </td><td>'.$this->auction->getGebot().'</td></tr>';
			echo '<tr><td>Ende: </td><td>'.Parser::Datum($this->auction->getEnde()).'</td></tr>';
			echo '</table>';
			
		}
	}
	
	
}

?>