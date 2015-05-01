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
		$album = Album::find($_GET['id']);
		require_once('views/albums/show.php');
	}
}
?>
