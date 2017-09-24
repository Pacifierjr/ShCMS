<?php 

class Guild { 
    public $Guild;
    public $query;
    public $res;
    
    public function __construct($Guild) { 
        global $conn;
        if(is_numeric($Guild)){
                $this->query = $conn->prepare('SELECT * FROM PS_GameData.dbo.Guilds WHERE GuildID = ?');
                $this->query->bindParam(1,$Guild,PDO::PARAM_INT);
                $this->query->execute();
                $this->Guild = $this->query->fetch(PDO::FETCH_BOTH);
               
                return $this->Guild;
        }
        else{
                $this->query = $conn->prepare('SELECT * FROM PS_GameData.dbo.Guilds WHERE GuildName = ?');
                $this->query->bindParam(1,$Guild,PDO::PARAM_STR);
                $this->query->execute();
                $this->Guild = $this->query->fetch(PDO::FETCH_BOTH);
               
                return $this->Guild;
        }
    } 
    public function Get($key){
        return ($this->Guild[$key]);
    }
} 

?>