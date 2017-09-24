<?php
if (basename($_SERVER["PHP_SELF"]) == "ranking.php") {
        exit ("<script>location.href=\"index.html\"</script>");
}
?>
<div class="box_two">
 <div class="box_two_title">sa Damage Ranking</div>
 <div class="movie-half">
			<div class="container">
             <div id="usual1" class="usual"> 
  <ul> 
    <li><a href="#tab1" class="selected">Normal</a></li> 
    <li><a href="#tab2">Hard</a></li> 
    <li><a href="#tab3">Ultimate</a></li> 
  </ul> 
  <div id="tab1" style="display: block; ">
  <center>
  <ul> 
    <li><a href="#aol" class="selected">Alliance of Light</a></li> 
    <li><a href="#uof">Union of Fury</a></li> 
  </ul></center>
  <div id="aol" style="display: block; background:transparent;">
   <table width="100%" class="game-ranking" style="">
	<tbody>
	<tr>
    <th width="20">Rank</th>
    <th width="180">Personage</th>
    <th>Classe</th>
    <th>Level</th>
    <th>Kills</th>

    </tr>
    <?php 
	$sql->connectar();	
	$Qtop = @toprank;
	$check = $sql->query("SELECT TOP $Qtop * FROM PS_GameData.dbo.Chars WHERE Grow=1 and Family <= 1 ORDER BY Level DESC, K1 DESC");
	$query = $sql->num($check);
	if ($query == 0) {
		echo "<td height=\"25px\" colspan=\"6\" align=\"center\">Nenhum personagem encontrado</td>";
	}else {
		$Rank = 1;
		while ($dados = $sql->fetch_array($check)) {
		switch ($dados['Job']) {
			case 0: $job = "Fighter"; break;
			case 1: $job = "Defensor"; break;
			case 2: $job = "Ranger"; break;
			case 3: $job = "Archer"; break;
			case 4: $job = "Mage"; break;
			case 5: $job = "Priest"; break;
		}
	?>
	<tr height="25px" >
    <td align="center"><?=$Rank?></td>
    <td align="center"><? echo utf8_encode($dados['CharName'])?></td>
    <td align="center"><? echo utf8_encode($job)?></td>
    <td align="center"><? echo number_format($dados['Level'])?></td>
    <td align="center"><? echo number_format($dados['K1'])?></td>
    <td align="center"></td>
    </tr>
    <? $Rank++;}}; ?>
	</tbody>
</table>
  </div>
  <div id="uof" style="display: block; background:transparent;">
   <table width="100%" class="game-ranking" style="">
	<tbody>
	<tr>
    <th width="20">Rank</th>
    <th width="180px">Personagem</th>
    <th>Classe</th>
    <th>Level</th>
    <th>Kills</th>

    </tr><tr>
    </tr>
    <?php 
	$sql->connectar();
	$Qtop = @toprank;
	$check = $sql->query("SELECT TOP $Qtop * FROM PS_GameData.dbo.Chars WHERE Grow=1 and Family >= 2 ORDER BY Level DESC, K1 DESC");
	$query = $sql->num($check);
	if ($query == 0) {
		echo "<td height=\"25px\" colspan=\"6\" align=\"center\">Nenhum personagem encontrado</td>";
	}else {
		$Rank = 1;
		while ($dados = $sql->fetch_array($check)) {
		switch ($dados['Job']) {
			case 0: $job = "Warrior"; break;
			case 1: $job = "Guardian"; break;
			case 2: $job = "Assasin"; break;
			case 3: $job = "Hunter"; break;
			case 4: $job = "Pagan"; break;
			case 5: $job = "Oracle"; break;
		}
	?>
	<tr height="25px" >
    <td align="center"><?=$Rank?></td>
    <td align="center"><? echo utf8_encode($dados['CharName'])?></td>
    <td align="center"><? echo utf8_encode($job)?></td>
    <td align="center"><? echo number_format($dados['Level'])?></td>
    <td align="center"><? echo number_format($dados['K1'])?></td>
    <td align="center"></td>
    </tr>
    <? $Rank++;}}; ?>
	</tbody>
</table>
  </div>
	</div> 
  <div id="tab2" style="display: none; ">
  <center>
  <ul> 
    <li><a href="#aol2" class="selected">Alliance of Light</a></li> 
    <li><a href="#uof2">Union of Fury</a></li> 
  </ul></center>
  <div id="aol2" style="display: block; background:transparent;">
   <table width="100%" class="game-ranking" style="">
	<tbody>
	<tr>
    <th width="20">Rank</th>
    <th width="180px">Personagem</th>
    <th>Classe</th>
    <th>Level</th>
    <th>Kills</th>

    </tr><tr>
    </tr>
    <?php 
	$sql->connectar();	
	$Qtop = @toprank;
	$check = $sql->query("SELECT TOP $Qtop * FROM PS_GameData.dbo.Chars WHERE Grow=2 and Family <= 1 ORDER BY Level DESC, K1 DESC");
	$query = $sql->num($check);
	if ($query == 0) {
		echo "<td height=\"25px\" colspan=\"6\" align=\"center\">Nenhum personagem encontrado</td>";
	}else {
		$Rank = 1;
		while ($dados = $sql->fetch_array($check)) {
		switch ($dados['Job']) {
			case 0: $job = "Fighter"; break;
			case 1: $job = "Defensor"; break;
			case 2: $job = "Ranger"; break;
			case 3: $job = "Archer"; break;
			case 4: $job = "Mage"; break;
			case 5: $job = "Priest"; break;
		}
	?>
	<tr height="25px" >
    <td align="center"><?=$Rank?></td>
    <td align="center"><? echo utf8_encode($dados['CharName'])?></td>
    <td align="center"><? echo utf8_encode($job)?></td>
    <td align="center"><? echo number_format($dados['Level'])?></td>
    <td align="center"><? echo number_format($dados['K1'])?></td>
    <td align="center"></td>
    </tr>
    <? $Rank++;}}; ?>
	</tbody>
