
select * from tipo_conta_credencial where cod_tipo_conta in (select cod_tipo_conta from tipo_conta where cod_grupo = 39);

select cod_tipo_conta from tipo_conta where cod_grupo = 39;

select * from usuarios_grupos_empresas where cod_grupo = 39;

select * from empresas_preferencias where cod_empresa in (select cod_empresa from grupo_empresas where cod_grupo = 39);

select * from empresas_licenca where cod_empresa in (select cod_empresa from grupo_empresas where cod_grupo = 39);

select * from empresas where cod_empresa in (select cod_empresa from grupo_empresas where cod_grupo = 39);

select * from grupo_empresas where cod_grupo = 38;

select * from grupos