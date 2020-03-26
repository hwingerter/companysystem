CREATE TABLE `tipo_comissao` (
  `cod_tipo_comissao` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`cod_tipo_comissao`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


insert into tipo_comissao (nome) values ('Percentual');
insert into tipo_comissao (nome) values ('Fixa');
