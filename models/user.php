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
		return $this->email;
	}

	public function username() {
		return $this->username;
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
		return new User($u['IdUser'], $u['Name']." ".$u['Surname'], $u['Email'], $u['Username'], $u['Password']);
	}
	// retrieve fellow list for a user
	public function fellows() {
		$list = array();
		$db = Db::getInstance();
		$req = $db->prepare('SELECT IdFellow FROM Follow WHERE IdUser = :id');
		$req->execute(array('id' => $this->id()));
		foreach ($req->fetchAll() as $result) {
			$list[] = $result['IdFellow'];
		}
		return $list;
	}
	// insert new user
	public static function insert($data) {
		$name = '';
		$surname = '';
		if(array_key_exists('Name', $data)) {
			$name = $data['Name'];
		}
		if(array_key_exists('Surname', $data)) {
			$surname = $data['Surname'];
		}
		$db = Db::getInstance();
		$req = $db->prepare('INSERT INTO User (Name, Surname, Email, Username, Password, Administrator) VALUES(:name, :surname, :email, :username, :password, 0)');
		$req->execute(array(
			'name' => $data['Name'],
			'surname' => $data['Surname'],
			'email' => $data['Email'],
			'username' => $data['Username'],
			'password' => $data['Password']
		));
	}
    // follow an User
    public static function follow($id, $uid) {
        $id = intval($id);
        $db = Db::getInstance();
        $req = $db->prepare('INSERT INTO Follow(`IdUser`, `IdFellow`) VALUES(:uid, :id)');
        $req->execute(array('id' => $id, 'uid' => $uid));
    }
    // unfollow an User
    public static function unfollow($id, $uid) {
        $id = intval($id);
        $db = Db::getInstance();
        $req = $db->prepare('DELETE FROM Follow WHERE IdUser = :uid AND IdFellow = :id');
        $req->execute(array('id' => $id, 'uid' => $uid));
    }
}
?>
