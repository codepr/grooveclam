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
}
?>
