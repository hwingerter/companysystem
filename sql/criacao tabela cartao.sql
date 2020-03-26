CREATE TABLE `claudio_company`.`cartao` (
  `cod_cartao` INT NOT NULL AUTO_INCREMENT,
  `bandeira` VARCHAR(45) NULL,
  `taxa_cartao_debito` VARCHAR(45) NULL,
  `dias_repasse_cartao_debito_operadora` VARCHAR(45) NULL,
  `taxa_cartao_credito_avista` VARCHAR(45) NULL,
  `taxa_cartao_credito_parcelado` VARCHAR(45) NULL,
  `numero_maximo_parcelas` VARCHAR(45) NULL,
  `cod_tipo_prazo` INT NULL,
  `dias_repasse_credito_operadora` INT NULL,
  PRIMARY KEY (`cod_cartao`));