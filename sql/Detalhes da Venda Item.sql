select 		c.cod_comanda
			,case
				when ci.cod_servico is not null then s.nome
                when ci.cod_produto is not null then p.descricao
			end as Descricao
			,ci.quantidade, ci.valor
            ,p1.nome
from 		comanda c
inner join 	comanda_item ci on ci.cod_comanda = c.cod_comanda
left join 	servico s on s.cod_servico = ci.cod_servico
left join 	produtos p on p.cod_produto = ci.cod_produto
left join 	profissional p1 on p1.cod_profissional=ci.cod_profissional
where 		c.cod_empresa = 8
and 		c.cod_cliente = 14
and 		c.cod_comanda = 39;