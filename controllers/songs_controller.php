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
			return call('pages', 'error');
		}
		$got = array();
		if(isset($_SESSION['logged'])) {
			$got = Song::got($_SESSION['uid']);
		}
		$song = Song::find($_GET['id']);
		require_once('views/songs/show.php');
	}
    public function addnew() {
        if(!isset($_SESSION['logged'])) {
            return call('pages', 'login');
        } else {
            $albums = Album::all();
            require_once('views/songs/addnew.php');
        }
    }
    public function addsong() {
        if(!isset($_SESSION['logged'])) {
            return call('pages', 'error');
        } else {
            $postdata = $_POST;
            Song::add($postdata);
            Header('Location:/basidati/~abaldan/?controller=songs&action=index');
        }
    }
    public function addheard() {
        if(isset($_SESSION['logged'])) {
            if(!isset($_GET['id'])){ 
                return call('pages', 'error');
            } else {
                Song::addheard($_GET['id'], $_SESSION['uid']);
                exit;
            }
        }
    }
}
?>
