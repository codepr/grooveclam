<?php
// Singleton for database object
class Db {

	private static $instance = NULL;

	private function __construct() {}

	private function __clone() {}
	// get database instance avoiding creation if already exists one
	public  static function getInstance() {
		if(!isset(self::$instance)) {
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			self::$instance = new PDO('mysql:host=localhost;dbname=grooveclam', 'root', 'yiz,CEF1', $pdo_options);
		}
		return self::$instance;
	}
}
?>
