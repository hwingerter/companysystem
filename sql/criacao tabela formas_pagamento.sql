CREATE TABLE `formas_pagamento` (
  `cod_forma_pagamento` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`cod_forma_pagamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `claudio_company`.`formas_pagamento` (`descricao`) VALUES ('Dinheiro');
INSERT INTO `claudio_company`.`formas_pagamento` (`descricao`) VALUES ('Cartão de Débito');
INSERT INTO `claudio_company`.`formas_pagamento` (`descricao`) VALUES ('Cartão de Crédito');
INSERT INTO `claudio_company`.`formas_pagamento` (`descricao`) VALUES ('Chegue à vista');
INSERT INTO `claudio_company`.`formas_pagamento` (`descricao`) VALUES ('Cheque a prazo');
INSERT INTO `claudio_company`.`formas_pagamento` (`descricao`) VALUES ('Fiado');
INSERT INTO `claudio_company`.`formas_pagamento` (`descricao`) VALUES ('Gorjeta');
INSERT INTO `claudio_company`.`formas_pagamento` (`descricao`) VALUES ('Crédito');
