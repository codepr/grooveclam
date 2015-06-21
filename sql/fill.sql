SET FOREIGN_KEY_CHECKS = 0;
-- Insert into Utente
INSERT INTO Utenti(`Nome`, `Cognome`, `Email`)
       VALUES('Andrea', 'Baldan', 'a.g.baldan@gmail.com'),
	         ('Federico', 'Angi', 'angiracing@gmail.com'),
	         ('Marco', 'Rossi', 'rossi@gmail.com'),
             ('Luca', 'Verdi', 'verdi@yahoo.it'),
             ('Alessia', 'Neri', 'neri@gmail.com'),
             ('Francesco', 'Franchi', 'franchi.francesco@gmail.com'),
             ('Paola', 'Ortini', 'paola.ortini@yahoo.it'),
             ('Giulio', 'Spadanuova', 'spadavecchia@msn.it'),
             ('Steven', 'Seagal', 'steven.seagal@gmail.com');
-- Insert into Login
INSERT INTO Login(`Username`, `Password`, `DataCreazione`, `IdUtente`)
       VALUES('codep', MD5('ciao'), '2015-04-29 18:51:00', 1),
             ('keepcalm', MD5('calm'), '2015-05-24 19:50:01', 2),
             ('rossi', MD5('marco'), '2015-05-28 19:50:04', 3),
             ('verdi', MD5('luca'), '2015-05-29 19:50:07', 4),
             ('neri', MD5('Alessia'), '2015-05-29 20:50:09', 5),
             ('fran', MD5('cesco'), '2015-06-01 17:42:22', 6),
             ('ortx', MD5('paola'), '2015-05-27 18:22:41', 7),
             ('gsword', MD5('newsword'), '2015-05-22 23:01:52', 8),
             ('casey', MD5('rayback'), '2015-06-21 15:43:01', 9);
-- Insert into Seguaci                
INSERT INTO Seguaci(`IdUtente`, `IdSeguace`) VALUES(1, 2), (1, 3), (2, 1), (3, 1), (1, 4), (4, 1), (1, 8), (8, 1), (1, 9);
-- Insert into Iscrizioni
INSERT INTO Iscrizioni(`IdUtente`, `Tipo`)
       VALUES(1, 'Free'),
             (2, 'Free'),
             (3, 'Premium'),
             (4, 'Free'),
             (5, 'Premium'),
             (6, 'Free'),
             (7, 'Free'),
             (8, 'Premium'),
             (9, 'Premium');
-- Insert into Album
INSERT INTO Album(`Titolo`, `Autore`, `Info`, `Anno`, `Live`, `Locazione`, `PathCopertina`)
       VALUES('Inception Suite', 'Hans Zimmer', 'Inception movie soundtrack, composed by the Great Compositor Hans Zimmer', '2010', 0, NULL, 'img/covers/inception.png'),
             ('The Good, the Bad and the Ugly: Original Motion Picture Soundtrack', 'Ennio Morricone', 'Homonym movie soundtrack, created by the Legendary composer The Master Ennio Morricone', '1966', 0, NULL, 'img/covers/morricone.jpg'),
             ('Hollywood in Vienna 2014', 'Randy Newman - David Newman', 'Annual cinematographic review hosted in Vienna', '2014', 1, 'Vienna', 'img/covers/hivlogo.jpg'),
             ('The Fragile', 'Nine Inch Nails', 'The Fragile is the third album and a double album by American industrial rock band Nine Inch Nails, released on September 21, 1999, by Interscope Records.', '1999', 0, NULL, 'img/covers/fragile.jpg'),
             ('American IV: The Man Comes Around', 'Johnny Cash', 'American IV: The Man Comes Around is the fourth album in the American series by Johnny Cash(and his 87th overall), released in 2002. The majority of songs are covers which Cash performs in his own spare style, with help from producer Rick Rubin.', '2002', 0, NULL, 'img/covers/nocover.jpg'),
             ('Greatest Hits', 'Neil Young', 'Rock & Folk Rock greatest success songs by Neil Young', '2004', 0, NULL, 'img/covers/nocover.jpg'),
             ('Kill Bill vol.2: Original Soundtack', 'Various', 'Kill Bill Vol. 2 Original Soundtrack is the soundtrack to the second volume of the two-part Quentin Tarantino film, Kill Bill. First released on April 13, 2004, it reached #58 on the Billboard 200 and #2 on the Billboard soundtracks chart in the US.', '2004', 0, NULL, 'img/covers/killbillv2.jpg');
