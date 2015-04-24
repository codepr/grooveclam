<?php
class CollectionController {
	public function index() {
		if(!isset($_GET['id'])) {
			return call('pages', 'error');
		}
		$collection = Collection::find($_GET['id']);
		require_once('views/collection/index.php');
	}
}
?>
