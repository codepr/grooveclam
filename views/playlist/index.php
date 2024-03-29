<h2>&#9733; PLAYLISTS (<?php echo count($playlists); ?>)</h2>
<?php if(isset($_SESSION['logged'])) { ?>
<div class="addstuff">
    <div class="addstuff-circle">
        <a class="addstuff" href="?controller=playlist&action=newplaylist">&#10010;</a>
    </div>
</div>
<?php } ?>
<table class="table">
    <caption>Public playlists</caption>
    <thead>
	    <tr>
		    <th>Name</th>
		    <th>Author</th>
		    <th># Tracks</th>
		    <th>Duration (min)</th>
	    </tr>
    </thead>
    <tbody>
        <?php foreach($playlists as $playlist) { ?>
	        <tr>
		        <td><a href='?controller=playlist&action=show&id=<?php echo $playlist->id(); ?>'><?php echo $playlist->name(); ?></a></td>
		        <td><a href='?controller=user&action=show&id=<?php $owner = $playlist->owner(); echo $owner['IdUtente']; ?>'><?php echo $owner['Username']; ?></a></td>
		        <td><?php $stats = $playlist->stats($playlist->id()); echo $stats['count']; ?></td>
		        <td><?php echo $stats['duration']; ?></td>
	        </tr>
        <?php } ?>
    </tbody>
</table>
<?php if(isset($_SESSION['logged'])) { ?>
<table class="table">
    <caption>Personal playlists</caption>
    <thead>
	    <tr>
		    <th>Name</th>
		    <th># Tracks</th>
		    <th>Duration (min)</th>
            <th>Domain</th>
            <th></th>
	    </tr>
    </thead>
    <tbody>
        <?php foreach($personal_playlists as $playlist) { ?>
	        <tr>
		        <td><a href='?controller=playlist&action=show&id=<?php echo $playlist->id(); ?>'><?php echo $playlist->name(); ?></a></td>
		        <td><?php $stats = $playlist->stats($playlist->id()); echo $stats['count']; ?></td>
		        <td><?php echo $stats['duration']; ?></td>
                <td style="color: rgb(15, 89, 182); font-size:.9em;">
                    <?php echo $playlist->domain() == 'Pubblica' ? "Public" : "Private"; ?>
                </td>
                <td><a href="?controller=playlist&action=remove&id=<?php echo $playlist->id(); ?>">&#10008;</a></td>
	        </tr>
        <?php } ?>
    </tbody>
</table>
<?php } ?>