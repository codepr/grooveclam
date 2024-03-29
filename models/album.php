<?php
require_once('song.php');
class Album {

	private $id;
	private $title;
	private $author;
	private $info;
    private $year;
	private $live;
	private $songs;
	private $path;

	public function __construct($id, $title, $author, $info, $year, $live, $songs, $path) {
		$this->id = $id;
		$this->title = $title;
		$this->author = $author;
		$this->info = $info;
        $this->year = $year;
		$this->live = $live;
		$this->songs = $songs;
		$this->path = $path;
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

    public function year() {
        return $this->year;
    }

	public function live() {
		return $this->live;
	}

	public function songs() {
		return $this->songs;
	}

	public function path() {
		return $this->path;
	}
	// return total duration of the album
	public function totalDuration() {
		$seconds = 0;
		foreach ($this->songs() as $song) {
            $seconds += $song->duration();
		}
		return floor($seconds / 60).":".sprintf("%02d",$seconds % 60);
	}
	// retrieve all albums from the database
	public static function all() {
		$list = array();
		$db = Db::getInstance();
		$req = $db->query('SELECT * FROM Album');
		foreach($req->fetchAll() as $album) {
			$live;
			if(isset($album['Live']) && $album['Live'] == true) {
				$live = array(
					'Live' => $album['Live'],
					'Location' => $album['Locazione']
				);
			} else {
				$live = false;
			}
			$list[] = new Album($album['IdAlbum'], $album['Titolo'], $album['Autore'], $album['Info'], $album['Anno'], $live, array(), $album['PathCopertina']);
		}
		return $list;
	}
	// retrieve a single album from the database, by a given id
	public static function find($id) {
		$song = array(
            'IdAlbum' => 0,
            'AlbumTitle' => "",
            'Autore' => "",
            'Info' => "",
            'Anno' => ""
        );
		$live;
		$songs = array();
        $alb = 0;
		$id = intval($id);
		$db = Db::getInstance();
        $req = $db->prepare('SELECT * FROM Album WHERE IdAlbum = :id');
        $req->execute(array('id' => $id));
        $alb = $req->fetch();
		$req = $db->prepare('SELECT a.IdAlbum, a.Live, a.Locazione, a.Info, a.Anno, a.PathCopertina, a.Titolo as AlbumTitle, a.Autore, b.* FROM Album a INNER JOIN Brani b ON(a.IdAlbum = b.IdAlbum) WHERE a.IdAlbum = :id');
		$req->execute(array('id' => $id));
		foreach($req->fetchAll() as $song) {
			$songs[] = new Song($song['IdBrano'], $song['Titolo'], $song['Genere'], $song['Durata'], $song['Autore'], $song['IdAlbum'], $song['AlbumTitle']);
		}
		if(!isset($song['PathCopertina'])) {
			$song['PathCopertina'] = '';
		}
		if(isset($song['Live']) && $song['Live'] == true) {
			$live = array(
				'Live' => $song['Live'],
				'Location' => $song['Locazione']
			);
		} else {
			$live = false;
		}
		return new Album($id, $alb['Titolo'], $alb['Autore'], $alb['Info'], $alb['Anno'], $live, $songs, $alb['PathCopertina']);
	}
    // retrieve a [list of] album by a given title
    public static function findByTitle($title) {
        $list = array();
        $title = addslashes($title);
        $song = array(
            'IdAlbum' => 0,
            'AlbumTitle' => "",
            'Autore' => "",
            'Info' => "",
            'Anno' => ""
        );
        $db = Db::getInstance();
		$live;
		$songs = array();
        $req = $db->prepare('SELECT a.IdAlbum, a.Live, a.Locazione, a.Info, a.Anno, a.PathCopertina, a.Titolo as AlbumTitle, a.Autore, b.* FROM Album a INNER JOIN Brani b ON(a.IdAlbum = b.IdAlbum) WHERE a.Titolo = :title');
		$req->execute(array('title' => $title));
		foreach($req->fetchAll() as $song) {
			$songs[] = new Song($song['IdBrano'], $song['Titolo'], $song['Genere'], $song['Durata'], $song['Autore'], $song['IdAlbum'], $song['AlbumTitle']);
		}
		if(!isset($song['PathCopertina'])) {
			$song['PathCopertina'] = '';
		}
		if(isset($song['Live']) && $song['Live'] == true) {
			$live = array(
				'Live' => $song['Live'],
				'Location' => $song['Locazione']
			);
		} else {
			$live = false;
		}
		return new Album($song['IdAlbum'], $song['AlbumTitle'], $song['Autore'], $song['Info'], $song['Anno'], $live, $songs, $song['PathCopertina']);
    }
}
?>
