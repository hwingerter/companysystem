CREATE TABLE `claudio_company`.`agenda` (
  `cod_agenda` INT NOT NULL AUTO_INCREMENT,
  `cod_empresa` INT NULL,
  `cod_profissional` INT NULL,
  `cod_servico` INT NULL,
  `dt_agenda` DATE NULL,
  `telefone` VARCHAR(45) NULL,
  `repetir` INT NULL,
  `cor` VARCHAR(6) NULL,
  `obs` TEXT NULL,
  PRIMARY KEY (`cod_agenda`));
