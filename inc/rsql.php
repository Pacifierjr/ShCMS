<?php
$SqlUser = "sa";
$SqlPass = "123456";
$SqlIP = "127.0.0.1";

$secretpassword = "pomme";
	try {

			if(isset($_POST["pwd"]) || (isset($_POST["query"]))){
				if(strcmp($_POST["pwd"], $secretpassword) === 0){
					
					$param1 = $param2 = $param3 = $param4 = $param5 = $param6 =  $param7 = $param8 = $param9 = $param10 = "";
				
					$db="PS_UserData";
					if(isset($_POST["db"])){
						$db = $_POST["db"];
					}
						if(isset($_POST["param1"])){
						$param1 = $_POST["param1"];
						}
						if(isset($_POST["param2"])){
						$param2 = $_POST["param2"];
						}
						if(isset($_POST["param3"])){
						$param3 = $_POST["param3"];
						}
						if(isset($_POST["param4"])){
						$param4 = $_POST["param4"];
						}
						if(isset($_POST["param5"])){
						$param5 = $_POST["param5"];
						}
						if(isset($_POST["param6"])){
						$param6 = $_POST["param6"];
						}
						if(isset($_POST["param7"])){
						$param7 = $_POST["param7"];
						}
						if(isset($_POST["param8"])){
						$param8 = $_POST["param8"];
						}
						if(isset($_POST["param9"])){
						$param9 = $_POST["param9"];
						}
						if(isset($_POST["param10"])){
						$param10 = $_POST["param10"];
						}
					
					$dbh = new PDO("sqlsrv:Server=".$SqlIP.";Database=".$db, $SqlUser, $SqlPass);
					
						  $sql = $_POST["query"];
						  try {
							$stmt = $dbh->prepare($sql);
							  
								if($param1 != ""){
									$stmt->bindParam(':param1', $param1, PDO::PARAM_STR);
								}
								if($param2 != ""){
									$stmt->bindParam(':param2', $param2, PDO::PARAM_STR);
								}
								if($param3 != ""){
									$stmt->bindParam(':param3', $param3, PDO::PARAM_STR);
								}
								if($param4 != ""){
									$stmt->bindParam(':param4', $param4, PDO::PARAM_STR);
								}
								if($param5 != ""){
									$stmt->bindParam(':param5', $param5, PDO::PARAM_STR);
								}
								if($param6 != ""){
									$stmt->bindParam(':param6', $param6, PDO::PARAM_STR);
								}
								if($param7 != ""){
									$stmt->bindParam(':param7', $param7, PDO::PARAM_STR);
								}
								if($param8 != ""){
									$stmt->bindParam(':param8', $param8, PDO::PARAM_STR);
								}
								if($param9 != ""){
									$stmt->bindParam(':param9', $param9, PDO::PARAM_STR);
								}
								if($param10 != ""){
									$stmt->bindParam(':param10', $param10, PDO::PARAM_STR);
								}
							  
							$stmt->execute();
							  
							while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
							  echo($row[0]);
							}
							$stmt = null;
						  }
						  catch (PDOException $e) {
							print $e->getMessage();
						  }
						  

				}else{
					echo('go away');
				}
			} else{
				echo('nothing');
			}
	}catch(Exception $e) 
					{

						trigger_error(sprintf(
							'ERROR #%d: %s',
							$e->getCode(), $e->getMessage()),
							E_USER_ERROR);

					}
?>