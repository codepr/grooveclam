<?php
// routing system
function call($controller, $action, $code = 0) {
	require_once('controllers/' . $controller . '_controller.php');
	switch($controller) {
		case 'pages':
			require_once('models/user.php');
			require_once('models/song.php');
            require_once('models/album.php');
			$controller = new PagesController();
	 	break;
		case 'songs':
			require_once('models/song.php');
            require_once('models/album.php');
			$controller = new SongsController();
		break;
		case 'albums':
			require_once('models/album.php');
			$controller = new AlbumController();
		break;
		case 'playlist':
			require_once('models/playlist.php');
            require_once('models/song.php');
            require_once('models/user.php');
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
		case 'user':
			require_once('models/user.php');
			$controller = new UserController();
		break;
	}
	$controller->{$action}($code);
}
// array containing all action for every controller
$controllers = array(
	'pages' => array('home', 'error', 'login', 'checkuser', 'logout', 'registration', 'search', 'register'),
	'songs' => array('index', 'show', 'addheard'),
	'albums' => array('index', 'show'),
	'playlist' => array('index', 'show', 'newplaylist', 'swap', 'createplaylist', 'manage', 'alter', 'remove'),
	'collection' => array('show', 'addsong', 'remove'),
	'queue' => array('index', 'addsong', 'swap', 'remove'),
	'user' => array('show', 'follow', 'unfollow', 'manage', 'alter')
);
if(array_key_exists($controller, $controllers)) {
	if(in_array($action, $controllers[$controller])) {
		call($controller, $action);
	} else {
		call('pages', 'error', 1);
	}
} else {
	call('pages', 'error', 1);
}
?>
