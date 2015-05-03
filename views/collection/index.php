<h3>Collection:</h3>
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
	</tr>
</thead>
<tbody>
<?php foreach($collection->songs() as $song) { ?>
	<tr>
		<td><a href='?controller=songs&action=show&id=<?php echo $song->id(); ?>'><?php echo $song->title(); ?></a></td>
		<td><?php echo $song->genre(); ?></td>
		<td><?php echo $song->duration(); ?></td>
		<td><a href='?controller=albums&action=show&id=<?php echo $song->idalbum(); ?>'><?php echo $song->album(); ?></a></td>
		<td><a href='?controller=collection&action=remove&id=<?php echo $song->id(); ?>&idc=<?php echo $collection->id(); ?>'>&#10008</a></td>
		<?php if(isset($_SESSION['logged'])) { ?>
		<td><a href='?controller=queue&action=addsong&id=<?php echo $song->id(); ?>'>&#10148</a></td>
		<?php } ?>
	</tr>
<?php } ?>
</tbody>
</table>
