CREATE TABLE `tipo_servico` (
  `cod_tipo_servico` int(11) NOT NULL AUTO_INCREMENT,
  `cod_grupo` int(11) DEFAULT NULL,
  `descricao` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`cod_tipo_servico`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


insert into tipo_servico (cod_grupo, descricao) values('2','Barba');
insert into tipo_servico (cod_grupo, descricao) values('2','Cervejaria');
insert into tipo_servico (cod_grupo, descricao) values('2','Corte');
insert into tipo_servico (cod_grupo, descricao) values('2','Depilação');
insert into tipo_servico (cod_grupo, descricao) values('2','Escova');
insert into tipo_servico (cod_grupo, descricao) values('2','Estética');
insert into tipo_servico (cod_grupo, descricao) values('2','Hidratação');
insert into tipo_servico (cod_grupo, descricao) values('2','Luzes');
insert into tipo_servico (cod_grupo, descricao) values('2','Massagem');
insert into tipo_servico (cod_grupo, descricao) values('2','Penteado');
insert into tipo_servico (cod_grupo, descricao) values('2','Tintura');
insert into tipo_servico (cod_grupo, descricao) values('2','Unhas');
