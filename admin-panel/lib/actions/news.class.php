<?php

/**
 * @author		Trayne & eQuiNox
 * @copyright	2011 - 2017 Shaiya Productions
**/

Class newsAction{
	private $NewID;
	private $NewTitle;
	private $NewText;
	private $NewGMID;
	private $NewDate;
	private $Action;
	private $Do;
	private $Dow;
	private $sql;
	private $res;
	private $row;
	private $ssql;
	private $sres;
	private $srow;	
	private $conn;
	private $IsDraft;
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
	public function btB($var){
		if($var == "0"){
			return "False";
		}else{
			return "True";
		}
	}
	
	public function execute(){
	if(!isset($_GET['do'])){
		$_GET['do'] = 0;
	}
	if(($_GET['do'] !== "edit") && ($_GET['do'] !== "create")){

		if(isset($_GET['do'])){//assuming GET DO exists
		
			if(($_GET['do'] == "draft") && (isset($_GET['id'])))
			{// do = draft, switch it
				$this->ssql = $this->conn->prepare("SELECT IsDraft FROM Website.dbo.News WHERE Row = '".Parser::validate($_GET['id'])."';");
				$this->ssql->execute();
				$this->srow = $this->ssql->fetch(PDO::FETCH_BOTH);
				//echo($this->srow[0]);
				if($this->srow[0] == 0){
				//	set it to 1
					$this->ssql = $this->conn->prepare("UPDATE Website.dbo.News SET IsDraft = 1 WHERE Row = '".Parser::validate($_GET['id'])."';");
					$this->ssql->execute();
					echo '<div Class="success">You have successfully put the news id '.$_GET['id'].' as draft</div>';

				}
				else
				{
				//	set it to 0
					$this->ssql = $this->conn->prepare("UPDATE Website.dbo.News SET IsDraft = 0 WHERE Row = '".Parser::validate($_GET['id'])."';");
					$this->ssql->execute();
					echo '<div Class="success">You have successfully put the news id '.$_GET['id'].' visible to public</div>';

				}
			}
			elseif(($_GET['do'] == "remove") && (isset($_GET['id']))){
					$this->ssql = $this->conn->prepare("DELETE FROM Website.dbo.News WHERE Row = '".Parser::validate($_GET['id'])."';");
					$this->ssql->execute();
					echo '<div Class="success">You have successfully deleted the news id '.$_GET['id'].'</div>';
			}
			elseif(($_GET['do'] == "update") && (isset($_POST["subject"])) && (isset($_POST["editor1"])) && (isset($_POST["Date"])) && (isset($_POST["Author"])) && (isset($_GET['id']))){
				
					$this->ssql = $this->conn->prepare("UPDATE Website.dbo.News SET Title = '".Parser::validate($_POST["subject"])."', Text = '".$_POST["editor1"]."', GM_ID = '".$this->getID($_POST["Author"])."', Date = '".Parser::validate($_POST["Date"])."' WHERE Row = '".Parser::validate($_GET['id'])."';");
					$this->ssql->execute();
					echo '<div Class="success">You have successfully deleted the news id '.$_GET['id'].'</div>';
			}
			elseif(($_GET['do'] == "insert") && (isset($_POST["subject"])) && (isset($_POST["editor1"])) && (isset($_POST["Date"])) && (isset($_POST["Author"]))){
				
					$this->ssql = $this->conn->prepare("INSERT INTO Website.dbo.News ([Title],[Text],[GM_ID],[Date],[IsDraft]) VALUES ('".Parser::validate($_POST["subject"])."', '".$_POST["editor1"]."', '".$this->getID($_POST["Author"])."', '".Parser::validate($_POST["Date"])."', 1);");
					$this->ssql->execute();
					echo '<div Class="success">You have successfully created the new '.$_POST["subject"].' as draft</div>';
			}
			
		}
		//getting all news
		$this->sql = $this->conn->prepare("SELECT * FROM Website.dbo.News ORDER By Date Asc");
		$this->res = $this->sql->execute();	
		?>
		<center>
		<table>
		<tr><th>News ID</th><th>News Title</th><th>Athor</th><th>News Date</th><th>Is Draft</th><th>Actions</th></tr>
		<?php
		while ($this->row = $this->sql->fetch(PDO::FETCH_BOTH)){
			echo("<tr>");
				echo("<td>".$this->row["Row"]."</td>");
				echo("<td>".$this->row["Title"]."</td>");
				echo("<td>".$this->getID($this->row["GM_ID"])."</td>");
				echo("<td>".$this->row["Date"]."</td>");
				echo("<td>".$this->btB($this->row["IsDraft"])."</td>");
				echo("<td><a href=\"".$_SERVER['PHP_SELF']."?action=news&do=edit&id=".$this->row["Row"]."\">Edit</a> | <a href=\"".$_SERVER['PHP_SELF']."?action=news&do=draft&id=".$this->row["Row"]."\">Switch Is Draft</a> | <a href=\"".$_SERVER['PHP_SELF']."?action=news&do=remove&id=".$this->row["Row"]."\">Remove</a></td>");
			echo("</tr>");

		}
		//list all news
			?>
		</table><br/>
		<a href="<?php echo($_SERVER['PHP_SELF']."?action=news&do=create");?>">Create a news</a>
		</center>
		
		<?php
		}
		elseif(($_GET['do'] == 'edit') && (isset($_GET['id']))){
		//edit
		
		$this->ssql = $this->conn->prepare("SELECT * FROM Website.dbo.News WHERE Row = '".Parser::validate($_GET['id'])."';");
		$this->ssql->execute();
		$this->srow = $this->ssql->fetch(PDO::FETCH_BOTH);
		
		$this->NewID = $this->srow["Row"];
		$this->NewTitle = $this->srow["Title"];
		$this->NewText = $this->srow["Text"];
		$this->NewGMID = $this->srow["GM_ID"];
		$this->NewDate = $this->srow["Date"];
	
		$this->Action = '?action=news&do=update&id='.$this->NewID;
		
				?>

			<script src="./js/ckeditor/ckeditor.js"></script>
			<style>
			#main{
				min-height: 600px;
			}
			</style>
			<center>
			<form action="<?php echo($_SERVER['PHP_SELF'].$this->Action); ?>" method="POST" style="width: 690px;float: left;">
				<p><h2>Title of News</h2><br>
				<input maxlength="100" name="subject" id="subject" placeholder ="Title" style="width:200px;" value="<?php echo($this->NewTitle); ?>"/><br>	</p>
				<p><h2>Date of News (keep the same format please, you can add hour at the end)</h2><br>
				<input maxlength="100" name="Date" id="Date" placeholder ="Date" style="width:200px;" value="<?php echo($this->NewDate); ?>"/><br>	</p>
				<p><h2>Author (have to be an in game account name)</h2><br>
				<input maxlength="100" name="Author" id="Author" placeholder ="Author" style="width:200px;" value="<?php echo($this->GetID($this->NewGMID)); ?>"/><br>	</p>
				<div style="float: left;width: 700px;">
					<textarea id="editor1" name="editor1" rows="10">
						<?php echo($this->NewText); ?>
					</textarea>
				</div>
				<script>
					CKEDITOR.replace( 'editor1' );
				</script>
					<span><input style=" margin: 10px 300px 0 300px;" type="submit" value="Send" ></span>
			</form>
			</center>
		<?php
		}
		elseif($_GET['do'] == 'create'){
		//create
		$this->Action = '?action=news&do=insert';
		?>

			<script src="./js/ckeditor/ckeditor.js"></script>
			<style>
			#main{
				min-height: 600px;
			}
			</style>
			<center>
			<form action="<?php echo($_SERVER['PHP_SELF'].$this->Action); ?>" method="POST" style="width: 690px;float: left;">
				<p><h2>Title of News</h2><br>
				<input maxlength="100" name="subject" id="subject" placeholder ="Title" style="width:200px;" value="<?php echo($this->NewTitle); ?>"/><br>	</p>
				<p><h2>Date of News (keep the same format please, you can add hour at the end)</h2><br>
				<input maxlength="100" name="Date" id="Date" placeholder ="Date" style="width:200px;" value="<?php echo(date('d M Y', strtotime('+0 hours'))); ?>"/><br>	</p>
				<p><h2>Author (have to be an in game account name)</h2><br>
				<input maxlength="100" name="Author" id="Author" placeholder ="Author" style="width:200px;" value="<?php echo($this->GetID($_SESSION['UserUID'])); ?>"/><br>	</p>
				<div style="float: left;width: 700px;">
					<textarea id="editor1" name="editor1" rows="10">
						<?php echo($this->NewText); ?>
					</textarea>
				</div>
				<script>
					CKEDITOR.replace( 'editor1' );
				</script>
					<span><input style=" margin: 10px 300px 0 300px;" type="submit" value="Send" ></span>
			</form>
			</center>
		<?php
		}

	}
}

?>