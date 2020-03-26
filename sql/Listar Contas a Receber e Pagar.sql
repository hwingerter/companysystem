select 		c.parcela, c.valor
			,case when c.flg_paga = 'S' then 'Sim' else 'Não' end as JafoiPaga
            ,case when c.flg_usoudagaveta = 'S' then 'Sim' else 'Não' end as UsouGaveta
            ,case when c.flg_quitar_automatico = 'S' then 'Sim' else 'Não' end as QuitadoAutomatico
            ,date_format(c.dt_vencimento, '%d/%m/%Y') as dt_vencimento
            ,date_format(c.dt_quitacao, '%d/%m/%Y') as dt_quitacao
            ,date_format(c1.dt_abertura, '%d/%m/%Y') as caixa
from 		conta c 
left join	caixa c1 on c1.cod_caixa = c.cod_caixa
where 		c.cod_contaPai = 69 or c.cod_conta = 69 
and 		c.cod_empresa = 8;

