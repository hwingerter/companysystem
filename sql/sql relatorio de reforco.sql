
select 		cg.dt_transacao, cg.valor, cg.descricao, u.nome, cg.dt_transacao
from 		caixa c
inner join  caixa_gaveta cg on cg.cod_caixa=c.cod_caixa
left join	profissional p on p.cod_profissional = cg.cod_usuario
left join	usuarios u on u.cod_usuario = c.cod_usuario
where		cg.cod_empresa = 8
and			cg.tipo_transacao = 'SANGRIA'
order by	cg.dt_transacao asc
