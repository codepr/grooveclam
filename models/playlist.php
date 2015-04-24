<?php
require_once('song.php');
class Playlist {
	private $id;
	private $name;
	private $songs;

	public function __construct($id, $name, $songs) {
		$this->id = $id;
		$this->name = $name;
		$this->songs = $songs;
	}

	public function name() {
		return $this->name;
	}

	public function songs() {
		return $this->songs;
	}

	public static function all() {
		$list = [];
		$db = Db::getInstance();
		$req = $db->query('SELECT s.* FROM Song s INNER JOIN PlaylistSong p ON(s.IdSong = p.IdSong)');

		foreach($req->fetchAll() as $song) {
			// $list[] = new Playlist($song['IdSong'], $song['Title'], $song['Genre'], $song['Duration']);
		}

		return $list;
	}

	public static function find($id) {
		$db = Db::getInstance();
		$id = intval($id);
		$req = $db->prepare('SELECT pl.IdPlaylist, pl.Name, s.*, a.Author FROM Song s INNER JOIN PlaylistSong p ON(s.IdSong = p.IdSong) INNER JOIN Playlist pl ON(pl.IdPlaylist = p.IdPlaylist) INNER JOIN Album a ON(s.IdAlbum = a.IdAlbum) WHERE pl.IdPlaylist = :id');
		$req->execute(array('id' => $id));
		$songlist = [];
		$song;
		foreach($req->fetchAll() as $song) {
			$songlist[] = new Song($song['IdSong'], $song['Title'], $song['Genre'], $song['Duration'], $song['Author']);
		}

		return new Playlist($song['IdPlaylist'], $song['Name'], $songlist);
	}
}
?>
