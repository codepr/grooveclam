<?php
// routing system
function call($controller, $action) {
	require_once('controllers/' . $controller . '_controller.php');
	switch($controller) {
		case 'pages':
			require_once('models/user.php');
			require_once('models/song.php');
			$controller = new PagesController();
	 	break;
		case 'songs':
			require_once('models/song.php');
			$controller = new SongsController();
		break;
		case 'albums':
			require_once('models/album.php');
			$controller = new AlbumController();
		break;
		case 'playlist':
			require_once('models/playlist.php');
			$controller = new PlayListController();
		break;
		case 'collection':
			require_once('models/collection.php');
			$controller = new CollectionController();
		break;
		case 'queue':
			require_once('models/queue.php');
			$controller = new QueueController();
		break;
	}
	$controller->{$action}();
}
// array containing all action for every controller
$controllers = array(
	'pages' => array('home', 'error', 'login', 'checkuser', 'logout'),
	'songs' => array('index', 'show'),
	'albums' => array('index', 'show'),
	'playlist' => array('index'),
	'collection' => array('index', 'addsong', 'remove'),
	'queue' => array('index')
);
// $controllers['pages'] = array('home', 'error');
// $controllers['songs'] = array('index', 'show');
// $controllers['albums'] = array('index', 'show');
// $controllers['playlist'][0] = 'index';
// $controllers['collection'][0] = 'index';
// $controllers['queue'][0] = 'index';

if(array_key_exists($controller, $controllers)) {
	if(in_array($action, $controllers[$controller])) {
		call($controller, $action);
	} else {
		call('pages', 'error');
	}
} else {
	call('pages', 'error');
}
?>
