<?php
class PlaylistController {
	public function index() {
		$playlists = Playlist::all();
		require_once('views/playlist/index.php');
	}
	public function show() {
		if(!isset($_GET['id'])) {
			return call('pages', 'error');
		} else {
			$playlist = Playlist::find($_GET['id']);
			require_once('views/playlist/show.php');
		}
	}
    public function newplaylist() {
        if(!isset($_SESSION['logged'])) {
            return call('pages', 'error');
        } else {
            $collection = Collection::findbyid($_SESSION['uid']);
            require_once('views/playlist/newplaylist.php');
        }
    }
    public function createplaylist() {
        if(!isset($_SESSION['logged'])) {
            return call('pages', 'error');
        } else {
            $postdata = $_POST;
            Playlist::create($postdata);
        }
    }
}
?>
