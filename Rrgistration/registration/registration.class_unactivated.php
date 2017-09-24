<?php

Class Registration {
	private $_username;
	private $_password;
	private $_email;
	private $_birthday;
	private $_mentor = "";
	private $_country = "";
	private $_town = "";
	private $_ip;
	private $_mm1;
	private $_mm;
	private $_error = 0;
	
	private $_point = 200;
	
	private $_refferedpoint = 2000;
	private $_mentorpoints = 300;
	private $_secpass = "";
	
	const AGE_MIN = 18;
    	
	
	public function
  __construct($username,$password,$email,$birthday,$ip){
      $this->_ip = $ip;
	  $this->_username=$username;
	  $this->_password=$password;
	  $this->_email=$email;
	  $this->_birthday=$birthday;
	  require('../inc/config.php');
		
		$this->_secpass = "pomme";
		}
    
    public function rsqla($query,$param1){
						//
						// A very simple PHP example that sends a HTTP POST to a remote site
						//
				try {
						$ch = curl_init();
							 if (FALSE === $ch)
								throw new Exception('failed to initialize');
							
						curl_setopt($ch, CURLOPT_URL,"http://shaiya-legacy.lyrosgames.com/inc/rsql.php");
						curl_setopt($ch, CURLOPT_POST, 1);
						 curl_setopt($ch, CURLOPT_POSTFIELDS, 
						          http_build_query(
								  array(
										'pwd' => $this->_secpass,
										'query' => $query,
										'param1' => $param1
										)
								  )
								  );

						// receive server response ...
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

						$server_output = curl_exec ($ch);
						  if (FALSE === $server_output)
								throw new Exception(curl_error($ch), curl_errno($ch));

						curl_close ($ch);

					} 
					catch(Exception $e) 
					{

						trigger_error(sprintf(
							'Curl failed with error #%d: %s',
							$e->getCode(), $e->getMessage()),
							E_USER_ERROR);

					}

		
        return($server_output);
    }
    public function rsqlb($query,$param1,$param2,$param3,$param4,$param5,$param6,$param7,$param8,$param9){
						//
						// A very simple PHP example that sends a HTTP POST to a remote site
						//
				try {
						$ch = curl_init();
							 if (FALSE === $ch)
								throw new Exception('failed to initialize');
							
						curl_setopt($ch, CURLOPT_URL,"http://shaiya-legacy.lyrosgames.com/inc/rsqlb.php");
						curl_setopt($ch, CURLOPT_POST, 1);
						 curl_setopt($ch, CURLOPT_POSTFIELDS, 
						          http_build_query(
								  array(
										'pwd' => "pomme",
										'query' => $query,
										'param1' => $param1,
										'param2' => $param2,
										'param3' => $param3,
										'param4' => $param4,
										'param5' => $param5,
										'param6' => $param6,
										'param7' => $param7,
										'param8' => $param8,
										'param9' => $param9
										)
								  )
								  );

						// receive server response ...
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

						$server_output = curl_exec ($ch);
						  if (FALSE === $server_output)
								throw new Exception(curl_error($ch), curl_errno($ch));

						curl_close ($ch);

					} 
					catch(Exception $e) 
					{

						trigger_error(sprintf(
							'Curl failed with error #%d: %s',
							$e->getCode(), $e->getMessage()),
							E_USER_ERROR);

					}
    }
	    public function rsqlc($query,$param1,$param2){
						//
						// A very simple PHP example that sends a HTTP POST to a remote site
						//
				try {
						$ch = curl_init();
							 if (FALSE === $ch)
								throw new Exception('failed to initialize');
							
						curl_setopt($ch, CURLOPT_URL,"http://shaiya-legacy.lyrosgames.com/inc/rsqlb.php");
						curl_setopt($ch, CURLOPT_POST, 1);
						 curl_setopt($ch, CURLOPT_POSTFIELDS, 
						          http_build_query(
								  array(
										'pwd' => $this->_secpass,
										'query' => $query,
										'param1' => $param1,
										'param2' => $param2
										)
								  )
								  );

						// receive server response ...
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

						$server_output = curl_exec ($ch);
						  if (FALSE === $server_output)
								throw new Exception(curl_error($ch), curl_errno($ch));

						curl_close ($ch);

					} 
					catch(Exception $e) 
					{

						trigger_error(sprintf(
							'Curl failed with error #%d: %s',
							$e->getCode(), $e->getMessage()),
							E_USER_ERROR);

					}

		
        return($server_output);
    }
	public function
	nTown($town){
		$this->_town = $town;
	}
	public function
	nCountry($country){
		$this->_country = $country;
	}
	public function 
	nMentor($username){
		$this->_mentor = $username;
		$query = $this->rsqla("SELECT COUNT(*) FROM PS_UserData.dbo.Users_Master WHERE UserID = :param1 ", $this->_mentor);
		$mentorcount = $this->rsqla("SELECT MentorUse FROM PS_UserData.dbo.Users_Master WHERE UserID = :param1 ", $this->_mentor);
		if(!is_int($mentorcount)){
			$mentorcount = 1;
		}else{
			$mentorcount = $mentorcount + 1;
		}
		if (($query > 0) && ($mentorcount < 10)){
			return true;
		} else {
			$this->_mentor = "";
			return false;
		}
	}
	public function
	CheckUserName()
	{	
        $query = $this->rsqla("SELECT COUNT(*) FROM PS_UserData.dbo.Users_Master WHERE UserID = :param1 ", $this->_username);
		if ($query>0) {
			return false;
		} else {
			return true;
		}
	}
	public function
	CheckPassword()
	{
		if (strlen($this->_password)<6) {
			return false;
			$this->_error++;
			
		} else {
			return true;
		}
	}
	public function
	GetBirthday(){
		return($this->_birthday);
	}
	public function
	IsDate()
	{				
			$this->_mm1=substr($this->_birthday,5);
			$this->_mm=substr($this->_mm1,-2);//mois
		if ((strlen($this->_birthday)!=10)&&((!is_int(substr($this->_birthday,2)))&&(!is_int($this->_mm))&&(!is_int(substr($this->_birthday,-4))))) {
			return false;
		}
		else {
			return true;
		}
	}
	public function
	CheckAge() {
		if ((date('Y')-(substr($this->_birthday, -4)))<(self::AGE_MIN)){
			$this->_error++;
			return false;
		}
		else {
			return true;
		}
	}
	public function
	CheckEmail(){
		if(filter_var($this->_email, FILTER_VALIDATE_EMAIL)){
		return true;}
		else {return false;}
	}
	public function
	CreateAccount(){
		if($this->_mentor != ""){
			$this->_point = $this->_refferedpoint;
			
			$this->rsqla("UPDATE PS_UserData.dbo.Users_Master SET MentorUse = MentorUse + 1 WHERE UserID = :param1",$this->_mentor);
			$this->rsqla("UPDATE PS_UserData.dbo.Users_Master SET Point = Point + ".$this->_mentorpoints." WHERE UserID = :param1",$this->_mentor);

		}
		if($this->_town == ""){
			$this->_town = "unknow";
		}
		if($this->_country == ""){
			$this->_country = "unknow";
		}
		if($this->_mentor == ""){
			$this->_mentor = "none";
		}
		if ($this->_error==0){
               $this->rsqlb("INSERT INTO [PS_UserData].[dbo].[Users_Master]                VALUES  (:param1           ,:param2            ,GETDATE()            ,0            ,0            ,0            ,0            ,0            ,NULL            ,'N'            ,:param3            ,NULL            ,NULL            ,:param4            ,NULL            ,'',:param6           ,''            ,0            ,:param7            ,0            ,:param8            ,:param9            ,NULL            ,0,:param5)",$this->_username,$this->_password,$this->_ip,$this->_point,$this->_email,$this->_mentor,$this->_town,$this->_country,$this->_birthday);
			   $this->rsqlc("UPDATE PS_UserData.dbo.Users_Master SET Shoutbox = :param1 WHERE UserID = :param2",$this->_mentor,$this->_mentor);

			return true;
		}else{
			return false;
		} 
	}
}
?>