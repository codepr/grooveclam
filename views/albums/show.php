<h3><?php echo $album->title(); ?> - <?php echo $album->author(); ?></h3>
<p><?php echo $album->info(); ?></p>
<?php if(is_array($album->live())) { echo "<p>Live at: " . $album->live()['Location']; } ?>
<table class="table">
<thead>
	<tr>
		<th>Title</th>
		<th>Genre</th>
		<th>Duration (min)</th>
	</tr>
</thead>
<tbody>
<?php foreach($album->songs() as $song) { ?>
	<tr>
		<td><a href='?controller=songs&action=show&id=<?php echo $song->id(); ?>'><?php echo $song->title(); ?></a></td>
		<td><?php echo $song->genre(); ?></td>
		<td><?php echo $song->duration(); ?></td>
	</tr>
<?php } ?>
</tbody>
</table>
