<?php
echo '<h3>Hello there '.$first_name.'</h3>';
?>
<br />
<?php if(!empty($lasten)) { ?>
    <table class="table floated" style="width:30%;">
	    <caption>New entries</caption>
	    <thead>
	        <tr>
		        <th></th>
		        <th></th>
	        </tr>
	    </thead>
	    <tbody>
            <?php foreach ($lasten as $title) { ?>
	            <tr>
		            <td><a href="/basidati/~abaldan/?controller=songs&action=show&id=<?php echo $title['id']; ?>"><?php echo $title['Title']; ?></a></td>
		            <td><?php echo $title['Genre']; ?></td>
	            </tr>
            <?php }
            ?>
	    </tbody>
    </table>
<?php } ?>
<!-- table last ten played -->
<?php if(!empty($lastplay)) { ?>
    <table class="table floated" style="width:15%;">
	    <caption>Top ten played songs</caption>
	    <thead>
	        <tr>
		        <th></th>
		        <th></th>
	        </tr>
	    </thead>
	    <tbody>
            <?php foreach ($lastplay as $title) { ?>
	            <tr>
		            <td><a href="/basidati/~abaldan/?controller=songs&action=show&id=<?php echo $title['id']; ?>"><?php echo $title['Title']; ?></a></td>
		            <td><?php echo $title['Count']; ?></td>
	            </tr>
            <?php } ?>
	    </tbody>
    </table>
<?php } ?>
<!-- table last 10 played by followers -->
<?php if(!empty($lastfellowplay)) { ?>
    <table class="table floated" style="width:45%;">
	    <caption>Last played by fellows</caption>
	    <thead>
	        <tr>
		        <th></th>
		        <th></th>
		        <th></th>
	        </tr>
	    </thead>
	    <tbody>
            <?php foreach ($lastfellowsplay as $title) { ?>
	            <tr>
		            <td><a href="/basidati/~abaldan/?controller=user&action=show&id=<?php echo $title['IdUser']; ?>"><?php echo $title['Username']; ?></a></td>
		            <td><a href="/basidati/~abaldan/?controller=songs&action=show&id=<?php echo $title['id']; ?>"><?php echo $title['Title']; ?></a></td>
		            <td><a href="/basidati/~abaldan/?controller=albums&action=show&id=<?php echo $title['IdAlbum']; ?>"><?php echo $title['AlbumTitle']; ?></a></td>
	            </tr>
            <?php } ?>
	    </tbody>
    </table>
<?php } ?>
