<h2>&crarr; QUEUE</h2>
<table class="table">
    <thead>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
    </thead>
    <tbody>
        <?php foreach($queue->queue() as $key => $song) { ?>
            <tr>
                <td><a href='?controller=songs&action=show&id=<?php echo $song->id(); ?>'><?php echo $song->title(); ?></a></td>
                <td><?php echo $song->author(); ?></td>
                <td><?php echo $song->genre(); ?></td>
                <td><?php echo floor($song->duration() / 60).":".sprintf("%02d", ($song->duration() % 60)); ?> min</td>
                <td><a href="?controller=queue&action=remove&id=<?php echo $song->id(); ?>&pos=<?php echo $key; ?>">&#10008;</a></td>
                <td>
                    <?php if($key > 1) { ?>
                        <a href="?controller=queue&action=swap&a=<?php echo $key; ?>&b=<?php echo $key-1; ?>">&#8963;</a>
                    <?php } ?>
                </td>
                <td><a href="#"><span onclick="play('<?php echo $song->duration() . '\'',',\'' . addslashes($song->title()) . '\'',',\'' . $song->id(); ?>');">&#9654;</span></a></td>
            </tr>
<?php } ?>
    </tbody>
</table>
