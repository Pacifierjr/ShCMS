<?php 

class Section { 
    public $Section;
    public $query;
    public $res;
    
    public function __construct($Section) { 
        global $conn;
        if(is_numeric($Section)){
                $this->query = $conn->prepare('SELECT * FROM Website.dbo.ForumSections WHERE ID = ?');
                $this->query->bindParam(1,$Section,PDO::PARAM_INT);
                $this->query->execute();
                $this->Section = $this->query->fetch(PDO::FETCH_BOTH);
               
                return $this->Section;
        }
        else{
                $this->query = $conn->prepare('SELECT * FROM Website.dbo.ForumSections WHERE Title = ?');
                $this->query->bindParam(1,$Section,PDO::PARAM_INT);
                $this->query->execute();
                $this->Section = $this->query->fetch(PDO::FETCH_BOTH);
               
                return $this->Section;
        }
    } 
    public function Get($key){
        return ($this->Section[$key]);
    }
} 

?>