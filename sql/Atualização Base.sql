ALTER TABLE `claudio_company`.`estoque` 
ADD INDEX `estoque_fornecedor_idx` (`cod_fornecedor` ASC);
ALTER TABLE `claudio_company`.`estoque` 
ADD CONSTRAINT `estoque_fornecedor`
  FOREIGN KEY (`cod_fornecedor`)
  REFERENCES `claudio_company`.`fornecedores` (`cod_fornecedor`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


ALTER TABLE `claudio_company`.`estoque` 
ADD INDEX `estoque_tipo_movimentacao_idx` (`cod_tipo_movimentacao` ASC);
ALTER TABLE `claudio_company`.`estoque` 
ADD CONSTRAINT `estoque_tipo_movimentacao`
  FOREIGN KEY (`cod_tipo_movimentacao`)
  REFERENCES `claudio_company`.`tipo_movimentacao` (`cod_tipo_movimentacao`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


