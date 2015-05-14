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
			<div class="logout">
                <button class="exit"><a href="/basidati/~abaldan/?controller=user&action=show&id=<?php echo $_SESSION['uid']; ?>">Settings &#9881</a></button>
                <button class="exit"><a href="/basidati/~abaldan/?controller=pages&action=logout">Logout &#10144</a></button>
            </div>
		<?php } ?>
		<main>
		<?php require_once('routes.php') ?>
		</main>
	</div>
    <div id="player">
        <label id="minutes">00</label>:<label id="seconds">00</label>
        <p id="songtitle">Song title</p>
        <span style="font-size: .7em;"> <a href="#"><span id="com_1">&#9646;&#9646;</span></a> <a href="#"> <span id="com_2">&#9724;</span></a></span>
        <div id="progressbar"></div>
        <div id="limits"></div>
    </div>
	<footer>
		Progetto Basi di dati 2015
	</footer>
    <script type="text/javascript">
     var min = document.getElementById("minutes");
     var sec = document.getElementById("seconds");
     var tot = 0;
     var threshold = 0;
     var pause = true;
     var timer;
     var min,
         sec;
     // get progress bar element
     var progressbar = document.getElementById("progressbar");
     // add listener to play/pause button
     document.getElementById("com_1").addEventListener("click", play_or_pause);
     // add listener to stop button
     document.getElementById("com_2").addEventListener("click", stop);
     // simulate song play
     function play(end, title) {
         document.getElementById("com_2").click(); // better reset triggering click stop()
         min.innerHTML = "00";
         sec.innerHTML = "00";
         document.getElementById("com_1").innerHTML="&#9646;&#9646;";
         pause = true;
         tot = 0;
         document.getElementById("player").style.visibility = "visible";
         clearInterval(timer);
         var time = end.split(".");
         threshold = (parseInt(time[0]) * 60) + parseInt(time[1]);
         document.getElementById("songtitle").innerHTML = title;
         timer = setInterval(countUp, 1000);
         progressbar.style.transition="all " + threshold + "s linear";
         progressbar.style.width="100%";
         document.getElementById("limits").innerHTML=end;
     }
     // simulate a counter to the end of the song
     function countUp() {
         if(tot < threshold) {
             ++tot;
         } else { clearInterval(timer); }
         sec.innerHTML = pad(tot % 60);
         min.innerHTML = pad(parseInt(tot / 60));
     }
     // format value
     function pad(val) {
         var valString = val + "";
         if(valString.length < 2) {
             return "0" + valString;
         } else {
             return valString;
         }
     }
     // pause simulation or play it
     function play_or_pause() {
         if(pause == true) {
             var endtime = document.getElementById("limits").innerHTML;
             endtime = endtime.split('.');
             endtime = (parseInt(endtime[0]) * 60) + parseInt(endtime[1]);
             var currtime = endtime - ((parseInt(min.innerHTML) * 60) + (parseInt(sec.innerHTML)));
             progressbar.style.transition="all " + currtime +"s linear";
             var currwidth = progressbar.offsetWidth; // getting current width
             progressbar.style.width=currwidth + "px"; // stop the transition setting current width
             clearInterval(timer);
             document.getElementById("com_1").innerHTML = '&#9654;';
             pause = false;
         } else {
             var endtime = document.getElementById("limits").innerHTML;
             endtime = endtime.split('.');
             endtime = (parseInt(endtime[0]) * 60) + parseInt(endtime[1]);
             var currtime = endtime - ((parseInt(min.innerHTML) * 60) + (parseInt(sec.innerHTML)));
             progressbar.style.transition="all " + currtime +"s linear";
             progressbar.style.width="100%";
             timer = setInterval(countUp, 1000);
             document.getElementById("com_1").innerHTML = '&#9646;&#9646;';
             pause = true;
         }
     }
     // stop simulation
     function stop() {
         clearInterval(timer);
         document.getElementById("com_1").innerHTML = '&#9654;';
         progressbar.style.transition="all 0s linear";
         progressbar.style.width="0px";
         pause = false;
         tot = 0;
         min.innerHTML = '00';
         sec.innerHTML = '00';
     }
    </script>
</body>
</html>
