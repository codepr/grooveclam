<?php
require_once('song.php');
class Collection {

	private $id;
	private $songs;

	public function __construct($id, $songs) {
		$this->id = $id;
		$this->songs = $songs;
	}

	public function id() {
		return $this->id;
	}

	public function songs() {
		return $this->songs;
	}
    // control if a given user is the author of a given collection
    public function canI($uid, $id) {
        $uid = intval($uid);
        $id = intval($id);
        $db = Db::getInstance();
        $req = $db->prepare('SELECT c.IdUtente, c.IdCollezione FROM Collezioni c WHERE c.IdUtente = :uid AND c.IdCollezione = :id');
        $req->execute(array('uid' => $uid, 'id' => $id));
        if(!empty($req->fetch())) {
            return true;
        } else {
            return false;
        }
    }
	// list all collections, for administrator users
	public static function all() {
		$list = array();
		$db = Db::getInstance();
		$req = $db->query('SELECT c.*, l.Username FROM Collezioni c INNER JOIN Login l ON(c.IdUtente = l.IdUtente)');
		foreach($req->fetchAll() as $collection) {
			$list[] = array('collection' => $collection['IdCollezione'], 'user' => $collection['Username']);
		}
		return $list;
	}
	// find a single collection and all contained songs
	public static function find($id) {
		$list = array();
		$song;
		$db = Db::getInstance();
		$req = $db->prepare('SELECT c.IdCollezione, s.*, a.Autore, a.Titolo as AlbumTitle FROM Brani s INNER JOIN BraniCollezione sc ON(s.IdBrano = sc.IdBrano) INNER JOIN Collezione c ON (sc.IdCollezione = c.IdCollezione) INNER JOIN Album a ON (s.IdAlbum = a.IdAlbum) WHERE c.IdCollezione = :id');
		$req->execute(array('id' => $id));
		foreach($req->fetchAll() as $song) {
			$list[] = new Song($song['IdBrano'], $song['Titolo'], $song['Genere'], $song['Durata'], $song['Autore'], $song['IdAlbum'], $song['AlbumTitle']);
		}
		return new Collection($song['IdCollezione'], $list);
	}
	// find a single collection by user id
	public static function findbyid($id) {
		$list = array();
		$song;
		$db = Db::getInstance();
		$req = $db->prepare('SELECT c.IdCollezione, s.*, a.Autore, a.Titolo as AlbumTitle FROM Brani s INNER JOIN BraniCollezione sc ON(s.IdBrano = sc.IdBrano) INNER JOIN Collezioni c ON(sc.IdCollezione = c.IdCollezione) INNER JOIN Album a ON(s.IdAlbum = a.IdAlbum) WHERE c.IdUtente = :id');
		$req->execute(array('id' => $id));
		foreach ($req->fetchAll() as $song) {
			$list[]	 = new Song($song['IdBrano'], $song['Titolo'], $song['Genere'], $song['Durata'], $song['Autore'], $song['IdAlbum'], $song['AlbumTitle']);
		}
        if(!isset($song)) {
            $song = NULL;
        }
		return new Collection($song['IdCollezione'], $list);
	}
	// add a song to collection by a given id
	public static function addsong($id, $idu) {
		$song;
		$db = Db::getInstance();
		$query = $db->prepare('SELECT c.IdCollezione FROM Collezioni c INNER JOIN Utenti u ON(c.IdUtente = u.IdUtente) WHERE u.IdUtente = :idu');
		$query->execute(array('idu' => $idu));
		$idc = $query->fetch();
		$req = $db->prepare('INSERT INTO BraniCollezione VALUES(:id, :idc)');
		$req->execute(array('id' => $id, 'idc' => $idc['IdCollezione']));
	}
	// remove a song by a given id
	public static function remove($id, $idc) {
		$db = Db::getInstance();
		$req = $db->prepare('DELETE FROM BraniCollezione WHERE IdCollezione = :idc AND IdBrano = :id');
		$req->execute(array('id' => $id, 'idc' => $idc));
	}
}
?>
