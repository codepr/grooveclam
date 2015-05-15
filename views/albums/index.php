<h2>&#9839; ALBUM LIST</h2>
<?php if(isset($_SESSION['logged'])) { ?>
    <div class="addstuff">
        <div class="addstuff-circle">
            <a class="addstuff" href="?controller=albums&action=add">&#10133</a>
        </div>
    </div>
<?php } ?>
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
