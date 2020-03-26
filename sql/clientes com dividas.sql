/* COMBO CLIENTES COM DÍVIDAS*/
Select 		cli.cod_cliente, cli.nome
from 		clientes cli
inner join	comanda c on c.cod_cliente = cli.cod_cliente
inner join 	comanda_pagamento cp on cp.cod_comanda = c.cod_comanda
where 		cp.cod_empresa = 8
and 		cp.cod_forma_pagamento = 6
and 		c.cod_comanda not in (
				select		cod_comanda 
                from 		comanda_pagamento cp2 
                where 		cp2.cod_empresa=8
				and 		cp2.cod_comanda=cp.cod_comanda
                and 		cp2.cod_forma_pagamento <> 6
			)
group by 	cli.cod_cliente, cli.nome
order by 	cli.nome asc;