DROP FUNCTION IF EXISTS albumTotalDuration;
DROP FUNCTION IF EXISTS elegibleForPrize;
DELIMITER $$

CREATE FUNCTION albumTotalDuration(IdAlbum INT)
RETURNS VARCHAR(5)
BEGIN
DECLARE Seconds INT UNSIGNED;
SELECT SUM(b.Durata) INTO Seconds FROM Brani b WHERE b.IdAlbum = IdAlbum;
RETURN CONCAT(FLOOR(Seconds / 60), ':', (Seconds % 60));
END $$

DELIMITER ;

DELIMITER $$

CREATE FUNCTION elegibleForPrize(IdUser INT, Genre VARCHAR(50))
RETURNS BOOLEAN
BEGIN
DECLARE Seconds INT UNSIGNED DEFAULT 0;
DECLARE Elegibility BOOLEAN DEFAULT FALSE;
SELECT SUM(b.Durata) INTO Seconds
FROM Ascoltate a INNER JOIN Utenti u ON(a.IdUtente = u.IdUtente)
                 INNER JOIN Brani b ON(a.IdBrano = b.IdBrano)
WHERE b.Genere = 'Orchestra' AND a.IdUtente = IdUser;
IF(Seconds >= 1000) THEN
           SET Elegibility = TRUE;
END IF;
RETURN Elegibility;
END $$

DELIMITER ;