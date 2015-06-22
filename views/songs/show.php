<div class="cover"><img alt="" src="<?php echo $song->cover(); ?>"></div>
<h3><?php echo $song->title(); ?></h3>
<h5>Author</h5>
<?php echo $song->author(); ?>
<h5>Genre</h5>
<?php echo $song->genre(); ?>
<h5>Duration</h5>
<?php echo floor($song->duration() / 60).":".sprintf('%02s', $song->duration() % 60); ?> min
<h5>Album</h5>
<a href="?controller=albums&action=show&id=<?php echo $song->idalbum(); ?>"><?php echo $song->album(); ?></a>
