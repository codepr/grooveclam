<?php
// Singleton for database object
class Db {
	// instance static field for singleton
	private static $instance = NULL;
	// private constructor following singleton pattern
	private function __construct() {}
	// private clone following singleton pattern
	private function __clone() {}
	// get database instance avoiding creation if already exists one
	public  static function getInstance() {
		if(!isset(self::$instance)) {
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			self::$instance = new PDO('mysql:host=localhost;dbname=;', , , $pdo_options);
		}
		return self::$instance;
	}
}
?>
