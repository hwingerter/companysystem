<?php

require_once "../config/conexao.php";

require_once "../include/funcoes.php";

	if ((isset($_REQUEST['sucesso']))){ $sucesso = $_REQUEST['sucesso']; }
	if ((isset($_REQUEST['erro']))){ $erro = $_REQUEST['erro']; } else { $erro = '0'; }
	if ( (isset($_REQUEST['login'])) &&  (isset($_REQUEST['senha'])) ){
	
	$usuario = limpa($_REQUEST['login']);
	$senha = limpa($_REQUEST['senha']);
	
	$senha .= "&D31R#i017$";
	$senha = md5($senha);
	
	$sql = "
	select	u.nome, u.cod_usuario, u.tipo_conta, t.descricao as tipo_conta_descricao, u.cod_grupo 
			,(
			select		count(*) 
			from 		usuarios_grupos_empresas 
			where 		cod_usuario = u.cod_usuario
			) as TotalEmpresas
	from usuarios u 
	inner join tipo_conta t on t.cod_tipo_conta = u.tipo_conta 
	where 	u.email='". $usuario ."' and u.senha='". $senha ."' and u.status='A'
	";

	//echo $sql;die;

	$query = mysql_query($sql)or die (mysql_error());

	$registros = mysql_num_rows($query);

	if ($registros > 0) 
	{
		session_start();

		$rs = mysql_fetch_array($query);

		$_SESSION['usuario_nome'] 	= $rs['nome'];
		$_SESSION['usuario_id'] 	= $rs['cod_usuario'];
		$_SESSION['usuario_conta'] = $rs['tipo_conta'];
		$_SESSION['tipo_conta'] 	= $rs['tipo_conta_descricao'];
		//$_SESSION['cod_grupo'] = $rs['cod_grupo'];

		if($rs['tipo_conta'] == "1"){

			//echo "entrei1";die;

			echo "<script language='javascript'>window.location='../login_empresa.php';</script>"; die();
		}
		else{

			$_SESSION['TotalEmpresas'] = $rs['TotalEmpresas'];

			if ($rs['TotalEmpresas'] == 0) 
			{	
				echo "<script language='javascript'>location.href='../login.php?erro=1';</script>";die();

			}
			elseif ($rs['TotalEmpresas'] == 1)
			{	
				//VerificaStatusGrupo($rs['cod_usuario']);
				
				$sql = "
				select		e.cod_empresa, e.empresa
				from 		usuarios_grupos_empresas g
				inner join	empresas e on e.cod_empresa = g.cod_empresa
				and 		cod_usuario = ".$rs['cod_usuario'].";
				";

				//echo $sql;die;

				$query = mysql_query($sql)or die( mysql_error() );

				$rs = mysql_fetch_array($query);

				$_SESSION['cod_empresa'] = $rs['cod_empresa'];
				$_SESSION['empresa'] 	 = $rs['empresa'];

				//$SituacaoLicencaAtual = ObterSituacaoLicencaAtual($rs['cod_empresa']);

				/*
				if ($SituacaoLicencaAtual == "I")
				{
					InativarLicencaAtualEmpresa($rs['cod_empresa']);
					echo "<script language='javascript'>window.location='login.php?erro=3';</script>"; die(); 
				}
				*/

				//MontarPreferencias($rs['cod_empresa']);

				//echo "entrei3";die;

				echo "<script language='javascript'>window.location='../inicio.php';</script>"; die();

			}
			elseif ($rs['TotalEmpresas'] > 1)
			{			
				echo "entrei4";die;

				VerificaStatusGrupo($rs['cod_usuario']);

				echo "<script language='javascript'>window.location='login_empresa.php';</script>"; die();
			}

		}

	} 
	else
	{
		echo "<script language='javascript'>location.href='../login.php?erro=1';</script>";die();
	}
	
}


function VerificaStatusGrupo($cod_usuario) {
	
	$resp = '';
	
	$sql2 = "Select g.status from usuarios_grupos_empresas uge, grupos g where g.cod_grupo = uge.cod_grupo and uge.cod_usuario = ". $cod_usuario;
	//echo $sql2;die;
	$query2 = mysql_query($sql2);
	$registros2 = mysql_num_rows($query2);
	if ($registros2 > 0) {
		if ($rs2 = mysql_fetch_array($query2)){
			$resp = $rs2['status'];
			
		}
	}
	
	if ($resp == 'I') { 
		$_SESSION['usuario_nome'] = '';
		$_SESSION['usuario_id'] = '';
		$_SESSION['usuario_conta'] = '';
		$_SESSION['tipo_conta'] = '';
		$_SESSION['cod_grupo'] = '';
		
		echo "<script language='javascript'>window.location='login.php?erro=2';</script>"; die(); 
	}
}

?>