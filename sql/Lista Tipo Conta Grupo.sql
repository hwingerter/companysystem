
select		g.cod_grupo, g.nome as Gupom, tc.cod_tipo_conta, tc.descricao
			,concat('(', g.nome, ') - ', tc.descricao )
from 		tipo_conta tc
inner join	grupos g on g.cod_grupo = tc.cod_grupo;


select		tc.cod_tipo_conta, concat('(', g.nome, ') - ', tc.descricao ) as TipoConta
from 		tipo_conta tc
inner join	grupos g on g.cod_grupo = tc.cod_grupo
group by	g.nome, tc.cod_tipo_conta, tc.descricao
order by 	g.nome asc, tc.descricao asc
