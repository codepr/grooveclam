<form class='loginform' action='?controller=albums&action=addsong' method='post'>
    <fieldset>
        <label for="Title">Title</label>
        <input type="text" id="Title" placeholder="Album title">
        <label for="Author">Author</label>
        <input type="text" id="Author" placeholder="Author name">
        <label for="Location">Location</label>
        <input type="text" id="Location" placeholder="Location of live performance">
        <input type="checkbox" name="Live" value="1"> Live
        <br>
        <input type="submit" value="submit">
    </fieldset>
</form>