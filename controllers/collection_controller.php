<?php
class CollectionController {
    public function show() {
        if(!isset($_SESSION['logged'])) {
            return call('pages', 'login');
        } else {
            if(!isset($_GET['id'])) {
                return call('pages', 'error', 2);
            } else {
                $can_i = Collection::canI($_SESSION['uid'], $_GET['id']);
                if(!$can_i) {
                    return call('pages', 'error', 3);
                } else {
                    $collection = Collection::findbyid($_GET['id']);
		            require_once('views/collection/show.php');
                }
            }
        }
    }
	public function addsong() {
		if(!isset($_GET['id']) || !isset($_GET['idu'])) {
			return call('pages', 'error', 2);
		}
        $offsetY = 0;
        if(isset($_GET['y'])) {
            $offsetY = $_GET['y'];
        }
        try {
		    Collection::addsong($_GET['id'], $_GET['idu']);
        } catch(Exception $e) {
            return call('pages', 'error', 3);
        }
		header('Location:/basidati/~abaldan/?controller=songs&action=index&y='.$offsetY);
	}
	public function remove() {
		if(!isset($_GET['id']) || !isset($_GET['idc'])) {
			return call('pages', 'error', 2);
		}
        $offsetY = 0;
        if(isset($_GET['y'])) {
            $offsetY = $_GET['y'];
        }
		Collection::remove($_GET['id'], $_GET['idc']);
		header('Location:/basidati/~abaldan/?controller=collection&action=show&id='.$_GET['idc'].'&y='.$offsetY);
	}
}
?>
