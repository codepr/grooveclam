<?php
echo '<h3>Hello there '.$first_name.'</h3>';
?>
<br />
<h4>Last 10 songs inserted by community</h4>
<table class="table floated" style="width:15%;">
	<thead>
	<tr>
		<!-- <th>Song</th> -->
		<th></th>
	</tr>
	</thead>
	<tbody>
<?php foreach ($lasten as $title) { ?>
	<tr>
		<td><a href="/basidati/~abaldan/?controller=songs&action=show&id=<?php echo $title['id']; ?>"><?php echo $title['Title']; ?></a></td>
	</tr>
<?php }
?>
	</tbody>
</table>
<!-- table last ten played -->
<table class="table floated" style="width:15%;">
	<thead>
	<tr>
		<!-- <th>Song</th> -->
		<th></th>
		<th></th>
	</tr>
	</thead>
	<tbody>
<?php foreach ($lastplay as $title) { ?>
	<tr>
		<td><a href="/basidati/~abaldan/?controller=songs&action=show&id=<?php echo $title['id']; ?>"><?php echo $title['Title']; ?></a></td>
		<td><?php echo $title['Count']; ?></td>
	</tr>
<?php }
?>
	</tbody>
</table>
<!-- table last 10 played by followers -->
<table class="table floated" style="width:30%;">
	<thead>
	<tr>
		<!-- <th>Song</th> -->
		<th></th>
		<th></th>
		<th></th>
	</tr>
	</thead>
	<tbody>
<?php foreach ($lastfellowsplay as $title) { ?>
	<tr>
		<td><?php echo $title['Username']; ?></td>
		<td><a href="/basidati/~abaldan/?controller=songs&action=show&id=<?php echo $title['id']; ?>"><?php echo $title['Title']; ?></a></td>
		<td><a href="/basidati/~abaldan/?controller=albums&action=show&id=<?php echo $title['IdAlbum']; ?>"><?php echo $title['AlbumTitle']; ?></a></td>
	</tr>
<?php }
?>
	</tbody>
</table>
