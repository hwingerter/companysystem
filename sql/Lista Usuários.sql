select * from usuarios order by nome asc;

select		u.cod_usuario, tp.descricao as TipoConta, u.nome, u.status, u.cod_grupo, g.nome as grupo
from 		usuarios u
left join 	tipo_conta tp on tp.cod_tipo_conta = u.tipo_conta
left join 	grupos g on g.cod_grupo = u.cod_grupo;


select case when count(*) > 0 then 'sim' else 'nao' end as TemEmpresa from usuarios_grupos_empresas where cod_usuario = 12;


select count(*) from usuarios_grupos_empresas where cod_usuario = 12;