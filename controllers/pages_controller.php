<?php
// homepage
class PagesController {
	// here there will be homepage with login form
	public function home() {
		$first_name = 'Andrea';
		$last_name  = 'Baldan';
		require_once('views/pages/home.php');
	}
	// redirect to error in case of bad inputs
	public function error() {
		require_once('views/pages/error.php');
	}
}
?>
