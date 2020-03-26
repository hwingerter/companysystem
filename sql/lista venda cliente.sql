select 		c.cod_comanda
			,DATE_FORMAT(c.dt_inclusao, '%d/%m/%Y') as dataVenda
			,(	select 	sum(c1.valor) 
				from 	comanda_item c1 
				where 	c1.cod_empresa=c.cod_empresa
                and 	c1.cod_cliente = c.cod_cliente
                and 	c1.cod_comanda = c.cod_comanda
                ) as ValorDivida
from 		caixa a
inner join 	comanda c on c.cod_caixa=a.cod_caixa
left join 	comanda_pagamento cp on cp.cod_comanda=c.cod_comanda
where 		c.cod_empresa = 8
and 		c.cod_cliente = 14
and 		c.situacao = 1;
and 		c.dt_inclusao asc;