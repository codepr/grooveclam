<div class="cover"><img alt="" src="<?php echo $album->path(); ?>"></div>
<h3><?php echo $album->title(); ?> - <?php echo $album->author(); ?></h3>
<p><?php echo $album->info(); ?></p>
<p><?php if(is_array($album->live())) { $location = $album->live();echo "Live at " . $location['Location']; } ?></p>
<h5>Published</h5>
<p><?php echo $album->year(); ?></p>
<h5>Genre</h5>
<p>
<?php
$genre = array();
$count = 0;
foreach ($album->songs() as $value) {
	$genre[$value->genre()] = $count++;
}
foreach ($genre as $key => $g) {
	echo $key." ";
}?>
</p>
<h5>Tracks</h5>
<p><?php echo count($album->songs()); ?></p>
<h5>Total duration</h5>
<p><?php echo $album->totalDuration(); ?> minutes</p>
<table class="table">
<thead>
	<tr>
		<th>Title</th>
		<th>Genre</th>
		<th>Duration (min)</th>
        <th></th>
	</tr>
</thead>
<tbody>
<?php foreach($album->songs() as $song) { ?>
	<tr>
		<td><a href='?controller=songs&action=show&id=<?php echo $song->id(); ?>'><?php echo $song->title(); ?></a></td>
		<td><?php echo $song->genre(); ?></td>
		<td><?php echo floor($song->duration() / 60).":".sprintf("%02d",$song->duration() % 60); ?></td>
        <td><a href="#" onclick="play('<?php echo $song->duration() . '\'',',\'' . addslashes($song->title()) . '\'',',\'' . $song->id(); ?>');">&#9654;</a></td>
	</tr>
<?php } ?>
</tbody>
</table>
