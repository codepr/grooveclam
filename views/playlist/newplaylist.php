<h3>Create a new playlist</h3>
<form class="loginform playlist" action="?controller=playlist&action=createplaylist" method="post">
    <fieldset>
        <label for="Name">Name</label>
        <input type="text" id="Name" name ="Name" placeholder="Playlist name">
        <label>Song list</label>
        <fieldset class="list">
            <?php
            foreach($collection->songs() as $song) {
                echo "<input type='checkbox' class='list' name='song[]' value='".$song->id()."'> ".$song->title()." - " .$song->author()." - ".floor($song->duration() / 60).":".($song->duration() % 60)." min<br />";
            }
            ?>
        </fieldset>
        <label>Share with</label>
        <fieldset class="list">
            <?php
            $index = 0;
            foreach($user->fellows() as $fellow) {
                $name = User::find($fellow);
                echo "<input type='checkbox' class='list' name='fellow[]' value='".$fellow."'> ".$name->username()."<br />";
                $index++;
            }
            ?>
        </fieldset>
        <input type="checkbox" name="Private" value="Private"> Private
        <br />
        <input type="submit" value="submit" >
    </fieldset>
</form>