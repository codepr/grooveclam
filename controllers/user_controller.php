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
    public function follow() {
        if(!isset($_SESSION['logged'])) {
            return call('pages', 'login');
        } else {
            if(!isset($_GET['id'])) {
                return call('pages', 'error');
            } else {
                User::follow($_GET['id'], $_SESSION['uid']);
                header('Location:/basidati/~abaldan/?controller=user&action=show&id='.$_GET['id']);
            }
        }
    }
    public function unfollow() {
        if(!isset($_SESSION['logged'])) {
            return call('pages', 'login');
        } else {
            if(!isset($_GET['id'])) {
                return call('pages', 'error');
            } else {
                User::unfollow($_GET['id'], $_SESSION['uid']);
                header('Location:/basidati/~abaldan/?controller=user&action=show&id='.$_GET['id']);
            }
        }
    }
}
?>
