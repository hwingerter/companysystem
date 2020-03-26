CREATE TABLE `claudio_company`.`tipo_prazo_cartao` (
  `cod_tipo_prazo` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(45) NULL,
  PRIMARY KEY (`cod_tipo_prazo`));
  
insert into tipo_operacao (descricao) values ('Crédito e Débito');
insert into tipo_operacao (descricao) values ('Somente Crédito');
insert into tipo_operacao (descricao) values ('Somente Débito');