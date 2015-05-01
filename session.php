<?php
class GrooveSession {
	private static $instance;
	private static $id;

	private function __construct() {
		session_start();
		self::$id = session_id();
	}

	private function __clone() {}

	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new GrooveSession();
		}
		return self::$instance;
	}

	public function destroy() {
		foreach ($_SESSION as $var => $val) {
			$_SESSION[$var]	= null;
		}
		session_destroy();
	}

	public function __get($var) {
		return $_SESSION[$var];
	}

}
?>
