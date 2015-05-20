<h2>&crarr; QUEUE</h2>
<?php foreach($queue->queue() as $key => $song) { ?>
    <p>
        <a href='?controller=songs&action=show&id=<?php echo $song->id(); ?>'><?php echo $song->title(); ?></a> -
        <?php echo $song->author(); ?> - <?php echo $key ?> -
        <?php echo $song->genre(); ?> - <?php echo floor($song->duration() / 60).":".($song->duration() % 60); ?> min -
        <a href="#"><span onclick="play('<?php echo $song->duration() . '\'',',\'' . addslashes($song->title()) . '\'',',\'' . $song->id(); ?>');">&#10148</span></a>
    </p>
<?php } ?>
