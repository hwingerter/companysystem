
CREATE TABLE `comanda_item` (
  `cod_comanda_item` int(11) NOT NULL AUTO_INCREMENT,
  `cod_comanda` int(11) NOT NULL,
  `cod_empresa` int(11) DEFAULT NULL,
  `cod_cliente` int(11) DEFAULT NULL,
  `cod_profissional` int(11) DEFAULT NULL,
  `cod_produto` int(11) DEFAULT NULL,
  `cod_servico` int(11) DEFAULT NULL,
  `valor` float(10,2) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `dt_inclusao` datetime DEFAULT NULL,
  PRIMARY KEY (`cod_comanda_item`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



CREATE TABLE `comanda` (
  `cod_comanda` int(11) NOT NULL AUTO_INCREMENT,
  `cod_empresa` int(11) DEFAULT NULL,
  `cod_cliente` int(11) DEFAULT NULL,
  `dt_inclusao` datetime DEFAULT NULL,
  `cod_usuario` int(11) DEFAULT NULL,
  `situacao` int(11) DEFAULT '1',
  PRIMARY KEY (`cod_comanda`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
