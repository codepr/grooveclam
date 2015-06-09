<?php
class PlaylistController {
	public function index() {
		$playlists = Playlist::all();
        if(isset($_SESSION['logged'])) {
            $personal_playlists = Playlist::personal_playlist($_SESSION['uid']);
        }
		require_once('views/playlist/index.php');
	}
	public function show() {
		if(!isset($_GET['id'])) {
			return call('pages', 'error', 2);
		} else {
			$playlist = Playlist::find($_GET['id']);
            $p = $playlist->id();
            if(empty($p)) {
                return call('pages', 'error', 1);
            } else {
                if($playlist->domain()) {
                    return call('pages', 'error', 3);
                } else {
                    require_once('views/playlist/show.php');
                }
            }
	    }
    }
    public function newplaylist() {
        if(!isset($_SESSION['logged'])) {
            return call('pages', 'login');
        } else {
            $collection = Collection::findbyid($_SESSION['uid']);
            require_once('views/playlist/newplaylist.php');
        }
    }
    public function createplaylist() {
        if(!isset($_SESSION['logged'])) {
            return call('pages', 'login');
        } else {
            $postdata = $_POST;
            Playlist::create($postdata);
        }
    }
    public function swap() {
        if(!isset($_SESSION['logged'])) {
            return call('pages', 'login');
        } else {
            if(!isset($_GET['a']) || !isset($_GET['b']) || !isset($_GET['id'])) {
                return call('pages', 'error', 2);
            } else {
                Playlist::swap($_GET['a'], $_GET['b'], $_GET['id']);
                header("Location:/basidati/~abaldan/?controller=playlist&action=show&id=".$_GET['id']);
            }
        }
    }
}
?>