</table>
  </div>
  <div id="uof2" style="display: block; background:transparent;">
   <table width="100%" class="game-ranking" style="">
	<tbody>
	<tr>
    <th width="20">Rank</th>
    <th width="180px">Personagem</th>
    <th>Classe</th>
    <th>Level</th>
    <th>Kills</th>

    </tr><tr>
    </tr>
    <?php 
	$sql->connectar();
	$Qtop = @toprank;
	$check = $sql->query("SELECT TOP $Qtop * FROM PS_GameData.dbo.Chars WHERE Grow=2 and Family >= 2 ORDER BY Level DESC, K1 DESC");
	$query = $sql->num($check);
	if ($query == 0) {
		echo "<td height=\"25px\" colspan=\"6\" align=\"center\">Nenhum personagem encontrado</td>";
	}else {
		$Rank = 1;
		while ($dados = $sql->fetch_array($check)) {
		switch ($dados['Job']) {
			case 0: $job = "Warrior"; break;
			case 1: $job = "Guardian"; break;
			case 2: $job = "Assasin"; break;
			case 3: $job = "Hunter"; break;
			case 4: $job = "Pagan"; break;
			case 5: $job = "Oracle"; break;
		}
	?>
	<tr height="25px" >
    <td align="center"><?=$Rank?></td>
    <td align="center"><? echo utf8_encode($dados['CharName'])?></td>
    <td align="center"><? echo utf8_encode($job)?></td>
    <td align="center"><? echo number_format($dados['Level'])?></td>
    <td align="center"><? echo number_format($dados['K1'])?></td>
    <td align="center"></td>
    </tr>
    <? $Rank++;}}; ?>
	</tbody>
</table>
  </div>
  </div> 
  <div id="tab3" style="display: none; ">
  <center>
  <ul> 
    <li><a href="#aol3" class="selected">Alliance of Light</a></li> 
    <li><a href="#uof3">Union of Fury</a></li> 
  </ul></center>
  <div id="aol3" style="display: block; background:transparent;">
   <table width="100%" class="game-ranking" style="">
	<tbody>
	<tr>
    <th width="20">Rank</th>
    <th width="180px">Personagem</th>
    <th>Classe</th>
    <th>Level</th>
    <th>Kills</th>

    </tr><tr>
    </tr>
    <?php 
	$sql->connectar();	
	$Qtop = @toprank;
	$check = $sql->query("SELECT TOP $Qtop * FROM PS_GameData.dbo.Chars WHERE Grow=3 and Family <= 1 ORDER BY Level DESC, K1 DESC");
	$query = $sql->num($check);
	if ($query == 0) {
		echo "<td height=\"25px\" colspan=\"6\" align=\"center\">Nenhum personagem encontrado</td>";
	}else {
		$Rank = 1;
		while ($dados = $sql->fetch_array($check)) {
		switch ($dados['Job']) {
			case 0: $job = "Fighter"; break;
			case 1: $job = "Defensor"; break;
			case 2: $job = "Ranger"; break;
			case 3: $job = "Archer"; break;
			case 4: $job = "Mage"; break;
			case 5: $job = "Priest"; break;
		}
	?>
	<tr height="25px" >
    <td align="center"><?=$Rank?></td>
    <td align="center"><? echo utf8_encode($dados['CharName'])?></td>
    <td align="center"><? echo utf8_encode($job)?></td>
    <td align="center"><? echo number_format($dados['Level'])?></td>
    <td align="center"><? echo number_format($dados['K1'])?></td>
    <td align="center"></td>
    </tr>
    <? $Rank++;}}; ?>
	</tbody>
</table>
  </div>
  <div id="uof3" style="display: block; background:transparent;">
   <table width="100%" class="game-ranking" style="">
	<tbody>
	<tr>
    <th width="20">Rank</th>
    <th width="180px">Personagem</th>
    <th>Classe</th>
    <th>Level</th>
    <th>Kills</th>

    </tr><tr>
    </tr>
    <?php 
	$sql->connectar();
	$Qtop = @toprank;
	$check = $sql->query("SELECT TOP $Qtop * FROM PS_GameData.dbo.Chars WHERE Grow=3 and Family >= 2 ORDER BY Level DESC, K1 DESC");
	$query = $sql->num($check);
	if ($query == 0) {
		echo "<td height=\"25px\" colspan=\"6\" align=\"center\">Nenhum personagem encontrado</td>";
	}else {
		$Rank = 1;
		while ($dados = $sql->fetch_array($check)) {
		switch ($dados['Job']) {
			case 0: $job = "Warrior"; break;
			case 1: $job = "Guardian"; break;
			case 2: $job = "Assasin"; break;
			case 3: $job = "Hunter"; break;
			case 4: $job = "Pagan"; break;
			case 5: $job = "Oracle"; break;
		}
	?>
	<tr height="25px" >
    <td align="center"><?=$Rank?></td>
    <td align="center"><? echo utf8_encode($dados['CharName'])?></td>
    <td align="center"><? echo utf8_encode($job)?></td>
    <td align="center"><? echo number_format($dados['Level'])?></td>
    <td align="center"><? echo number_format($dados['K1'])?></td>
    <td align="center"></td>
    </tr>
    <? $Rank++;}}; ?>
	</tbody>
</table>
  </div>
  </div> 
</div> 
 
<script type="text/javascript"> 
  $("#usual1 ul").idTabs(); 
</script>
	</div>
  </div>
 </div>