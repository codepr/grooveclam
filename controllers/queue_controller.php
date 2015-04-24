<?php
class QueueController {
	public function index() {
		if(!isset($_GET['id'])) {
			return call('pages', 'error');
		}
		$queue = Queue::find($_GET['id']);
		require_once('views/queue/index.php');
	}
}
?>
