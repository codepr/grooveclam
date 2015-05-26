<?php
// homepage
class PagesController {
	// here there will be homepage with login form
	public function home() {
		$session = GrooveSession::getInstance();
		if(!isset($_SESSION['logged'])) {
			$this->login();
		} else {
			$user = User::find($_SESSION['uid']);
			$first_name = $user->name();
			$lasten = Song::lasten();
			$lastplay = Song::lastweekplay();
			$lastfellowsplay = Song::lastfellowsplay($_SESSION['uid']);
			require_once('views/pages/home.php');
		}
	}
	// redirect to error in case of bad inputs
	public function error($code) {
        $errors = array(
            0 => '',
            1 => '404 page does not exists',
            2 => 'Missing get or post parameters'
        );
        $message = $errors{$code};
		require_once('views/pages/error.php');
	}
	// redirect to login form
	public function login() {
		require_once('views/pages/login.php');
	}
	// check for login credentials and initialize session
	public function checkuser() {
		$uname = $_POST['uname'];
		$passw = $_POST['passw'];
		$user = User::checkuser($uname, $passw);
		if($user != -1) {
			$session = GrooveSession::getInstance();
			$session->__set('logged', 1);
			$session->__set('uid', $user->id());
			header('Location:/basidati/~abaldan/');
		} else {
			$this->login();
		}
	}
	// logout
	public function logout() {
		$session = GrooveSession::getInstance();
		$session->destroy();
		header('Location:/basidati/~abaldan/');
	}
	// registration form
	public function registration() {
		require_once('views/pages/register.php');
	}
	// registration
	public function register() {
		if(!isset($_POST['Username']) || !isset($_POST['Password']) ||!isset($_POST['Email'])) {
			return call('pages', 'error');
		} else {
			$postdata = $_POST;
			User::insert($postdata);
			header('Location:/basidati/~abaldan/');
		}
	}
}
?>
