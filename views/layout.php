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
					<a href='/basidati/~abaldan'><img src="img/home.png" alt="">Home</a>
				</li>
                <?php if(isset($_SESSION['logged']) && $_SESSION['admin'] == true) { ?>
                    <li <?php if(preg_match('/\/\?controller=user/i', $_SERVER['REQUEST_URI'])) { echo 'class="active"'; } ?>>
                        <a href='?controller=user&action=index'><img src="img/collab.png" alt="">Users</a>
                    </li>
                <?php } ?>
				<li <?php if(preg_match('/\/\?controller=songs/i', $_SERVER['REQUEST_URI'])) { echo 'class="active"'; }?>>
					<a href='?controller=songs&action=index'><img src="img/music.png" alt="">Songs</a>
				</li>
				<li <?php if(preg_match('/\/\?controller=albums/i', $_SERVER['REQUEST_URI'])) { echo 'class="active"'; }?>>
					<a href='?controller=albums&action=index'><img src="img/folder-icon.png" alt="">Albums</a>
				</li>
				<li <?php if(preg_match('/\/\?controller=collection/i', $_SERVER['REQUEST_URI'])) { echo 'class="active"'; }?>>
                    <?php if(isset($_SESSION['logged']) && $_SESSION['admin'] == true) { ?>
                        <a href="?controller=collection&action=index"><img src="img/music-icon.png" alt="">Collections</a>
                    <?php } else { ?>
					    <a href='?controller=collection&action=show&id=<?php echo isset($_SESSION['uid']) ? $_SESSION['uid'] : '-1'; ?>'><img src="img/music-icon.png" alt="">Collection</a>
                    <?php } ?>
				</li>
				<li <?php if(preg_match('/\/\?controller=playlist/i', $_SERVER['REQUEST_URI'])) { echo 'class="active"'; }?>>
					<a href='?controller=playlist&action=index'><img src="img/poweramp-icon.png" alt="">Playlists</a>
				</li>
				<li <?php if(preg_match('/\/\?controller=queue/i', $_SERVER['REQUEST_URI'])) { echo 'class="active"'; }?>>
					<a href='?controller=queue&action=index&id=<?php echo isset($_SESSION['uid']) ? $_SESSION['uid'] : '-1'; ?>'><img src="img/mic-icon.png" alt="">Queue</a>
				</li>
			</ul>
		</nav>
        <div class="logout">
            <?php if('/basidati/~abaldan/' == $_SERVER['REQUEST_URI']) { ?>
                <a href="/basidati/~abaldan/?controller=pages&action=search"><button class="exit" style="padding: 2px 10px 3px 10px;"><div style="float:left;-webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-o-transform: rotate(45deg); transform: rotate(45 deg); margin-right:5px;">&#9906;</div> Search</button></a>
            <?php } ?>
		    <?php if(isset($_SESSION['logged'])) { ?>
                <?php if(preg_match('/\/\?controller=user&action=show/i', $_SERVER['REQUEST_URI'])) { ?>
                    <a href="/basidati/~abaldan/"><button class="exit">&larr; back to home</button></a>
                <?php } else if(preg_match('/\/\?controller=user&action=manage/i', $_SERVER['REQUEST_URI'])) { ?>
                    <button class="exit" onclick="javascript:window.history.back();">&larr; Back</button>
                <?php } else if(preg_match('/\/\?controller=songs&action=show/i', $_SERVER['REQUEST_URI'])) { ?>
                    <a href="/basidati/~abaldan/?controller=songs&action=index"><button class="exit">&larr; Back to songs</button></a>
                <?php } else if(preg_match('/\/\?controller=albums&action=show/i', $_SERVER['REQUEST_URI'])) { ?>
                    <a href="/basidati/~abaldan/?controller=albums&action=index"><button class="exit">&larr; Back to albums</button></a>
                <?php } else if(preg_match('/\/\?controller=playlist&action=show/i', $_SERVER['REQUEST_URI'])) { ?>
                    <a href="/basidati/~abaldan/?controller=playlist&action=index"><button class="exit">&larr; Back to playlists</button></a>
                <?php } ?>
                <a href="/basidati/~abaldan/?controller=user&action=show&id=<?php echo $_SESSION['uid']; ?>"><button class="exit">Settings &#9881;</button></a>
                <a href="/basidati/~abaldan/?controller=pages&action=logout"><button class="exit">Logout &#10144;</button></a>
		    <?php } ?>
        </div>
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
     // get progress bar and commands elements 
     var progressbar = document.getElementById("progressbar");
     var com_1 = document.getElementById("com_1");
     var com_2 = document.getElementById("com_2");
     // add listener to play/pause button
     com_1.addEventListener("click", play_or_pause);
     // add listener to stop button
     com_2.addEventListener("click", stop);
     // simulate song play
     function play(end, title, id) {
         var audio = new Audio("mp3/mad_max.mp3");
         audio.play();
         com_2.click(); // better reset triggering click stop()
         min.innerHTML = "00";
         sec.innerHTML = "00";
         com_1.innerHTML="&#9646;&#9646;";
         pause = true;
         tot = 0;
         document.getElementById("player").style.visibility = "visible";
         clearInterval(timer);
         threshold = end;
         document.getElementById("songtitle").innerHTML = title;
         timer = setInterval(countUp, 1000);
         progressbar.style.transition="all " + threshold + "s linear";
         progressbar.style.width="100%";
         document.getElementById("limits").innerHTML=Math.floor(end / 60) + "." + (end % 60);
         // add to Heard table
         xmlhttp = new XMLHttpRequest();
         xmlhttp.open("GET", "?controller=songs&action=addheard&id=" + id, true);
         xmlhttp.send();
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
             com_1.innerHTML = '&#9654;';
             pause = false;
         } else {
             var endtime = document.getElementById("limits").innerHTML;
             endtime = endtime.split('.');
             endtime = (parseInt(endtime[0]) * 60) + parseInt(endtime[1]);
             var currtime = endtime - ((parseInt(min.innerHTML) * 60) + (parseInt(sec.innerHTML)));
             progressbar.style.transition="all " + currtime +"s linear";
             progressbar.style.width="100%";
             timer = setInterval(countUp, 1000);
             com_1.innerHTML = '&#9646;&#9646;';
             pause = true;
         }
     }
     // stop simulation
     function stop() {
         clearInterval(timer);
         com_1.innerHTML = '&#9654;';
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
