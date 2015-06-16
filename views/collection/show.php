<h2>&#9738; COLLECTION (<?php echo count($collection->songs()); ?>)</h2>
<table class="table">
<thead>
	<tr>
		<th>Title</th>
		<th>Genre</th>
		<th>Duration (min)</th>
		<th>Album</th>
		<th></th>
		<?php if(isset($_SESSION['logged'])) {
			echo "<th></th>\n";
		} ?>
        <th></th>
	</tr>
</thead>
<tbody>
<?php if($collection->songs() !== NULL) {
    foreach($collection->songs() as $song) { ?>
	<tr>
		<td><a href='?controller=songs&action=show&id=<?php echo $song->id(); ?>'><?php echo $song->title(); ?></a></td>
		<td><?php echo $song->genre(); ?></td>
		<td><?php echo floor($song->duration() / 60).":".sprintf("%02d",($song->duration() % 60)); ?></td>
		<td><a href='?controller=albums&action=show&id=<?php echo $song->idalbum(); ?>'><?php echo $song->album(); ?></a></td>
		<td><a href='?controller=collection&action=remove&id=<?php echo $song->id(); ?>&idc=<?php echo $collection->id(); ?>'>&#10008</a></td>
		<?php if(isset($_SESSION['logged'])) { ?>
		<td><a href='?controller=queue&action=addsong&id=<?php echo $song->id(); ?>'>&crarr;</a></td>
		<?php } ?>
        <td><a href="#" onclick="play('<?php echo $song->duration() . '\'',',\'' . addslashes($song->title()) . '\'',',\'' . $song->id(); ?>');">&#9654;</a></td>
	</tr>
<?php }
}?>
</tbody>
</table>