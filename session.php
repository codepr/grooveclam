<?php
// singleton wrapper class for session
class GrooveSession {
	// instance static field for singleton object
	private static $instance;
	// static session id
	private static $id;
	// private constructor according to singleton pattern
	private function __construct() {
		session_start();
		self::$id = session_id();
	}
	// private clone according to singleton pattern
	private function __clone() {}
		// get session instance avoiding creation if already exists
	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new GrooveSession();
		}
		return self::$instance;
	}
	// destroy session instance
	public function destroy() {
		foreach ($_SESSION as $var => $val) {
			$_SESSION[$var]	= null;
		}
		session_destroy();
	}
	// get requested variable
	public function __get($var) {
		return $_SESSION[$var];
	}
	// set variable into session instance
	public function __set($var, $val) {
		$_SESSION[$var] = $val;
	}
}
?>
