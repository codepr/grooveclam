<h3><?php echo $song->title(); ?></h3>
<p>Author: <?php echo $song->author(); ?></p>
<p>Genre: <?php echo $song->genre(); ?></p>
<p>Duration: <?php echo $song->duration(); ?> min</p>
<p>Album: <a href="?controller=albums&action=show&id=<?php echo $song->idalbum(); ?>"><?php echo $song->album(); ?></a></p>
