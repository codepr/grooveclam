<?php
class AlbumController {
	public function index() {
		$albums = Album::all();
		require_once('views/albums/index.php');
	}
    // show
	public function show() {
		if(!isset($_GET['id'])) {
			return call('pages', 'error', 2);
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
        if(!isset($_SESSION['logged'])) {
            return call('pages', 'login');
        } else {
            $postdata = $_POST;
            $targetdir = "img/covers/";
            $targetfile = $targetdir.basename($_FILES["uploadedCover"]["name"]);
            var_dump($_FILES);
            $uploadOk = 1;
            if(move_uploaded_file($_FILES["uploadedCover"]["tmp_name"], $targetfile)) {
                chmod("$targetfile", 0755);
                echo "upload complete";
            } else { echo "no upload "; echo ini_get('post_max_size');
                if ($_FILES["uploadedCover"]["error"] > 0) {
                    switch ($_FILES['uploadedCover']['error']) {
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
//            Album::addalbum($postdata);
//            header('Location:basidati/~abaldan/?controller=albums&action=index');
        }
    }
    public function drop() {
        if(!isset($_SESSION['logged'])) {
            return call('pages', 'login');
        } else {
            if($_SESSION['admin'] == false) {
                return call('pages', 'error', 3);
            } else {
                if(!isset($_GET['id'])) {
                    return call('pages', 'error', 2);
                } else {
                    Album::drop($_GET['id']);
                    Header('Location:/basidati/~abaldan/?controller=albums&action=index');
                }
            }
        }
    }
}
?>
