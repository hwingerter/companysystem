CREATE TABLE `claudio_company`.`tipo_movimentacao` (
  `cod_tipo_movimentacao` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(45) NULL,
  PRIMARY KEY (`cod_tipo_movimentacao`))
ENGINE = InnoDB;

INSERT INTO `claudio_company`.`tipo_movimentacao` (`descricao`) VALUES ('(+) Entrada - Compra');
INSERT INTO `claudio_company`.`tipo_movimentacao` (`descricao`) VALUES ('(+) Entrada - Bonificação/Brinde');
INSERT INTO `claudio_company`.`tipo_movimentacao` (`descricao`) VALUES ('(+) Entrada - Devolução de Venda');
INSERT INTO `claudio_company`.`tipo_movimentacao` (`descricao`) VALUES ('(-) Saída - Devolução de Compra');
INSERT INTO `claudio_company`.`tipo_movimentacao` (`descricao`) VALUES ('(-) Saída - Perda/Quebra/Deterioração');
INSERT INTO `claudio_company`.`tipo_movimentacao` (`descricao`) VALUES ('(-) Saída - Uso Interno/Consumo');
INSERT INTO `claudio_company`.`tipo_movimentacao` (`descricao`) VALUES ('(-) Saída - Venda sem comanda');

