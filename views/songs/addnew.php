<h3>Add new song to the platform</h3>
<form class="loginform" method="post" action="?controller=songs&action=addsong">
    <fieldset>
        <label for="Title">Title</label>
        <input type="text" id="Title" placeholder="Song title">
        <label for="Genre">Genre</label>
        <input type="text" id="Genre" placeholder="Song genre">
        <label for="Duration">Duration</label>
        <input type="text" id="Duration" placeholder="Song duration mm:ss">
        <label for="Album">Album</label>
        <select name="Album">
            <option value="">No album</option>
            <?php
            foreach($albums as $album) {
                echo "<option value='".$album->id()."'>".$album->title()."</option>";
            }
            ?>
        </select>
        <input type="submit" value="submit">
    </fieldset>
</form>