CREATE TABLE `produtos` (
  `cod_produto` int(11) NOT NULL AUTO_INCREMENT,
  `cod_grupo_produto` int(11) DEFAULT NULL,
  `cod_fornecedor` int(11) DEFAULT NULL,
  `cod_empresa` int(11) DEFAULT NULL,
  `descricao` varchar(50) COLLATE utf8_swedish_ci DEFAULT NULL,
  `custo` float(10,2) DEFAULT NULL,
  `preco_venda` float(10,2) DEFAULT NULL,
  `desconto_maximo` float(10,2) DEFAULT NULL,
  `desconto_promocional` float(10,2) DEFAULT NULL,
  `cod_tipo_comissao` int(11) DEFAULT NULL,
  `comissao_percentual` int(11) DEFAULT NULL,
  `comissao_fixa` float(10,2) DEFAULT NULL,
  `descontar_custo_produtos` int(11) DEFAULT NULL,
  `obs` text COLLATE utf8_swedish_ci,
  PRIMARY KEY (`cod_produto`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;
