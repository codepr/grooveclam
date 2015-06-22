<h2>&#9881; MENAGE PLAYLIST</h2>
<form class="loginform" action="?controller=playlist&action=alter&id=<?php echo $_GET['id']; ?>" method="post">
    <fieldset>
        <label for="NewName">Name</label>
        <input name="NewName" type="text" value="<?php echo $playlist->name(); ?>" id="NewName" />
        <label>Song list</label>
        <fieldset class="list">
            <?php
            foreach($songlist as $song) {
                $checked = '';
                if(in_array($song, $playlist->songs())) {
                    $checked = 'checked';
                }
                echo "<input type='checkbox' class='list' name='song[]' value='".$song->id()."'".$checked."> ".$song->title()." - " .$song->author()." - ".floor($song->duration() / 60).":".($song->duration() % 60)." min<br />";
            }
            ?>
        </fieldset>
        <?php
        $chk = '';
        if($playlist->domain() == 'Privata') {
            $chk = "checked";
        }
        ?>
        <input type="checkbox" name="Private" id="Private" value="Privata" <?php echo $chk; ?>> Private
        <br />
        <input type="hidden" name="idpl" id="idpl" value="<?php echo $_GET['id']; ?>" />
        <input type="submit" value="submit" />
    </fieldset>
</form>