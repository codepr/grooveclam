<h2>&#9738; COLLECTION LIST</h2>
<table class="table" style="width:40%;">
<thead>
	<tr>
        <th>User</th>
		<th></th>
	</tr>
</thead>
<tbody>
    <?php foreach($collections as $collection) { ?>
        <tr>
            <td><a href="?controller=collection&action=show&id=<?php echo $collection['collection']; ?>"><?php echo $collection['user']; ?></a></td>
            <td><a href="?controller=collection&action=drop&id=<?php echo $collection['collection']; ?>">&#10008;</a></td>
        </tr>
    <?php } ?>
</tbody>
</table>
