<?php

require_once "usuario.php";

//RESETANDO CREDENCIAS

$credencial_ver = 0;
$credencial_incluir = 0;
$credencial_editar = 0;
$credencial_excluir = 0;
$credencial_areas = 0;	
$credencial_empresa_acessar = 0;			

if(($_SESSION['tipo_conta'] == 1) || ($_SESSION['tipo_conta'] == 2))
{
	$credencial_ver = 1;
	$credencial_incluir = 1;
	$credencial_editar = 1;
	$credencial_excluir = 1;
	$credencial_areas = 1;
	$credencial_empresa_acessar = 1;		

	$menu_tipo_conta = 1;
	$menu_credencial = 1;
	$menu_usuario = 1;
	$menu_minhas_preferencias = 1;
}

//CREDENCIAIS PERMITIDAS
$sql = "
select		c.credencial
from		tipo_conta_credencial t
inner join	credenciais c on c.cod_credencial = t.cod_credencial
where 		t.cod_tipo_conta = ".$_SESSION['tipo_conta']."
";
//echo $sql;die;
$query = mysql_query($sql);
$registros = mysql_num_rows($query);
$totalcredencial = $registros;
if ($registros > 0) {
	$i = 0;
	while ($rs = mysql_fetch_array($query)) { 
		$credenciais[$i] = $rs["credencial"];
		//echo $credenciais[$i]."<br>";
		$i = $i + 1;
		
	}
}
//die;

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
from	 	tipo_conta_permissao lp
inner join	permissoes p on p.cod_permissao = lp.cod_permissao
where 		lp.cod_tipo_conta = ".$_SESSION['tipo_conta']."
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

//MENU
$menu_tipo_conta = 0;
$menu_credencial = 0;
$menu_usuarios = 0;
$menu_minhas_preferencias = 0;
$menu_licencas = 0;

$menu_clientes = 0;
$menu_empresas = 0;
$menu_fornecedores = 0;
$menu_produtos = 0;
$menu_grupo_produtos = 0;
$menu_profissional = 0;
$menu_tipo_servico = 0;
$menu_servicos = 0;
$menu_cartao = 0;

$menu_agenda = 0;

$sql = "
Select		lp.cod_permissao
from	 	tipo_conta_permissao lp
where 		lp.cod_tipo_conta = ".$_SESSION['tipo_conta'].";
";
//echo $sql;die;
$query = mysql_query($sql);
if (mysql_num_rows($query) > 0) 
{
	while ($rs = mysql_fetch_array($query)) 
	{ 
		switch($rs['cod_permissao'])
		{
			case '2':
			$menu_tipo_conta = 1;
			break;
			case '3':
			$menu_credencial = 1;
			break;
			case '18':
			$menu_minhas_preferencias = 1;
			break;
			case '1':
			$menu_usuarios = 1;
			break;
			case '45':
			$menu_licencas = 1;
			break;
			case '4':
			$menu_empresas = 1;
			break;
			case '5':
			$menu_clientes = 1;
			break;
			case '6':
			$menu_fornecedores = 1;
			break;
			case '7':
			$menu_produtos = 1;
			break;
			case '8':
			$menu_grupo_produtos = 1;
			break;
			case '10':
			$menu_servicos = 1;
			break;
			case '11':
			$menu_profissional = 1;
			break;
			case '12':
			$menu_tipo_servico = 1;
			break;	
			case '13':
			$menu_cartao = 1;
			break;
			case '60':
			$menu_agenda = 1;
		}

	}
}

?>