<!DOCTYPE html>
<html>
<head>
<title>Grooveclam</title>
<!-- css, js.. -->
</head>
<body>
	<header>
	 	<a href='/grooveclam'>Home</a>
		<a href='?controller=songs&action=index'>Songs</a>
		<a href='?controller=collection&action=index&id=1'>Collection</a>
		<a href='?controller=playlist&action=index&id=1'>Playlist</a>
	</header>
	<?php require_once('routes.php') ?>
	<footer>
		CodeP&copy; 2015
	</footer>
</body>
</html>
