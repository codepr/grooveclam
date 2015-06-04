<h2>&#9733; PLAYLISTS</h2>
<?php if(isset($_SESSION['logged'])) { ?>
<div class="addstuff">
    <div class="addstuff-circle">
        <a class="addstuff" href="?controller=playlist&action=newplaylist">&#10010;</a>
    </div>
</div>
<?php } ?>
<table class="table">
    <caption><?php echo (isset($_SESSION['logged']) && $_SESSION['admin']) ? "All" : "Public"; ?> playlists</caption>
    <thead>
	    <tr>
		    <th>Name</th>
		    <th>Author</th>
		    <th># Tracks</th>
		    <th>Duration (min)</th>
            <?php if(isset($_SESSION['logged']) && $_SESSION['admin']) { ?>
                <th>Domain</th>
                <th></th>
                <th></th>
            <?php } ?>
	    </tr>
    </thead>
    <tbody>
        <?php foreach($playlists as $playlist) { ?>
	        <tr>
		        <td><a href='?controller=playlist&action=show&id=<?php echo $playlist->id(); ?>'><?php echo $playlist->name(); ?></a></td>
		        <td><a href='?controller=user&action=show&id=<?php $owner = $playlist->owner(); echo $owner['IdUtente']; ?>'><?php echo $owner['Username']; ?></a></td>
		        <td><?php $stats = $playlist->stats($playlist->id()); echo $stats['count']; ?></td>
		        <td><?php echo $stats['duration']; ?></td>
                <?php if(isset($_SESSION['logged']) && $_SESSION['admin']) { ?>
                    <td><?php echo $playlist->domain() ? "&#128274;" : "&#128275;"; ?></td>
                    <td><a href="?controller=playlist&action=alter&id=<?php echo $playlist->id(); ?>">&#9998;</a></td>
                    <td><a href="?controller=playlist&action=drop&id=<?php echo $playlist->id(); ?>">&#10008;</a></td>
                <?php } ?>
	        </tr>
        <?php } ?>
    </tbody>
</table>
<?php if(isset($_SESSION['logged']) && !$_SESSION['admin']) { ?>
<table class="table">
    <caption>Personal playlists</caption>
    <thead>
	    <tr>
		    <th>Name</th>
		    <th># Tracks</th>
		    <th>Duration (min)</th>
            <th></th>
	    </tr>
    </thead>
    <tbody>
        <?php foreach($personal_playlists as $playlist) { ?>
	        <tr>
		        <td><a href='?controller=playlist&action=show&id=<?php echo $playlist->id(); ?>'><?php echo $playlist->name(); ?></a></td>
		        <td><?php $stats = $playlist->stats($playlist->id()); echo $stats['count']; ?></td>
		        <td><?php echo $stats['duration']; ?></td>
                <td style="color: rgb(15, 89, 182); font-size:.9em;"><?php if($playlist->domain()) { ?>&#128274;<?php } else { echo "&#128275;"; } ?></td>
	        </tr>
        <?php } ?>
    </tbody>
</table>
<?php } ?>