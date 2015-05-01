<?php
class CollectionController {
	public function index() {
		if(!isset($_GET['id'])) {
			return call('pages', 'error');
		}
		$session = GrooveSession::getInstance();
		if(!isset($_SESSION['logged'])) {
			return call('pages', 'login');
		}
		$collection = Collection::find($_GET['id']);
		require_once('views/collection/index.php');
	}
}
?>
