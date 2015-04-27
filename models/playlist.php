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
	// list all playlists, for administrator users
	public static function all() {
		$list = array();
		$db = Db::getInstance();
		$req = $db->query('SELECT * FROM PlaylistSong');

		foreach($req->fetchAll() as $playlist) {
			$list[] = new Playlist($playlist['IdPlaylist'], $playlist['Name'], array());
		}

		return $list;
	}
	// find a single playlist and all songs contained
	public static function find($id) {
		$songlist = array();
		$song;
		$db = Db::getInstance();
		$id = intval($id);
		$req = $db->prepare('SELECT pl.IdPlaylist, pl.Name, s.*, a.Author, a.Title as AlbumTitle FROM Song s INNER JOIN PlaylistSong p ON(s.IdSong = p.IdSong) INNER JOIN Playlist pl ON(pl.IdPlaylist = p.IdPlaylist) INNER JOIN Album a ON(s.IdAlbum = a.IdAlbum) WHERE pl.IdPlaylist = :id');
		$req->execute(array('id' => $id));
		foreach($req->fetchAll() as $song) {
			$songlist[] = new Song($song['IdSong'], $song['Title'], $song['Genre'], $song['Duration'], $song['Author'], $song['IdAlbum'], $song['AlbumTitle']);
		}
		return new Playlist($song['IdPlaylist'], $song['Name'], $songlist);
	}
}
?>
