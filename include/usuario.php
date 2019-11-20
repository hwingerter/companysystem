<?php 

function EhAdministrador()
{
	if($_SESSION['usuario_conta'] == 1) return True;
}

function RetornaEmpresasDoGrupo($grupo)
{

	$sql = "
	select 		ge.cod_empresa
	from 		grupos g
	inner join	grupo_empresas ge on ge.cod_grupo = g.cod_grupo
	where 		g.cod_grupo = ".$grupo.";
	";

	$query = mysql_query($sql);

	return $query;

}

 ?>
