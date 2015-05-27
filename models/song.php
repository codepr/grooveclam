<?php
class Song {

	private $id;
	private $title;
	private $genre;
	private $duration;
	private $author;
	private $idalbum;
	private $album;

	public function __construct($id, $title, $genre, $duration, $author, $idalbum, $album) {
		$this->id = $id;
		$this->title = $title;
		$this->genre = $genre;
		$this->duration = $duration;
		$this->author = $author;
		$this->idalbum = $idalbum;
		$this->album = $album;
	}

	public function id() {
		return $this->id;
	}

	public function title() {
		return $this->title;
	}

	public function genre() {
		return $this->genre;
	}

	public function duration() {
		return $this->duration;
	}

	public function author() {
		return $this->author;
	}

	public function idalbum() {
		return $this->idalbum;
	}

	public function	album() {
		return $this->album;
	}
	// get album cover path
	public function cover() {
		$db = Db::getInstance();
		$req = $db->prepare('SELECT a.PathCopertina FROM Album a WHERE a.IdAlbum = :id');
		$req->execute(array('id' => $this->idalbum()));
		$p = $req->fetch();
		return $p['PathCopertina'];
	}
	// add a song to the database
	public static function add($song) {
        $duration = split('[:.]', $song['Duration']);
        $duration = ($duration[0] * 60) + $duration[1];
		$db = Db::getInstance();
		$req = $db->prepare('INSERT INTO Brani (IdAlbum, Titolo, Genere, Durata) VALUES (:IdAlbum, :Title, :Genre, :Duration)');
		$req->execute(array(
			'IdAlbum' => $song['IdAlbum'],
			'Title' => $song['Title'],
			'Genre' => $song['Genre'],
			'Duration' => $duration,
			)
		);
	}
	// retrieve all songs from the database
	public static function all() {
		$list = array();
		$db = Db::getInstance();
		$req = $db->query('SELECT b.*, a.Autore, a.Titolo as AlbumTitle FROM Brani b INNER JOIN Album a ON(b.IdAlbum = a.IdAlbum)');
		foreach($req->fetchAll() as $song) {
			$list[] = new Song($song['IdBrano'], $song['Titolo'], $song['Genere'], $song['Durata'], $song['Autore'], $song['IdAlbum'], $song['AlbumTitle']);
		}
		return $list;
	}
	// retrieve a single song, by a given id
	public static function find($id) {
		$db = Db::getInstance();
		$id = intval($id);
		$req = $db->prepare('SELECT b.*, a.Autore, a.Titolo as AlbumTitle FROM Brani b INNER JOIN Album a ON(b.IdAlbum = a.IdAlbum) WHERE b.IdBrano = :id');
		$req->execute(array('id' => $id));
		$song = $req->fetch();
		return new Song($song['IdBrano'], $song['Titolo'], $song['Genere'], $song['Durata'], $song['Autore'], $song['IdAlbum'], $song['AlbumTitle']);
	}
	// retrieve last 10 songs inserted
	public static function lasten() {
		$db = Db::getInstance();
		$req = $db->query('SELECT b.IdBrano, b.Titolo, b.Genere FROM Brani b ORDER BY b.IdBrano DESC LIMIT 10');
		$list = array();
		foreach ($req->fetchAll() as $result) {
			$list[]	= array('id' => $result['IdBrano'], 'Title' => $result['Titolo'], 'Genre' => $result['Genere']);
		}
		return $list;
	}
	// retrieve all songs owned by a user by given id
	public static function got($id) {
		$list = array();
		$db = Db::getInstance();
		$req = $db->prepare('SELECT s.IdBrano FROM Brani s INNER JOIN BraniCollezione sc ON(s.IdBrano = sc.IdBrano) INNER JOIN Collezioni c ON(sc.IdCollezione = c.IdCollezione) INNER JOIN Utenti u ON(c.IdUtente = u.IdUtente) WHERE u.IdUtente = :id');
		$req->execute(array('id' => $id));
		foreach ($req->fetchAll() as $got) {
			$list[] = $got['IdBrano'];
		}
		return $list;
	}
	// retrieve first 10 songs played during last week ordered by play time
	public static function lastweekplay() {
		$list = array();
		$db = Db::getInstance();
		$req = $db->query('SELECT s.IdBrano, s.Titolo, COUNT(h.IdBrano) AS played FROM Brani s INNER JOIN Ascoltate h ON(s.IdBrano = h.IdBrano) WHERE h.Timestamp BETWEEN ADDDATE(CURDATE(), - 7) AND NOW() GROUP BY h.IdBrano ORDER BY played DESC LIMIT 10');
		foreach ($req->fetchAll() as $result) {
			$list[] = array('id' => $result['IdBrano'], 'Title' => $result['Titolo'], 'Count' => $result['played']);
		}
		return $list;
	}
	//retrieve last 10 songs played by fellow ordered by timestamp
	public static function lastfellowsplay($id) {
		$list = array();
		$id = intval($id);
		$db = Db::getInstance();
		$query = 'SELECT s.IdBrano, s.Titolo, a.IdAlbum, a.Titolo AS AlbumTitle, l.Username, u.IdUtente FROM Brani s INNER JOIN Album a ON(s.IdAlbum = a.IdAlbum) '.
			'INNER JOIN Ascoltate h ON(s.IdBrano = h.IdBrano) INNER JOIN Seguaci f ON(h.IdUtente = f.IdSeguace) INNER JOIN Utenti u ON(u.IdUtente = f.IdSeguace) '.
			'INNER JOIN Login l ON(u.IdUtente = l.IdUtente) WHERE h.Timestamp BETWEEN ADDDATE(CURDATE(), -7) AND NOW() AND u.IdUtente IN '.
			     '(SELECT u.IdUtente FROM Utenti u INNER JOIN Seguaci f ON(u.IdUtente = f.IdSeguace) WHERE f.IdUtente = :id) ORDER BY h.Timestamp DESC LIMIT 10';
		$req = $db->prepare($query);
		$req->execute(array('id' => $id));
		foreach ($req->fetchAll() as $result) {
			$list[] = array(
				'id' => $result['IdUtente'],
				'Title' => $result['Titolo'],
				'AlbumTitle' => $result['AlbumTitle'],
				'Username' => $result['Username'],
				'IdUser' => $result['IdUtente'],
				'IdAlbum' => $result['IdAlbum']
			);
		}
		return $list;
    }
    // add a song to heard table
    public static function addheard($id, $uid) {
        $id = intval($id);
        $uid = intval($uid);
        $db = Db::getInstance();
        $req = $db->prepare('INSERT INTO Ascoltate (`IdUtente`, `IdBrano`, `Timestamp`) VALUES(:uid, :id, NOW())');
        $req->execute(array('id' => $id, 'uid' => $uid));
    }
}
?>
