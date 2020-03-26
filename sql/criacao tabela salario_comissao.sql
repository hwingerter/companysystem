CREATE TABLE `claudio_company`.`salario_comissao` (
  `cod_salario_comissao` INT NOT NULL AUTO_INCREMENT,
  `cod_empresa` INT NOT NULL,
  `cod_profissional` INT NOT NULL,
  `salario` FLOAT(10,2) NULL,
  `decimo_terceiro` FLOAT(10,2) NULL,
  `ferias` FLOAT(10,2) NULL,
  PRIMARY KEY (`cod_salario_comissao`));