<?php
require_once('song.php');
class Queue {
	private $queue;

	public function __construct($queue) {
		$this->queue = $queue;
	}

	public function queue() {
		return $this->queue;
	}
	// find a queue by its id
	public static function find($id) {
		$list = array();
		$tstamps = array();
		$db = Db::getInstance();
		$id = intval($id);
		$req = $db->prepare('SELECT s.*, qs.Posizione, a.Autore, a.Titolo as AlbumTitle FROM Brani s INNER JOIN Code qs ON(s.IdBrano = qs.IdBrano) INNER JOIN Album a ON(s.IdAlbum = a.IdAlbum) WHERE qs.IdUtente = :id ORDER BY qs.Posizione');
		$req->execute(array('id' => $id));
		foreach($req->fetchAll() as $song) {
			$list[$song['Posizione']] = new Song($song['IdBrano'], $song['Titolo'], $song['Genere'], $song['Durata'], $song['Autore'], $song['IdAlbum'], $song['AlbumTitle']);
		}
		return new Queue($list);
	}
	// add a song to the queue
	public static function addsong($uid, $id) {
		$db = Db::getInstance();
		$id = intval($id);
		$uid = intval($uid);
        $req = $db->prepare('SELECT COUNT(*) AS C FROM Code WHERE IdUtente = :UID');
        $req->execute(array('UID' => $uid));
        $len = $req->fetch();
        $len = $len['C'] + 1;
		$req = $db->prepare('INSERT INTO Code VALUES(:uid, :id,  :pos)');
		$req->execute(array('uid' => $uid, 'id' => $id, 'pos' => $len));
	}
    // remove a song from the queue
    public static function removesong($uid, $id, $pos) {
        $db = Db::getInstance();
        $id = intval($id);
        $uid = intval($uid);
        $req = $db->prepare("DELETE FROM Code WHERE IdBrano = :idb AND IdUtente = :idu AND Posizione = :pos");
        $req->execute(array("idb" => $id, "idu" => $uid, "pos" => $pos));
    }
    // swap two song position for a give uid
    public static function swap($a, $b, $id) {
        $db = Db::getInstance();
        $req = $db->prepare("CALL SWAP_POSITION(:a, :b, :id, 1)");
        $req->execute(array("a" => $a, "b" => $b, "id" => $id));
    }
}
?>
