
select * from agenda where cod_empresa in (select cod_empresa from grupo_empresas where cod_grupo = 40);

select * from caixa_gaveta where cod_empresa in (select cod_empresa from grupo_empresas where cod_grupo = 40);

select * from caixa where cod_empresa in (select cod_empresa from grupo_empresas where cod_grupo = 40);

select * from cartao where cod_empresa in (select cod_empresa from grupo_empresas where cod_grupo = 40);

select * from categoria where cod_empresa in (select cod_empresa from grupo_empresas where cod_grupo = 40);

select * from clientes where cod_empresa in (select cod_empresa from grupo_empresas where cod_grupo = 40);

select * from clientes_credito where cod_empresa in (select cod_empresa from grupo_empresas where cod_grupo = 40);

select * from comanda_pagamento where cod_empresa in (select cod_empresa from grupo_empresas where cod_grupo = 40);

select * from comanda_item where cod_empresa in (select cod_empresa from grupo_empresas where cod_grupo = 40);

select * from comanda where cod_empresa in (select cod_empresa from grupo_empresas where cod_grupo = 40);

select * from conta where cod_empresa in (select cod_empresa from grupo_empresas where cod_grupo = 40);

/*select * from estoque where cod_empresa in (select cod_empresa from grupo_empresas where cod_grupo = 40);*/

select * from fornecedores where cod_empresa in (select cod_empresa from grupo_empresas where cod_grupo = 40);

select * from grupo_produtos where cod_empresa in (select cod_empresa from grupo_empresas where cod_grupo = 40);

select * from produtos where cod_empresa in (select cod_empresa from grupo_empresas where cod_grupo = 40);

select * from profissional_rendimentos where cod_empresa in (select cod_empresa from grupo_empresas where cod_grupo = 40);

select * from profissional_horario where cod_empresa in (select cod_empresa from grupo_empresas where cod_grupo = 40);

select * from profissional_comissao where cod_empresa in (select cod_empresa from grupo_empresas where cod_grupo = 40);

select * from profissional where cod_empresa in (select cod_empresa from grupo_empresas where cod_grupo = 40);

select * from servico where cod_empresa in (select cod_empresa from grupo_empresas where cod_grupo = 40);

select * from tipo_servico where cod_empresa in (select cod_empresa from grupo_empresas where cod_grupo = 40);

select * from tipo_movimentacao where cod_empresa in (select cod_empresa from grupo_empresas where cod_grupo = 40);

select * from tipo_conta where cod_grupo = 40;

select * from tipo_conta_credencial where cod_tipo_conta in (select cod_tipo_conta from tipo_conta where cod_grupo = 40);

select * from usuarios_grupos_empresas where cod_grupo = 40;

/*select * from empresas_preferencias where cod_empresa in (select cod_empresa from grupo_empresas where cod_grupo = 40);*/

select * from empresas_licenca where cod_empresa in (select cod_empresa from grupo_empresas where cod_grupo = 40);

select * from empresas where cod_empresa in (select cod_empresa from grupo_empresas where cod_grupo = 40);

select * from grupo_empresas where cod_grupo = 40;

select * from grupos where cod_grupo = 40;