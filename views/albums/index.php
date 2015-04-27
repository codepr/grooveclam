<h3>Album list:</h3>
<table class="table">
<thead>
	<tr>
		<th>Title</th>
		<th>Author</th>
		<th>Recorded</th>
		<th>Location</th>
	</tr>
</thead>
<tbody>
<?php foreach($albums as $album) { ?>
	<tr>
		<td><a href='?controller=albums&action=show&id=<?php echo $album->id(); ?>'><?php echo $album->title(); ?></a></td>
		<td><?php echo $album->author(); ?></td>
		<td><?php if(is_array($album->live())) { echo "Live"; } else { echo "Studio"; } ?></td>
		<td><?php if(is_array($album->live())) { $location = $album->live(); echo $location['Location']; } else { echo ""; } ?></td>
	</tr>
<?php } ?>
</tbody>
</table>
