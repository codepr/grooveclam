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
    // create a new playlist
    public static function create($newplaylist) {
        $db = Db::getInstance();
        $add = $db->prepare('INSERT INTO Playlist (IdUtente, Nome, Tipo) VALUES(:idUser, :Name, :Type)');
        if(!isset($newplaylist['Private'])) {
            $newplaylist['Private'] = 'Pubblica';
        }
        $add->execute(array('idUser' => $newplaylist['uid'], 'Name' => $newplaylist['Name'], 'Type' => $newplaylist['Private']));
        $idp = $db->lastInsertId();
        if(isset($newplaylist['fellow']) && !empty($newplaylist)) {
            // insert creator in Condivise table
            $req = $db->prepare('INSERT INTO Condivise (IdPlaylist, IdUtente) VALUES(:idp, :idu)');
            $req->execute(array('idp' => $idp, 'idu' => $_SESSION['uid']));
            foreach($newplaylist['fellow'] as $fellow) {
                $add = $db->prepare('INSERT INTO Condivise (IdPlaylist, IdUtente) VALUES(:idp, :idu)');
                $add->execute(array('idp' => $idp, 'idu' => $fellow));
            }
        }
        $i = 1;
        if(isset($newplaylist['song']) && !empty($newplaylist['song'])) {
            foreach($newplaylist['song'] as $song) {
                $add = $db->prepare('INSERT INTO BraniPlaylist (IdPlaylist, IdBrano, Posizione) VALUES(:idp, :idb, :pos)');
                $add->execute(array('idp' => $idp, 'idb' => $song, 'pos' => $i));
                $i++;
            }
        }
    }
    // modify a given list
    public static function alter($altplaylist) {
        $idp = intval($altplaylist['idpl']);
        $db = Db::getInstance();
        if(isset($altplaylist['NewName'])) {
            $req = $db->prepare("UPDATE Playlist SET Nome = :name WHERE IdPlaylist = :idp");
            $req->execute(array("name" => $altplaylist['NewName'], "idp" => $idp));
        }
        if(isset($altplaylist['song'])) {
            $req = $db->prepare("DELETE FROM BraniPlaylist WHERE IdPlaylist = :idp");
            $req->execute(array("idp" => $idp));
            $i = 0;
            foreach($altplaylist['song'] as $song) {
                $req = $db->prepare("INSERT INTO BraniPlaylist (IdPlaylist, IdBrano, Posizione) VALUES(:idp, :idb, :pos)");
                $req->execute(array("idp" => $idp, "idb" => $song, "pos" => $i));
                $i++;
            }
        }
        if(!isset($altplaylist['Private'])) {
            $altplaylist['Private'] = 'Pubblica';
        } 
        $req = $db->prepare('UPDATE Playlist SET Tipo = :type WHERE IdPlaylist = :idp');
        $req->execute(array("type" => $altplaylist['Private'], "idp" => $idp));
    }
	// retrieve number of songs and total duration of a given playlist
	public function stats($id) {
		$stats = array();
		$dur = 0;
		$seconds = 0;
		$id = intval($id);
		$db = Db::getInstance();
		$req = $db->prepare('SELECT b.Durata FROM Brani b INNER JOIN BraniPlaylist bp ON(b.IdBrano = bp.IdBrano) WHERE bp.IdPlaylist = :id');
		$req->execute(array('id' => $id));
		$res = $req->fetchAll();
		foreach ($res as $duration) {
            $dur += $duration['Durata'];
		}
		$dur = floor($dur / 60).":".sprintf("%02d", ($dur % 60));
		return array('count' => count($res), 'duration' => $dur);
	}
	// list all public playlists
	public static function all() {
		$list = array();
		$db = Db::getInstance();
		$req = $db->query('SELECT p.*, l.Username FROM Playlist p INNER JOIN Login l ON(p.IdUtente = l.IdUtente) WHERE p.Tipo = \'Pubblica\'');
		foreach($req->fetchAll() as $playlist) {
			$list[] = new Playlist($playlist['IdPlaylist'], $playlist['Nome'], array('IdUtente' => $playlist['IdUtente'], 'Username' => $playlist['Username']), array(), 0);
		}
		return $list;
	}
	// find a single playlist and all songs contained
	public static function find($id) {
		$songlist = array();
		$song = 0;
		$db = Db::getInstance();
		$id = intval($id);
		$req = $db->prepare('SELECT pl.IdPlaylist, pl.Nome, pl.Tipo, p.Posizione, b.*, a.Autore, a.Titolo as AlbumTitle FROM Brani b INNER JOIN BraniPlaylist p ON(b.IdBrano = p.IdBrano) INNER JOIN Playlist pl ON(pl.IdPlaylist = p.IdPlaylist) INNER JOIN Album a ON(b.IdAlbum = a.IdAlbum) WHERE pl.IdPlaylist = :id ORDER BY p.Posizione');
		$req->execute(array('id' => $id));
		foreach($req->fetchAll() as $song) {
			$songlist[$song['Posizione']] = new Song($song['IdBrano'], $song['Titolo'], $song['Genere'], $song['Durata'], $song['Autore'], $song['IdAlbum'], $song['AlbumTitle']);
		}
		return new Playlist($song['IdPlaylist'], $song['Nome'], array(), $songlist, $song['Tipo']);
	}
    // retrieve all personal playlist by a given userID
    public static function personal_playlist($id) {
        $list = array();
        $id = intval($id);
        $db = Db::getInstance();
        $req = $db->prepare('SELECT p.* FROM Playlist p WHERE p.IdUtente = :id');
        $req->execute(array('id' => $id));
        foreach($req->fetchAll() as $playlist) {
            $list[] = new Playlist($playlist['IdPlaylist'], $playlist['Nome'], array('IdUser' => $id, 'Username' => ''), array(), $playlist['Tipo']);
        }
        $req = $db->prepare('SELECT c.*, pl.Nome, pl.Tipo FROM Condivise c INNER JOIN Playlist pl ON(c.IdPlaylist = pl.IdPlaylist) WHERE c.IdUtente = :id AND c.IdPlaylist NOT IN (SELECT p.IdPlaylist FROM Playlist p WHERE p.IdUtente = :id)');
        $req->execute(array('id' => $id));
        foreach($req->fetchAll() as $playlist) {
            $list[] = new Playlist($playlist['IdPlaylist'], $playlist['Nome'], array('IdUser' => $id, 'Username' => ''), array(), $playlist['Tipo']);
        }
        return $list;
    }
    // retrieve shared fellows of a given playlist
    public static function shared_fellows($id) {
        $list = array();
        $id = intval($id);
        $db = Db::getInstance();
        $req = $db->prepare('SELECT l.IdUtente, l.Username FROM Login l INNER JOIN Condivise c ON(l.IdUtente = c.IdUtente) WHERE c.IdPlaylist = :idp AND c.IdUtente <> :idu');
        $req->execute(array('idp' => $id, 'idu' => $_SESSION['uid']));
        foreach($req->fetchAll() as $fellow) {
            $list[$fellow['IdUtente']] = $fellow['Username'];
        }
        return $list;
    }
    // verify who's the owner of a given playlist
    public function is_mine() {
        $db = Db::getInstance();
        $req = $db->prepare('SELECT IdPlaylist FROM Playlist WHERE IdUtente = :uid');
        $req->execute(array('uid' => $_SESSION['uid']));
        $res = array();
        foreach($req->fetchAll() as $r) {
            $res[] = $r['IdPlaylist'];
        }
        if(!empty($res) && in_array($this->id(), $res)) {
            return true;
        } else {
            $req = $db->prepare('SELECT IdPlaylist FROM Condivise WHERE IdUtente = :uid');
            $req->execute(array('uid' => $_SESSION['uid']));
            $res = array();
            foreach($req->fetchAll() as $r) {
                $res[] = $r['IdPlaylist'];
            }
            if(!empty($res) && in_array($this->id(), $res)) {
                return true;
            } else {
                return false;
            }
        }
    }
    // swap position of two songs in the playlist
    public static function swap($a, $b, $id) {
        $db = Db::getInstance();
        $req = $db->prepare("CALL SWAP_POSITION(:a, :b, :id, 2)");
        $req->execute(array("a" => $a, "b" => $b, "id" => $id));
    }
}
?>
