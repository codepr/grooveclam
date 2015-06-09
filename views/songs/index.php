<h2>&#9836; SONG LIST</h2>
<table class="table">
<thead>
	<tr>
		<th>Title</th>
		<th>Genre</th>
		<th>Duration (min)</th>
		<th>Album</th>
		<?php if(isset($_SESSION['logged'])) { echo "<th></th><th></th>"; } ?>
        <th></th>
	</tr>
</thead>
<tbody>
<?php foreach($songs as $song) { ?>
	<tr>
		<td><a href='?controller=songs&action=show&id=<?php echo $song->id(); ?>'><?php echo $song->title(); ?></a></td>
		<td><?php echo $song->genre(); ?></td>
		<td><?php echo floor($song->duration() / 60).":".sprintf('%02s', ($song->duration() % 60)); ?></td>
		<td><a href='?controller=albums&action=show&id=<?php echo $song->idalbum(); ?>'><?php echo $song->album(); ?></a></td>
		<?php if(isset($_SESSION['logged'])) {
			if(in_array($song->id(), $got)) {
				echo "<td style='color: rgb(15, 89, 182);'>&#10004;</td>\n";
			} else { echo "<td><a href='?controller=collection&action=addsong&id=".$song->id()."&idu=".$_SESSION['uid']."'>&#10010;</a></td>\n"; }
		?>
		<td><a href='?controller=queue&action=addsong&id=<?php echo $song->id(); ?>'>&crarr;</a></td>
		<?php
		} ?>
        <td><a href="#" onclick="play('<?php echo $song->duration() . '\'',',\'' . addslashes($song->title()) . '\'',',\'' . $song->id(); ?>');">&#9654;</a></td>
	</tr>
<?php } ?>
</tbody>
</table>
