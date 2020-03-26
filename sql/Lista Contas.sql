select 
		case when c.cod_contaPai is null then c.cod_conta else c.cod_contaPai end cod_conta ,c.descricao, f.empresa, c.valor 
        ,DATE_FORMAT(c.dt_vencimento, '%d/%m/%Y') as dt_vencimento 
        ,DATE_FORMAT(c.dt_quitacao, '%d/%m/%Y') as dt_quitacao ,c.cod_empresa 
        ,case when (select count(*) from conta c1 where c1.cod_contaPai = c.cod_contaPai and c1.cod_empresa = 8) > 1 then 
			concat(convert(c.parcela, char(5)) ,'/' , convert((select count(*) from conta c1 where c1.cod_contaPai = c.cod_contaPai and c1.cod_empresa = 8), char(5))) end as parcela 
            ,c.dt_inclusao
            
from 		conta c 
inner join 	fornecedores f on f.cod_fornecedor = c.cod_fornecedor 
where		c.cod_empresa = 8 
/*and 		c.dt_inclusao >= '2018-03-18 00:00:00' and c.dt_inclusao <= '2018-03-19 23:59:59'*/
order by 	c.cod_contaPai desc;