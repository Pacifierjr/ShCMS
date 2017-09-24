<?php
//$PowerAuth_password = "YOUR PASSWORD";
//include "PowerAuth.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="style.css">
        <title> Shaiya Admin control panel</title>
    <style type="text/css">
    body,td,th,div {
	color: #C524BD;
}
body {
	background-color: #9FF781;
	color: #49C524;
}
    </style>
    </head>
    <body>
	<font face=\"Trebuchet MS\">
    <table align="center" id="main">
    <thead>
    <tr id="panel_info">
    <td colspan="2"><p align="center"><i></i><center><iframe  name="BLESS" src="http://opalus.ddns.net/diamon/glawitomtom/Kastos/momo/Bless_mssql/Bless_mssql/bless.php" scrolling="no" width="870" frameborder="0" height="64"></iframe></center></p></td></tr>
    </thead>
    <tbody>
    <tr>
    <td id="lewy_panel">
	<div align="center">
    
	<iframe  name="BLESS" src="http://opalus.ddns.net/online/online1.php" scrolling="no" width="200" frameborder="0" height="200"></iframe>
	<div class="naglowek">OUTILS PRINCIPAUX</div>
			<p><a href="panel.php?action=Statistic">Stat Du Serveur</a></p>
			<p><a href="panel.php?action=Player_login_status">Joueurs En Ligne</a></p>
			<p><a href="panel.php?action=Restore_UM_single">RES UM d'ici</a></p>
			<p><a href="panel.php?action=FactionChange">Faction Change avec skin Dark ou Light</a></p>
			<p><a href="panel.php?action=apbonus">D.P. par nom de compte</a></p>
            <p><a href="panel.php?action=dpbonus">D.P. par nom de perso</a></p>
			<p><a href="panel.php?action=apdeleat">Enlever les AP au joueur</a></p>
			<p><a href="panel.php?action=boss">BOSS RECORD</a></p>
			<p><a href="panel.php?action=top_player">Top Player</a></p>
			<p><a href="panel.php?action=global_chat">Love Storie</a></p>
			<p><a href="panel.php?action=player_chatsearch">Player Chat Search par Pseudo </a></p>
			<p><a href="panel.php?action=drop">Item Drop Search y a pas besoin </a></p>
            <p><a href="panel.php?action=admin">Create GM+ Account </a></p>
		<div class="naglowek">OUTILS POUR MODIF DES TRUC SUR LES JOUEURS</div>
			<p><a href="panel.php?action=lotto">Random Lottery</a></p>
			<p><a href="panel.php?action=lotto_winners">Random Lottery Winners</a></p>
			<p><a href="panel.php?action=player_search_by_char">trouver tout les perso d'un compte avec le nom d'un perso</a></p>
			<p><a href="panel.php?action=player_search_by_Acc">trouver le compte avec le nom du perso</a></p>
			<p><a href="panel.php?action=player_ip_search">Tous les compte avec la meme IP par le nom du perso</a></p>
			<p><a href="panel.php?action=IP_Search">IP Search</a></p>
			<p><a href="panel.php?action=toon">Trouver un joueur qui est mort ou delete ou rename</a></p>
			<p><a href="panel.php?action=player_edit">Edit Player</a></p>
			<p><a href="panel.php?action=item_edit">Item Edits sur le perso</a></p>
			<p><a href="panel.php?action=item_delete">Item Deletion sur le perso</a></p>
			<p><a href="panel.php?action=W.H.item_edit">W.H.Items Edit dans entrepot</a></p>
			<p><a href="panel.php?action=W.H.item_delete">W.H.Items Deletion dans entrepot</a></p>
			<p><a href="panel.php?action=acc_jail">Compte en Prison</a></p>
			<p><a href="panel.php?action=acc_unjail"> liste des compte en Prison</a></p>
			<p><a href="panel.php?action=ban_search">liste des compte Bani</a></p>
			<p><a href="panel.php?action=acc_ban">Banir un compte</a></p>
			<p><a href="panel.php?action=unacc_ban">Debanir un compte</a></p>
		<div class="naglowek">AUTRE OUTILS</div>        
			<p><a href="panel.php?action=ItemList1">Item Search by Catagory</a></p>
			<p><a href="panel.php?action=ItemList">Item List</a></p>
			<p><a href="panel.php?action=MobList">Mob List</a></p>
			<p><a href="panel.php?action=guild_Disband">Dissoudre une guilde</a></p>
			<p><a href="panel.php?action=guild_name_change">Renomer une guilde en ce qu'on veux</a></p>
			<p><a href="panel.php?action=guild_lead_change">Change *Chef de Guilde*</a></p>
			
			<p><a href="panel.php?action=stat_pad">Joueurs qui free kill peut etre</a></p>
			<p><a href="panel.php?action=pvprank">PVP RANK</a></p>
			<p><a href="panel.php?action=pvprank2">PVP RANK</a></p>
			<p><a href="panel.php?action=gmtool">GM TOOL</a></p>
    </div>
    </td>
    <td id="prawy_panel"><?php
include('main_panel.php');
?></td></tr>
    </tbody>
    <tfoot></tfoot>
    </table>
	</font>
</body>
</html>
