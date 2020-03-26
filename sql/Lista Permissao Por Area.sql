/* PERMISSAO POR AREA */

select 		p.cod_permissao, p.descricao
			,(
				select 	case when count(*) > 0 then 'S' else 'N' end 
				from	licenca_permissao lp 
                where 	lp.cod_permissao = p.cod_permissao 
                and 	lp.cod_licenca = 1) as TemPermissao
from 		permissoes p
inner join	area a on a.cod_area = p.cod_area

order by 	cod_permissao;