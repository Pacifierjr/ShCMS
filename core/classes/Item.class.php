<?php 

class Item { 
    public $Item;
    public $query;
    public $res;
    public $guild;
    public $data;
    public $subdata;
    public $iconh;
    public $iconw;
    public $arr;
    public $iconn;
    public $nbline;
    public $nbrow;
    public $backupiconn;
    public $backuptype;
    public function __construct($Item) { 
        global $conn;
        if(is_numeric($Item)){
                $this->query = $conn->prepare('SELECT * FROM PS_GameDefs.dbo.Items WHERE ItemID = ?');
                $this->query->bindParam(1,$Item,PDO::PARAM_INT);
                $this->query->execute();
                $this->Item = $this->query->fetch(PDO::FETCH_BOTH);
               
                return $this->Item;
        }
        else{
                $this->query = $conn->prepare('SELECT * FROM PS_GameDefs.dbo.Items WHERE ItemName = ?');
                $this->query->bindParam(1,$Item,PDO::PARAM_STR);
                $this->query->execute();
                $this->Item = $this->query->fetch(PDO::FETCH_BOTH);
               
                return $this->Item;
        }
    } 
    public function Get($key){
        return ($this->Item[$key]);
    }
    public function PrintIcon(){
        global $conn;
        $this->data = $this->Get("Type");
        $this->backuptype = $this->data;
        $this->subdata = $this->Get("TypeID");
        if (strlen($this->data) < 2) {
            $this->data = "0".$this->data;
        }
        if($this->data == "30"){
            $this->data = "icon_rapis";
        }elseif($this->data == "100" || $this->data == "150" || $this->data == "120"){
            $this->data = "icon_somo2";
        }elseif($this->data == "25" || $this->data == "44" || $this->data == "42" ){
            $this->data = "icon_somo";
        }
        elseif($this->data == "121" ){
            $this->data = "icon_Wing";
        }
         list($this->iconw, $this->iconh) = getimagesize("img/icon/item/".$this->data.".png"); 
         $this->arr = array('h' =>  $this->iconh, 'w' => $this->iconw );
         $this->data = intval($this->data);
         $this->subdata = intval($this->subdata);
         $this->query = $conn->prepare("SELECT TOP 1 ItemIcon FROM PS_GameDefs.dbo.ItemsClient WHERE Type = '".$this->data."' AND TypeID = '".$this->subdata."'");
         $this->query->execute();
         $this->iconn = $this->query->fetch(PDO::FETCH_BOTH)["ItemIcon"];
         $this->backupiconn = $this->iconn;
         $this->data = $this->iconn;
        
        $this->nbline = 1;
        while($this->data > ($this->arr["w"] / 32)){
            $this->nbline++;
            $this->data = $this->data - ($this->arr["w"] / 32);
        }
        $this->data = 0.5;
        $nbrow = 0;
        
        if(is_int($this->iconn / ($this->arr["w"] / 32))){
                    $nbrow = ($this->arr["w"] / 32);
        }
        while(!is_int($this->data)){
                $nbrow = $nbrow + 1;
                $this->data = $this->iconn / ($this->arr["w"] / 32);
                $this->iconn = $this->iconn - 1;

        }
        

        
        if(strlen($this->backuptype) < 2){
            $this->backuptype = "0".$this->backuptype;
        }
        
        if($this->backuptype == "30"){
            $this->backuptype = "icon_rapis";
        }elseif($this->backuptype == "100" || $this->backuptype == "150" || $this->backuptype == "120"){
            $this->backuptype = "icon_somo2";
        }elseif($this->backuptype == "25" || $this->backuptype == "44" || $this->backuptype == "42"){
            $this->backuptype = "icon_somo";
        }
        $A = ((($nbrow-1)*32)-32);
        $B = (($this->nbline*32)-32);
        
        if($this->backupiconn == "1"){
            $A = $B = "0";
        }
        ?>

<div style="background-image: url(img/icon/item/<?=$this->backuptype?>.png);  background-position: left -<?=$A?>px top -<?=$B?>px;  width: 32px; height: 32px;"></div>
<?
    }

} 

?>