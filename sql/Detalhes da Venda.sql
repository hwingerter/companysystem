select 		cp.*
from 		caixa a
inner join 	comanda c on c.cod_caixa=a.cod_caixa
left join 	comanda_pagamento cp on cp.cod_comanda=c.cod_comanda
where 		a.cod_caixa = 40;

