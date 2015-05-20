<?php
require_once('song.php');
class Playlist {

	private $id;
	private $name;
	private $owner;
	private $songs;
    private $domain;

	public function __construct($id, $name, $owner, $songs, $domain) {
		$this->id = $id;
		$this->name = $name;
		$this->owner = $owner;
		$this->songs = $songs;
        $this->domain = $domain;
	}

	public function id() {
		return $this->id;
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

    public function domain() {
        return $this->domain;
    }
	// retrieve number of songs and total duration of a given playlist
	public function stats($id) {
		$stats = array();
		$dur = 0;
		$seconds = 0;
		$id = intval($id);
		$db = Db::getInstance();
		$req = $db->prepare('SELECT s.Duration FROM Song s INNER JOIN PlaylistSong p ON(s.IdSong = p.IdSong) WHERE p.IdPlaylist = :id');
		$req->execute(array('id' => $id));
		$res = $req->fetchAll();
		foreach ($res as $duration) {
			/* $intpart = intval($duration['Duration']);
			   $fltpart = $duration['Duration'] - $intpart;
			   $seconds += ($intpart * 60) + ($fltpart * 100); 
			   $dur += $seconds; */
            $dur += $duration['Duration'];
		}
		$dur = floor($dur / 60).":".($dur % 60);
		return array('count' => count($res), 'duration' => $dur);
	}
	// list all playlists, for administrator users
	public static function all() {
		$list = array();
		$db = Db::getInstance();
		$req = $db->query('SELECT p.*, u.Username FROM Playlist p INNER JOIN User u ON(p.IdUser = u.IdUser) WHERE p.Private = FALSE');
		foreach($req->fetchAll() as $playlist) {
			$list[] = new Playlist($playlist['IdPlaylist'], $playlist['Name'], array('IdUser' => $playlist['IdUser'], 'Username' => $playlist['Username']), array(), 0);
		}

		return $list;
	}
	// find a single playlist and all songs contained
	public static function find($id) {
		$songlist = array();
		$song;
		$db = Db::getInstance();
		$id = intval($id);
		$req = $db->prepare('SELECT pl.IdPlaylist, pl.Name, pl.Private, s.*, a.Author, a.Title as AlbumTitle FROM Song s INNER JOIN PlaylistSong p ON(s.IdSong = p.IdSong) INNER JOIN Playlist pl ON(pl.IdPlaylist = p.IdPlaylist) INNER JOIN Album a ON(s.IdAlbum = a.IdAlbum) WHERE pl.IdPlaylist = :id');
		$req->execute(array('id' => $id));
		foreach($req->fetchAll() as $song) {
			$songlist[] = new Song($song['IdSong'], $song['Title'], $song['Genre'], $song['Duration'], $song['Author'], $song['IdAlbum'], $song['AlbumTitle']);
		}
		return new Playlist($song['IdPlaylist'], $song['Name'], array(), $songlist, $song['Private']);
	}
    // retrieve all personal playlist by a given userID
    public static function personal_playlist($id) {
        $list = array();
        $id = intval($id);
        $db = Db::getInstance();
        $req = $db->prepare('SELECT p.* FROM Playlist p WHERE p.IdUser = :id');
        $req->execute(array('id' => $id));
        foreach($req->fetchAll() as $playlist) {
            $list[] = new Playlist($playlist['IdPlaylist'], $playlist['Name'], array('IdUser' => $id, 'Username' => ''), array(), $playlist['Private']);
        }
        return $list;
    }
}
?>
