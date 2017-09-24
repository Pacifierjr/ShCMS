<table class="CharStatTable">
	<tbody>
		<tr><td colspan="4" align="center">Level <?php echo $characterData['Stats']['Level']; ?> <?php echo $characterData['Stats']['CharClass']; ?></td></tr>
		<tr><td colspan="4" align="center"><span class="<?php echo $characterData['Stats']['Faction']; ?>"><span class="ClassIcon <?php echo htmlspecialchars($characterData['Stats']['CharClass']); ?>">&nbsp;</span></span></td></tr>
		<tr><td colspan="2">Attack</td><td colspan="2" align="right"><?php echo $characterData['Stats']['AttackMin']; ?> - <?php echo $characterData['Stats']['AttackMax']; ?></td></tr>
		<tr><td>Defense</td><td align="right"><?php echo $characterData['Stats']['Defense']; ?></td><td>Resist</td><td align="right"><?php echo $characterData['Stats']['MagicResist']; ?></td></tr>
		<tr><td colspan="4">&nbsp;</td></tr>
		<tr><td>Str</td><td align="right"><?php echo $characterData['Stats']['BaseStr']; ?> + <span class="GearStat"><?php echo $characterData['Stats']['Str']; ?></span></td><td>Wis</td><td align="right"><?php echo $characterData['Stats']['BaseWis']; ?> + <span class="GearStat"><?php echo $characterData['Stats']['Wis']; ?></span></td></tr>
		<tr><td>Rec</td><td align="right"><?php echo $characterData['Stats']['BaseRec']; ?> + <span class="GearStat"><?php echo $characterData['Stats']['Rec']; ?></span></td><td>Dex</td><td align="right"><?php echo $characterData['Stats']['BaseDex']; ?> + <span class="GearStat"><?php echo $characterData['Stats']['Dex']; ?></span></td></tr>
		<tr><td>Int</td><td align="right"><?php echo $characterData['Stats']['BaseInt']; ?> + <span class="GearStat"><?php echo $characterData['Stats']['Int']; ?></span></td><td>Luc</td><td align="right"><?php echo $characterData['Stats']['BaseLuc']; ?> + <span class="GearStat"><?php echo $characterData['Stats']['Luc']; ?></span></td></tr>
		<tr><td colspan="2" class="Bold">Base Stats</td><td colspan="2" align="right"><?php echo $characterData['Stats']['BaseStat']; ?></td></tr>
		<tr><td colspan="2" class="Bold">Total Stats</td><td colspan="2" align="right"><?php echo $characterData['Stats']['TotalStat']; ?></td></tr>
		<tr><td colspan="4">&nbsp;</td></tr>
		<tr><td>HP</td><td align="right"><?php echo $characterData['Stats']['HP']; ?></td><td>Attack</td><td align="right"><?php echo $characterData['Stats']['AttackMin']; ?> - <?php echo $characterData['Stats']['AttackMax']; ?></td></tr>
		<tr><td>MP</td><td align="right"><?php echo $characterData['Stats']['MP']; ?></td><td>Defense</td><td align="right"><?php echo $characterData['Stats']['Defense']; ?></td></tr>
		<tr><td>SP</td><td align="right"><?php echo $characterData['Stats']['SP']; ?></td><td>Resist</td><td align="right"><?php echo $characterData['Stats']['MagicResist']; ?></td></tr>
		<tr><td colspan="4">&nbsp;</td></tr>
		<tr><td colspan="2">Kill donner par</td><td colspan="2" align="right"><?php echo isset($characterData['LastKilled']['LastKilled']) ? htmlspecialchars($characterData['LastKilled']['LastKilled']) : 'No Data'; ?></td></tr>
		<tr><td colspan="2">kill reçu sur</td><td colspan="2" align="right"><?php echo isset($characterData['LastKilledBy']['LastKilledBy']) ? htmlspecialchars($characterData['LastKilledBy']['LastKilledBy']) : 'No Data'; ?></td></tr>
		<tr><td colspan="2">le plus tuer</td><td colspan="2" align="right"><?php echo isset($characterData['MostKilled']['MostKilled']) ? htmlspecialchars($characterData['MostKilled']['MostKilled']) : 'No Data'; ?>(<?php echo isset($characterData['MostKilled']['MostKilledCount']) ? $characterData['MostKilled']['MostKilledCount'] : 'N/A'; ?>)</td></tr>
		<tr><td colspan="2">Most Killed By</td><td colspan="2" align="right"><?php echo isset($characterData['MostKilledBy']['MostKilledBy']) ? htmlspecialchars($characterData['MostKilledBy']['MostKilledBy']) : 'No Data'; ?>(<?php echo isset($characterData['MostKilledBy']['MostKilledByCount']) ? $characterData['MostKilledBy']['MostKilledByCount'] : 'N/A'; ?>)</td></tr>
		<tr><td colspan="4">&nbsp;</td></tr>
		<tr><td colspan="2">derniere fois en jeu</td><td  colspan="2" align="right"><?php echo isset($characterData['Stats']['LastSeen']) ? $characterData['Stats']['LastSeen'] : 'No Data'; ?></td></tr>
	</tbody>
</table>