
select 		a.cod_area, a.nome
from 		licencas l 
inner join	licenca_permissao lp on lp.cod_licenca = l.cod_licenca
inner join 	permissoes p on p.cod_permissao = lp.cod_permissao
inner join 	area a on a.cod_area = p.cod_area
where 		l.cod_licenca = 1
group by	a.cod_area, a.nome;