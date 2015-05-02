<!DOCTYPE html>
<?php GrooveSession::getInstance(); ?>
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
					<img src="img/music-icon.png" alt=""><a href='?controller=collection&action=index&id=<?php echo $_SESSION['uid']; ?>'>Collection</a>
				</li>
				<li <?php if(preg_match('/\/\?controller=playlist/i', $_SERVER['REQUEST_URI'])) { echo 'class="active"'; }?>>
					<img src="img/poweramp-icon.png" alt=""><a href='?controller=playlist&action=index&id=<?php echo $_SESSION['uid']; ?>'>Playlist</a>
				</li>
				<li <?php if(preg_match('/\/\?controller=queue/i', $_SERVER['REQUEST_URI'])) { echo 'class="active"'; }?>>
					<img src="img/mic-icon.png" alt=""><a href='?controller=queue&action=index&id=<?php echo $_SESSION['uid']; ?>'>Queue</a>
				</li>
			</ul>
		</nav>
		<?php if(isset($_SESSION['logged'])) {?>
			<div class="logout"><button class="exit"><a href="/grooveclam/?controller=pages&action=logout">Logout &#10144</a></button></div>
		<?php } ?>
		<main>
		<?php require_once('routes.php') ?>
		</main>
	</div>
	<footer>
		Progetto Basi di dati 2015
	</footer>
</body>
</html>
