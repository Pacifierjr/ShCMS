<?php

/**
 * @author		Trayne & eQuiNox
 * @copyright	2011 - 2017 Shaiya Productions
**/

Class logsAction{
	private $LogTitle;
	private $LogActionID;
	private $conn;
    private $query;
    private $res;
    private $row;
	private $IsHome;
    private $sql;
    private $orderby;
    private $post;
    private $ordersens;
    private $schar;
    private $andsup;
    
	public function __construct(){
			$this->conn = dbConn::getConnection();
	}	
	public function execute(){
		if((!isset($_POST["inout"])) && (!isset($_POST["transactions"])) && (!isset($_POST["kills"]))){
			$this->IsHome = true;
		}else{
			$this->IsHome = false;
		}
	
	
	

	
		if($this->IsHome){
			
		?>
		<center>
		<h1>Shaiya Admin Log Panel</h1>
		<form action="" method="POST">
		<input type="Submit" name="inout" value="Enter / Leave Logs"/><p>Display a list of last connections to the server.</p><br/><br/>
		<input type="Submit" name="transactions" value="Transactions logs"/><p>Display a list of the game transactions done.</p><br/><br/>
		<input type="Submit" name="kills" value="Kills logs" /><p>Display a list of the server kills.</p><br/>
            <br/><br/>
        <input type="number" name="maxrow" value="50" placeholder = "maxrow"/><p>Max selected rows.</p>
		</form>
		</center>

		<?php
		}else{
            $this->orderby = "A.ActionTime";
            if(isset($_POST["orderby"])){
                if($_POST["orderby"] != ""){
                    $this->orderby = "A.".Parser::validate($_POST["orderby"]);
                }
            }
            $this->ordersens = "DESC";
            if(isset($_POST["ordersens"])){
                if($_POST["ordersens"] == "CAsc"){
                    $this->ordersens = "ASC";
                }elseif($_POST["ordersens"] == "CDesc"){
                    $this->ordersens = "DESC";
                }elseif($_POST["KAsc"]){
                    $this->ordersens = "ASC";
                    $this->orderby = "KDR";
                }elseif($_POST["KDesc"]){
                    $this->ordersens = "DESC";
                    $this->orderby = "KDR";
                }
            }
            
            $this->LogTitle = $this->LogActionID = null;
            $this->post = "";
            $this->andsub = "";
            if(isset($_POST["Hip"])){
                $this->andsub = "AND (C.UserIP = '".Parser::validate($_POST["Hip"])."' OR A.Text1 = '".Parser::validate($_POST["Hip"])."')";
            }
            if(isset($_POST["Huser"])){
                $this->andsub = "AND (C.UserID = '".Parser::validate($_POST["Huser"])."' OR C.UserUID = '".Parser::validate($_POST["Huser"])."')";
            }
            if(isset($_POST["Hchar"])){
                $this->andsub = "AND (B.CharName = '".Parser::validate($_POST["Hchar"])."' OR B.CharID = '".Parser::validate($_POST["Hchar"])."')";     
            }
            
			if(isset($_POST["inout"])){
				$this->LogTitle = "Enter / Leave Logs";
				$this->LogActionID = "107,108";
                 $this->sql = "SELECT TOP " . Parser::validate($_POST["maxrow"])  ." *, (B.K1 - B.K2) AS KDR FROM PS_GameLog.dbo.ActionLog AS A INNER JOIN PS_GameData.dbo.Chars AS B ON A.CharID = B.CharID INNER JOIN PS_UserData.dbo.Users_Master AS C ON A.UserUID = C.UserUID WHERE (A.ActionType in (" . $this->LogActionID . ")) ORDER BY ". $this->orderby ." ".$this->ordersens.";";
                 $this->post = "inout";
			}elseif(isset($_POST["transactions"])){
				$this->Loge = "Transactions Logs";
				$this->LogActionID = "116";
                $this->sql = "SELECT TOP " . Parser::validate($_POST["maxrow"])  ." *, (B.K1 - B.K2) AS KDR FROM PS_GameLog.dbo.ActionLog AS A INNER JOIN PS_GameData.dbo.Chars AS B ON A.CharID = B.CharID INNER JOIN PS_UserData.dbo.Users_Master AS C ON A.UserUID = C.UserUID WHERE (A.ActionType in (" . $this->LogActionID . ")) ORDER BY ". $this->orderby ." ".$this->ordersens.";";
                 $this->post = "transactions";
			}elseif(isset($_POST["kills"])){
				$this->LogTitle = "Kills logs";
                $this->LogActionID = "104";
                $this->sql = "SELECT TOP " . Parser::validate($_POST["maxrow"])  ." *, (B.K1 - B.K2) AS KDR FROM PS_GameLog.dbo.ActionLog AS A INNER JOIN PS_GameData.dbo.Chars AS B ON A.CharID = B.CharID INNER JOIN PS_UserData.dbo.Users_Master AS C ON A.UserUID = C.UserUID WHERE (A.ActionType in (" . $this->LogActionID . ")) ORDER BY ". $this->orderby ." ".$this->ordersens.";";
                $this->post = "kills";
			}
            $this->query = $this->conn->prepare($this->sql);
            $this->query->execute();
		?>
            <h1>Shaiya Logs: <?=$this->LogTitle;?> </h1>
            <center>
            <form action="#" id="TheForm" method="POST">
                <table>
                
                <tr><td><p>Search by player IP: </p></td><td><input name="Hip" type="text" value="" placeholder="Type an IP..."/></td></tr>
                <tr><td><p>Search by player UserID or UserUID:</p></td><td><input name="Huser" type="text" value="" placeholder="Type an Username / UserUID..."/></td></tr>
                <tr><td><p>Search by character name or character id: </p></td><td><input name="Hchar" type="text" value="" placeholder="Type charname or charid..."/></td></tr>
                <tr><td><p>OrderBy : </p></td><td><select name="ordersens" ><option value="CAsc">Collumn click Asc</option><option value="CDesc">Collumn click Desc</option><option value="KAsc">PlayerKDR Asc</option><option value="CDesc">PlayerKDR  Desc</option></select></td></tr>
                <tr><td><p>Max rows: </p></td><td> <input type="number" name="maxrow" value="<?=$_POST["maxrow"]?>" placeholder = "maxrow"/>  </td></tr>

                </table>
            <input type="text" name="<?=$this->post?>" value="yes" style="display:none"/>
            <input type="text" id="valorder" name="orderby" value="ActionTime" style="display:none"/>
                <br/>
                <input type="Submit"/> 
                            <p>Click on collum title if you want to order the results instead of using this submit button, default order is ActionTime.</p>
            </form>
            </center>
		<style>
            p {
                font-size: 15px;
            }
            #m {
                margin-top:350px;
                left:0px;
                background-color:gray;
                color:white;
                font-size:10px;
                border-spacing: 0;
                border-collapse: collapse;
                position:absolute;
            }   
            #m th{
                background-color:black;
            }
        </style>
            <script>
            function OrderBy(vara){
                document.getElementById('valorder').value = vara;
                document.getElementById('TheForm').submit();        
            }
            </script>

        <table id="m" cellpadding="0" cellspacing="0">
			<tr><th onclick="OrderBy(this.id)" id="CharName">CharName</th><th onclick="OrderBy(this.id)" id="CharLevel">CharLevel</th><th onclick="OrderBy(this.id)" id="CharExp">CharExp</th><th onclick="OrderBy(this.id)" id="MapID">MapID</th><th onclick="OrderBy(this.id)" id="PosX">PosX</th><th onclick="OrderBy(this.id)" id="PosY">PosY</th><th onclick="OrderBy(this.id)" id="PosZ">PosZ</th><th onclick="OrderBy(this.id)" id="ActionTime">ActionTime</th><th onclick="OrderBy(this.id)" id="ActionType">ActionType</th><th onclick="OrderBy(this.id)" id="Value1">Value1</th><th onclick="OrderBy(this.id)" id="Value2">Value2</th><th onclick="OrderBy(this.id)" id="Value3">Value3</th><th onclick="OrderBy(this.id)" id="Value4">Value4</th><th onclick="OrderBy(this.id)" id="Value5">Value5</th><th onclick="OrderBy(this.id)" id="Value6">Value6</th><th onclick="OrderBy(this.id)" id="Value7">Value7</th><th onclick="OrderBy(this.id)" id="Value8">Value8</th><th onclick="OrderBy(this.id)" id="Value9">Value9</th><th onclick="OrderBy(this.id)" id="Value10">Value10</th><th onclick="OrderBy(this.id)" id="Text1">Text1</th><th onclick="OrderBy(this.id)" id="Text2">Text2</th><th onclick="OrderBy(this.id)" id="Text3">Text3</th><th onclick="OrderBy(this.id)" id="Text4">Text4</th></tr>
            <?php 
             while($this->row=$this->query->fetch(PDO::FETCH_BOTH)){
            ?>
            <tr><td><a href="index.php?action=char&CharID=<?=$this->row["CharID"]?>"><?=$this->row["CharName"]?></a></td><td><?=$this->row["CharLevel"]?></td><td><?=$this->row["CharExp"]?></td><td><?=$this->row["MapID"]?></td><td><?=$this->row["PosX"]?></td><td><?=$this->row["PosY"]?></td><td><?=$this->row["PosZ"]?></td><td><?=$this->row["ActionTime"]?></td><td><?=$this->row["ActionType"]?></td><td><?=$this->row["Value1"]?></td><td><?=$this->row["Value2"]?></td><td><?=$this->row["Value3"]?></td><td><?=$this->row["Value4"]?></td><td><?=$this->row["Value5"]?></td><td><?=$this->row["Value6"]?></td><td><?=$this->row["Value7"]?></td><td><?=$this->row["Value8"]?></td><td><?=$this->row["Value9"]?></td><td><?=$this->row["Value10"]?></td><td><?=$this->row["Text1"]?></td><td><?=$this->row["Text2"]?></td><td><?=$this->row["Text3"]?></td><td><?=$this->row["Text4"]?></td></tr>
            
            <?php 
             }
            ?>

		</table>
		<?php
		}
	}
}
?>