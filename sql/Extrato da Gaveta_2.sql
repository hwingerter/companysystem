select		DATE_FORMAT(cg.dt_transacao, '%d/%m/%Y - %H:%m') as data_hora
			,cg.descricao
            ,cg.cod_comanda
			,case cg.tipo_transacao 
				when 'INICIO' then 'Administrador'
				else (select cli.nome from clientes cli where cli.cod_cliente = cg.cod_usuario)
			end NomeUsuario
			,case cg.tipo_transacao 
				when 'INICIO' then c.valor
				else
					(select sum(cp1.valor) from comanda_pagamento cp1 where cp1.cod_comanda=cg.cod_comanda and cp1.cod_forma_pagamento=1) 
				end as 'Dinheiro'
            ,(select sum(cp1.valor) from comanda_pagamento cp1 where cp1.cod_comanda=cg.cod_comanda and cp1.cod_forma_pagamento=2) as 'C_Debito'
            ,(select sum(cp1.valor*cp1.num_parcelas) from comanda_pagamento cp1 where cp1.cod_comanda=cg.cod_comanda and cp1.cod_forma_pagamento=3) as 'C_Credito'
            ,(select sum(cp1.valor) from comanda_pagamento cp1 where cp1.cod_comanda=cg.cod_comanda and cp1.cod_forma_pagamento=4) as 'Ch_Vista'
            ,(select sum(cp1.valor) from comanda_pagamento cp1 where cp1.cod_comanda=cg.cod_comanda and cp1.cod_forma_pagamento=5) as 'Ch_Prazo'
            ,(select sum(cp1.valor) from comanda_pagamento cp1 where cp1.cod_comanda=cg.cod_comanda and cp1.cod_forma_pagamento=6) as 'Fiado'
from		caixa c
left join 	caixa_gaveta cg on cg.cod_caixa = c.cod_caixa
where 		c.cod_caixa = 40
and 		c.cod_empresa = 8
order by 	cg.dt_transacao asc;
