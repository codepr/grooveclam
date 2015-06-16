<h2>&#9881; MENAGE PLAYLIST</h2>
<form class="loginform" action="?controller=playlist&action=alter&id=<?php echo $_GET['id']; ?>" method="post">
    <fieldset>
        <label for="NewName">Name</label>
        <input name="NewName" type="text" value="<?php echo $playlist->name(); ?>" id="NewName" />
        <label>Song list</label>
        <fieldset class="list">
            <?php
            foreach($collection->songs() as $song) {
                $checked = '';
                if(in_array($song, $playlist->songs())) {
                    $checked = 'checked';
                }
                echo "<input type='checkbox' class='list' name='song[]' value='".$song->id()."'".$checked."> ".$song->title()." - " .$song->author()." - ".floor($song->duration() / 60).":".($song->duration() % 60)." min<br />";
            }
            ?>
        </fieldset>
        <input type="submit" value="submit" />
    </fieldset>
</form>