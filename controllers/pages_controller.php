<?php
// homepage
class PagesController {
	// here there will be homepage with login form
	public function home() {
		$session = GrooveSession::getInstance();
		if(!isset($_SESSION['logged'])) {
			$this->login();
		} else {
			$first_name = 'Andrea';
			$last_name  = 'Baldan';
			require_once('views/pages/home.php');
		}
	}
	// redirect to error in case of bad inputs
	public function error() {
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
		if($user) {
			$session = GrooveSession::getInstance();
			$session->__set('logged', 1);
		}
		// $this->home();
		header('Location:/grooveclam/');
	}
	// logout
	public function logout() {
		$session = GrooveSession::getInstance();
		$session->destroy();
		// $this->home();
		header('Location:/grooveclam/');
	}
}
?>
