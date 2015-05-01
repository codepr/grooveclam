<?php
echo '<h3>Hello there '.$first_name.'</h3>';
?>
<h4>Last 10 songs inserted by community</h4>
<table class="table" style="width:15%;">
	<thead>
	<tr>
		<th>Song</th>
	</tr>
	</thead>
	<tbody>
<?php foreach ($lasten as $title) { ?>
	<tr>
		<td><a href="/grooveclam/?controller=songs&action=show&id=<?php echo $title['id']; ?>"><?php echo $title['Title']; ?></a></td>
	</tr>
<?php }
?>
	</tbody>
</table>

