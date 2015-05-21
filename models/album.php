<?php
require_once('song.php');
class Album {

	private $id;
	private $title;
	private $author;
	private $info;
	private $live;
	private $songs;
	private $path;

	public function __construct($id, $title, $author, $info, $live, $songs, $path) {
		$this->id = $id;
		$this->title = $title;
		$this->author = $author;
		$this->info = $info;
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
		return floor($seconds / 60).":".($seconds % 60);
	}
	// add a new album to the database
	public static function add($album) {
		$db = Db::getInstance();
		$req = $db->prepare('INSERT INTO Album (Titolo, Info, Autore, Anno, Live, Locazione) VALUES(:Title, :Info, :Author, :Year, :Live, :Location)');
		$req->execute(array(
			'Title' => $album['Title'],
			'Info' => $album['Info'],
			'Author' => $album['Year'],
			'Live' => $album['Live'],
			'Location' => $album['Location']
		));
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
			$list[] = new Album($album['IdAlbum'], $album['Titolo'], $album['Autore'], $album['Info'], $live, array(), '');
		}
		return $list;
	}
	// retrieve a single album from the database, by a given id
	public static function find($id) {
		$song;
		$live;
		$songs = array();
		$id = intval($id);
		$db = Db::getInstance();
		$req = $db->prepare('SELECT a.IdAlbum, a.Live, a.Locazione, a.Info, a.Titolo as AlbumTitle, a.Autore, s.*, c.Path FROM Album a INNER JOIN Brani s ON(a.IdAlbum = s.IdAlbum) INNER JOIN Copertine c ON(a.IdAlbum = c.IdAlbum) WHERE a.IdAlbum = :id');
		$req->execute(array('id' => $id));
		foreach($req->fetchAll() as $song) {
			$songs[] = new Song($song['IdBrano'], $song['Titolo'], $song['Genere'], $song['Durata'], $song['Autore'], $song['IdAlbum'], $song['AlbumTitle']);
		}
		if(!isset($song['Path'])) {
			$song['Path'] = '';
		}
		if(isset($song['Live']) && $song['Live'] == true) {
			$live = array(
				'Live' => $song['Live'],
				'Location' => $song['Locazione']
			);
		} else {
			$live = false;
		}
		return new Album($song['IdAlbum'], $song['AlbumTitle'], $song['Autore'], $song['Info'], $live, $songs, $song['Path']);
	}
    // add a new album into the database
    public static function addalbum($newalbum) {
        $db = Db::getInstance();
        $req = $db->prepare('INSERT INTO Album VALUES(:Title, :Author, :Live, :Location)');
        $req->execute(array(
                'Title' => $newalbum['Title'],
                'Author' => $newalbum['Author'],
                'Live' => $newalbum['Live'],
                'Location' => $newalbum['Location']
            ));
    }
}
?>
