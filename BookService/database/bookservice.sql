-- MySQL Script generated by MySQL Workbench
-- Kam 29 Nov 2018 05:45:52  WIB
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema bookservice
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `bookservice` ;

-- -----------------------------------------------------
-- Schema bookservice
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `bookservice` ;
USE `bookservice` ;

-- -----------------------------------------------------
-- Table `bookservice`.`book`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bookservice`.`book` ;

CREATE TABLE IF NOT EXISTS `bookservice`.`book` (
  `id` VARCHAR(15) NOT NULL,
  `price` INT NOT NULL,
  `sale` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bookservice`.`book_category`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bookservice`.`book_category` ;

CREATE TABLE IF NOT EXISTS `bookservice`.`book_category` (
  `book_id` VARCHAR(15) NOT NULL,
  `category` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`book_id`, `category`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `bookservice`.`book`
-- -----------------------------------------------------
START TRANSACTION;
USE `bookservice`;
INSERT INTO `bookservice`.`book` (`id`, `price`, `sale`) VALUES ('VE0LqD085eMC', 139040, 0);
INSERT INTO `bookservice`.`book` (`id`, `price`, `sale`) VALUES ('iQmPNDIAskUC', 115200, 0);
INSERT INTO `bookservice`.`book` (`id`, `price`, `sale`) VALUES ('Aaug_RnI-xQC', 132600, 0);
INSERT INTO `bookservice`.`book` (`id`, `price`, `sale`) VALUES ('0ENFDwAAQBAJ', 63750, 0);
INSERT INTO `bookservice`.`book` (`id`, `price`, `sale`) VALUES ('iO5pApw2JycC', 230100, 0);
INSERT INTO `bookservice`.`book` (`id`, `price`, `sale`) VALUES ('OyB4llvAoXQC', 144300, 0);
INSERT INTO `bookservice`.`book` (`id`, `price`, `sale`) VALUES ('WV8pZj_oNBwC', 192400, 0);
INSERT INTO `bookservice`.`book` (`id`, `price`, `sale`) VALUES ('LiWrXUHgnL8C', 82000, 0);
INSERT INTO `bookservice`.`book` (`id`, `price`, `sale`) VALUES ('szF_pLGmJTQC', 52900, 0);
INSERT INTO `bookservice`.`book` (`id`, `price`, `sale`) VALUES ('o-QCOFDHmPEC', 170100, 0);

COMMIT;
