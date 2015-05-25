DROP PROCEDURE IF EXISTS RAISE_ERROR;
DROP PROCEDURE IF EXISTS GENRE_DISTRIBUTION;
DROP PROCEDURE IF EXISTS SWAP_POSITION;

DELIMITER $$

CREATE PROCEDURE RAISE_ERROR (IN ERROR VARCHAR(256))
BEGIN
DECLARE V_ERROR VARCHAR(256);
SET V_ERROR := CONCAT('[ERROR: ', ERROR, ']');
INSERT INTO Errors VALUES(V_ERROR);
END $$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE GENRE_DISTRIBUTION()
BEGIN
DECLARE Total INT DEFAULT 0;
DROP TEMPORARY TABLE IF EXISTS `Distribution`;
CREATE TEMPORARY TABLE `Distribution` (
       `Genere` VARCHAR(100),
       `Percentuale` VARCHAR(6)
) ENGINE=InnoDB;
SELECT count(b.Genere) INTO Total FROM Brani b;
INSERT INTO Distribution (Genere, Percentuale)
SELECT Genere, CONCAT(FLOOR((count(Genere) / Total) * 100), "%")
FROM Brani GROUP BY Genere;
SELECT * FROM `Distribution`;
DROP TABLE `Distribution`;
END $$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE GENRE_DISTRIBUTION_ALT(IN IdUser INT)
BEGIN
DECLARE Total INT DEFAULT 0;
SELECT COUNT(b.IdBrano) INTO Total
FROM Brani b INNER JOIN BraniCollezione bc ON(b.IdBrano = bc.IdBrano)
                         INNER JOIN Collezioni c ON(bc.IdCollezione = c.IdCollezione)
WHERE c.IdUtente = IdUser;
DROP TEMPORARY TABLE IF EXISTS `Distribution`;
CREATE TEMPORARY TABLE `Distribution` (
       `Genere` VARCHAR(100),
       `Percentuale` VARCHAR(6)
) ENGINE=InnoDB;
DECLARE CUR_Dist CURSOR FOR
        SELECT b.Genere, COUNT(b.IdBrano)
        FROM Brani b INNER JOIN BraniCollezione ON (b.IdBrano = bc.IdBrano)
                                 INNER JOIN Collezioni c ON(c.IdCollezione = bc.IdCollezione)
        WHERE c.IdUtente = IdUser;
OPEN CUR_Dist
REPEAT
        FETCH CUR_Dist INTO
        UNTIL Done END REPEAT;
CLOSE CUR_Dist;
END $$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE SWAP_POSITION(IN a INT, IN b INT, IN id INT, IN tab INT)
BEGIN
DECLARE AUX INT DEFAULT -1;
CASE tab
     WHEN 1 THEN
          UPDATE Code SET Posizione = AUX WHERE Posizione = a AND IdUtente = id;
          UPDATE Code SET Posizione = a WHERE Posizione = b AND IdUtente = id;
          UPDATE Code SET Posizione = b WHERE Posizione = AUX AND IdUtente = id;
     ELSE        
          UPDATE BraniPlaylist SET Posizione = AUX WHERE Posizione = a AND IdPlaylist = id;
          UPDATE BraniPlaylist SET Posizione = a WHERE Posizione = b AND IdPlaylist = id;
          UPDATE BraniPlaylist SET Posizione = b WHERE Posizione = AUX AND IdPlaylist = id;
END CASE;
END $$

DELIMITER ;