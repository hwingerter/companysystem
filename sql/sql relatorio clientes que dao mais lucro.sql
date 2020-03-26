

select		cli.nome
			,( select sum(ci.valor) from comanda_item ci where ci.cod_empresa=c.cod_empresa and ci.cod_cliente=c.cod_cliente) as valor_vendas
            ,0.00 as custo_produtos
            ,0.00 as comissao
			,( select sum(ci.valor) from comanda_item ci where ci.cod_empresa=c.cod_empresa and ci.cod_cliente=c.cod_cliente) as lucro_bruto
            ,(select sum(ci.quantidade) from comanda_item ci where ci.cod_empresa=c.cod_empresa and ci.cod_cliente=c.cod_cliente and ci.cod_produto is null) as qtd_serv_vendidos
            ,(select sum(ci.quantidade) from comanda_item ci where ci.cod_empresa=c.cod_empresa and ci.cod_cliente=c.cod_cliente and ci.cod_servico	 is null) as qtd_prod_vendidos
from 		comanda c
inner join	clientes cli on cli.cod_cliente = c.cod_cliente
where		c.cod_empresa = 8
group by 	cli.nome
order by 	lucro_bruto desc