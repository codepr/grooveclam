<form class="loginform playlist" action="?controller=playlist&action=createplaylist" method="post">
    <fieldset>
        <label for="Name">Name</label>
        <input type="text" id="Name" placeholde="Playlist name">
        <fieldset class="list">
            <legend>Song collection</legend>
            <?php
            $index = 0;
            foreach($collection->songs() as $song) {
                echo "<input type='checkbox' class='list' name='song_$index' value=$song->id()> ".$song->title()." - " .$song->author()." - ".$song->duration()." min<br />";
                $index++;
            }
            ?>
        </fieldset>
        <input type="checkbox" name="Private" value="1"> Private
        <br />
        <input type="submit" value="submit" >
    </fieldset>
</form>