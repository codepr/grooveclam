<h3><?php echo $playlist->name(); ?></h3>
<?php foreach($playlist->songs() as $song) { ?>
<p><a href='?controller=songs&action=show&id=<?php echo $song->id(); ?>'><?php echo $song->title(); ?></a> - <?php echo $song->genre(); ?> - <?php echo $song->duration(); ?> min</p>
<?php } ?>
