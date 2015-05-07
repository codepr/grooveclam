<?php
class UserController {
	public function show() {
		if(!isset($_GET['id'])) {
			return call('pages', 'error');
		} else {
			$id = intval($_GET['id']);
			$user = User::find($id);
			$fellows = $user->fellows();
			require_once('views/user/show.php');
		}
	}
}
?>
