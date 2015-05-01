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
		$db = Db::getInstance();
		$req = $db->prepare('INSERT INTO SONG (IdAlbum, Title, Genre, Duration, IdImage) VALUES (:IdAlbum, :Title, :Genre, :Duration, :IdImage)');
		$req->execute(array(
			'IdAlbum' => $song['IdAlbum'],
			'Title' => $song['Title'],
			'Genre' => $song['Genre'],
			'Duration' => $song['Duration'],
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
		$req = $db->query('SELECT s.IdSong, s.Title FROM Song s ORDER BY s.IdSong DESC LIMIT 10');
		$list = array();
		foreach ($req->fetchAll() as $result) {
			$list[]	= array('id' => $result['IdSong'], 'Title' => $result['Title']);
		}
		return $list;
	}
}
?>
