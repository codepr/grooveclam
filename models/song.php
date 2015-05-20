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
		$req = $db->prepare('SELECT c.Path FROM Cover c INNER JOIN Album a ON(c.IdAlbum = a.IdAlbum) INNER JOIN Song s ON (s.IdAlbum = a.IdAlbum) WHERE a.IdAlbum = :id');
		$req->execute(array('id' => $this->idalbum()));
		$p = $req->fetch();
		return $p['Path'];
	}
	// add a song to the database
	public static function add($song) {
        $duration = split('[:.]', $song['Duration']);
        $duration = ($duration[0] * 60) + $duration[1];
		$db = Db::getInstance();
		$req = $db->prepare('INSERT INTO SONG (IdAlbum, Title, Genre, Duration, IdImage) VALUES (:IdAlbum, :Title, :Genre, :Duration, :IdImage)');
		$req->execute(array(
			'IdAlbum' => $song['IdAlbum'],
			'Title' => $song['Title'],
			'Genre' => $song['Genre'],
			'Duration' => $duration,
			'IdImage' => $song['IdImage']
			)
		);
	}
	// retrieve all songs from the database
	public static function all() {
		$list = array();
		$db = Db::getInstance();
		$req = $db->query('SELECT s.*, a.Author, a.Title as AlbumTitle FROM Song s INNER JOIN Album a ON(s.IdAlbum = a.IdAlbum)');
		foreach($req->fetchAll() as $song) {
			$list[] = new Song($song['IdSong'], $song['Title'], $song['Genre'], $song['Duration'], $song['Author'], $song['IdAlbum'], $song['AlbumTitle']);
		}
		return $list;
	}
	// retrieve a single song, by a given id
	public static function find($id) {
		$db = Db::getInstance();
		$id = intval($id);
		$req = $db->prepare('SELECT s.*, a.Author, a.Title as AlbumTitle FROM Song s INNER JOIN Album a ON(s.IdAlbum = a.IdAlbum) WHERE IdSong = :id');
		$req->execute(array('id' => $id));
		$song = $req->fetch();
		return new Song($song['IdSong'], $song['Title'], $song['Genre'], $song['Duration'], $song['Author'], $song['IdAlbum'], $song['AlbumTitle']);
	}
	// retrieve last 10 songs inserted
	public static function lasten() {
		$db = Db::getInstance();
		$req = $db->query('SELECT s.IdSong, s.Title, s.Genre FROM Song s ORDER BY s.IdSong DESC LIMIT 10');
		$list = array();
		foreach ($req->fetchAll() as $result) {
			$list[]	= array('id' => $result['IdSong'], 'Title' => $result['Title'], 'Genre' => $result['Genre']);
		}
		return $list;
	}
	// retrieve all songs owned by a user by given id
	public static function got($id) {
		$list = array();
		$db = Db::getInstance();
		$req = $db->prepare('SELECT s.IdSong FROM Song s INNER JOIN SongCollection sc ON(s.IdSong = sc.IdSong) INNER JOIN Collection c ON(sc.IdCollection = c.IdCollection) INNER JOIN User u ON(c.IdUser = u.IdUser) WHERE u.IdUser = :id');
		$req->execute(array('id' => $id));
		foreach ($req->fetchAll() as $got) {
			$list[] = $got['IdSong'];
		}
		return $list;
	}
	// retrieve first 10 songs played during last week ordered by play time
	public static function lastweekplay() {
		$list = array();
		$db = Db::getInstance();
		$req = $db->query('SELECT s.IdSong, s.Title, COUNT(h.IdSong) AS played FROM Song s INNER JOIN Heard h ON(s.IdSong = h.IdSong) WHERE h.TimeStamp BETWEEN ADDDATE(CURDATE(), - 7) AND NOW() GROUP BY h.IdSong ORDER BY played DESC LIMIT 10');
		foreach ($req->fetchAll() as $result) {
			$list[] = array('id' => $result['IdSong'], 'Title' => $result['Title'], 'Count' => $result['played']);
		}
		return $list;
	}
	//retrieve last 10 songs played by fellow ordered by timestamp
	public static function lastfellowsplay($id) {
		$list = array();
		$id = intval($id);
		$db = Db::getInstance();
		$query = 'SELECT s.IdSong, s.Title, a.IdAlbum, a.Title AS AlbumTitle, u.Username, u.IdUser FROM Song s INNER JOIN Album a ON(s.IdAlbum = a.IdAlbum) '.
			'INNER JOIN Heard h ON(s.IdSong = h.IdSong) INNER JOIN Follow f ON(h.IdUser = f.IdFellow) INNER JOIN User u ON(u.IdUser = f.IdFellow) '.
			'WHERE h.TimeStamp BETWEEN ADDDATE(CURDATE(), -7) AND NOW() AND u.IdUser IN '.
			     '(SELECT u.IdUser FROM User u INNER JOIN Follow f ON(u.IdUser = f.IdFellow) WHERE f.IdUser = :id) ORDER BY h.TimeStamp DESC LIMIT 10';
		$req = $db->prepare($query);
		$req->execute(array('id' => $id));
		foreach ($req->fetchAll() as $result) {
			$list[] = array(
				'id' => $result['IdSong'],
				'Title' => $result['Title'],
				'AlbumTitle' => $result['AlbumTitle'],
				'Username' => $result['Username'],
				'IdUser' => $result['IdUser'],
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
        $req = $db->prepare('INSERT INTO Heard (`IdUser`, `IdSong`, `TimeStamp`) VALUES(:uid, :id, NOW())');
        $req->execute(array('id' => $id, 'uid' => $uid));
    }
}
?>
