<?php
require_once('song.php');
class Playlist {

	private $id;
	private $name;
	private $owner;
	private $songs;

	public function __construct($id, $name, $owner, $songs) {
		$this->id = $id;
		$this->name = $name;
		$this->owner = $owner;
		$this->songs = $songs;
	}

	public function name() {
		return $this->name;
	}

	public function owner() {
		return $this->owner;
	}

	public function songs() {
		return $this->songs;
	}
	// list all playlists, for administrator users
	public static function all() {
		$list = array();
		$db = Db::getInstance();
		$req = $db->query('SELECT ps.*, u.IdUser, u.Username FROM PlaylistSong ps INNER JOIN Playlist p ON(ps.IdPlaylist = p.IdPlaylist) INNER JOIN User u ON(p.IdUser = u.IdUser)');
		foreach($req->fetchAll() as $playlist) {
			$list[] = new Playlist($playlist['IdPlaylist'], $playlist['Name'], array('IdUser' => $playlist['IdUser'], 'Username' => $playlist['Username']), array());
		}

		return $list;
	}
	// find a single playlist and all songs contained
	public static function find($id) {
		$songlist = array();
		$song;
		$db = Db::getInstance();
		$id = intval($id);
		$req = $db->prepare('SELECT pl.IdPlaylist, pl.Name, s.*, a.Author, a.Title as AlbumTitle FROM Song s INNER JOIN PlaylistSong p ON(s.IdSong = p.IdSong) INNER JOIN Playlist pl ON(pl.IdPlaylist = p.IdPlaylist) INNER JOIN Album a ON(s.IdAlbum = a.IdAlbum) WHERE pl.IdUser = :id');
		$req->execute(array('id' => $id));
		foreach($req->fetchAll() as $song) {
			$songlist[] = new Song($song['IdSong'], $song['Title'], $song['Genre'], $song['Duration'], $song['Author'], $song['IdAlbum'], $song['AlbumTitle']);
		}
		return new Playlist($song['IdPlaylist'], $song['Name'], array(), $songlist);
	}
}
?>
