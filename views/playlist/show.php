<h3><?php echo $playlist->name(); ?></h3>
<table class="table">
<thead>
	<tr>
		<th>Title</th>
		<th>Genre</th>
		<th>Duration (min)</th>
		<th>Album</th>
        <th></th>
	</tr>
</thead>
<tbody>
<?php foreach($playlist->songs() as $song) { ?>
	<tr>
		<td><a href='?controller=songs&action=show&id=<?php echo $song->id(); ?>'><?php echo $song->title(); ?></a></td>
		<td><?php echo $song->genre(); ?></td>
		<td><?php echo floor($song->duration() / 60).":".($song->duration() % 60); ?></td>
		<td><a href='?controller=albums&action=show&id=<?php echo $song->idalbum(); ?>'><?php echo $song->album(); ?></a></td>
        <td><a href="#" onclick="play('<?php echo $song->duration() . '\'',',\'' . addslashes($song->title()) . '\'',',\'' . $song->id(); ?>');">&#9654;</a></td>
	</tr>
<?php } ?>
</tbody>
</table>
