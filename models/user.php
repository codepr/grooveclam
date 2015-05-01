<?php
class User {

	private $id;
	private $name;
	private $email;
	private $username;
	private $password;

	public function __construct($id, $name, $email, $username, $password) {
		$this->id = $id;
		$this->name = $name;
		$this->email = $email;
		$this->username = $username;
		$this->password = $password;
	}

	public function id() {
		return $this->id;
	}

	public function name() {
		return $this->name;
	}

	public function email() {
		return $this->email();
	}

	public function username() {
		return $this->username();
	}
	// check if the user exists and return it by given credentials
	public static function checkuser($uname, $passw) {
		$db = Db::getInstance();
		$req = $db->prepare('SELECT * FROM User WHERE Username = :username AND Password = :password');
		$req->execute(array('username' => $uname, 'password' => $passw));
		$u = $req->fetch();
		if($u) {
			return new User($u['IdUser'], $u['Name'], $u['Email'], $u['Username'], $u['Password']);
		} else return -1;
	}
	// return a complete user by a given id
	public static function find($id) {
		$db = Db::getInstance();
		$req = $db->prepare('SELECT * FROM User WHERE IdUser = :id');
		$req->execute(array('id' => $id));
		$u = $req->fetch();
		return new User($u['uUser'], $u['Name'], $u['Email'], $u['Username'], $u['Password']);
	}
}
?>
