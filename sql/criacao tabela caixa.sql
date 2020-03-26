CREATE TABLE `caixa` (
  `cod_caixa` int(11) NOT NULL auto_increment,
  `valor` varchar(45) DEFAULT NULL,
  `dt_abertura` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cod_caixa`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
