<?php

require_once "../config/conexao.php";

require_once "../include/funcoes.php";

require_once "../licenca/licenca.inc.php";

	if ((isset($_REQUEST['sucesso']))){ $sucesso = $_REQUEST['sucesso']; }
	if ((isset($_REQUEST['erro']))){ $erro = $_REQUEST['erro']; } else { $erro = '0'; }
	if ( (isset($_REQUEST['login'])) &&  (isset($_REQUEST['senha'])) ){
	
	$usuario = limpa($_REQUEST['login']);
	$senha = limpa(trim($_REQUEST['senha']));
	
	$senha .= "&D31R#i017$";
	$senha = md5($senha);
	
	$sql = "
	select 	
			u.cod_usuario, u.nome, u.tipo_conta, t.descricao as tipo_conta_descricao, u.status
			,(select count(*) from usuarios_empresas where cod_usuario = u.cod_usuario) as TotalEmpresas 
	from 	
			usuarios u
	inner join
			tipo_conta t on t.cod_tipo_conta = u.tipo_conta

	where 	
			u.email='". $usuario ."' and u.senha='". $senha ."'
	";	

	$query = mysql_query($sql)or die (mysql_error());

	$registros = mysql_num_rows($query);

	
	if ($registros > 0) 
	{
		$rs = mysql_fetch_array($query);

		if($rs['status'] == 'A')
		{
			session_start();
			
			$_SESSION['usuario_nome'] 			= $rs['nome'];
			$_SESSION['cod_usuario'] 			= $rs['cod_usuario'];
			$_SESSION['usuario_conta']			= $rs['cod_usuario'];
			$_SESSION['tipo_conta'] 			= $rs['tipo_conta'];
			$_SESSION['tipo_conta_descricao'] 	= $rs['tipo_conta_descricao'];
			$_SESSION['TotalEmpresas'] 			= $rs['TotalEmpresas'];

			if ($rs['TotalEmpresas'] == 1)
			{			
				$sql = "
				select		e.cod_empresa, e.empresa
				from 		usuarios_empresas g
				inner join	empresas e on e.cod_empresa = g.cod_empresa
				and 		cod_usuario = ".$rs['cod_usuario'].";
				";
	
				$query2 = mysql_query($sql)or die( mysql_error() );	
				$rs2 = mysql_fetch_array($query2);

				$_SESSION['cod_empresa'] = $rs2['cod_empresa'];
				$_SESSION['empresa'] 	 = $rs2['empresa'];
	
				echo "<script language='javascript'>window.location='../inicio.php';</script>"; die();
	
			}
			elseif ($rs['TotalEmpresas'] > 1)
			{			
				echo "<script language='javascript'>window.location='../login_empresa.php';</script>"; die();
			}

		}
		else
		{
			echo "<script language='javascript'>location.href='../login.php?erro=2';</script>";die();
		}
	}
	else
	{
		echo "<script language='javascript'>location.href='../login.php?erro=1';</script>";die();
	}
	
}

?>