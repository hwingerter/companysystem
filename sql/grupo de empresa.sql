
select * from empresas;

select 		e.empresa, e.endereco, e.email, e.telefone
from 		empresas e
order by	e.empresa asc;


Select e.*, l.descricao from empresas e
inner join licencas l on l.cod_licenca = e.cod_licenca
where cod_empresa = 1;


/*empresas vinculadas*/
select			e.empresa, e.endereco, e.email, e.telefone, uf.uf, c.nome as cidade, l.descricao as licenca
from 			empresas e
inner join 		grupo_empresas g on g.cod_empresa = e.cod_empresa
inner join		licencas l on l.cod_licenca = e.cod_licenca
inner join		cidades c on c.cod_cidade = e.cidade
inner join 		estados uf on uf.cod_estado = e.estado
where 			g.cod_grupo = 2;

/*empresas não vinculadas a esse grupo*/
select			e.empresa, e.endereco, e.email, e.telefone, uf.uf, c.nome as cidade, l.descricao as licenca
from 			empresas e
inner join 		grupo_empresas g on g.cod_empresa = e.cod_empresa
inner join		licencas l on l.cod_licenca = e.cod_licenca
inner join		cidades c on c.cod_cidade = e.cidade
inner join 		estados uf on uf.cod_estado = e.estado
where 			g.cod_grupo = 2;


select 		e.empresa, e.endereco, e.email, e.telefone
from 		empresas e
where		e.cod_empresa not in (select g.cod_empresa from grupo_empresas g)
order by	e.empresa asc;


