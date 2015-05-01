<?php
class PlaylistController {
	public function index() {
		if(!isset($_GET['id'])) {
			return call('pages', 'error');
		}
		$session = GrooveSession::getInstance();
		if(!isset($_SESSION['logged'])) {
			return call('pages', 'login');
		}
		$playlist = Playlist::find($_GET['id']);
		require_once('views/playlist/index.php');
	}
}
?>
