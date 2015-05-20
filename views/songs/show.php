<div class="cover"><img alt="" src="<?php echo $song->cover(); ?>"></div>
<h3><?php echo $song->title(); ?></h3>
<h5>Author</h5>
<?php echo $song->author(); ?>
<h5>Genre</h5>
<?php echo $song->genre(); ?>
<h5>Duration</h5>
<?php echo floor($song->duration() / 60).":".($song->duration() % 60); ?> min
<h5>Album</h5>
<a href="?controller=albums&action=show&id=<?php echo $song->idalbum(); ?>"><?php echo $song->album(); ?></a>
<?php if(isset($_SESSION['logged'])) {
	if((!in_array($song->id(), $got))) {
		echo "<p><button class='exit add'><a href='?controller=collection&action=addsong&id=".$song->id()."&idu=".$_SESSION['uid']."'>&#10010 Add to collection</a></button></p>";
	} else {
		echo "<p><button class='exit add'><a href='?controller=collection&action=remove&id=".$song->id()."&idu=".$_SESSION['uid']."'>&#10008 Remove from collection<a></button></p>";
	}
} ?>
