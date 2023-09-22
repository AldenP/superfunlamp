# Create Users Table
CREATE TABLE `UserDatabase`.`Users` (
    `ID` INT NOT NULL AUTO_INCREMENT,
    `UserName` VARCHAR(50) NOT NULL DEFAULT '',
    `FirstName` VARCHAR(50) NOT NULL DEFAULT '',
    `LastName` VARCHAR(50) NOT NULL DEFAULT '',
    `Login` VARCHAR(50) NOT NULL DEFAULT '',
    `Password` VARCHAR(50) NOT NULL DEFAULT '',
    UNIQUE (`UserName`),
    PRIMARY KEY (`ID`)
) ENGINE = InnoDB;

# Create Contacts Table
CREATE TABLE `UserDatabase`.`Contacts` (
    `ID` INT NOT NULL AUTO_INCREMENT,
    `UserID` INT NOT NULL,
    `DateCreated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `PhoneNumber` VARCHAR(15) NOT NULL DEFAULT '',
    `Email`  VARCHAR(50) NOT NULL DEFAULT '',
    `FirstName` VARCHAR(50) NOT NULL DEFAULT '',
    `LastName` VARCHAR(50) NOT NULL DEFAULT '',
    PRIMARY KEY (`ID`)
) ENGINE = InnoDB;
