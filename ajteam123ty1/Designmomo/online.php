<?php
$host = '127.0.0.1';
$dbuser = 'fucking';
$dbpass  = 'Glaoui123';
$database = 'PS_GameData';
//Connect to the database
$conn = @odbc_connect("Driver={SQL Server};Server=$host;Database=$database", $dbuser, $dbpass) or die("Database Connection Error!");

// check who's online
$result  = @odbc_exec($conn,"SELECT Family FROM Chars WHERE LoginStatus=1",$link);

// initialize veriables
$online = @odbc_num_rows($result);
$human = $elf = $vail = $nordein = 0;

// fill variables with data (who's online)
while($row = @odbc_fetch_array($result))
{
	if (@odbc_num_rows($result)==0) return;
          switch($row['Family'])
             {
                case 0: $human++;break;
                case 1: $elf++;break;
                case 2: $vail++;break;
                case 3: $nordein++;break;
             };
      };

    // Print number of online players
    print "<table style=\"border: 1px solid black;\">
          <tr><td colspan=2>Players online: </td><td>".$online."</td></tr>
          <tr><td>Human: </td><td>".$human."</td></tr>
          <tr><td>Elf: </td><td>".$elf."</td></tr>
          <tr><td>Vail: </td><td>".$vail."</td></tr>
          <tr><td>DeathEater: </td><td>".$nordein."</td></tr>
          </table>";

    @odbc_close($link);

?>

