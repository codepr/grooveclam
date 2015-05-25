SET FOREIGN_KEY_CHECKS = 0;
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
       VALUES('Inception Suite', 'Hans Zimmer', 'Inception movie soundtrack, composed by the Great Compositor Hans Zimmer', '2010', 0, NULL),
             ('The Good, the Bad and the Ugly: Original Motion Picture Soundtrack', 'Ennio Morricone', 'Homonym movie soundtrack, created by the Legendary composer The Master Ennio Morricone', '1966', 0, NULL),
             ('Hollywood in Vienna 2014', 'Randy Newman - David Newman', 'Annual cinematographic review hosted in Vienna', '2014', 1, 'Vienna'),
             ('The Fragile', 'Nine Inch Nails', 'The Fragile is the third album and a double album by American industrial rock band Nine Inch Nails, released on September 21, 1999, by Interscope Records.', '1999', 0, NULL),
             ('American IV: The Man Comes Around', 'Johnny Cash', 'American IV: The Man Comes Around is the fourth album in the American series by Johnny Cash(and his 87th overall), released in 2002. The majority of songs are covers which Cash performs in his own spare style, with help from producer Rick Rubin.', '2002', 0, NULL),
             ('Greatest Hits', 'Neil Young', 'Rock & Folk Rock greatest success songs by Neil Young', '2004', 0, NULL);
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
-- Insert into BraniCollezione
INSERT INTO BraniCollezione(`IdBrano`, `IdCollezione`) VALUES(1, 1), (2, 1), (3, 1), (7, 1), (14, 1), (12, 1), (17, 1), (18, 1), (2, 2);
-- Insert into Playlist
INSERT INTO Playlist(`IdUtente`, `Nome`, `Privata`) VALUES(1, 'Score & Soundtracks', 0), (1, 'Southern Rock', 0), (2, 'Colonne sonore western', 0);
-- Insert into BraniPlaylist
INSERT INTO BraniPlaylist(`IdPlaylist`, `IdBrano`, `Posizione`) VALUES(1, 1, 1), (1, 2, 2), (1, 3, 3), (1, 4, 4), (1, 5, 5), (2, 21, 1), (2, 22, 2), (3, 5, 1), (3, 7, 2), (3, 4, 3);
-- Insert into Code
INSERT INTO Code(`IdUtente`, `IdBrano`, `Posizione`)
       VALUES(1, 1, 1),
       (1, 5, 2),
       (1, 1, 3),
       (1, 12, 4),
       (1, 10, 5),
       (2, 1, 1);
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