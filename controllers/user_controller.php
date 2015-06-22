<?php
class UserController {
	public function show() {
		if(!isset($_GET['id'])) {
			return call('pages', 'error', 2);
		} else {
			$id = intval($_GET['id']);
			$user = User::find($id);
			$fellows = $user->fellows();
            $stats = $user->stats();
			require_once('views/user/show.php');
		}
	}
    public function follow() {
        if(!isset($_SESSION['logged'])) {
            return call('pages', 'login');
        } else {
            if(!isset($_GET['id'])) {
                return call('pages', 'error', 2);
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
                return call('pages', 'error', 2);
            } else {
                User::unfollow($_GET['id'], $_SESSION['uid']);
                header('Location:/basidati/~abaldan/?controller=user&action=show&id='.$_GET['id']);
            }
        }
    }
    public function manage() {
        if(!isset($_SESSION['logged'])) {
            return call('pages', 'login');
        } else {
            if(!isset($_GET['id'])) {
                return call('pages', 'error', 2);
            } else {
                $user = User::find($_GET['id']);
                require_once('views/user/manage.php');
            }
        }
    }
    public function alter() {
        if(!isset($_SESSION['logged'])) {
            return call('pages', 'login');
        } else {
            if(!isset($_GET['id'])) {
                return call('pages', 'error', 2);
            } else {
                try {
                    $postdata = $_POST;
                    User::alter($_GET['id'], $postdata);
                    header("Location:/basidati/~abaldan/?controller=user&action=show&id=".$_GET['id']);
                } catch(Exception $e) {
                    return call('pages', 'error', 2);
                }
            }
        }
    }
}
?>
