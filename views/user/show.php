<h2>&#9881; USER SETTINGS</h2>
<dl style="float:left; margin-right:50px;">
    <dt>Username</dt>
    <dd><?php echo $user->username(); ?></dd>
    <dt>Name</dt>
    <dd><?php echo $user->name(); ?></dd>
    <dt>Surname</dt>
    <dd><?php echo $user->surname(); ?></dd>
    <dt>E-mail</dt>
    <dd><?php echo $user->email(); ?></dd>
    <dt>Following</dt>
    <dd><?php echo count($fellows); ?></dd>
</dl>
<table class="table" style="width: 20%; margin-top:0;">
    <thead>
        <th>Genre</th>
        <th>Distribution</th>
    </thead>
    <tbody>
        <?php foreach($stats as $key => $val) { ?>
            <tr>
                <td><?php echo $key; ?></td>
                <td><?php echo $val; ?></td>
            </tr>
        <?php }?>
    </tbody>
</table>
<div style="clear:both;">
<?php
if(isset($_SESSION['logged'])) {
	if($_SESSION['uid'] != $_GET['id']) {
		if(in_array($_GET['id'], $fellows)) {
			echo "<p><a href='?controller=user&action=follow&id=".$_GET['id']."'><button class='exit add'>&#10010; Follow</button></a></p>";
		} else {
			echo "<p><a href='?controller=user&action=unfollow&id=".$_GET['id']."'><button class='exit add'>&#10008; Unfollow</button></a></p>";
		}
	} else {
        echo "<p><a href='?controller=user&action=manage&id=".$_GET['id']."'><button class='exit add'>&#9881; Manage infos</button></a></p>";
    }
}
?>
</div>