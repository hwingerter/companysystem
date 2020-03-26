CREATE TABLE `servico` (
  `cod_servico` int(11) NOT NULL AUTO_INCREMENT,
  `cod_empresa` int(11) NOT NULL,
  `cod_categoria` int(11) DEFAULT NULL,
  `cod_tipo_servico` int(11) DEFAULT NULL,
  `nome` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `custo_produtos` float(10,2) DEFAULT NULL,
  `preco_venda` float(10,2) DEFAULT NULL,
  `desconto_maximo` float(10,2) DEFAULT NULL,
  `desconto_promocional` float(10,2) DEFAULT NULL,
  `duracao_aproximada` int(11) DEFAULT NULL,
  `cod_tipo_comissao` int(11) DEFAULT NULL,
  `comissao_percentual` float(10,2) DEFAULT NULL,
  `descontar_custo_produtos` int(11) DEFAULT NULL,
  `obs` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`cod_servico`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
