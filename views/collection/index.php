<h3>Collection:</h3>
<?php foreach($collection->songs() as $song) { ?>
<p><a href='?controller=songs&action=show&id=<?php echo $song->id(); ?>'><?php echo $song->title(); ?></a> - <?php echo $song->genre(); ?> - <?php echo $song->duration(); ?> min</p>
<?php } ?>
