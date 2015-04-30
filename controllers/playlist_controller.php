<?php
class PlaylistController {
	public function index() {
		if(!isset($_GET['id'])) {
			return call('pages', 'error');
		}

		$playlist = Playlist::find($_GET['id']);
		require_once('views/playlist/index.php');
	}
}
?>
