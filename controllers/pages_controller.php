<?php
// homepage
class PagesController {
	// here there will be homepage with login form
	public function home() {
		$session = GrooveSession::getInstance();
		if(!isset($_SESSION['logged'])) {
			$this->login();
		} else {
			$user = User::find($_SESSION['uid']);
			$first_name = $user->name();
			$lasten = Song::lasten();
			$lastplay = Song::lastweekplay();
			$lastfellowsplay = Song::lastfellowsplay($_SESSION['uid']);
			require_once('views/pages/home.php');
		}
	}
	// redirect to error in case of bad inputs
	public function error($code) {
        $errors = array(
            0 => '',
            1 => '404 page does not exists',
            2 => 'Missing get or post parameters',
            3 => 'Maximum quota for free users reached. Free subscription users are allowed to add a maximum of 50 songs to their collection.'
        );
        $message = $errors{$code};
		require_once('views/pages/error.php');
	}
	// redirect to login form
	public function login() {
		require_once('views/pages/login.php');
	}
	// check for login credentials and initialize session
	public function checkuser() {
		$uname = $_POST['uname'];
		$passw = $_POST['passw'];
		$user = User::checkuser($uname, $passw);
		if($user != -1) {
			$session = GrooveSession::getInstance();
			$session->__set('logged', 1);
			$session->__set('uid', $user->id());
			header('Location:/basidati/~abaldan/');
		} else {
			$this->login();
		}
	}
	// logout
	public function logout() {
		$session = GrooveSession::getInstance();
		$session->destroy();
		header('Location:/basidati/~abaldan/');
	}
	// registration form
	public function registration() {
		require_once('views/pages/register.php');
	}
	// registration
	public function register() {
		if(!isset($_POST['Username']) || !isset($_POST['Password']) || !isset($_POST['Email'])) {
			return call('pages', 'error');
		} else {
			$postdata = $_POST;
			User::insert($postdata);
			header('Location:/basidati/~abaldan/');
		}
	}
    public function search() {
        if(!$_POST) {
            require_once('views/pages/search.php');
        } else {
            if(isset($_POST['query']) && !empty($_POST['query'])) {
                $mh = function($str) {
                    return "<th>".$str."</th>";
                };
                $mc = function($str) {
                    return "<td>".$str."</td>";
                };
                $results = "<table class='table'><thead><tr>";
                switch($_POST['filter']) {
                    case 'user':
                        $user = User::findByUsername($_POST['query']);
                        $headers = array('Username', 'E-Mail', 'Name', 'Surname');
                        $q_res = array($user->email(), $user->name());
                        $results .= implode(array_map($mh, $headers));
                        $results .= "</tr></thead><tbody><tr>";
                        $results .= "<td><a href='?controller=user&action=show&id=".$user->id()."'>".$user->username()."</td>";
                        $results .= implode(array_map($mc, $q_res));
                        $results .= "</tr>";
                    break;
                    case 'song':
                        $songs = Song::findByTitle($_POST['query']);
                        $headers = array('Title', 'Genre', 'Duration', 'Author', 'Album');
                        $results .= implode(array_map($mh, $headers));
                        foreach($songs as $s) {
                            $q_res = array($s['Genre'], floor($s['Duration'] / 60).":".($s['Duration'] % 60), $s['Author'], $s['AlbumTitle']);
                            $results .= "</tr></thead><tbody><tr>";
                            $results .= "<td><a href='?controller=songs&action=show&id=".$s['id']."'>".$s['Title']."</td>";
                            $results .= implode(array_map($mc, $q_res));
                            $results .= "</tr>";
                        }
                    break;
                    case 'album':
                        $albums = Album::findByTitle($_POST['query']);
                        $headers = array('Title', 'Author', 'Year', 'Duration', 'Live', 'Location');
                        $results .= implode(array_map($mh, $headers));
                        $l = $albums->live();
                        $q_res = array($albums->author(), $albums->year(), $albums->totalDuration(), $l['Live'], $l['Location']);
                        $results .= "</tr></thead><tbody><tr>";
                        $results .= "<td><a href='?controller=albums&action=show&id=".$albums->id()."'>".$albums->title()."</td>";
                        $results .= implode(array_map($mc, $q_res));
                        $results .= "</tr>";
                    break;
                }
                $results .= "</tbody></table>";
            }
            require_once('views/pages/search.php');
        }
    }
}
?>
