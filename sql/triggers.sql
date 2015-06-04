DROP TRIGGER IF EXISTS checkDuration;
DROP TRIGGER IF EXISTS errorTrigger;
DROP TRIGGER IF EXISTS checkFollower;
DROP TRIGGER IF EXISTS insertAutoCollection;
DROP TRIGGER IF EXISTS insertAutoAdminSubs;
DROP TRIGGER IF EXISTS updateAutoAdminSubs;

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

DELIMITER ;

DELIMITER $$

CREATE TRIGGER checkFollower
BEFORE INSERT ON `Seguaci`
FOR EACH ROW
BEGIN
    IF NEW.IdUtente = NEW.IdSeguace THEN
       CALL RAISE_ERROR('Un utente non può seguire se stesso (IdUtente e IdSeguace devono essere diversi fra loro)');
    END IF;       
END $$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER insertAutoCollection
AFTER INSERT ON `Utenti`
FOR EACH ROW
BEGIN
    INSERT INTO `Collezioni` (`IdUtente`) VALUES(NEW.IdUtente);
END $$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER insertAutoAdminSubs
BEFORE INSERT ON `Login`
FOR EACH ROW
BEGIN
    IF(NEW.Amministratore = 1) THEN
        INSERT INTO `Iscrizioni` (`IdUtente`, `Tipo`) VALUES(NEW.IdUtente, 'Premium')
        ON DUPLICATE KEY UPDATE Tipo = 'Premium';
    ELSE
        INSERT INTO `Iscrizioni` (`IdUtente`, `Tipo`) VALUES(NEW.IdUtente, 'Free');
    END IF;
END $$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER updateAutoAdminSubs
BEFORE UPDATE ON `Login`
FOR EACH ROW
BEGIN
   IF(NEW.Amministratore = 1) THEN
        INSERT INTO `Iscrizioni` (`IdUtente`, `Tipo`) VALUES(NEW.IdUtente, 'Premium')
        ON DUPLICATE KEY UPDATE Tipo = 'Premium';
   END IF;
END $$

DELIMITER ;