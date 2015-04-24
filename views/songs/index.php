<p>Song list:</p>
<?php foreach($songs as $song) { ?>
<p><a href='?controller=songs&action=show&id=<?php echo $song->id(); ?>'><?php echo $song->title(); ?></a> - <?php echo $song->genre(); ?> - <?php echo $song->duration(); ?> min</p>
<?php } ?>
