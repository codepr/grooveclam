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
		$req = $db->prepare('SELECT s.*, qs.Timestamp, a.Autore, a.Titolo as AlbumTitle FROM Brani s INNER JOIN Code qs ON(s.IdBrano = qs.IdBrano) INNER JOIN Album a ON(s.IdAlbum = a.IdAlbum) WHERE qs.IdUtente = :id');
		$req->execute(array('id' => $id));
		foreach($req->fetchAll() as $song) {
			$list[$song['Timestamp']] = new Song($song['IdBrano'], $song['Titolo'], $song['Genere'], $song['Durata'], $song['Autore'], $song['IdAlbum'], $song['AlbumTitle']);
		}
		return new Queue($list);
	}
	// add a song to te queue
	public static function addsong($uid, $id) {
		$db = Db::getInstance();
		$id = intval($id);
		$uid = intval($uid);
		$req = $db->prepare('INSERT INTO Code VALUES(:uid, :id, NOW())');
		$req->execute(array('uid' => $uid, 'id' => $id));
	}
}
?>
