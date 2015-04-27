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

	public static function all() {
		$list = array();
		$db = Db::getInstance();
		$req = $db->query('SELECT s.*, a.Author, a.Title as AlbumTitle FROM Song s INNER JOIN Album a ON(s.IdAlbum = a.IdAlbum)');

		foreach($req->fetchAll() as $song) {
			$list[] = new Song($song['IdSong'], $song['Title'], $song['Genre'], $song['Duration'], $song['Author'], $song['IdAlbum'], $song['AlbumTitle']);
		}

		return $list;
	}

	public static function find($id) {
		$db = Db::getInstance();
		$id = intval($id);
		$req = $db->prepare('SELECT s.*, a.Author, a.Title as AlbumTitle FROM Song s INNER JOIN Album a ON(s.IdAlbum = a.IdAlbum) WHERE IdSong = :id');
		$req->execute(array('id' => $id));
		$song = $req->fetch();

		return new Song($song['IdSong'], $song['Title'], $song['Genre'], $song['Duration'], $song['Author'], $song['IdAlbum'], $song['AlbumTitle']);
	}
}
?>
