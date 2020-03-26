<?php

require_once "usuario.php";

$sql = "Select count(*) as total from tipo_conta_credencial where cod_tipo_conta = ". $_SESSION['tipo_conta'];
//echo $sql;die;
$query = mysql_query($sql);
$registros = mysql_num_rows($query);
if ($registros > 0) {
	if ($rs = mysql_fetch_array($query)) { 
		$totalcredencial = $rs["total"];
	}
}

$sql = "
Select		credenciais.credencial 
from 		tipo_conta_credencial 
inner join 	credenciais on tipo_conta_credencial.cod_credencial = credenciais.cod_credencial  
where 		tipo_conta_credencial.cod_tipo_conta = " . $_SESSION['tipo_conta']."";
//echo $sql;die;
$query = mysql_query($sql);
$registros = mysql_num_rows($query);
if ($registros > 0) {
	$i = 0;
	while ($rs = mysql_fetch_array($query)) { 
		$credenciais[$i] = $rs["credencial"];
		$i = $i + 1;
	}
}

$credencial_ver = 1;
$credencial_incluir = 1;
$credencial_editar = 1;
$credencial_excluir = 1;

/*

if (!EhAdministrador())
{

	//AREAS PERMITIDAS
	$acesso_minha_empresa = 0;
	$acesso_cadastros = 0;
	$acesso_agenda = 0;
	$acesso_caixa = 0;
	$acesso_vendas = 0;
	$acesso_financeiro = 0;
	$acesso_salarios_comissoes = 0;
	$acesso_estoque = 0;
	$acesso_relatorio = 0;

	$sql = "
	Select		p.cod_area
	from	 	licenca_permissao lp
	inner join	permissoes p on p.cod_permissao = lp.cod_permissao
	where 		lp.cod_licenca = ".$_SESSION['cod_licenca']."
	group by	p.cod_area
	order by	p.cod_area;
	";
	//echo $sql;die;
	$query = mysql_query($sql);
	if (mysql_num_rows($query) > 0) 
	{
		$i = 0;
		while ($rs = mysql_fetch_array($query)) 
		{ 
			
			switch($rs['cod_area'])
			{
				case '1':
					$acesso_minha_empresa = 1;
					break;
				case '2':
					$acesso_cadastros = 1;
					break;
				case '3':
					$acesso_caixa = 1;
					break;
					
				case '4':
					$acesso_vendas = 1;
					break;
					
				case '5':
					$acesso_financeiro = 1;
					break;
					
				case '6':
					$acesso_agenda = 1;
					break;
					
				case '7':
					$acesso_estoque = 1;
					break;
					
				case '8':
					$acesso_salarios_comissoes = 1;
					break;
					
				case '9':
					$acesso_relatorio = 1;
					break;
			}

			$i = $i + 1;
		}
	}
	
}
else
{
	//AREAS PERMITIDAS
	$acesso_minha_empresa = 1;
	$acesso_cadastros = 1;
	$acesso_agenda = 1;
	$acesso_caixa = 1;
	$acesso_vendas = 1;
	$acesso_financeiro = 1;
	$acesso_salarios_comissoes = 1;
	$acesso_estoque = 1;
	$acesso_relatorio = 1;
}

*/
?>