SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `muveo` ;
CREATE SCHEMA IF NOT EXISTS `muveo` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `muveo` ;

-- -----------------------------------------------------
-- Table `muveo`.`Usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `muveo`.`Usuario` ;

CREATE  TABLE IF NOT EXISTS `muveo`.`Usuario` (
  `idUsuario` INT NOT NULL AUTO_INCREMENT ,
  `nbUsuario` VARCHAR(45) CHARACTER SET 'utf8' NOT NULL ,
  `tipoUsuario` INT NOT NULL ,
  `nombre` VARCHAR(45) NULL ,
  `apellidos` VARCHAR(45) NULL ,
  `nacionalidad` VARCHAR(45) NULL ,
  `password` VARCHAR(45) NOT NULL ,
  `email` VARCHAR(45) NOT NULL ,
  `telefono` VARCHAR(45) NULL ,
  `valoracion` INT NULL ,
  `formacion` TEXT NULL ,
  `avatarPath` VARCHAR(45) NULL ,
  `salt` CHAR(128) NULL ,
  PRIMARY KEY (`idUsuario`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `muveo`.`Oferta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `muveo`.`Oferta` ;

CREATE  TABLE IF NOT EXISTS `muveo`.`Oferta` (
  `idOferta` INT NOT NULL ,
  `idOfertante` INT NOT NULL ,
  `titulo` VARCHAR(45) NULL ,
  `descripcion` TEXT NULL ,
  `categoria` VARCHAR(45) NULL ,
  `localizacion` VARCHAR(45) NULL ,
  `fechaPublicacion` DATE NULL ,
  `precio` DECIMAL(6,2) NULL ,
  `ratio` INT NULL ,
  `idioma` INT NULL ,
  `valoracion` INT NULL ,
  PRIMARY KEY (`idOferta`) ,
  INDEX `idOfertante_idx` (`idOfertante` ASC) ,
  CONSTRAINT `fk_idOfertante`
    FOREIGN KEY (`idOfertante` )
    REFERENCES `muveo`.`Usuario` (`idUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `muveo`.`Contrato`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `muveo`.`Contrato` ;

CREATE  TABLE IF NOT EXISTS `muveo`.`Contrato` (
  `idUsuario` INT NOT NULL ,
  `idOferta` INT NOT NULL ,
  `fechaContratacion` DATE NULL ,
  `valoracion` INT NULL ,
  PRIMARY KEY (`idUsuario`, `idOferta`) ,
  INDEX `fk_Usuario_has_Oferta_Oferta1_idx` (`idOferta` ASC) ,
  INDEX `fk_Usuario_has_Oferta_Usuario1_idx` (`idUsuario` ASC) ,
  CONSTRAINT `fk_Usuario_has_Oferta_Usuario1`
    FOREIGN KEY (`idUsuario` )
    REFERENCES `muveo`.`Usuario` (`idUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Oferta_Oferta1`
    FOREIGN KEY (`idOferta` )
    REFERENCES `muveo`.`Oferta` (`idOferta` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `muveo`.`Etiqueta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `muveo`.`Etiqueta` ;

CREATE  TABLE IF NOT EXISTS `muveo`.`Etiqueta` (
  `idEtiqueta` INT NOT NULL ,
  `nombre` VARCHAR(45) NULL ,
  PRIMARY KEY (`idEtiqueta`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `muveo`.`EtiquetasOferta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `muveo`.`EtiquetasOferta` ;

CREATE  TABLE IF NOT EXISTS `muveo`.`EtiquetasOferta` (
  `idOferta` INT NOT NULL ,
  `idEtiqueta` INT NOT NULL ,
  PRIMARY KEY (`idOferta`, `idEtiqueta`) ,
  INDEX `fk_Oferta_has_Etiqueta_Etiqueta1_idx` (`idEtiqueta` ASC) ,
  INDEX `fk_Oferta_has_Etiqueta_Oferta1_idx` (`idOferta` ASC) ,
  CONSTRAINT `fk_Oferta_has_Etiqueta_Oferta1`
    FOREIGN KEY (`idOferta` )
    REFERENCES `muveo`.`Oferta` (`idOferta` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Oferta_has_Etiqueta_Etiqueta1`
    FOREIGN KEY (`idEtiqueta` )
    REFERENCES `muveo`.`Etiqueta` (`idEtiqueta` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `muveo`.`LoginAttempt`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `muveo`.`LoginAttempt` ;

CREATE  TABLE IF NOT EXISTS `muveo`.`LoginAttempt` (
  `idAttempt` INT NOT NULL ,
  `idUsuario` INT NULL ,
  `time` DATETIME NULL ,
  PRIMARY KEY (`idAttempt`) ,
  INDEX `fk_idUsuario_idx` (`idUsuario` ASC) ,
  CONSTRAINT `fk_idUsuario`
    FOREIGN KEY (`idUsuario` )
    REFERENCES `muveo`.`Usuario` (`idUsuario` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `muveo` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
