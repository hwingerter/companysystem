CREATE TABLE `categoria` (
  `cod_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`cod_categoria`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



insert into categoria (nome) values('Barba');
insert into categoria (nome) values('Cabelo');
insert into categoria (nome) values('Depilação');
insert into categoria (nome) values('Estética Corporal');
insert into categoria (nome) values('Estética Facial');
insert into categoria (nome) values('Manicure e Pedicure');
insert into categoria (nome) values('Maquiagem');
insert into categoria (nome) values('Massagem');
insert into categoria (nome) values('Podologia');
insert into categoria (nome) values('Outros');
