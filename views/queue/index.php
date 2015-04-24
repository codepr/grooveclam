<h3>Queue:</h3>
<?php foreach($queue->queue() as $song) { ?>
<p><a href='?controller=songs&action=show&id=<?php echo $song->id(); ?>'><?php echo $song->title(); ?></a> - <?php echo $song->author(); ?> - <?php echo $song->genre(); ?> - <?php echo $song->duration(); ?> min </p>
<?php } ?>
