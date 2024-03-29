<?php
class SongsController {
	public function index() {
		$songs = Song::all();
		$got = array();
		if(isset($_SESSION['logged'])) {
			$got = Song::got($_SESSION['uid']);
		}
		require_once('views/songs/index.php');
	}
	public function show() {
		if(!isset($_GET['id'])) {
			return call('pages', 'error', 2);
		}
		$got = array();
		if(isset($_SESSION['logged'])) {
			$got = Song::got($_SESSION['uid']);
		}
		$song = Song::find($_GET['id']);
		require_once('views/songs/show.php');
	}
    public function addheard() {
        if(isset($_SESSION['logged'])) {
            if(!isset($_GET['id'])){ 
                return call('pages', 'error', 2);
            } else {
                Song::addheard($_GET['id'], $_SESSION['uid']);
                exit;
            }
        }
    }
}
?>
