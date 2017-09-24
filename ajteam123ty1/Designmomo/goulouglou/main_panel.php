<div align="center" class="pojemnik">
<?php
error_reporting(E_ALL);
if (isset($_REQUEST['action'])) {
	switch ($_GET['action']) {
		case 'Statistic':
?><IFRAME SRC="Statistics.php" TITLE="Statistic" NAME="Statistic" FRAMEBORDER="0" WIDTH="600" HEIGHT="900"></IFRAME><?php
			break;
		case 'ItemList1':
?><IFRAME SRC="itemsearch.php" TITLE="Item Search" NAME="Item Search" FRAMEBORDER="0" WIDTH="600" HEIGHT="900"></IFRAME><?php
			break;
		case 'FactionChange':
?><IFRAME SRC="FactionChange/factionchange.php" TITLE="FC" NAME="FC" FRAMEBORDER="0" WIDTH="600" HEIGHT="900"></IFRAME><?php
			break;
		case 'admin':
?><IFRAME SRC="adminmake.php" TITLE="Admin" NAME="Admin" FRAMEBORDER="0" WIDTH="600" HEIGHT="900"></IFRAME><?php
			break;
		case 'ItemList':
?><IFRAME SRC="itemlist.php" TITLE="ItemList" NAME="ItemList" FRAMEBORDER="0" WIDTH="600" HEIGHT="900"></IFRAME><?php
			break;
		case 'toon':
?><IFRAME SRC="toon.php" TITLE="Toon Search" NAME="Toon Search" FRAMEBORDER="0" WIDTH="600" HEIGHT="900"></IFRAME><?php
			break;
			case 'boss':
?><IFRAME SRC="boss.php" TITLE="Boss Record" NAME="Boss Record" FRAMEBORDER="0" WIDTH="600" HEIGHT="900"></IFRAME><?php
			break;
			case 'top_player':
?><IFRAME SRC="top_player.php" TITLE="Top Player" NAME="Top Player" FRAMEBORDER="0" WIDTH="1000" HEIGHT="900"></IFRAME><?php
			break;
		case 'MobList':
?><IFRAME SRC="moblist.php" TITLE="ItemList" NAME="ItemList" FRAMEBORDER="0" WIDTH="600" HEIGHT="900"></IFRAME><?php
			break;
		case 'Restore_UM_single':
?><IFRAME SRC="restore_um.php" TITLE="UM Restore" NAME="UM Restore" FRAMEBORDER="0" WIDTH="600" HEIGHT="900"></IFRAME><?php
			break;
		case 'drop':
?><IFRAME SRC="dropsearch.php" TITLE="Item Drop Search" NAME="Item Drop Search" FRAMEBORDER="0" WIDTH="600" HEIGHT="900"></IFRAME><?php
			break;
		case 'apbonus':
?><IFRAME SRC="apbyaccount.php" TITLE="D.P. Bonus" NAME="D.P. Bonus" FRAMEBORDER="0" WIDTH="600" HEIGHT="900"></IFRAME><?php
			break;
		case 'dpbonus':
?><IFRAME SRC="apByChar.php" TITLE="D.P." NAME="D.P." FRAMEBORDER="0" WIDTH="600" HEIGHT="900"></IFRAME><?php
			break;
		case 'apdeleat':
?><IFRAME SRC="ap_deleat.php" TITLE="UM Restore" NAME="D.P. Deletion" FRAMEBORDER="0" WIDTH="600" HEIGHT="900"></IFRAME><?php
			break;
		case 'guild_lead_change':
?><IFRAME SRC="guild_leader_change.php" TITLE="Guild Leader Change" NAME="Guild Leader Change" FRAMEBORDER="0" WIDTH="600" HEIGHT="900"></IFRAME><?php
			break;
		case 'guild_Disband':
?><IFRAME SRC="guild_Disband.php" TITLE="Guild Name Change" NAME="Guild Name Change" FRAMEBORDER="0" WIDTH="600" HEIGHT="900"></IFRAME><?php
			break;
		case 'guild_name_change':
?><IFRAME SRC="guild_name_change.php" TITLE="Guild Name Change" NAME="Guild Name Change" FRAMEBORDER="0" WIDTH="600" HEIGHT="900"></IFRAME><?php
			break;
		case 'Player_login_status':
?><IFRAME SRC="Player_login_status.php" TITLE="Login Status" NAME="Login Status" FRAMEBORDER="0" WIDTH="900" HEIGHT="1500"></IFRAME><?php
			break;
		case 'item_edit':
?><IFRAME SRC="item_edit.php" TITLE="Item Edit" NAME="Item Edit" FRAMEBORDER="0" WIDTH="600" HEIGHT="1300"></IFRAME><?php
			break;
		case 'item_delete':
?><IFRAME SRC="item_delete.php" TITLE="Item Edit" NAME="Item Edit" FRAMEBORDER="0" WIDTH="600" HEIGHT="1300"></IFRAME><?php
			break;
		case 'W.H.item_edit':
?><IFRAME SRC="WH_item_edit.php" TITLE="W.H. Item Edit" NAME="W.H. Item Edit" FRAMEBORDER="0" WIDTH="600" HEIGHT="1300"></IFRAME><?php
			break;
		case 'W.H.item_delete':
?><IFRAME SRC="WH_item_delete.php" TITLE="W.H. Item Edit" NAME="W.H. Item Edit" FRAMEBORDER="0" WIDTH="600" HEIGHT="1300"></IFRAME><?php
			break;
		case 'lotto':
?><IFRAME SRC="lotto.php" TITLE="Random Lottery" NAME="Random Lottery" FRAMEBORDER="0" WIDTH="600" HEIGHT="1300"></IFRAME><?php
			break;
		case 'lotto_winners':
?><IFRAME SRC="lotto_winners.php" TITLE="Random Lottery Winners" NAME="Random Lottery Winners" FRAMEBORDER="0" WIDTH="600" HEIGHT="1300"></IFRAME><?php
			break;
		case 'player_edit':
?><IFRAME SRC="player_edit.php" TITLE="Player Edit" NAME="Player Edit" FRAMEBORDER="0" WIDTH="600" HEIGHT="1300"></IFRAME><?php
			break;
		case 'player_search_by_char':
?><IFRAME SRC="player_search_by_char.php" TITLE="Player Search" NAME="Player Search" FRAMEBORDER="0" WIDTH="600" HEIGHT="1300"></IFRAME><?php
			break;
		case 'player_search_by_Acc':
?><IFRAME SRC="player_search_by_Acc.php" TITLE="Player Search" NAME="Player Search" FRAMEBORDER="0" WIDTH="600" HEIGHT="1300"></IFRAME><?php
			break;
		case 'player_ip_search':
?><IFRAME SRC="player_ip_search.php" TITLE="Player Search" NAME="Player Search" FRAMEBORDER="0" WIDTH="600" HEIGHT="1300"></IFRAME><?php
			break;
		case 'global_chat':
?><IFRAME SRC="global_chat.php" TITLE="Global Chat" NAME="Global Chat" FRAMEBORDER="0" WIDTH="700" HEIGHT="900"></IFRAME><?php
			break;
		case 'acc_jail':
?><IFRAME SRC="jail.php" TITLE="Account Jail" NAME="Account Ban" FRAMEBORDER="0" WIDTH="700" HEIGHT="900"></IFRAME><?php
			break;
		case 'acc_unjail':
?><IFRAME SRC="unjail.php" TITLE=" Un Jail Account" NAME="Account Ban" FRAMEBORDER="0" WIDTH="700" HEIGHT="900"></IFRAME><?php
			break;
		case 'acc_ban':
?><IFRAME SRC="ban_account.php" TITLE="Account Ban" NAME="Account Ban" FRAMEBORDER="0" WIDTH="700" HEIGHT="900"></IFRAME><?php
			break;
		case 'ban_search':
?><IFRAME SRC="ban_search.php" TITLE="Account Ban" NAME="Account Ban" FRAMEBORDER="0" WIDTH="700" HEIGHT="900"></IFRAME><?php
			break;
		case 'unacc_ban':
?><IFRAME SRC="unban_account.php" TITLE="Account Un-Ban" NAME="Account Un-Ban" FRAMEBORDER="0" WIDTH="700" HEIGHT="900"></IFRAME><?php
			break;
		case 'player_chatsearch':
?><IFRAME SRC="global_chatserch.php" TITLE="Player Chat Search" NAME="Player Chat Search" FRAMEBORDER="0" WIDTH="700" HEIGHT="900"></IFRAME><?php
			break;
		case 'IP_Search':
?><IFRAME SRC="IP_Search.php" TITLE="Player Chat Search" NAME="Player Chat Search" FRAMEBORDER="0" WIDTH="700" HEIGHT="900"></IFRAME><?php
			break;
		case 'stat_pad':
?><IFRAME SRC="StatPad.php" TITLE="Possable Stat Padders" NAME="Possable Stat Padders" FRAMEBORDER="0" WIDTH="700" HEIGHT="900"></IFRAME><?php
			break;
			case 'pvprank':
?><IFRAME SRC="pvp.php" TITLE="Possable Stat Padders" NAME="Possable Stat Padders" FRAMEBORDER="1" WIDTH="900" HEIGHT="900"></IFRAME><?php
			break;
			case 'pvprank2':
?><IFRAME SRC="rank" TITLE="Possable Stat Padders" NAME="Possable Stat Padders" FRAMEBORDER="1" WIDTH="900" HEIGHT="900"></IFRAME><?php
			break;
			case 'gmtool':
?><IFRAME SRC="gmtool" TITLE="Possable Stat Padders" NAME="Possable Stat Padders" FRAMEBORDER="1" WIDTH="1250" HEIGHT="2500"></IFRAME><?php
			break;
		default:
			print "<center>Choose action";
	}
} else
	echo " Paneau de controle d'Ato et Momo choisi la global Chat en 1 er pour rigoler ";
?>
</div>