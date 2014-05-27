SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
USE `T_800`;

DELIMITER $$
USE `T_800`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `T_800`.`makecards`
AFTER INSERT ON `T_800`.`jc_identificaciones`
FOR EACH ROW
BEGIN
INSERT INTO jc_credenciales (nombre_credencial,email_credencial,fk_identificaciones_credenciales) VALUES (NEW.usuario_identificacion,CONCAT(NEW.usuario_identificacion,'@junglacode.org'),NEW.pk_id_identificacion);
 END$$

DELIMITER ;


-- insert iniciales 

INSERT INTO `T_800`.`jc_roles` (`pk_id_rol`, `nombre_rol`) VALUES ('1', 'root');
INSERT INTO `T_800`.`jc_perfiles` (`pk_id_perfil`, `nombre_perfil`, `fk_id_roles_perfiles`) VALUES ('1', 'root', '1');
INSERT INTO `T_800`.`jc_identificaciones` (`pk_id_identificacion`, `usuario_identificacion`, `password_identificacion`, `candado_identificacion`, `fk_id_perfiles_identificaciones`, `fecha_identificacion`) VALUES ('1', 'Root', 'frameworkRegina', '1', '1', '1986-04-27');


