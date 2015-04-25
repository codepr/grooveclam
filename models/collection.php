<?php
require_once('song.php');
class Collection {
	private $id;
	private $songs;

	public function __construct($id, $songs) {
		$this->id = $id;
		$this->songs = $songs;
	}

	public function songs() {
		return $this->songs;
	}
	// list all collections, for administrator users
	public function all() {
		$list = [];
		$db = Db::getInstance();
		$req = $db->query('SELECT * FROM Collection');
		foreach($req->fetchAll() as $collection) {
			$list[] = new Collection($collection['IdCollection'], []);
		}
		return $list;
	}
	// find a single collection and all contained songs
	public static function find($id) {
		$list = [];
		$song;
		$db = Db::getInstance();
		$req = $db->prepare('SELECT c.IdCollection, s.*, a.Author FROM Song s INNER JOIN SongCollection sc ON(s.IdSong = sc.IdSong) INNER JOIN Collection c ON (sc.IdCollection = c.IdCollection) INNER JOIN Album a ON (s.IdAlbum = a.IdAlbum) WHERE c.IdCollection = :id');
		$req->execute(array('id' => $id));
		foreach($req->fetchAll() as $song) {
			$list[] = new Song($song['IdSong'], $song['Title'], $song['Genre'], $song['Duration'], $song['Author']);
		}
		return new Collection($song['IdCollection'], $list);
	}
}
?>
