CREATE TABLE `area` (
  `cod_area` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`cod_area`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

insert into area (nome) values ('Sistema');
insert into area (nome) values ('Cadastros');
insert into area (nome) values ('Caixa');
insert into area (nome) values ('Financeiro');