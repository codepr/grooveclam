<?php
class QueueController {
	public function index() {
		if(!isset($_GET['id'])) {
			return call('pages', 'error', 2);
		} else {
			if(isset($_SESSION['logged'])) {
				$queue = Queue::find($_GET['id']);
				require_once('views/queue/index.php');
			} else {
				return call('pages', 'login');
			}
		}
	}
	public function addsong() {
		if(!isset($_GET['id'])) {
			return call('pages', 'error', 2);
		} else {
			if(isset($_SESSION['logged'])) {
				Queue::addsong($_SESSION['uid'], $_GET['id']);
				header('Location:/basidati/~abaldan/?controller=songs&action=index');
			} else {
				return call('pages', 'login');
			}
		}
	}
    public function remove() {
        if(!isset($_GET['id']) || !isset($_GET['pos'])) {
			return call('pages', 'error', 2);
		} else {
			if(isset($_SESSION['logged'])) {
                $offsetY = 0;
                if(isset($_GET['y'])) {
                    $offsetY = $_GET['y'];
                }
				Queue::removesong($_SESSION['uid'], $_GET['id'], $_GET['pos']);
				header("Location:/basidati/~abaldan/?controller=queue&action=index&id=".$_SESSION['uid']."&y=".$offsetY);
			} else {
				return call('pages', 'login');
			}
		}
    }
    public function swap() {
        if(!isset($_SESSION['logged'])) {
            return call('pages', 'login');
        } else {
            if(!isset($_GET['a']) || !isset($_GET['b'])) {
                return call('pages', 'error', 2);
            } else {
                $offsetY = 0;
                if(isset($_GET['y'])) {
                    $offsetY = $_GET['y'];
                }
                Queue::swap($_GET['a'], $_GET['b'], $_SESSION['uid']);
                header("Location:/basidati/~abaldan/?controller=queue&action=index&id=".$_SESSION['uid']."&y=".$offsetY);
            }
        }
    }
}
?>
