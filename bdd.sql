-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`category` (
  `id_cat` INT NOT NULL AUTO_INCREMENT,
  `name_cat` VARCHAR(255) NULL,
  PRIMARY KEY (`id_cat`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`movie`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`movie` (
  `id_mov` INT NOT NULL AUTO_INCREMENT,
  `title_mov` VARCHAR(255) NULL,
  `description_mov` TEXT(2048) NULL,
  `video_link_mov` VARCHAR(255) NULL,
  `cover_mov` VARCHAR(255) NULL,
  `released_at_mov` DATE NULL,
  `id_cat` INT NOT NULL,
  PRIMARY KEY (`id_mov`, `id_cat`),
  INDEX `fk_movie_category_idx` (`id_cat` ASC),
  CONSTRAINT `fk_movie_category`
    FOREIGN KEY (`id_cat`)
    REFERENCES `mydb`.`category` (`id_cat`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`user` (
  `id_user` INT NOT NULL AUTO_INCREMENT,
  `username_user` VARCHAR(64) NULL,
  `email_user` VARCHAR(255) NULL,
  `password_user` VARCHAR(255) NULL,
  `token_expiration_user` DATETIME NULL,
  `token` VARCHAR(255) NULL,
  PRIMARY KEY (`id_user`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
