<h3>Queue:</h3>
<?php foreach($queue->queue() as $key => $song) { ?>
<p><a href='?controller=songs&action=show&id=<?php echo $song->id(); ?>'><?php echo $song->title(); ?></a> - <?php echo $song->author(); ?> - <?php echo $key ?> - <?php echo $song->genre(); ?> - <?php echo $song->duration(); ?> min</p>
<?php } ?>
