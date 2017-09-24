<?php if(!isset($characterRanks['Data']) || !count($characterRanks['Data'])){ ?>
No results to display.
<?php return;} ?>
<?php $pagingHelper->displayPageNumberOverview(); ?>
<table class="RankTable" width="100%">
	<thead style="cursor:pointer;">
		<th title="A gold number indicates the player is currently online.">#</th>
		<th title="The character's name.">Name</th>
		<th title="The character's class and faction. Faction is indicated by the color of the background.">Cls</th>
		<th title="The character's level.">Level</th>
		<th title="The guild the character is currently a member of.">Guild</th>
		<th><a href="#K1" title="The number of kills the character has since their data was last updated. Click here to sort by kills.">Kills</a></th>
		<th><a href="#K2" title="The number of deaths the character has since their data was last updated. Click here to sort by deaths.">Deaths</a></th>
		<th><a href="#KDR" title="The number of kills divided by deaths the character has since their data was last updated. Click here to sort by kill to death ratio.">KDR</a></th>
		<th>Rank</th>
	</thead>
	<tbody>
		<?php foreach($characterRanks['Data'] as $c){ ?>
		<tr>
			<td class="<?php echo $c['Leave']; ?>" title="<?php echo $c['Leave']; ?>" style="cursor:pointer"><?php echo $c['RowIndex']; ?></td>
			<td class="tooltip CharName" id="Char_<?php echo $c['CharID']; ?>"><?php echo htmlspecialchars($c['CharName']); ?></td>
			<td align="center" style="width:16px;"><span class="<?php echo $c['Faction']; ?>"><span class="ClassIcon <?php echo $c['CharClass']; ?>" title="<?php echo htmlspecialchars($c['CharClass']); ?>">&nbsp;</span></span></td>
			<td align="right"><?php echo $c['Level']; ?></td>
			<td><?php echo htmlspecialchars($c['GuildName']); ?></td>
			<td align="right"><?php echo $c['K1']; ?></td>
			<td align="right"><?php echo $c['K2']; ?></td>
			<td align="right"><?php echo $c['KDR']; ?></td>
			<td align="center"><span<?php if(!empty($c['Rank'])){ ?> class="RankIcon <?php echo 'Rank'.str_pad($c['Rank'],2,0,STR_PAD_LEFT); ?>" title="<?php echo "Rank {$c['Rank']}"; ?>"<?php } ?>>&nbsp;</span></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php $pagingHelper->displayPageNumberOverview(); ?>
<script type="text/javascript" src="./js/rank.js"></script>