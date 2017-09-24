<?php
define('INCLUDE_CHECK', true);
if(!function_exists('playersOnline')){
	function playersOnline($variant='',$usecolors='',$customTh='',$customTd=''){
		include('db.config.php');
		$return='';
		if($customTh!==''&&$customTd==''){
			$customTd='defaultTd';
		}
		if($variant==''){
		$sql="SELECT COUNT(*) AS 'Currently Online',
			(SELECT COUNT(*) FROM PS_UserData.dbo.Users_Master WHERE [Status]=0)AS 'Active Accounts',
			(SELECT COUNT(*) FROM PS_GameData.dbo.Chars WHERE Del=0 AND CharName NOT LIKE '%]%')AS 'Living Characters',
			(SELECT COUNT(*) FROM PS_UserData.dbo.Users_Master WHERE [Status]='-5')AS ' Ban 3 D',
			(SELECT COUNT(*) FROM PS_UserData.dbo.Users_Master WHERE [Status]='-2')AS ' Ban IP',
			(SELECT COUNT(*) FROM PS_GameData.dbo.Chars WHERE LoginStatus=1 AND Family IN (0,1)) AS 'Alliance of Light',
			(SELECT COUNT(*) FROM PS_GameData.dbo.Chars WHERE LoginStatus=1 AND Family IN (2,3)) AS 'Union of Fury',
			(SELECT COUNT(*) FROM PS_GameData.dbo.Chars WHERE LoginStatus=1 AND Family IN (0,1) AND Job=0) AS Fighter, 
			(SELECT COUNT(*) FROM PS_GameData.dbo.Chars WHERE LoginStatus=1 AND Family IN (0,1) AND Job=1) AS Defender,
			(SELECT COUNT(*) FROM PS_GameData.dbo.Chars WHERE LoginStatus=1 AND Family IN (0,1) AND Job=2) AS Ranger,
			(SELECT COUNT(*) FROM PS_GameData.dbo.Chars WHERE LoginStatus=1 AND Family IN (0,1) AND Job=3) AS Archer,
			(SELECT COUNT(*) FROM PS_GameData.dbo.Chars WHERE LoginStatus=1 AND Family IN (0,1) AND Job=4) AS Mage,
			(SELECT COUNT(*) FROM PS_GameData.dbo.Chars WHERE LoginStatus=1 AND Family IN (0,1) AND Job=5) AS Priest,
			(SELECT COUNT(*) FROM PS_GameData.dbo.Chars WHERE LoginStatus=1 AND Family IN (2,3) AND Job=0) AS Warrior,
			(SELECT COUNT(*) FROM PS_GameData.dbo.Chars WHERE LoginStatus=1 AND Family IN (2,3) AND Job=1) AS Guardian,
			(SELECT COUNT(*) FROM PS_GameData.dbo.Chars WHERE LoginStatus=1 AND Family IN (2,3) AND Job=2) AS Assassin,
			(SELECT COUNT(*) FROM PS_GameData.dbo.Chars WHERE LoginStatus=1 AND Family IN (2,3) AND Job=3) AS Hunter,
			(SELECT COUNT(*) FROM PS_GameData.dbo.Chars WHERE LoginStatus=1 AND Family IN (2,3) AND Job=4) AS Pagan,
			(SELECT COUNT(*) FROM PS_GameData.dbo.Chars WHERE LoginStatus=1 AND Family IN (2,3) AND Job=5) AS Oracle 
			FROM PS_GameData.dbo.Chars WHERE LoginStatus=1";
		}else if($variant=='1'){
		$sql="SELECT COUNT(*) AS 'Alliance of Light',
			(SELECT COUNT(*) FROM PS_GameData.dbo.Chars WHERE LoginStatus=1 AND Family IN (0,1) AND Job=0) AS Fighter, 
			(SELECT COUNT(*) FROM PS_GameData.dbo.Chars WHERE LoginStatus=1 AND Family IN (0,1) AND Job=1) AS Defender,
			(SELECT COUNT(*) FROM PS_GameData.dbo.Chars WHERE LoginStatus=1 AND Family IN (0,1) AND Job=2) AS Ranger,
			(SELECT COUNT(*) FROM PS_GameData.dbo.Chars WHERE LoginStatus=1 AND Family IN (0,1) AND Job=3) AS Archer,
			(SELECT COUNT(*) FROM PS_GameData.dbo.Chars WHERE LoginStatus=1 AND Family IN (0,1) AND Job=4) AS Mage,
			(SELECT COUNT(*) FROM PS_GameData.dbo.Chars WHERE LoginStatus=1 AND Family IN (0,1) AND Job=5) AS Priest
			FROM PS_GameData.dbo.Chars WHERE LoginStatus=1 AND Family IN (0,1)";
		}else if($variant=='2'){
		$sql="SELECT COUNT(*) AS 'Union of Fury',
			(SELECT COUNT(*) FROM PS_GameData.dbo.Chars WHERE LoginStatus=1 AND Family IN (2,3) AND Job=0) AS Warrior,
			(SELECT COUNT(*) FROM PS_GameData.dbo.Chars WHERE LoginStatus=1 AND Family IN (2,3) AND Job=1) AS Guardian,
			(SELECT COUNT(*) FROM PS_GameData.dbo.Chars WHERE LoginStatus=1 AND Family IN (2,3) AND Job=2) AS Assassin,
			(SELECT COUNT(*) FROM PS_GameData.dbo.Chars WHERE LoginStatus=1 AND Family IN (2,3) AND Job=3) AS Hunter,
			(SELECT COUNT(*) FROM PS_GameData.dbo.Chars WHERE LoginStatus=1 AND Family IN (2,3) AND Job=4) AS Pagan,
			(SELECT COUNT(*) FROM PS_GameData.dbo.Chars WHERE LoginStatus=1 AND Family IN (2,3) AND Job=5) AS Oracle 
			FROM PS_GameData.dbo.Chars WHERE LoginStatus=1 AND Family IN (2,3)";
		}else if($variant=='3'){
		$sql="SELECT COUNT(*) AS 'Currently Online',
			(SELECT COUNT(*) FROM PS_UserData.dbo.Users_Master WHERE [Status]=0)AS 'Active Accounts',
			(SELECT COUNT(*) FROM PS_GameData.dbo.Chars WHERE Del=0 AND CharName NOT LIKE '%]%')AS 'Living Characters',
			(SELECT COUNT(*) FROM PS_UserData.dbo.Users_Master WHERE [Status]='-5')AS 'Banned Accounts'
			FROM PS_GameData.dbo.Chars WHERE LoginStatus=1";
		}else if($variant=='4'){
		$sql="SELECT COUNT(*) AS 'Currently Online'
			FROM PS_GameData.dbo.Chars WHERE LoginStatus=1";
		}
		$execSql=odbc_exec($dbConn,$sql);
		$results=odbc_fetch_array($execSql);
		for($i=0;$i<odbc_num_fields($execSql);$i++){
			$fieldName=odbc_field_name($execSql, ($i+1));
			$fieldValue=odbc_result($execSql,($i+1));
			if($usecolors!==''){
				if($fieldName=='Currently Online'){
					$fieldValue='<span style="color:rgba(0,253,0,1);">'.$fieldValue.'</span>';
					$fieldName='<th colspan="3" align="left" class="'.$customTh.'"><span style="font-size:22px;">'.$fieldName.'</span></th>';
				}else
				if($fieldName=='Banned Accounts'){
					$fieldName='<th colspan="2" align="left" class="'.$customTh.'">'.$fieldName.'</th>';
					$fieldValue='<span style="color:rgba(255,0,0,1);">'.$fieldValue.'</span>';
				}else
				if($fieldName=='Active Accounts'){
					$fieldName='<th colspan="2" align="left" class="'.$customTh.'">'.$fieldName.'</th>';
				}else
				if($fieldName=='Living Characters'){
					$fieldName='<th colspan="2" align="left" class="'.$customTh.'">'.$fieldName.'</th>';
				}else
				if($fieldName=='Alliance of Light'){
					if($variant>0){
						$fieldName='<th colspan="3" align="left" class="'.$customTh.'"><span style="font-size:18px;">'.$fieldName.'</span></th>';
						$fieldValue='<span style="color:rgba(0,253,0,1);">'.$fieldValue.'</span>';
					}else{
						$fieldName='<th colspan="2" align="left" class="'.$customTh.'">'.$fieldName.'</th>';
					}
				}else
				if($fieldName=='Union of Fury'){
					if($variant>0){
						$fieldName='<th colspan="3" align="left" class="'.$customTh.'"><span style="font-size:18px;">'.$fieldName.'</span></th>';
						$fieldValue='<span style="color:rgba(0,253,0,1);">'.$fieldValue.'</span>';				
					}else{
						$fieldName='<th colspan="2" align="left" class="'.$customTh.'">'.$fieldName.'</th>';
					}
				}else
				if($fieldName=='Total Accounts'){
					$fieldName='<th colspan="2" align="left" class="'.$customTh.'">'.$fieldName.'</th>';
				}else
				if($fieldName=='Total Characters'){
					$fieldName='<th colspan="2" align="left" class="'.$customTh.'">'.$fieldName.'</th>';
				}else{
					$fieldName='<th align="left" class="'.$customTh.'">'.$fieldName.'</th>';
				}
				$return.='<tr> '.$fieldName.' <td width="50" class="'.$customTd.'">'.$fieldValue.'</td></tr>';
			}else{
				$return.='<tr><th align="left" class="'.$customTh.'"> '.$fieldName.' </th><td width="50" class="'.$customTd.'">'.$fieldValue.'</td></tr>';
			}
		}
		return $return;
		odbc_free_result($execSql);
		odbc_close($dbConn);
	}
}
/*/////////  Usage  ////////////
//  playersOnline(variant(int),usecolors(true/false)
//////////////////////////*/
?>