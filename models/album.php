<?php
require_once('song.php');
class Album {
	private $id;
	private $title;
	private $author;
	private $info;
	private $live;
	private $songs;

	public function __construct($id, $title, $author, $info, $live, $songs) {
		$this->id = $id;
		$this->title = $title;
		$this->author = $author;
		$this->info = $info;
		$this->live = $live;
		$this->songs = $songs;
	}

	public function id() {
		return $this->id;
	}

	public function title() {
		return $this->title;
	}

	public function author() {
		return $this->author;
	}

	public function info() {
		return $this->info;
	}

	public function live() {
		return $this->live;
	}

	public function songs() {
		return $this->songs;
	}

	public static function all() {
		$list = [];
		$db = Db::getInstance();
		$req = $db->query('SELECT * FROM Album');
		foreach($req->fetchAll() as $album) {
			$live;
			if(isset($album['Live']) && $album['Live'] == true) {
				$live = array(
					'Live' => $album['Live'],
					'Location' => $album['Location']
				);
			} else {
				$live = false;
			}
			$list[] = new Album($album['IdAlbum'], $album['Title'], $album['Author'], $album['Info'], $live, []);
		}
		return $list;
	}

	public static function find($id) {
		$song;
		$live;
		$songs = [];
		$id = intval($id);
		$db = Db::getInstance();
		$req = $db->prepare('SELECT a.IdAlbum, a.Live, a.Location, a.Info, a.Title as AlbumTitle, a.Author, s.* FROM Album a INNER JOIN Song s ON(a.IdAlbum = s.IdAlbum) WHERE a.IdAlbum = :id');
		$req->execute(array('id' => $id));
		foreach($req->fetchAll() as $song) {
			$songs[] = new Song($song['IdSong'], $song['Title'],$song['Genre'], $song['Duration'], $song['Author'], $song['IdAlbum'], $song['AlbumTitle']);
		}
		if(isset($song['Live']) && $song['Live'] == true) {
			$live = array(
				'Live' => $song['Live'],
				'Location' => $song['Location']
			);
		} else {
			$live = false;
		}
		return new Album($song['IdAlbum'], $song['AlbumTitle'], $song['Author'], $song['Info'], $live, $songs);
	}
}
?>
