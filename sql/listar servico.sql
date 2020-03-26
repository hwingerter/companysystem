select 		s.nome, ts.nome as tipo_servico, s.custo_produtos, s.preco_venda, s.desconto_maximo, s.desconto_promocional
			,s.duracao_aproximada, s.comissao_percentual
			,case when s.descontar_custo_produtos = 1 then 'Sim' else 'Não' end as DescontaCursoProduto
from 		servico s
inner join 	categoria c on c.cod_categoria = s.cod_categoria
inner join 	tipo_servico ts on ts.cod_tipo_servico = s.cod_tipo_servico
inner join	tipo_comissao tc on tc.cod_tipo_comissao = s.cod_tipo_comissao
where 		s.cod_empresa = 2
order by	s.nome; 