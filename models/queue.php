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
		$req = $db->prepare('SELECT s.*, qs.TimeStamp, a.Author, a.Title as AlbumTitle FROM Song s INNER JOIN Queue qs ON(s.IdSong = qs.IdSong) INNER JOIN Album a ON(s.IdAlbum = a.IdAlbum) WHERE qs.IdUser = :id');
		$req->execute(array('id' => $id));
		foreach($req->fetchAll() as $song) {
			// $tstamps = date_create($song['TimeStamp']);
			// date_format($tstamps, 'd-m-Y H:i:s');
			$list[$song['TimeStamp']] = new Song($song['IdSong'], $song['Title'], $song['Genre'], $song['Duration'], $song['Author'], $song['IdAlbum'], $song['AlbumTitle']);
		}
		return new Queue($list);
	}
	// add a song to te queue
	public static function addsong($uid, $id) {
		$db = Db::getInstance();
		$id = intval($id);
		$uid = intval($uid);
		$req = $db->prepare('INSERT INTO Queue VALUES(:uid, :id, NOW())');
		$req->execute(array('uid' => $uid, 'id' => $id));
	}
}
?>
