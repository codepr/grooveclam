DROP FUNCTION IF EXISTS albumTotalDuration;

DELIMITER $$

CREATE FUNCTION albumTotalDuration(IdAlbum INT)
RETURNS VARCHAR(5)
BEGIN
DECLARE Seconds INT UNSIGNED;
SELECT SUM(b.Durata) INTO Seconds FROM Brani b WHERE b.IdAlbum = IdAlbum;
RETURN CONCAT(FLOOR(Seconds / 60), ':', (Seconds % 60));
END $$

DELIMITER ;