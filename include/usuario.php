<?php 

function EhAdministrador()
{
	if($_SESSION['tipo_conta'] == 1) return True;
}

function MontaMenu()
{
	if ($_SESSION['cod_empresa'] == 1) 
	{
		return "menu_companySystem.php";
	}
	else
	{
		return "menu.php";
	}
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
