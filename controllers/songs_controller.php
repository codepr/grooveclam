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
            return call('pages', 'login');
        } else {
            $postdata = $_POST;
            $targetdir = "mp3/";
            $targetfile = $targetdir.basename($_FILES["uploadedMp3"]["name"]);
            var_dump($_FILES);
            $uploadOk = 1;
            if(move_uploaded_file($_FILES["uploadedMp3"]["tmp_name"], $targetfile)) {
                chmod("$targetfile", 0755);
                echo "upload complete";
            } else { echo "no upload "; echo ini_get('post_max_size');
                if ($_FILES["uploadedMp3"]["error"] > 0) {
                    switch ($_FILES['uploadedMp3']['error']) {
                        case UPLOAD_ERR_OK:
                            break;
                        case UPLOAD_ERR_NO_FILE:
                            throw new RuntimeException('No file sent.');
                        case UPLOAD_ERR_INI_SIZE:
                        case UPLOAD_ERR_FORM_SIZE:
                            throw new RuntimeException('Exceeded filesize limit.');
                        default:
                            throw new RuntimeException('Unknown errors.');
                    }
                }
            }
//            Song::add($postdata);
//            Header('Location:/basidati/~abaldan/?controller=songs&action=index');
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