-- Insert into Brani
INSERT INTO Brani(`IdAlbum`, `Titolo`, `Genere`, `Durata`)
       VALUES(1, 'Mind Heist', 'Orchestra', 203),
             (1, 'Dream is collapsing', 'Orchestra', 281),
             (1, 'Time', 'Orchestra', 215),
             (1, 'Half Remembered Dream', 'Orchestra', 71),
             (1, 'We Built Our Own World', 'Orchestra', 115),
             (1, 'Radical Notion', 'Orchestra', 222),
             (1, 'Paradox', 'Orchestra', 205),
             (2, 'Il Tramonto', 'Orchestra', 72),
             (2, 'L\'estasi dell\'oro', 'Orchestra', 202),
             (2, 'Morte di un soldato', 'Orchestra', 185),
             (2, 'Il Triello', 'Orchestra', 434),
             (3, 'The Simpsons', 'Orchestra', 172),
             (3, 'The war of the Roses', 'Orchestra', 272),
             (4, 'Somewhat Damaged', 'Industrial Metal', 271),
             (4, 'The Day The Whole World Went Away', 'Industrial Metal', 273),
             (4, 'We\'re In This Together', 'Industrial Metal', 436),
             (4, 'Just Like You Imagined', 'Industrial Metal', 229),
             (4, 'The Great Below', 'Industrial Metal', 317),
             (5, 'Hurt', 'Country', 218),
             (5, 'Danny Boy', 'Country', 199),
             (6, 'Old Man', 'Rock', 203),
             (6, 'Southern Man', 'Rock', 331),
             (7, 'Il tramonto', 'Orchestra', 75),
             (7, 'Summertime Killer','Score', 209),
             (7, 'L\'arena', 'Score / Orchestra', 286),
             (7, 'The Legend of Pai Mei', 'Score', 126);
-- Insert into BraniCollezione
INSERT INTO BraniCollezione(`IdBrano`, `IdCollezione`) VALUES(1, 1), (2, 1), (3, 1), (7, 1), (14, 1), (12, 1), (17, 1), (18, 1), (13, 1), (8, 1), (2, 2), (11, 2), (3,2), (4, 2), (7, 2), (15, 2), (21, 2), (22, 2), (1, 3), (2, 3), (6, 3), (8, 3), (15, 3), (19, 3), (17, 3), (7, 3), (4, 3), (2, 4), (3, 4), (7, 4), (8, 4), (16, 4), (1, 5), (7, 5), (2, 5);
-- Insert into Playlist
INSERT INTO Playlist(`IdUtente`, `Nome`, `Tipo`) VALUES(1, 'Score & Soundtracks', 'Pubblica'), (1, 'Southern Rock', 'Pubblica'), (2, 'Colonne sonore western', 'Pubblica'), (1, 'Rock', 'Privata'), (3, 'Orchestra', 'Pubblica');
-- Insert into BraniPlaylist
INSERT INTO BraniPlaylist(`IdPlaylist`, `IdBrano`, `Posizione`) VALUES(1, 1, 1), (1, 2, 2), (1, 3, 3), (1, 4, 4), (1, 5, 5), (1, 7, 6), (1, 12, 7), (1, 18, 8), (1, 13, 9), (1, 8, 10), (2, 21, 1), (2, 22, 2), (2, 15, 3), (2, 4, 4), (2, 7, 5), (3, 5, 1), (3, 7, 2), (3, 4, 3);
-- Insert Condivise
INSERT INTO Condivise(`IdPlaylist`, `IdUtente`) VALUES(4, 1), (4, 2), (4, 3);
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
             (2, 7, '2015-04-29 18:51:02'),
             (3, 11, '2015-04-29 17:23:15'),
             (3, 9, '2015-04-30 21:12:52'),
             (2, 1, '2015-05-02 22:21:22');

SET FOREIGN_KEY_CHECKS = 1;