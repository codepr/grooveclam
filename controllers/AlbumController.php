<?php
class AlbumController {
	public function index() {
		$albums = Album::all();
		require_once('views/albums/index.php');
	}
	// show
}
?>
