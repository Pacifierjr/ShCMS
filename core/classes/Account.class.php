<style>
    a:hover{
        color:brown;
    }
</style>
<?php 

class Account { 
    public $User;
    public $query;
    public $res;
    
    public function __construct($user) { 
        global $conn;
        if(is_numeric($user)){
                $this->query = $conn->prepare('SELECT * FROM PS_UserData.dbo.Users_Master WHERE UserUID = ?');
                $this->query->bindParam(1,$user,PDO::PARAM_INT);
                $this->query->execute();
                $this->User = $this->query->fetch(PDO::FETCH_BOTH);
                if($this->User["MainCharID"] == 0){
                    $this->query = $conn->prepare('SELECT TOP 1 CharID FROM PS_GameData.dbo.Chars WHERE UserUID = ? AND Del = 0 ORDER BY [Level] DESC');
                    $this->query->bindParam(1,$this->User["UserUID"],PDO::PARAM_INT);
                    $this->query->execute();
                    $this->res = $this->query->fetch(PDO::FETCH_BOTH);
                    
                    $this->query = $conn->prepare('UPDATE PS_UserData.dbo.Users_Master SET MainCharID = ? WHERE UserUID = ?');
                    $this->query->bindParam(1,$this->res["CharID"],PDO::PARAM_INT);
                    $this->query->bindParam(2,$this->User["UserUID"],PDO::PARAM_INT);
                    $this->query->execute();
                    
                }
                return $this->User;
        }
        else{
                $this->query = $conn->prepare('SELECT * FROM PS_UserData.dbo.Users_Master WHERE UserID = ?');
                $this->query->bindParam(1,$user,PDO::PARAM_STR);
                $this->query->execute();
                $this->User = $this->query->fetch(PDO::FETCH_BOTH);
                if($this->User["MainCharID"] == null){
                        $this->query = $conn->prepare('SELECT TOP 1 CharID FROM PS_GameData.dbo.Chars WHERE UserUID = ? AND Del = 0 ORDER BY [Level] DESC');
                        $this->query->bindParam(1,$this->User["UserUID"],PDO::PARAM_INT);
                        $this->query->execute();
                        $this->res = $this->query->fetch(PDO::FETCH_BOTH);

                        $this->query = $conn->prepare('UPDATE PS_UserData.dbo.Users_Master SET MainCharID = ? WHERE UserUID = ?');
                        $this->query->bindParam(1,$this->res["CharID"],PDO::PARAM_INT);
                        $this->query->bindParam(2,$this->User["UserUID"],PDO::PARAM_INT);
                        $this->query->execute();

                    }
                return $this->User;
        }
    } 
    public function Get($key){
        return @$this->User[$key];
    }
    public function IsAdm() { 
        if($this->Exists()){
              if($this->User["Status"] == 16){
            return true;
            }else{
                return false;
            }
        }else{
                return false;
            }
    } 
    public function GetFaction($display = null){
        global $conn;
        $this->query = $conn->prepare("SELECT Country FROM PS_GameData.dbo.UserMaxGrow WHERE UserUID = ?");
        $this->query->bindParam(1,$this->User["UserUID"],PDO::PARAM_INT);
        $this->query->execute();
        $this->res = $this->query->fetch(PDO::FETCH_BOTH);
        if($this->res["Country"] == 0){
            if($display == "full"){
                return "Alliance of Light";
                
            }else{
                return "AoL";

            }
        }elseif($this->res["Country"] == 1){
            if($display == "full"){
                return "Union of Fury";
                
            }else{
                return "UoF";

            }
        }else{
            return "None";
        }
        
    }
    public function GetCountry($display = null){
        global $conn;
        $this->query = $conn->prepare("SELECT Country FROM PS_GameData.dbo.UserMaxGrow WHERE UserUID = ?");
        $this->query->bindParam(1,$this->User["UserUID"],PDO::PARAM_INT);
        $this->query->execute();
        $this->res = $this->query->fetch(PDO::FETCH_BOTH);
        if($this->res["Country"] == 0){
            if($display == "full"){
                return "Alliance of Light";
                
            }else{
                return "0";

            }
        }elseif($this->res["Country"] == 1){
            if($display == "full"){
                return "Union of Fury";
                
            }else{
                return "1";

            }
        }else{
            return "None";
        }
        
    }
    public function IsLoggedIn() {
        if(isset($_SESSION["UserUID"])){
            if(isset($this->User["UserUID"])){
                if($this->User["UserUID"] == $_SESSION["UserUID"]){
                    return true;
                }else{
                    return false;
                }
            }else{
                    return false;
                }
        }else{
                    return false;
                }
    }
    public function Exists(){
        global $conn;
        $this->query = $conn->prepare("SELECT COUNT(*) AS Counter FROM PS_UserData.dbo.Users_Master WHERE UserUID = ?;");
        $this->query->bindParam(1,$this->User["UserUID"],PDO::PARAM_INT);
        $this->query->execute();
        $this->res = $this->query->fetch(PDO::FETCH_BOTH);
        if($this->res["Counter"] != 1){
            return false;
        }else{
            return true;
        }
    }
    public function ThreadsCnt(){
        global $conn;
        $this->query = $conn->prepare("SELECT COUNT(*) AS Counter FROM Website.dbo.ForumThreads WHERE IsFirstPost = 1 AND PosterUID = ?");
        $this->query->bindParam(1,$this->User["UserUID"],PDO::PARAM_INT);
        $this->query->execute();
        $this->res = $this->query->fetch(PDO::FETCH_BOTH);
        return $this->res["Counter"];
        
    }
    public function PostsCnt(){
        global $conn;
        $this->query = $conn->prepare("SELECT COUNT(*) AS Counter FROM Website.dbo.ForumThreads WHERE IsFirstPost = 0 AND PosterUID = ?");
        $this->query->bindParam(1,$this->User["UserUID"],PDO::PARAM_INT);
        $this->query->execute();
        $this->res = $this->query->fetch(PDO::FETCH_BOTH);
        return $this->res["Counter"];  
    }
} 

?>