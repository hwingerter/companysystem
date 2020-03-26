CREATE TABLE `claudio_company`.`banco` (
  `cod_banco` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(45) NULL,
  PRIMARY KEY (`cod_banco`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


INSERT INTO `claudio_company`.`banco` (`descricao`) VALUES ('Banco do Brasil');
INSERT INTO `claudio_company`.`banco` (`descricao`) VALUES ('Bradesco');
INSERT INTO `claudio_company`.`banco` (`descricao`) VALUES ('Caixa');
INSERT INTO `claudio_company`.`banco` (`descricao`) VALUES ('Itaú');
INSERT INTO `claudio_company`.`banco` (`descricao`) VALUES ('Santander');
