<?
//	Connect to MSSQL server with SQL credentials using PDO

	try {
		//$conn  = new PDO("sqlsrv:Server=".$sqlHost.";Database=".$database, $sqlUser, $sqlPass);
		$conn = new PDO("sqlsrv:Server=".$sqlHost.";Database=".$database.";",$sqlUser,$sqlPass);
	}
	catch (PDOException $e){
    	die($e->getMessage());
	}
?>
