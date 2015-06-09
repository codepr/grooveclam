DROP TRIGGER IF EXISTS checkDuration;
DROP TRIGGER IF EXISTS errorTrigger;
DROP TRIGGER IF EXISTS checkFollower;
DROP TRIGGER IF EXISTS insertAutoCollection;
/*DROP TRIGGER IF EXISTS cleanUp*/
DROP TRIGGER IF EXISTS insertAutoSongNumber;
DROP TRIGGER IF EXISTS updateAutoSongNumber;
DROP TRIGGER IF EXISTS checkCollectionSize;

DELIMITER $$

CREATE TRIGGER checkDuration
BEFORE INSERT ON `Brani`
FOR EACH ROW
BEGIN
IF(NEW.Durata < 0) THEN
    CALL RAISE_ERROR('La durata di un brano non può essere negativa');
END IF;
END $$

CREATE TRIGGER errorTrigger
BEFORE INSERT ON `Errori`
FOR EACH ROW
BEGIN
    SET NEW = NEW.errore;
END $$

CREATE TRIGGER checkFollower
BEFORE INSERT ON `Seguaci`
FOR EACH ROW
BEGIN
    IF NEW.IdUtente = NEW.IdSeguace THEN
       CALL RAISE_ERROR('Un utente non può seguire se stesso (IdUtente e IdSeguace devono essere diversi fra loro)');
    END IF;
END $$

CREATE TRIGGER insertAutoCollection
AFTER INSERT ON `Utenti`
FOR EACH ROW
BEGIN
    INSERT INTO `Collezioni` (`IdUtente`) VALUES(NEW.IdUtente);
END $$

CREATE TRIGGER updateAutoSongNumber
AFTER UPDATE ON `Brani`
FOR EACH ROW
BEGIN
    DECLARE ida INTEGER DEFAULT -1;
    SELECT a.IdAlbum INTO ida
    FROM `Album` a
    WHERE a.IdAlbum = NEW.IdAlbum;
    IF(ida <> -1) THEN
        UPDATE `Album` SET NBrani = NBrani - 1 WHERE IdAlbum = OLD.IdAlbum;
        UPDATE `Album` SET NBrani = NBrani + 1 WHERE IdAlbum = ida;
    END IF;
END $$

CREATE TRIGGER checkCollectionSize
BEFORE INSERT ON `BraniCollezione`
FOR EACH ROW
BEGIN
	DECLARE numSong INTEGER DEFAULT 0;
    DECLARE idUser INTEGER DEFAULT 0;
    DECLARE subType VARCHAR(7) DEFAULT '';
    SELECT DISTINCT c.IdUtente INTO idUser
    FROM BraniCollezione bc INNER JOIN Collezioni c ON(bc.IdCollezione = c.IdCollezione)
    WHERE bc.IdCollezione = NEW.IdCollezione;
    SELECT COUNT(IdBrano) INTO numSong
    FROM BraniCollezione
    WHERE IdCollezione = NEW.IdCollezione;
    SELECT DISTINCT i.Tipo INTO subType
    FROM Iscrizioni i INNER JOIN Login l ON(i.IdUtente = l.IdUtente)
    WHERE l.IdUtente = idUser;
    IF(numSong = 50 && subType = 'Free') THEN
        CALL RAISE_ERROR('Maximum limit for collected songs reached for a free subscription account.');
    END IF;
END $$

DELIMITER ;
