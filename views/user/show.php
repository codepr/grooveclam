<h2>&#9881; USER SETTINGS</h2>
<h3><?php echo $user->username(); ?></h3>
<p>Name: <?php echo $user->name(); ?></p>
<p>E-Mail: <?php echo $user->email(); ?></p>
<?php
if(isset($_SESSION['logged'])) {
	if($_SESSION['uid'] != $_GET['id']) {
		if(in_array($_GET['id'], $fellows)) {
			echo "<p><button class='exit add'><a href='?controller=user&action=follow&id=".$_GET['id']."'>&#10010 Follow</a></button></p>";
		} else {
			echo "<p><button class='exit add'><a href='?controller=user&action=unfollow&id=".$_GET['id']."'>&#10010 Unfollow </a></button></p>";
		}
	}
}
?>
