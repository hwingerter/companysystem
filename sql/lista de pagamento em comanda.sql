select		case p.cod_forma_pagamento
				when 1 then 'Dinheiro'
				when 2 then 'Cartão de Débito'
			end as forma_pagamento				
			,p.cod_comanda_pagamento,p.cod_comanda, p.valor
			,DATE_FORMAT(p.dt_pagamento, '%d/%m/%Y %H:%m hs') as dataPagamento
			,u.nome as atendente 
from 		comanda_pagamento p 
inner join 	usuarios u on u.cod_usuario = p.cod_usuario_pagamento 
where 		p.cod_empresa = 8 
and 		p.cod_cliente = 10 
and 		p.cod_comanda = 14 
order by	p.dt_pagamento asc