<?php
class Song {
	private $id;
	private $title;
	private $genre;
	private $duration;
	private $author;

	public function __construct($id, $title, $genre, $duration, $author) {
		$this->id = $id;
		$this->title = $title;
		$this->genre = $genre;
		$this->duration = $duration;
		$this->author = $author;
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

	public static function all() {
		$list = [];
		$db = Db::getInstance();
		$req = $db->query('SELECT s.*, a.Author FROM Song s INNER JOIN Album a ON(s.IdAlbum = a.IdAlbum)');

		foreach($req->fetchAll() as $song) {
			$list[] = new Song($song['IdSong'], $song['Title'], $song['Genre'], $song['Duration'], $song['Author']);
		}

		return $list;
	}

	public static function find($id) {
		$db = Db::getInstance();
		$id = intval($id);
		$req = $db->prepare('SELECT s.*, a.Author FROM Song s INNER JOIN Album a ON(s.IdAlbum = a.IdAlbum) WHERE IdSong = :id');
		$req->execute(array('id' => $id));
		$song = $req->fetch();

		return new Song($song['IdSong'], $song['Title'], $song['Genre'], $song['Duration'], $song['Author']);
	}
}
?>
