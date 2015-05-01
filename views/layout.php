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
				<li <?php if($_SERVER['REQUEST_URI'] == '/basidati/~abaldan') { echo 'class="active"'; }?>>
					<img src="img/home.png" alt=""><a href='/basidati/~abaldan'>Home</a>
				</li>
				<li <?php if(preg_match('/\/\?controller=songs/i', $_SERVER['REQUEST_URI'])) { echo 'class="active"'; }?>>
					<img src="img/music.png" alt=""><a href='?controller=songs&action=index'>Songs</a>
				</li>
				<li <?php if(preg_match('/\/\?controller=albums/i', $_SERVER['REQUEST_URI'])) { echo 'class="active"'; }?>>
					<img src="img/folder-icon.png" alt=""><a href='?controller=albums&action=index'>Albums</a>
				</li>
				<li <?php if(preg_match('/\/\?controller=collection/i', $_SERVER['REQUEST_URI'])) { echo 'class="active"'; }?>>
					<img src="img/music-icon.png" alt=""><a href='?controller=collection&action=index&id=1'>Collection</a>
				</li>
				<li <?php if(preg_match('/\/\?controller=playlist/i', $_SERVER['REQUEST_URI'])) { echo 'class="active"'; }?>>
					<img src="img/poweramp-icon.png" alt=""><a href='?controller=playlist&action=index&id=1'>Playlist</a>
				</li>
				<li <?php if(preg_match('/\/\?controller=queue/i', $_SERVER['REQUEST_URI'])) { echo 'class="active"'; }?>>
					<img src="img/mic-icon.png" alt=""><a href='?controller=queue&action=index&id=1'>Queue</a>
				</li>
			</ul>
		</nav>
		<?php GrooveSession::getInstance();
		 if(isset($_SESSION['logged'])) {?>
			<div class="logout"><a href="/grooveclam/?controller=pages&action=logout">Logout</a></div>
		<?php } ?>
		<main>
		<?php require_once('routes.php') ?>
		</main>
	</div>
	<footer>
		CodeP&copy; 2015
	</footer>
</body>
</html>
