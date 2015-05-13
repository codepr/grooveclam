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
				<li <?php if($_SERVER['REQUEST_URI'] == '/basidati/~abaldan/') { echo 'class="active"'; }?>>
					<img src="img/home.png" alt=""><a href='/basidati/~abaldan'>Home</a>
				</li>
				<li <?php if(preg_match('/\/\?controller=songs/i', $_SERVER['REQUEST_URI'])) { echo 'class="active"'; }?>>
					<img src="img/music.png" alt=""><a href='?controller=songs&action=index'>Songs</a>
				</li>
				<li <?php if(preg_match('/\/\?controller=albums/i', $_SERVER['REQUEST_URI'])) { echo 'class="active"'; }?>>
					<img src="img/folder-icon.png" alt=""><a href='?controller=albums&action=index'>Albums</a>
				</li>
				<li <?php if(preg_match('/\/\?controller=collection/i', $_SERVER['REQUEST_URI'])) { echo 'class="active"'; }?>>
					<img src="img/music-icon.png" alt=""><a href='?controller=collection&action=index&id=<?php echo isset($_SESSION['uid']) ? $_SESSION['uid'] : '-1'; ?>'>Collection</a>
				</li>
				<li <?php if(preg_match('/\/\?controller=playlist/i', $_SERVER['REQUEST_URI'])) { echo 'class="active"'; }?>>
					<img src="img/poweramp-icon.png" alt=""><a href='?controller=playlist&action=index'>Playlist</a>
				</li>
				<li <?php if(preg_match('/\/\?controller=queue/i', $_SERVER['REQUEST_URI'])) { echo 'class="active"'; }?>>
					<img src="img/mic-icon.png" alt=""><a href='?controller=queue&action=index&id=<?php echo isset($_SESSION['uid']) ? $_SESSION['uid'] : '-1'; ?>'>Queue</a>
				</li>
			</ul>
		</nav>
		<?php if(isset($_SESSION['logged'])) {?>
			<div class="logout"><button class="exit"><a href="/basidati/~abaldan/?controller=pages&action=logout">Logout &#10144</a></button></div>
		<?php } ?>
		<main>
		<?php require_once('routes.php') ?>
		</main>
	</div>
    <div id="player">
        <label id="minutes">00</label>:<label id="seconds">00</label>
        <p id="songtitle">Song title</p>
        <span style="font-size: .7em;"> &#9646;&#9646;   &#9724;</span>
    </div>
	<footer>
		Progetto Basi di dati 2015
	</footer>
    <script type="text/javascript">
     var min = document.getElementById("minutes");
     var sec = document.getElementById("seconds");
     var tot = 0;
     var threshold = 0;
     var timer;
     var min,
         sec;
     function play(end, title) {
         min.innerHTML = "00";
         sec.innerHTML = "00";
         tot = 0;
         document.getElementById("player").style.visibility = "visible";
         clearInterval(timer);
         var time = end.split(".");
         console.log(time);
         threshold = (parseInt(time[0]) * 60) + parseInt(time[1]);
         document.getElementById("songtitle").innerHTML = title;
         timer = setInterval(countUp, 1000);
     }

     function countUp() {
         if(tot < threshold) {
             ++tot;
         } else { clearInterval(timer); }
         sec.innerHTML = pad(tot % 60);
         min.innerHTML = pad(parseInt(tot/60));
     }

     function pad(val) {
         var valString = val + "";
         if(valString.length < 2) {
             return "0" + valString;
         } else {
             return valString;
         }
     }
    </script>
</body>
</html>
