<h3>Playlists</h3>
<table class="table">
<thead>
	<tr>
		<th>Name</th>
		<th>Author</th>
		<th># Tracks</th>
		<th>Duration (min)</th>
	</tr>
</thead>
<tbody>
<?php foreach($playlists as $playlist) { ?>
	<tr>
		<td><a href='?controller=playlist&action=show&id=<?php echo $playlist->id(); ?>'><?php echo $playlist->name(); ?></a></td>
		<td><?php $owner = $playlist->owner(); echo $owner['Username']; ?></td>
		<td><?php $stats = $playlist->stats($playlist->id()); echo $stats['count']; ?></td>
		<td><?php echo $stats['duration']; ?></td>
	</tr>
<?php } ?>
</tbody>
</table>
