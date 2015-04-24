SET FOREIGN_KEY_CHECKS = 0;
-- Table Album
CREATE TABLE IF NOT EXISTS `Album` (
	`IdAlbum` INT(11) NOT NULL AUTO_INCREMENT,
	`Title` VARCHAR(140) NOT NULL,
	`Author` VARCHAR(40) NOT NULL,
	`Year` DATE NOT NULL,
	`Live` BOOLEAN NOT NULL,
	`Location` VARCHAR(40) DEFAULT NULL,
	PRIMARY KEY(`IdAlbum`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- Table Song
CREATE TABLE IF NOT EXISTS `Song` (
	`IdSong` INT(11) NOT NULL AUTO_INCREMENT,
	`IdAlbum` INT(11) NOT NULL,
	`Title` VARCHAR(40) NOT NULL,
	`Genre` VARCHAR(40) NOT NULL,
	`Duration` FLOAT,
	`IdImage` INT(11) NOT NULL,
	PRIMARY KEY(`IdSong`),
	FOREIGN KEY(`IdAlbum`) REFERENCES Album(`IdAlbum`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(`IdImage`) REFERENCES Cover(`IdImage`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- Table Cover
CREATE TABLE IF NOT EXISTS `Cover` (
	`IdImage` INT(11) NOT NULL AUTO_INCREMENT,
	`IdAlbum` INT(11) NOT NULL,
	`Path` VARCHAR (40) NOT NULL,
	PRIMARY KEY(`IdImage`),
	FOREIGN KEY(`IdAlbum`) REFERENCES Album(`IdAlbum`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- Table User
CREATE TABLE IF NOT EXISTS `User` (
	`IdUser` INT(11) NOT NULL AUTO_INCREMENT,
	`Name` VARCHAR(40) DEFAULT NULL,
	`Surname` VARCHAR(40) DEFAULT NULL,
	`Email` VARCHAR(40) NOT NULL,
	`Administrator` BOOLEAN NOT NULL,
	`Username` VARCHAR(40) NOT NULL,
	`Password` VARCHAR(40) NOT NULL,
	PRIMARY KEY(`IdUser`),
	UNIQUE(`Username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- Table Follow
CREATE TABLE IF NOT EXISTS `Follow` (
	`IdUser` INT(11) NOT NULL,
	`IdFellow` INT(11) NOT NULL,
	CONSTRAINT PRIMARY KEY pk(`IdUser`, `IdFellow`),
	FOREIGN KEY(`IdUser`) REFERENCES User(`IdUser`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(`IdFellow`) REFERENCES User(`IdUser`) ON DELETE CASCADE ON UPDATE CASCADE,
	CHECK(`IdUser` != `IdFellow`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- Table Subscription
CREATE TABLE IF NOT EXISTS `Subscription` (
	`IdUser` INT(40) NOT NULL,
	`Type` ENUM('Free', 'Premium') NOT NULL,
	PRIMARY KEY(`IdUser`),
	FOREIGN KEY(`IdUser`) REFERENCES User(`IdUser`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- Table Collection
CREATE TABLE IF NOT EXISTS `Collection` (
	`IdCollection` INT(11) NOT NULL AUTO_INCREMENT,
	`IdUser` INT(11) NOT NULL,
	PRIMARY KEY(`IdCollection`),
	FOREIGN KEY(`IdUser`) REFERENCES User(`IdUser`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- Table SongCollection
CREATE TABLE IF NOT EXISTS `SongCollection` (
	`IdSong` INT(11) NOT NULL,
	`IdCollection` INT(11) NOT NULL,
	CONSTRAINT PRIMARY KEY pk(`IdCollection`, `IdSong`),
	FOREIGN KEY(`IdSong`) REFERENCES Song(`IdSong`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(`IdCollection`) REFERENCES Collection(`IdCollection`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- Table Playlist
CREATE TABLE IF NOT EXISTS `Playlist` (
	`IdPlaylist` INT(11) NOT NULL AUTO_INCREMENT,
	`IdUser` INT(11) NOT NULL,
	`Name` VARCHAR(40) NOT NULL,
	PRIMARY KEY(`IdPlaylist`),
	FOREIGN KEY(`IdUser`) REFERENCES User(`IdUser`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- Table PlaylistSong
CREATE TABLE IF NOT EXISTS `PlaylistSong` (
	`IdPlaylist` INT(11) NOT NULL,
	`IdSong` INT(11) NOT NULL,
	CONSTRAINT PRIMARY KEY pk(`IdPlaylist`, `IdSong`),
	FOREIGN KEY(`IdPlaylist`) REFERENCES Playlist(`IdPlaylist`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(`IdSong`) REFERENCES Song(`IdSong`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- Table Queue
CREATE TABLE IF NOT EXISTS `Queue` (
	`IdUser` INT(11) NOT NULL,
	FOREIGN KEY(`IdUser`) REFERENCES User(`IdUser`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- Table QueueSong
CREATE TABLE IF NOT EXISTS `QueueSong` (
	`IdUser` INT(11) NOT NULL,
	`IdSong` INT(11) NOT NULL,
	CONSTRAINT PRIMARY KEY pk(`IdUser`, `IdSong`),
	FOREIGN KEY(`IdUser`) REFERENCES Queue(`IdUser`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(`IdSong`) REFERENCES Song(`IdSong`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- INSERT POPULATION
-- Insert into User
INSERT INTO User(`Name`, `Surname`, `Email`, `Administrator`, `Username`, `Password`)
VALUES('Andrea', 'Baldan', 'a.g.baldan@gmail.com', 0, 'codep', 'ciao'), ('Federico', 'Angi', 'angiracing@gmail.com', 0, 'keepcalm', 'calm');
-- Insert into Subscrition
INSERT INTO Subscription(`IdUser`, `Type`) VALUES(1, 'Free'), (2, 'Free');
-- Insert into Album
INSERT INTO Album(`Title`, `Author`, `Year`, `Live`, `Location`)
VALUES('Inception Suite', 'Hans Zimmer', '2010-07-13', 0, NULL), ('The Good, the Bad and the Ugly: Original Motion Picture Soundtrack', 'Ennio Morricone', '1966-12-29', 0, NULL);
-- Insert into Song
INSERT INTO Song(`IdAlbum`, `Title`, `Genre`, `Duration`, `IdImage`) VALUES(1, 'Mind Heist', 'Orchestra', 3.23, 1), (1, 'Dream is collapsing', 'Orchestra', 4.41, 1), (1, 'Time', 'Orchestra', 3.35, 1),(2, 'Il Triello', 'Orchestra', 7.14, 2);
-- Insert into Cover
INSERT INTO Cover(`IdImage`, `IdAlbum`, `Path`) VALUES(1, 1, 'img/covers/inception.jpg'), (2, 2, 'img/covers/morricone.jpg)');
-- Insert into Collection
INSERT INTO Collection(`IdUser`) VALUES(1), (2);
-- Insert into SongCollection
INSERT INTO SongCollection(`IdSong`, `IdCollection`) VALUES(1, 1), (2, 1), (3, 1), (2, 2);
-- Insert into Playlist
INSERT INTO Playlist(`IdUser`, `Name`) VALUES(1, 'Score & Soundtracks'),(2, 'Colonne sonore western');
-- Insert into PlaylistSong
INSERT INTO PlaylistSong(`IdPlaylist`, `IdSong`) VALUES(1, 1), (1, 2), (1, 3), (1, 4), (2, 4);

SET FOREIGN_KEY_CHECKS = 1;
