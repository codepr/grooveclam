<?php
class CollectionController {
	public function index() {
		if(!isset($_GET['id'])) {
			return call('pages', 'error', 2);
		}
		$session = GrooveSession::getInstance();
		if(!isset($_SESSION['logged'])) {
			return call('pages', 'login');
		}
		$collection = Collection::findbyid($_GET['id']);
		require_once('views/collection/index.php');
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
