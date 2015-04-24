<?php
class Queue {
	private $queue;

	public function __construct($queue) {
		$this->queue = $queue;
	}

	public function queue() {
		return $this->queue;
	}

	public function find($id) {
		$list = [];
		$db = Db::getInstance();
		$if = intval($id);
		$req = $db->prepare('SELECT s.*, a.Author FROM Song s INNER JOIN QueueSong qs ON(s.IdSong = qs.IdSong) INNER JOIN Album a ON(s.IdAlbum = a.IdAlbum) WHERE qs.IdUser = :id');
		$req->execute(array('id' => $id));
		foreach($req->fetchAll() as $song) {
			$list[] = new Song($song['IdSong'], $song['Title'], $song['Genre'], $song['Duration'], $song['Author']);
		}
		return new Queue($list);
	}
}
?>
