<h3>Playlists</h3>
<div class="addstuff">
    <div class="addstuff-circle">
        <a class="addstuff" href="?controller=playlist&action=newplaylist">&#10133</a>
    </div>
</div>
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
		<td><a href='?controller=user&action=show&id=<?php echo $playlist->id(); ?>'><?php $owner = $playlist->owner(); echo $owner['Username']; ?></a></td>
		<td><?php $stats = $playlist->stats($playlist->id()); echo $stats['count']; ?></td>
		<td><?php echo $stats['duration']; ?></td>
	</tr>
<?php } ?>
</tbody>
</table>
