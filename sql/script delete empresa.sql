set @cod_empresa = 43;

delete from agenda where cod_empresa = @cod_empresa;

delete from caixa_gaveta where cod_empresa = @cod_empresa;

delete from caixa where cod_empresa = @cod_empresa;

delete from cartao where cod_empresa = @cod_empresa;

delete from categoria where cod_empresa = @cod_empresa;

delete from clientes_credito where cod_empresa = @cod_empresa;

delete from comanda_pagamento where cod_empresa = @cod_empresa;

delete from comanda_item where cod_empresa = @cod_empresa;

delete from comanda where cod_empresa = @cod_empresa;

delete from conta where cod_empresa = @cod_empresa;

delete from clientes where cod_empresa = @cod_empresa;

delete from estoque where cod_fornecedor in (
	select cod_fornecedor from fornecedores where cod_empresa = @cod_empresa
);

delete from fornecedores where cod_empresa = @cod_empresa;

delete from grupo_produtos where cod_empresa = @cod_empresa;

delete from produtos where cod_empresa = @cod_empresa;

delete from profissional_rendimentos where cod_empresa = @cod_empresa;

delete from profissional_horario where cod_empresa = @cod_empresa;

delete from profissional_comissao where cod_empresa = @cod_empresa;

delete from profissional where cod_empresa = @cod_empresa;

delete from servico where cod_empresa = @cod_empresa;

delete from tipo_servico where cod_empresa = @cod_empresa;

delete from tipo_movimentacao where cod_empresa = @cod_empresa;

delete from tipo_conta where cod_empresa = @cod_empresa;

delete from tipo_conta_credencial  where cod_tipo_conta in (select cod_tipo_conta from tipo_conta where cod_empresa = @cod_empresa);

delete from usuarios where cod_usuario in (select cod_usuario from usuarios_grupos_empresas where cod_empresa = @cod_empresa);

delete from usuarios_grupos_empresas where cod_empresa = @cod_empresa;

delete from empresas_licenca where cod_empresa = @cod_empresa;

delete from empresas_preferencias where cod_empresa = @cod_empresa;

update grupo_empresas set cod_filial = null where cod_filial = @cod_empresa;

delete from grupo_empresas where cod_empresa = @cod_empresa;

delete from empresas where cod_empresa = @cod_empresa;


