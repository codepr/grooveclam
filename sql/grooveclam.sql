SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `Errors`;
DROP TABLE IF EXISTS `Album`;
DROP TABLE IF EXISTS `Song`;
DROP TABLE IF EXISTS `Cover`;
DROP TABLE IF EXISTS `User`;
DROP TABLE IF EXISTS `Follow`;
DROP TABLE IF EXISTS `Subscription`;
DROP TABLE IF EXISTS `Collection`;
DROP TABLE IF EXISTS `SongCollection`;
DROP TABLE IF EXISTS `Playlist`;
DROP TABLE IF EXISTS `PlaylistSong`;
DROP TABLE IF EXISTS `Queue`;
DROP TABLE IF EXISTS `Heard`;

-- Support Table Error
CREATE TABLE IF NOT EXISTS `Errors` (
       `Error` VARCHAR(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=Latin1;
-- Table Album
CREATE TABLE IF NOT EXISTS `Album` (
	`IdAlbum` INT(11) NOT NULL AUTO_INCREMENT,
	`Title` VARCHAR(140) NOT NULL,
	`Author` VARCHAR(140) NOT NULL,
	`Info` VARCHAR(300) DEFAULT NULL,
	`Year` DATE NOT NULL,
	`Live` BOOLEAN NOT NULL,
	`Location` VARCHAR(40) DEFAULT NULL,
	PRIMARY KEY(`IdAlbum`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- Table Song
CREATE TABLE IF NOT EXISTS `Song` (
	`IdSong` INT(11) NOT NULL AUTO_INCREMENT,
	`IdAlbum` INT(11) NOT NULL,
	`Title` VARCHAR(140) NOT NULL,
	`Genre` VARCHAR(40) NOT NULL,
	`Duration` INT(11),
	`IdImage` INT(11) NOT NULL,
	PRIMARY KEY(`IdSong`),
	FOREIGN KEY(`IdAlbum`) REFERENCES Album(`IdAlbum`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(`IdImage`) REFERENCES Cover(`IdImage`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- Table Cover
CREATE TABLE IF NOT EXISTS `Cover` (
	`IdImage` INT(11) NOT NULL AUTO_INCREMENT,
	`IdAlbum` INT(11) NOT NULL,
	`Path` VARCHAR (40) NOT NULL DEFAULT "img/covers/nocover.jpg",
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
	`IdUser` INT(10) NOT NULL,
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
    `Private` BOOLEAN DEFAULT FALSE,
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
	`IdSong` INT(11) NOT NULL,
	`TimeStamp` TIMESTAMP NOT NULL,
	CONSTRAINT PRIMARY KEY pk(`IdUser`, `IdSong`, `TimeStamp`),
	FOREIGN KEY(`IdUser`) REFERENCES User(`IdUser`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(`IdSong`) REFERENCES Song(`IdSong`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- Table Heard
CREATE TABLE IF NOT EXISTS `Heard` (
	`IdUser` INT(11) NOT NULL,
	`IdSong` INT(11) NOT NULL,
	`TimeStamp` TIMESTAMP NOT NULL,
	CONSTRAINT PRIMARY KEY pk(`IdUser`, `IdSong`, `TimeStamp`),
	FOREIGN KEY(`IdUser`) REFERENCES User(`IdUser`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(`IdSong`) REFERENCES Song(`IdSong`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- INSERT POPULATION
-- Insert into User
INSERT INTO User(`Name`, `Surname`, `Email`, `Administrator`, `Username`, `Password`)
       VALUES('Andrea', 'Baldan', 'a.g.baldan@gmail.com', 0, 'codep', MD5('ciao')),
	         ('Federico', 'Angi', 'angiracing@gmail.com', 0, 'keepcalm', MD5('calm')),
	         ('Marco', 'Rossi', 'rossi@gmail.com', 0, 'rossi', MD5('marco')),
             ('Luca', 'Verdi', 'verdi@yahoo.it', 0, 'verdi', MD5('luca')),
             ('Alessia', 'Neri', 'neri@gmail.com', 0, 'neri', MD5('alessia'));
-- Insert into Subscrition
INSERT INTO Subscription(`IdUser`, `Type`) VALUES(1, 'Free'), (2, 'Free');
-- Insert into Album
INSERT INTO Album(`Title`, `Author`, `Info`, `Year`, `Live`, `Location`)
       VALUES('Inception Suite', 'Hans Zimmer', 'Inception movie soundtrack, composed by the Great Compositor Hans Zimmer', '2010-07-13', 0, NULL),
             ('The Good, the Bad and the Ugly: Original Motion Picture Soundtrack', 'Ennio Morricone', 'Homonym movie soundtrack, created by the Legendary composer The Master Ennio Morricone', '1966-12-29', 0, NULL),
             ('Hollywood in Vienna 2014', 'Randy Newman - David Newman', 'Annual cinematographic review hosted in Vienna', '2014-09-23', 1, 'Vienna'),
             ('The Fragile', 'Nine Inch Nails', 'The Fragile is the third album and a double album by American industrial rock band Nine Inch Nails, released on September 21, 1999, by Interscope Records.', '1999-09-21', 0, NULL),
             ('American IV: The Man Comes Around', 'Johnny Cash', 'American IV: The Man Comes Around is the fourth album in the American series by Johnny Cash(and his 87th overall), released in 2002. The majority of songs are covers which Cash performs in his own spare style, with help from producer Rick Rubin.', '2002-06-19', 0, NULL),
             ('Greatest Hits', 'Neil Young', 'Rock & Folk Rock greatest success songs by Neil Young', '2004-06-21', 0, NULL);
-- Insert into Song
INSERT INTO Song(`IdAlbum`, `Title`, `Genre`, `Duration`, `IdImage`)
       VALUES(1, 'Mind Heist', 'Orchestra', 203, 1),
             (1, 'Dream is collapsing', 'Orchestra', 281, 1),
             (1, 'Time', 'Orchestra', 215, 1),
             (1, 'Half Remembered Dream', 'Orchestra', 71, 1),
             (1, 'We Built Our Own World', 'Orchestra', 115, 1),
             (1, 'Radical Notion', 'Orchestra', 222, 1),
             (1, 'Paradox', 'Orchestra', 205, 1),
             (2, 'Il Tramonto', 'Orchestra', 72, 2),
             (2, 'L\'estasi dell\'oro', 'Orchestra', 202, 2),
             (2, 'Morte di un soldato', 'Orchestra', 185, 2),
             (2, 'Il Triello', 'Orchestra', 434, 2),
             (3, 'The Simpsons', 'Orchestra', 172, 3),
             (3, 'The war of the Roses', 'Orchestra', 272, 3),
             (4, 'Somewhat Damaged', 'Industrial Metal', 271, 4),
             (4, 'The Day The Whole World Went Away', 'Industrial Metal', 273, 4),
             (4, 'We\'re In This Together', 'Industrial Metal', 436, 4),
             (4, 'Just Like You Imagined', 'Industrial Metal', 229, 4),
             (4, 'The Great Below', 'Industrial Metal', 317, 4),
             (5, 'Hurt', 'Country', 218, 5),
             (5, 'Danny Boy', 'Country', 199, 5),
             (6, 'Old Man', 'Rock', 203, 6),
             (6, 'Southern Man', 'Rock', 331, 6);
-- Insert into Cover
INSERT INTO Cover(`IdImage`, `IdAlbum`, `Path`)
       VALUES(1, 1, 'img/covers/inception.png'),
       (2, 2, 'img/covers/morricone.jpg'),
       (3, 3, 'img/covers/hivlogo.jpg'),
       (4, 4, 'img/covers/fragile.jpg'),
       (5, 5, 'img/covers/nocover.jpg'),
       (6, 6, 'img/covers/nocover.jpg');
-- Insert into Collection
INSERT INTO Collection(`IdUser`) VALUES(1), (2);
-- Insert into SongCollection
INSERT INTO SongCollection(`IdSong`, `IdCollection`) VALUES(1, 1), (2, 1), (3, 1), (2, 2);
-- Insert into Playlist
INSERT INTO Playlist(`IdUser`, `Name`, `Private`) VALUES(1, 'Score & Soundtracks', 0), (1, 'Southern Rock', 0), (2, 'Colonne sonore western', 0);
-- Insert into PlaylistSong
INSERT INTO PlaylistSong(`IdPlaylist`, `IdSong`) VALUES(1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (2, 21), (2, 22), (3, 5), (3, 7), (3, 4);
-- Insert into Queue
INSERT INTO Queue(`IdUser`, `IdSong`, `TimeStamp`)
       VALUES(1, 1, '2015-04-28 18:50:03'),
       (1, 5, '2015-04-28 18:54:06'),
       (1, 1, '2015-04-28 19:01:43');
-- Insert into Heard
INSERT INTO Heard(`IdUser`, `IdSong`, `TimeStamp`)
       VALUES(1, 1, '2015-04-28 18:50:03'),
       (1, 5, '2015-04-28 18:54:06'),
       (1, 1, '2015-04-28 19:01:43'),
       (3, 7, '2015-04-29 18:51:02'),
       (3, 11, '2015-04-29 17:23:15'),
       (2, 9, '2015-04-30 21:12:52'),
       (2, 1, '2015-05-02 22:21:22');
-- Insert into Follow
INSERT INTO Follow(`IdUser`, `IdFellow`) VALUES(1, 2), (1, 3), (2, 1), (3, 1);
SET FOREIGN_KEY_CHECKS = 1;