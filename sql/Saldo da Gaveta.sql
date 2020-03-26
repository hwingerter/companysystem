
select		DATE_FORMAT(cg.dt_transacao, '%d/%m/%Y - %H:%m') as data_hora
			,cg.descricao
            ,u.nome
			,cg.valor
from		caixa c
inner join 	caixa_gaveta cg on cg.cod_caixa = c.cod_caixa
inner join 	usuarios u on u.cod_usuario = cg.cod_usuario = u.cod_usuario
where 		c.cod_caixa = 21
and 		c.cod_empresa = 8
order by 	cg.dt_transacao asc;