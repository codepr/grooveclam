<?php
class SongsController {
	public function index() {
		$songs = Song::all();
		require_once('views/songs/index.php');
	}
	public function show() {
		if(!isset($_GET['id'])) {
			return call('pages', 'error');
		}
		$song = Song::find($_GET['id']);
		require_once('views/songs/show.php');
	}
}
?>
