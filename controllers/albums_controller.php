<?php
class AlbumController {
	public function index() {
		$albums = Album::all();
		require_once('views/albums/index.php');
	}
    // show
	public function show() {
		if(!isset($_GET['id'])) {
			return call('pages', 'error', 2);
		}
		$album = Album::find($_GET['id']);
        $ida = $album->id();
        if($ida === null) {
            return call('pages', 'error', 1);
        } else {
		    require_once('views/albums/show.php');
        }
    }
}
?>
