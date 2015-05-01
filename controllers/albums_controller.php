<?php
class AlbumController {
	public function index() {
		$albums = Album::all();
		require_once('views/albums/index.php');
	}
	// show
	public function show() {
		if(!isset($_GET['id'])) {
			return call('pages', 'error');
		}
		$session = GrooveSession::getInstance();
		if(!isset($_SESSION['logged'])) {
			return call('pages', 'login');
		}
		$album = Album::find($_GET['id']);
		require_once('views/albums/show.php');
	}
}
?>
