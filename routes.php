<?php
// routing system
function call($controller, $action) {
	require_once('controllers/' . $controller . '_controller.php');
	switch($controller) {
		case 'pages':
			$controller = new PagesController();
	 	break;
		case 'songs':
			require_once('models/song.php');
			$controller = new SongsController();
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
	'pages' => ['home', 'error'],
	'songs' => ['index', 'show'],
	'playlist' => ['index'],  // need add song action
	'collection' => ['index'], // need add song action
	'queue' => ['index'] // need add song action
);

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
