<?php
class CollectionController {
	public function index() {
        $session = GrooveSession::getInstance();
        if(!isset($_SESSION['logged'])) {
			return call('pages', 'login');
		} else { 
		    if($_SESSION['admin'] != true ) {
			    return call('pages', 'error', 3);
		    } elseif($_SESSION['admin'] == true) {
                $collections = Collection::all();
                require_once('views/collection/index.php');
            }
        }
	}
    public function show() {
        if(!isset($_SESSION['logged'])) {
            return call('pages', 'login');
        } else {
            if(!isset($_GET['id'])) {
                return call('pages', 'error', 2);
            } else {
                $can_i = Collection::canI($_SESSION['uid'], $_GET['id']);
                if(!$can_i) {
                    if(!$_SESSION['admin']) {
                        return call('pages', 'error', 3);
                    } else {
                        $collection = Collection::findbyid($_GET['id']);
		                require_once('views/collection/show.php');
                    }
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
		Collection::addsong($_GET['id'], $_GET['idu']);
		header('Location:/basidati/~abaldan/?controller=songs&action=index');
	}
	public function remove() {
		if(!isset($_GET['id']) || !isset($_GET['idc'])) {
			return call('pages', 'error', 2);
		}
		Collection::remove($_GET['id'], $_GET['idc']);
		header('Location:/basidati/~abaldan/?controller=collection&action=index&id='.$_GET['idc'].'');
	}
}
?>
