ALTER TABLE `comanda_item` 
ADD COLUMN `flg_desconto_acrescimo` CHAR(1) NULL COMMENT 'D - Desconto\nA - Acrescimo' AFTER `dt_inclusao`,
ADD COLUMN `desconto` INT NULL AFTER `flg_desconto_acrescimo`,
ADD COLUMN `valor_ascrescimo` FLOAT(10,2) NULL AFTER `desconto`;

ALTER TABLE `claudio_company`.`comanda_item` 
CHANGE COLUMN `desconto` `percentual` INT(11) NULL DEFAULT NULL ,
ADD COLUMN `percentual_desconto` INT NULL AFTER `percentual`,
ADD COLUMN `valor_desconto` FLOAT(10,2) NULL AFTER `percentual_desconto`;
