<?php
class QueueController {
	public function index() {
		if(!isset($_GET['id'])) {
			return call('pages', 'error');
		}
		$session = GrooveSession::getInstance();
		if(!isset($_SESSION['logged'])) {
			return call('pages', 'login');
		}
		$queue = Queue::find($_GET['id']);
		require_once('views/queue/index.php');
	}
}
?>
