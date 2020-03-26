CREATE TABLE `usuarios_grupos_empresas` (
  `cod_usuario_grupo_empresa` int(11) NOT NULL AUTO_INCREMENT,
  `cod_usuario` int(11) DEFAULT NULL,
  `cod_grupo` int(11) DEFAULT NULL,
  `cod_empresa` int(11) DEFAULT NULL,
  PRIMARY KEY (`cod_usuario_grupo_empresa`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;
