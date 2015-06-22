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
            $shared_fellows = Playlist::shared_fellows($_GET['id']);
            $p = $playlist->id();
            if($playlist === null) {
                return call('pages', 'error', 1);
            } else {
                if($playlist->domain() == 'Privata' && !$playlist->is_mine()) {
                    return call('pages', 'error', 1);
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
            $songlist = Song::all();
            $user = User::find($_SESSION['uid']);
            require_once('views/playlist/newplaylist.php');
        }
    }
    public function createplaylist() {
        if(!isset($_SESSION['logged'])) {
            return call('pages', 'login');
        } else {
            $postdata = $_POST;
            $postdata['uid'] = $_SESSION['uid'];
            try {
                Playlist::create($postdata);
                header("Location:/basidati/~abaldan/?controller=playlist&action=index");
            } catch(Exception $e) {
                return call('pages', 'error', 1);
            }
        }
    }
    public function manage() {
        if(!isset($_SESSION['logged'])) {
            return call('pages', 'login');
        } else {
            if(!isset($_GET['id'])) {
                return call('pages', 'error', 2);
            } else {
                $songlist = Song::all();
                $playlist = Playlist::find($_GET['id']);
                require_once('views/playlist/manage.php');
            }
        }
    }
    public function alter() {
        if(!isset($_SESSION['logged'])) {
            return call('pages', 'login');
        } else {
            if(!isset($_GET['id'])) {
                return call('pages', 'error', 2);
            } else {
                try {
                    $postdata = $_POST;
                    Playlist::alter($postdata);
                    header("Location:/basidati/~abaldan/?controller=playlist&action=show&id=".$_GET['id']);
                } catch(Exception $e) {
                    echo $e->message();
                }
            }
        }
    }
    public function remove() {
        if(!isset($_SESSION['logged'])) {
            return call('pages', 'login');
        } else {
            if(!isset($_GET['id'])) {
                return call('pages', 'error', 2);
            } else {
                $offsetY = 0;
                if(isset($_GET['y'])) {
                    $offsetY = $_GET['y'];
                }
                Playlist::remove($_GET['id']);
                header("Location:/basidati/~abaldan/?controller=playlist&action=index&y=".$offsetY);
            }
        }
    }
    public function swap() {
        if(!isset($_SESSION['logged'])) {
            return call('pages', 'login');
        } else {
            if(!isset($_GET['a']) || !isset($_GET['b']) || !isset($_GET['id'])) {
                return call('pages', 'error', 2);
            } else {
                $offsetY = 0;
                if(isset($_GET['y'])) {
                    $offsetY = $_GET['y'];
                }
                Playlist::swap($_GET['a'], $_GET['b'], $_GET['id']);
                header("Location:/basidati/~abaldan/?controller=playlist&action=show&id=".$_GET['id']."&y=".$offsetY);
            }
        }
    }
}
?>
