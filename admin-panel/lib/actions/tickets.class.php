<?php

/**
 * @author		Trayne & eQuiNox
 * @copyright	2011 - 2017 Shaiya Productions
**/

Class ticketsAction{
	
	private $uid;
	private $sql;
	private $res;
	private $row;
	private $ssql;
	private $sres;
	private $srow;
	private $acc;
	private $conn;
	public function __construct(){
			$this->conn = dbConn::getConnection();
	}	
	
	public function getID($uid){
		if(is_numeric($uid)){
			$this->ssql = $this->conn->prepare("SELECT UserID FROM PS_UserData.dbo.Users_Master WHERE UserUID = '".Parser::validate($uid)."';");
			$this->ssql->execute();
			$this->srow = $this->ssql->fetch(PDO::FETCH_BOTH);
			return $this->srow[0];
		}else{		
			$this->ssql = $this->conn->prepare("SELECT UserUID FROM PS_UserData.dbo.Users_Master WHERE UserID = '".Parser::validate($uid)."';");
			$this->ssql->execute();
			$this->srow = $this->ssql->fetch(PDO::FETCH_BOTH);
			return $this->srow[0];
		}

	}
	public function strT($var){
		$str = "";
		switch($var){
			case "0":
				$str = "Closed";
				break;
			case "1":
				$str ="Waiting";
				break;
			case "2":
				$str = "Done";
				break;
		}
		return $str;
	}

	public function execute(){
		echo('<script language="JavaScript" src="./js/main.js"></script><center>');	
		
		$this->uid = $_SESSION['UserUID'];
		$this->sql = $this->conn->prepare("SELECT TOP 50 * FROM Website.dbo.Ticket ORDER BY ticketID DESC");
		$this->res = $this->sql->execute();		
		
			echo "<div class='col-md-10'>";
			echo "<table class='table table-hover'>";
			echo "<tr>";
			echo "<th> UserID </td>";
			echo "<th> Object </th>";
			echo "<th> Date </th>";
			echo "<th> Status </th>";

			echo "</tr>";
			while ($this->row = $this->sql->fetch(PDO::FETCH_BOTH)){
					?>
					<tr onclick="javascript:ticketDetails('<? echo ($this->row[2]);?>')">
					<?php
						if ($this->row[1] == 0)
						{
							$this->acc = 'staff';
						}
						else
						{
							$this->acc = $this->getID($this->row[1]);
						}
						echo "<td>";
						echo $this->acc."</td><td>";
						echo $this->row[5];
						echo "</td>";
						echo "<td>";
						echo $this->row[8];
						echo "</td><td>".$this->strT($this->row[3])."</td>";
					echo "</tr>";
			}
			
			echo "</table>";
			echo "</div></center>";

		?>
		</div>
		<div id="details" class="md-col-12">
			<p id ="yourTicket"></p>
		</div>
		<?php
	}
}

?>