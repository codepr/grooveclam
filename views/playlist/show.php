<h3><?php echo $playlist->name()." (".count($playlist->songs()).")"; ?></h3>
<table class="table">
<thead>
	<tr>
		<th>Title</th>
		<th>Genre</th>
		<th>Duration (min)</th>
		<th>Album</th>
        <th></th>
        <th></th>
	</tr>
</thead>
<tbody>
<?php foreach($playlist->songs() as $key => $song) { ?>
	<tr>
		<td><a href='?controller=songs&action=show&id=<?php echo $song->id(); ?>'><?php echo $song->title(); ?></a></td>
		<td><?php echo $song->genre(); ?></td>
		<td><?php echo floor($song->duration() / 60).":".sprintf("%02d", $song->duration() % 60); ?></td>
		<td><a href='?controller=albums&action=show&id=<?php echo $song->idalbum(); ?>'><?php echo $song->album(); ?></a></td>
        <td>
            <?php if($key > 1) { ?>
                <a href="?controller=playlist&action=swap&a=<?php echo $key; ?>&b=<?php echo $key-1; ?>&id=<?php echo $playlist->id(); ?>">&#8963;</a>
            <?php } ?>
        </td>
        <td><a href="#" onclick="play('<?php echo $song->duration() . '\'',',\'' . addslashes($song->title()) . '\'',',\'' . $song->id(); ?>');">&#9654;</a></td>
	</tr>
<?php } ?>
</tbody>
</table>
<?php if(count($shared_fellows)) { ?>
    <table class="table">
        <caption>Shared with</caption>
        <thead>
            <tr>
                <th>Fellow</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($shared_fellows as $key => $value) { ?>
                <tr>
                    <td><a href="?controller=user&action=show&id=<?php echo $key; ?>"><?php echo $value; ?></a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } ?>
<?php if(isset($_SESSION['logged']) && $playlist->is_mine()) { ?>
    <p><a href="?controller=playlist&action=manage&id=<?php echo $_GET['id']; ?>"><button class='exit add'>&#9881; Manage playlist</button></a></p>
<?php } ?>