SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `T_800`.`jc_roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `T_800`.`jc_roles` (
  `pk_id_rol` TINYINT(4) NOT NULL AUTO_INCREMENT,
  `nombre_rol` VARCHAR(15) NOT NULL,
  PRIMARY KEY (`pk_id_rol`),
  UNIQUE INDEX `nombre_rol` (`nombre_rol` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = latin1
COMMENT = 'esta tabla es parte del framework regina';


-- -----------------------------------------------------
-- Table `T_800`.`jc_perfiles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `T_800`.`jc_perfiles` (
  `pk_id_perfil` TINYINT(4) NOT NULL AUTO_INCREMENT,
  `nombre_perfil` VARCHAR(25) NOT NULL,
  `fk_id_roles_perfiles` TINYINT(4) NULL DEFAULT NULL,
  PRIMARY KEY (`pk_id_perfil`),
  UNIQUE INDEX `nombre_perfil` (`nombre_perfil` ASC),
  INDEX `roles_perfiles_Idx` (`fk_id_roles_perfiles` ASC),
  CONSTRAINT `fk_perfiles_roles`
    FOREIGN KEY (`fk_id_roles_perfiles`)
    REFERENCES `T_800`.`jc_roles` (`pk_id_rol`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 16
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin
COMMENT = 'tabla que es parte del  framework tregina';


-- -----------------------------------------------------
-- Table `T_800`.`jc_identificaciones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `T_800`.`jc_identificaciones` (
  `pk_id_identificacion` TINYINT(4) NOT NULL AUTO_INCREMENT,
  `usuario_identificacion` VARCHAR(20) CHARACTER SET 'latin1' NOT NULL,
  `password_identificacion` VARCHAR(150) NULL DEFAULT NULL,
  `candado_identificacion` CHAR(1) CHARACTER SET 'latin1' NOT NULL DEFAULT '1',
  `fk_id_perfiles_identificaciones` TINYINT(4) NULL DEFAULT NULL,
  `fecha_identificacion` DATETIME NOT NULL,
  `cookie_identificacion` VARCHAR(180) CHARACTER SET 'latin1' NOT NULL,
  PRIMARY KEY (`pk_id_identificacion`),
  UNIQUE INDEX `usuario_identificacion` (`usuario_identificacion` ASC),
  UNIQUE INDEX `fecha_identificacion` (`fecha_identificacion` ASC),
  INDEX `fk_identificaciones_perfiles` (`fk_id_perfiles_identificaciones` ASC),
  CONSTRAINT `fk_identificaciones_perfiles`
    FOREIGN KEY (`fk_id_perfiles_identificaciones`)
    REFERENCES `T_800`.`jc_perfiles` (`pk_id_perfil`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 21
DEFAULT CHARACTER SET = utf8
COMMENT = 'esta tabla es parte del framework regina';


-- -----------------------------------------------------
-- Table `T_800`.`jc_credenciales`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `T_800`.`jc_credenciales` (
  `pk_id_credencial` TINYINT(4) NOT NULL AUTO_INCREMENT,
  `nombre_credencial` VARCHAR(25) NOT NULL,
  `apellido_credencial` VARCHAR(30) NULL,
  `email_credencial` VARCHAR(60) NULL,
  `fk_identificaciones_credenciales` TINYINT(4) NOT NULL,
  `foto_credencial` VARCHAR(100) NOT NULL DEFAULT '../utilerias/img/avatar.png',
  `fecha_credencial` DATE NOT NULL,
  PRIMARY KEY (`pk_id_credencial`),
  UNIQUE INDEX `email_credencial` (`email_credencial` ASC),
  INDEX `fk_credenciales_identificaciones` (`fk_identificaciones_credenciales` ASC),
  CONSTRAINT `fk_credenciales_identificaciones`
    FOREIGN KEY (`fk_identificaciones_credenciales`)
    REFERENCES `T_800`.`jc_identificaciones` (`pk_id_identificacion`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 19
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin
COMMENT = 'esta tabla es parte del framework regina';



