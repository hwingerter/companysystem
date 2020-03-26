
select		c.dt_inclusao as dt_venda,
			case
				when ci.cod_servico <> '' then s.nome
				when ci.cod_produto <> '' then prod.descricao
			end as servico_produto,
            c1.nome,
            (ci.comissao*ci.quantidade) as total_comissao,
            (ci.comissao*ci.quantidade) as valores_processar,
            '0.00' as valores_pagos,
			'' as datas_pgt_realizados
from 		comanda c 
inner join 	comanda_item ci on ci.cod_comanda = c.cod_comanda
left join	servico s on s.cod_servico = ci.cod_servico
left join 	produtos prod on prod.cod_produto = ci.cod_produto
left join 	profissional p on p.cod_profissional = ci.cod_profissional
inner join 	clientes c1 on c1.cod_cliente = c.cod_cliente
where 		ci.cod_empresa = 8
order by 	dt_venda desc