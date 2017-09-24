<?php 

class Char { 
    public $Char;
    public $query;
    public $res;
    public $guild;
    public $s;
    public function __construct($char) { 
        global $conn;
        if(is_numeric($char)){
                $this->query = $conn->prepare('SELECT * FROM PS_GameData.dbo.Chars WHERE CharID = ?');
                $this->query->bindParam(1,$char,PDO::PARAM_INT);
                $this->query->execute();
                $this->Char = $this->query->fetch(PDO::FETCH_BOTH);
               
                return $this->Char;
        }
        else{
                $this->query = $conn->prepare('SELECT * FROM PS_GameData.dbo.Chars WHERE CharName = ?');
                $this->query->bindParam(1,$char,PDO::PARAM_STR);
                $this->query->execute();
                $this->Char = $this->query->fetch(PDO::FETCH_BOTH);
               
                return $this->Char;
        }
    } 
    public function Get($key){
        return ($this->Char[$key]);
    }
    public function IsOnline() {
        if($this->Char["LoginStatus"] == 1){
            return true;
        }else{
            return false;
        }
        
    }
    public function PrintIcon(){
        $this->res = new Account($this->Char["UserUID"]);
        
        $this->s = "f";
        if($this->Char["Sex"] == 0){
            $this->s = "m";
        }
        
        ?>
        <div style="background-image: url(img/icon/class/<?=$this->res->GetCountry()?>_<?=$this->Char["Job"]?>_<?=$this->s?>.png); width: 128px; height: 128px;  -webkit-border-radius: 25px; -moz-border-radius: 25px; border-radius: 25px; border: none;"></div><?

    }
    public function GetGuildID(){
        global $conn;
        $this->query = $conn->prepare('SELECT * FROM PS_GameData.dbo.GuildChars WHERE CharID = ?');
        $this->query->bindParam(1,$this->Char["CharID"],PDO::PARAM_INT);
        $this->query->execute();
        $this->res = $this->query->fetch(PDO::FETCH_BOTH);
        $this->guild = new Guild($this->res["GuildID"]);
        return $this->guild->Get("GuildID");
    }
} 

?>