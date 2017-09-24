<?php 

class Thread { 
    public $Thread;
    public $query;
    public $res;
    public $usr;
    public function __construct($Thread) { 
        global $conn;
        if(is_numeric($Thread)){
                $this->query = $conn->prepare('SELECT * FROM Website.dbo.ForumThreads WHERE ID = ?');
                $this->query->bindParam(1,$Thread,PDO::PARAM_INT);
                $this->query->execute();
                $this->Thread = $this->query->fetch(PDO::FETCH_BOTH);
               
                return $this->Thread;
        }
        else{
                $this->query = $conn->prepare('SELECT * FROM Website.dbo.ForumThreads WHERE Title = ?');
                $this->query->bindParam(1,$Thread,PDO::PARAM_INT);
                $this->query->execute();
                $this->Thread = $this->query->fetch(PDO::FETCH_BOTH);
               
                return $this->Thread;
        }
    } 
    public function Get($key){
        return ($this->Thread[$key]);
    }
    
    public function SeenByUsr($user){
        global $conn;

        $this->usr = new Account($user);
        $this->usr = $this->usr->Get("UserUID");
        $this->query = $conn->prepare("SELECT COUNT(*) AS Counter  FROM Website.dbo.ForumViews WHERE UserUID = ? AND ThreadID = ?;");
        $this->query->bindParam(1,$this->usr,PDO::PARAM_STR);
        $this->query->bindParam(2,$this->Thread["ID"],PDO::PARAM_INT);
        $this->query->execute();
        $this->res = $this->query->fetch(PDO::FETCH_BOTH);
        if($this->res['Counter'] > 0){
            return true;
        }else{
            return false;
        }
        
    }
 public function SeenByIp($ip){
        global $conn;

        
        $this->query = $conn->prepare("SELECT COUNT(*) AS Counter  FROM Website.dbo.ForumViews WHERE UserIP = ? AND ThreadID = ?;");
        $this->query->bindParam(1,$ip,PDO::PARAM_STR);
        $this->query->bindParam(2,$this->Thread["ID"],PDO::PARAM_INT);
        $this->query->execute();
        $this->res = $this->query->fetch(PDO::FETCH_BOTH);
        if($this->res['Counter'] > 0){
            return true;
        }else{
            return false;
        }
        
    }
} 

?>