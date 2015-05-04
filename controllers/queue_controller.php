<?php
class QueueController {
	public function index() {
		if(!isset($_GET['id'])) {
			return call('pages', 'error');
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
			return call('pages', 'error');
		} else {
			if(isset($_SESSION['logged'])) {
				Queue::addsong($_SESSION['uid'], $_GET['id']);
				header('Location:/basidati/~abaldan/?controller=queue&action=index&id='.$_SESSION['uid'].'');
			} else {
				return call('pages', 'login');
			}
		}
	}
}
?>
