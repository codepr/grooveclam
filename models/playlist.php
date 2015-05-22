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
		$req = $db->prepare('SELECT s.Durata FROM Brani s INNER JOIN BraniPlaylist p ON(s.IdBrano = p.IdBrano) WHERE p.IdPlaylist = :id');
		$req->execute(array('id' => $id));
		$res = $req->fetchAll();
		foreach ($res as $duration) {
            $dur += $duration['Durata'];
		}
		$dur = floor($dur / 60).":".($dur % 60);
		return array('count' => count($res), 'duration' => $dur);
	}
	// list all playlists, for administrator users
	public static function all() {
		$list = array();
		$db = Db::getInstance();
		$req = $db->query('SELECT p.*, u.Username FROM Playlist p INNER JOIN Utenti u ON(p.IdUtente = u.IdUtente) WHERE p.Privata = FALSE');
		foreach($req->fetchAll() as $playlist) {
			$list[] = new Playlist($playlist['IdPlaylist'], $playlist['Nome'], array('IdUtente' => $playlist['IdUtente'], 'Username' => $playlist['Username']), array(), 0);
		}

		return $list;
	}
	// find a single playlist and all songs contained
	public static function find($id) {
		$songlist = array();
		$song;
		$db = Db::getInstance();
		$id = intval($id);
		$req = $db->prepare('SELECT pl.IdPlaylist, pl.Nome, pl.Privata, p.Posizione, s.*, a.Autore, a.Titolo as AlbumTitle FROM Brani s INNER JOIN BraniPlaylist p ON(s.IdBrano = p.IdBrano) INNER JOIN Playlist pl ON(pl.IdPlaylist = p.IdPlaylist) INNER JOIN Album a ON(s.IdAlbum = a.IdAlbum) WHERE pl.IdPlaylist = :id ORDER BY p.Posizione');
		$req->execute(array('id' => $id));
		foreach($req->fetchAll() as $song) {
			$songlist[$song['Posizione']] = new Song($song['IdBrano'], $song['Titolo'], $song['Genere'], $song['Durata'], $song['Autore'], $song['IdAlbum'], $song['AlbumTitle']);
		}
		return new Playlist($song['IdPlaylist'], $song['Nome'], array(), $songlist, $song['Privata']);
	}
    // retrieve all personal playlist by a given userID
    public static function personal_playlist($id) {
        $list = array();
        $id = intval($id);
        $db = Db::getInstance();
        $req = $db->prepare('SELECT p.* FROM Playlist p WHERE p.IdUtente = :id');
        $req->execute(array('id' => $id));
        foreach($req->fetchAll() as $playlist) {
            $list[] = new Playlist($playlist['IdPlaylist'], $playlist['Nome'], array('IdUser' => $id, 'Username' => ''), array(), $playlist['Privata']);
        }
        return $list;
    }
    // swap position of two songs in the playlist
    public static function swap($a, $b, $id) {
        $db = Db::getInstance();
        $req = $db->prepare("CALL SWAP_POSITION(:a, :b, :id, 2)");
        $req->execute(array("a" => $a, "b" => $b, "id" => $id));
    }
}
?>
