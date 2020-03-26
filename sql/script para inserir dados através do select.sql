
select 	concat("insert into credenciais values (", cod_credencial, ", '", descricao, "', '", credencial, "');")
from 	credenciais
where cod_credencial in (36, 37, 38, 39)
;

