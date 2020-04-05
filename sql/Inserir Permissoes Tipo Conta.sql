/*ADMINISTRADOR MASTER*/

insert into	tipo_conta_permissao (cod_tipo_conta, cod_permissao)
select 		1, cod_permissao
from 		permissoes;

/*ANALISTA DE SISTEMAS*/

insert into	tipo_conta_permissao (cod_tipo_conta, cod_permissao)
select 		2, cod_permissao
from 		permissoes
