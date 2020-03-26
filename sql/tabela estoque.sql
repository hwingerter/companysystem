CREATE TABLE `claudio_company`.`estoque` (
  `cod_estoque` INT NOT NULL,
  `cod_produto` INT NULL,
  `cod_tipo_movimentacao` INT NULL,
  `dt_movimentacao` DATE NULL,
  `quantidade` INT NULL,
  `custo_total` FLOAT NULL,
  `custo_medio_compra` FLOAT NULL,
  `gerar_conta_pagamento` CHAR(1) NULL,
  `cod_fornecedor` INT NULL,
  `nota_fiscal` VARCHAR(45) NULL,
  `obs` TEXT NULL,
  PRIMARY KEY (`cod_estoque`));

ALTER TABLE `claudio_company`.`estoque` 
ADD CONSTRAINT `produto_estoque`
  FOREIGN KEY (`cod_produto`)
  REFERENCES `claudio_company`.`produtos` (`cod_produto`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
  