-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema WMSS_Project
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema WMSS_Project
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `WMSS_Project` DEFAULT CHARACTER SET utf8 ;
USE `WMSS_Project` ;

-- -----------------------------------------------------
-- Table `WMSS_Project`.`categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WMSS_Project`.`categories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WMSS_Project`.`products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WMSS_Project`.`products` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(150) NOT NULL DEFAULT 'unnamed',
  `stock` INT NOT NULL DEFAULT 0,
  `description` TEXT NULL,
  `price` DECIMAL(6,2) NOT NULL,
  `kind` ENUM('literverpakking', 'ijstaart') NOT NULL,
  `image` TEXT NULL,
  `featured` TINYINT(1) NOT NULL DEFAULT 0,
  `categories_id` INT NOT NULL,
  `sortweight` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `fk_products_categories1_idx` (`categories_id` ASC) VISIBLE,
  CONSTRAINT `fk_products_categories1`
    FOREIGN KEY (`categories_id`)
    REFERENCES `WMSS_Project`.`categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WMSS_Project`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WMSS_Project`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `phonenumber` VARCHAR(45) NULL,
  `address` VARCHAR(120) NULL,
  `password` VARCHAR(255) NOT NULL,
  `is_admin` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WMSS_Project`.`orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WMSS_Project`.`orders` (
  `id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `date` DATETIME NOT NULL,
  PRIMARY KEY (`id`, `user_id`),
  INDEX `fk_orders_customers1_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_orders_customers1`
    FOREIGN KEY (`user_id`)
    REFERENCES `WMSS_Project`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WMSS_Project`.`tags`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WMSS_Project`.`tags` (
  `id` INT NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WMSS_Project`.`order_has_product`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WMSS_Project`.`order_has_product` (
  `product_id` INT UNSIGNED NOT NULL,
  `order_id` INT NOT NULL,
  `quantity` INT NOT NULL DEFAULT 1,
  PRIMARY KEY (`product_id`, `order_id`),
  INDEX `fk_products_has_orders_orders1_idx` (`order_id` ASC) VISIBLE,
  INDEX `fk_products_has_orders_products1_idx` (`product_id` ASC) VISIBLE,
  CONSTRAINT `fk_products_has_orders_products1`
    FOREIGN KEY (`product_id`)
    REFERENCES `WMSS_Project`.`products` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_products_has_orders_orders1`
    FOREIGN KEY (`order_id`)
    REFERENCES `WMSS_Project`.`orders` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WMSS_Project`.`product_has_tag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WMSS_Project`.`product_has_tag` (
  `product_id` INT UNSIGNED NOT NULL,
  `tag_id` INT NOT NULL,
  PRIMARY KEY (`product_id`, `tag_id`),
  INDEX `fk_products_has_tags_tags1_idx` (`tag_id` ASC) VISIBLE,
  INDEX `fk_products_has_tags_products1_idx` (`product_id` ASC) VISIBLE,
  CONSTRAINT `fk_products_has_tags_products1`
    FOREIGN KEY (`product_id`)
    REFERENCES `WMSS_Project`.`products` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_products_has_tags_tags1`
    FOREIGN KEY (`tag_id`)
    REFERENCES `WMSS_Project`.`tags` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WMSS_Project`.`arrangements`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WMSS_Project`.`arrangements` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(150) NOT NULL,
  `description` VARCHAR(150) NULL,
  `location` DATETIME NOT NULL,
  `start_time` DATETIME NOT NULL,
  `end_time` DATETIME NOT NULL,
  `is_work` TINYINT(1) NULL DEFAULT 0,
  `user_id` INT NULL,
  `url` VARCHAR(150) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_afspraken_users1_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_afspraken_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `WMSS_Project`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WMSS_Project`.`pop-ups`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WMSS_Project`.`pop-ups` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `message` TEXT NOT NULL,
  `start` DATETIME NOT NULL,
  `end` DATETIME NOT NULL,
  `frequency` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
