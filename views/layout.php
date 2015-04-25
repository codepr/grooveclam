<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>Grooveclam</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<header>
		<img src="img/blueseashell.png" alt="">
		<h1>Grooveclam</h1>
	</header>
	<div class="content">
		<nav>
			<ul>
				<li><a href='/grooveclam'>Home</a></li>
				<li><a href='?controller=songs&action=index'>Songs</a></li>
				<li><a href='?controller=collection&action=index&id=1'>Collection</a></li>
				<li><a href='?controller=playlist&action=index&id=1'>Playlist</a></li>
				<li><a href='?controller=queue&action=index&id=1'>Queue</a></li>
			</ul>
		</nav>
		<main>
		<?php require_once('routes.php') ?>
		</main>
	</div>
	<footer>
		CodeP&copy; 2015
	</footer>
</body>
</html>
