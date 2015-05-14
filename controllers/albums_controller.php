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
    public function add() {
        if(!isset($_SESSION['logged'])) {
            return call('pages', 'login');
        } else {
            require_once('views/albums/add.php');
        }
    }
    public function addalbum() {
        if(!isset($_POST['Title'])) {
            return call('pages', 'login');
        } else {
            $postdata = $_POST;
            Album::addalbum($postdata);
            header('Location:basidati/~abaldan/?controller=albums&action=index');
        }
    }
}
?>
