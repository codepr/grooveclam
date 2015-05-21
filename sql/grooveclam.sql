SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `Errori`;
DROP TABLE IF EXISTS `Album`;
DROP TABLE IF EXISTS `Brani`;
DROP TABLE IF EXISTS `Copertine`;
DROP TABLE IF EXISTS `Utenti`;
DROP TABLE IF EXISTS `Seguaci`;
DROP TABLE IF EXISTS `Iscrizioni`;
DROP TABLE IF EXISTS `Collezione`;
DROP TABLE IF EXISTS `BraniCollezione`;
DROP TABLE IF EXISTS `Playlist`;
DROP TABLE IF EXISTS `BraniPlaylist`;
DROP TABLE IF EXISTS `Code`;
DROP TABLE IF EXISTS `Ascoltate`;

-- Table di supporto Errori
CREATE TABLE IF NOT EXISTS `Errori` (
       `Errore` VARCHAR(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=Latin1;
-- Table Album
CREATE TABLE IF NOT EXISTS `Album` (
	`IdAlbum` INT(11) NOT NULL AUTO_INCREMENT,
	`Titolo` VARCHAR(140) NOT NULL,
	`Autore` VARCHAR(140) NOT NULL,
	`Info` VARCHAR(300) DEFAULT NULL,
	`Anno` DATE NOT NULL,
	`Live` BOOLEAN NOT NULL,
	`Locazione` VARCHAR(40) DEFAULT NULL,
	PRIMARY KEY(`IdAlbum`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- Table Brani
CREATE TABLE IF NOT EXISTS `Brani` (
	`IdBrano` INT(11) NOT NULL AUTO_INCREMENT,
	`IdAlbum` INT(11) NOT NULL,
	`Titolo` VARCHAR(140) NOT NULL,
	`Genere` VARCHAR(40) NOT NULL,
	`Durata` INT(11),
	`IdImm` INT(11) NOT NULL,
	PRIMARY KEY(`IdBrano`),
	FOREIGN KEY(`IdAlbum`) REFERENCES Album(`IdAlbum`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(`IdImm`) REFERENCES Copertine(`IdImm`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- Table Copertine
CREATE TABLE IF NOT EXISTS `Copertine` (
	`IdImm` INT(11) NOT NULL AUTO_INCREMENT,
	`IdAlbum` INT(11) NOT NULL,
	`Path` VARCHAR (40) NOT NULL DEFAULT "img/covers/nocover.jpg",
	PRIMARY KEY(`IdImm`),
	FOREIGN KEY(`IdAlbum`) REFERENCES Album(`IdAlbum`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- Table Utenti
CREATE TABLE IF NOT EXISTS `Utenti` (
	`IdUtente` INT(11) NOT NULL AUTO_INCREMENT,
	`Nome` VARCHAR(40) DEFAULT NULL,
	`Cognome` VARCHAR(40) DEFAULT NULL,
	`Email` VARCHAR(40) NOT NULL,
	`Amministratore` BOOLEAN NOT NULL,
	`Username` VARCHAR(40) NOT NULL,
	`Password` VARCHAR(40) NOT NULL,
	PRIMARY KEY(`IdUtente`),
	UNIQUE(`Username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- Table Seguaci
CREATE TABLE IF NOT EXISTS `Seguaci` (
	`IdUtente` INT(11) NOT NULL,
	`IdSeguace` INT(11) NOT NULL,
	CONSTRAINT PRIMARY KEY pk(`IdUtente`, `IdSeguace`),
	FOREIGN KEY(`IdUtente`) REFERENCES Utenti(`IdUtente`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(`IdSeguace`) REFERENCES Utenti(`IdUtente`) ON DELETE CASCADE ON UPDATE CASCADE,
	CHECK(`IdUtente` != `IdSeguace`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- Table Iscrizioni
CREATE TABLE IF NOT EXISTS `Iscrizioni` (
	`IdUtente` INT(10) NOT NULL,
	`Tipo` ENUM('Free', 'Premium') NOT NULL,
	PRIMARY KEY(`IdUtente`),
	FOREIGN KEY(`IdUtente`) REFERENCES Utenti(`IdUtente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- Table Collezioni
CREATE TABLE IF NOT EXISTS `Collezioni` (
	`IdCollezione` INT(11) NOT NULL AUTO_INCREMENT,
	`IdUtente` INT(11) NOT NULL,
	PRIMARY KEY(`IdCollezione`),
	FOREIGN KEY(`IdUtente`) REFERENCES Utenti(`IdUtente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- Table BraniCollezione
CREATE TABLE IF NOT EXISTS `BraniCollezione` (
	`IdBrano` INT(11) NOT NULL,
	`IdCollezione` INT(11) NOT NULL,
	CONSTRAINT PRIMARY KEY pk(`IdCollezione`, `IdBrano`),
	FOREIGN KEY(`IdBrano`) REFERENCES Brani(`IdBrano`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(`IdCollezione`) REFERENCES Collezioni(`IdCollezione`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- Table Playlist
CREATE TABLE IF NOT EXISTS `Playlist` (
	`IdPlaylist` INT(11) NOT NULL AUTO_INCREMENT,
	`IdUtente` INT(11) NOT NULL,
	`Nome` VARCHAR(40) NOT NULL,
    `Privata` BOOLEAN DEFAULT FALSE,
	PRIMARY KEY(`IdPlaylist`),
	FOREIGN KEY(`IdUtente`) REFERENCES Utenti(`IdUtente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- Table BraniPlaylist
CREATE TABLE IF NOT EXISTS `BraniPlaylist` (
	`IdPlaylist` INT(11) NOT NULL,
	`IdBrano` INT(11) NOT NULL,
	CONSTRAINT PRIMARY KEY pk(`IdPlaylist`, `IdBrano`),
	FOREIGN KEY(`IdPlaylist`) REFERENCES Playlist(`IdPlaylist`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(`IdBrano`) REFERENCES Brani(`IdBrano`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- Table Code
CREATE TABLE IF NOT EXISTS `Code` (
	`IdUtente` INT(11) NOT NULL,
	`IdBrano` INT(11) NOT NULL,
	`Timestamp` TIMESTAMP NOT NULL,
	CONSTRAINT PRIMARY KEY pk(`IdUtente`, `IdBrano`, `Timestamp`),
	FOREIGN KEY(`IdUtente`) REFERENCES Utenti(`IdUtente`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(`IdBrano`) REFERENCES Brani(`IdBrano`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- Table Ascoltate
CREATE TABLE IF NOT EXISTS `Ascoltate` (
	`IdUtente` INT(11) NOT NULL,
	`IdBrano` INT(11) NOT NULL,
	`Timestamp` TIMESTAMP NOT NULL,
	CONSTRAINT PRIMARY KEY pk(`IdUtente`, `IdBrano`, `Timestamp`),
	FOREIGN KEY(`IdUtente`) REFERENCES Utenti(`IdUtente`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(`IdBrano`) REFERENCES Brani(`IdBrano`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- INSERT POPULATION
-- Insert into Utente
INSERT INTO Utenti(`Nome`, `Cognome`, `Email`, `Amministratore`, `Username`, `Password`)
       VALUES('Andrea', 'Baldan', 'a.g.baldan@gmail.com', 0, 'codep', MD5('ciao')),
	         ('Federico', 'Angi', 'angiracing@gmail.com', 0, 'keepcalm', MD5('calm')),
	         ('Marco', 'Rossi', 'rossi@gmail.com', 0, 'rossi', MD5('marco')),
             ('Luca', 'Verdi', 'verdi@yahoo.it', 0, 'verdi', MD5('luca')),
             ('Alessia', 'Neri', 'neri@gmail.com', 0, 'neri', MD5('alessia'));
-- Insert into Subscrition
INSERT INTO Iscrizioni(`IdUtente`, `Tipo`) VALUES(1, 'Free'), (2, 'Free');
-- Insert into Album
INSERT INTO Album(`Titolo`, `Autore`, `Info`, `Anno`, `Live`, `Locazione`)
       VALUES('Inception Suite', 'Hans Zimmer', 'Inception movie soundtrack, composed by the Great Compositor Hans Zimmer', '2010-07-13', 0, NULL),
             ('The Good, the Bad and the Ugly: Original Motion Picture Soundtrack', 'Ennio Morricone', 'Homonym movie soundtrack, created by the Legendary composer The Master Ennio Morricone', '1966-12-29', 0, NULL),
             ('Hollywood in Vienna 2014', 'Randy Newman - David Newman', 'Annual cinematographic review hosted in Vienna', '2014-09-23', 1, 'Vienna'),
             ('The Fragile', 'Nine Inch Nails', 'The Fragile is the third album and a double album by American industrial rock band Nine Inch Nails, released on September 21, 1999, by Interscope Records.', '1999-09-21', 0, NULL),
             ('American IV: The Man Comes Around', 'Johnny Cash', 'American IV: The Man Comes Around is the fourth album in the American series by Johnny Cash(and his 87th overall), released in 2002. The majority of songs are covers which Cash performs in his own spare style, with help from producer Rick Rubin.', '2002-06-19', 0, NULL),
             ('Greatest Hits', 'Neil Young', 'Rock & Folk Rock greatest success songs by Neil Young', '2004-06-21', 0, NULL);
-- Insert into Brani
INSERT INTO Brani(`IdAlbum`, `Titolo`, `Genere`, `Durata`, `IdImm`)
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
-- Insert into Copertine
INSERT INTO Copertine(`IdImm`, `IdAlbum`, `Path`)
       VALUES(1, 1, 'img/covers/inception.png'),
       (2, 2, 'img/covers/morricone.jpg'),
       (3, 3, 'img/covers/hivlogo.jpg'),
       (4, 4, 'img/covers/fragile.jpg'),
       (5, 5, 'img/covers/nocover.jpg'),
       (6, 6, 'img/covers/nocover.jpg');
-- Insert into Collezioni
INSERT INTO Collezioni(`IdUtente`) VALUES(1), (2);
-- Insert into BraniCollezione
INSERT INTO BraniCollezione(`IdBrano`, `IdCollezione`) VALUES(1, 1), (2, 1), (3, 1), (2, 2);
-- Insert into Playlist
INSERT INTO Playlist(`IdUtente`, `Nome`, `Privata`) VALUES(1, 'Score & Soundtracks', 0), (1, 'Southern Rock', 0), (2, 'Colonne sonore western', 0);
-- Insert into BraniPlaylist
INSERT INTO BraniPlaylist(`IdPlaylist`, `IdBrano`) VALUES(1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (2, 21), (2, 22), (3, 5), (3, 7), (3, 4);
-- Insert into Code
INSERT INTO Code(`IdUtente`, `IdBrano`, `Timestamp`)
       VALUES(1, 1, '2015-04-28 18:50:03'),
       (1, 5, '2015-04-28 18:54:06'),
       (1, 1, '2015-04-28 19:01:43');
-- Insert into Ascoltate
INSERT INTO Ascoltate(`IdUtente`, `IdBrano`, `Timestamp`)
       VALUES(1, 1, '2015-04-28 18:50:03'),
       (1, 5, '2015-04-28 18:54:06'),
       (1, 1, '2015-04-28 19:01:43'),
       (3, 7, '2015-04-29 18:51:02'),
       (3, 11, '2015-04-29 17:23:15'),
       (2, 9, '2015-04-30 21:12:52'),
       (2, 1, '2015-05-02 22:21:22');
-- Insert into Seguaci
INSERT INTO Seguaci(`IdUtente`, `IdSeguace`) VALUES(1, 2), (1, 3), (2, 1), (3, 1);
SET FOREIGN_KEY_CHECKS = 1;
