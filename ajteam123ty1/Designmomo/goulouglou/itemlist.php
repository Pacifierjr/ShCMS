<?php
// Database configuration parameters
include "db_connect.php";
//Form Data
$ip = $_SERVER['REMOTE_ADDR'];
$count  = 1;
$rank   = 0;
$cimg   = 0;
$kdr    = 0;
$char  = '???';
$query  = ('SELECT * FROM PS_GameDefs.dbo.Items WHERE ItemName NOT LIKE  "%"+\'' . $char . '\'+"%"  ORDER BY ItemName');
$result = mssql_query($query);
echo " /getitem useing Type space TypeID space Count you want.";
echo "<html><head><STYLE TYPE=\"text/css\">
<!--
td { background:url(image.png) no-repeat; }
td.i0{ background-position: 0 0; width: 28px; height: 16px; } 
td.i1{ background-position: 0 -26px; width: 28px; height: 16px; } 
td.i2{ background-position: 0 -52px; width: 28px; height: 16px; } 
td.i3{ background-position: 0 -78px; width: 29px; height: 16px; } 
td.i4{ background-position: 0 -104px; width: 29px; height: 15px; } 
td.i5{ background-position: 0 -129px; width: 28px; height: 18px; } 
td.i6{ background-position: 0 -157px; width: 30px; height: 17px; } 
td.i7{ background-position: 0 -184px; width: 29px; height: 17px; } 
td.i8{ background-position: 0 -211px; width: 28px; height: 16px; } 
td.i9{ background-position: 0 -237px; width: 28px; height: 18px; } 
td.i10{ background-position: 0 -265px; width: 29px; height: 18px; } 
td.i11{ background-position: 0 -293px; width: 29px; height: 24px; } 
td.i12{ background-position: 0 -327px; width: 29px; height: 18px; } 
td.i13{ background-position: 0 -355px; width: 29px; height: 18px; } 
td.i14{ background-position: 0 -383px; width: 29px; height: 18px; } 
td.i15{ background-position: 0 -411px; width: 29px; height: 18px; } 
td.i16{ background-position: 0 -439px; width: 29px; height: 18px; } 
td.i17{ background-position: 0 -467px; width: 24px; height: 24px; } 
td.i18{ background-position: 0 -501px; width: 24px; height: 24px; } 
td.i19{ background-position: 0 -535px; width: 24px; height: 24px; } 
td.i20{ background-position: 0 -569px; width: 24px; height: 24px; } 
td.i21{ background-position: 0 -603px; width: 24px; height: 24px; } 
td.i22{ background-position: 0 -637px; width: 24px; height: 24px; } 
</STYLE>
<title>Item List</title></head>";
echo "<body><center>
      <table cellspacing=10 cellpadding=0 border=0 bgcolor=\"black\">
      <td style=\"color:#FC9700\" bgcolor=\"black\">ItemName</td>
	  <td style=\"color:#FC9700\" bgcolor=\"black\">Type</td>
	  <td style=\"color:#FC9700\" bgcolor=\"black\">TypeID</td>
";
while ($row = mssql_fetch_array($result)) {
	echo "<tr style=\"color:white\">";
	echo "<td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . $row[4] . "</td>";
	echo "</tr>";
	$count++;
}
echo "</table>";
echo "</html>";
?> 