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

    public function surname() {
        return "";
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
		$req = $db->prepare('SELECT u.*, l.Username, l.Password FROM Utenti u INNER JOIN Login l ON(u.IdUtente = l.IdUtente) WHERE l.Username = :username AND l.Password = :password');
		$req->execute(array('username' => $uname, 'password' => md5($passw)));
		$u = $req->fetch();
		if($u) {
			return new User($u['IdUtente'], $u['Nome'], $u['Email'], $u['Username'], $u['Password']);
		} else return -1;
	}
	// return a complete user by a given id
	public static function find($id) {
		$db = Db::getInstance();
		$req = $db->prepare('SELECT u.*, l.Username, l.Password FROM Utenti u INNER JOIN Login l ON(u.IdUtente = l.IdUtente) WHERE u.IdUtente = :id');
		$req->execute(array('id' => $id));
		$u = $req->fetch();
		return new User($u['IdUtente'], $u['Nome']." ".$u['Cognome'], $u['Email'], $u['Username'], $u['Password']);
	}
    // retrieve a user based on username
    public static function findByUsername($uname) {
        $db = Db::getInstance();
        $uname = addslashes($uname);
        $req = $db->prepare('SELECT u.*, l.Username, l.Password FROM Utenti u INNER JOIN Login l ON(u.IdUtente = l.IdUtente) WHERE l.Username = :uname');
		$req->execute(array('uname' => $uname));
		$u = $req->fetch();
        return new User($u['IdUtente'], $u['Nome']." ".$u['Cognome'], $u['Email'], $u['Username'], $u['Password']);
    }
	// retrieve fellow list for a user
	public function fellows() {
		$list = array();
		$db = Db::getInstance();
		$req = $db->prepare('SELECT IdSeguace FROM Seguaci WHERE IdUtente = :id');
		$req->execute(array('id' => $this->id()));
		foreach ($req->fetchAll() as $result) {
			$list[] = $result['IdSeguace'];
		}
		return $list;
	}
    // retrieve listening stats
    public function stats() {
        $list = array();
        $db = Db::getInstance();
        $req = $db->prepare('CALL USER_GENRE_DISTRIBUTION(:id)');
        $req->execute(array('id' => $this->id()));
        foreach($req->fetchAll() as $result) {
            $list[$result['Genere']] = $result['Percentuale'];
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
		$req = $db->prepare('INSERT INTO Utenti (Nome, Cognome, Email) VALUES(:name, :surname, :email)');
		$req->execute(array(
			'name' => $data['Name'],
			'surname' => $data['Surname'],
			'email' => $data['Email']
		));
	}
    // follow an User
    public static function follow($id, $uid) {
        $id = intval($id);
        $db = Db::getInstance();
        $req = $db->prepare('INSERT INTO Seguaci(`IdUtente`, `IdSeguace`) VALUES(:uid, :id)');
        $req->execute(array('id' => $id, 'uid' => $uid));
    }
    // unfollow an User
    public static function unfollow($id, $uid) {
        $id = intval($id);
        $db = Db::getInstance();
        $req = $db->prepare('DELETE FROM Seguaci WHERE IdUtente = :uid AND IdSeguace = :id');
        $req->execute(array('id' => $id, 'uid' => $uid));
    }
}
?>
