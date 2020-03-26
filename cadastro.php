<?php 

	require_once "config/conexao.php";

	require_once "include/funcoes.php";

	require_once "preferencias/preferencias_inc.php";

	require_once "licenca/licenca.inc.php";

	require_once "include/email.php";

	$flgEnviaEmail = "0";
	$erro = '0';

	if (isset($_REQUEST['cod_licenca'])) { $cod_licenca = $_REQUEST['cod_licenca']; } else { $cod_licenca = '';	}
	if (isset($_REQUEST['empresa'])) { $empresa = $_REQUEST['empresa']; } else { $empresa = '';	}
	if (isset($_REQUEST['celular'])) { $celular = $_REQUEST['celular']; } else { $celular = '';	}
	if (isset($_REQUEST['telefone'])) { $telefone = $_REQUEST['telefone']; } else { $telefone = '';	}
	
	if (isset($_REQUEST['nome'])) { $nome = $_REQUEST['nome']; } else { $nome = '';	}
	if (isset($_REQUEST['email'])) { $email = $_REQUEST['email'];
		
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
	 		$erro = '0';
 		} else { 
			$erro = '5';
		}
	} else { 
		$email = '';
	}
	if (isset($_REQUEST['senha'])) { $senha = $_REQUEST['senha']; } else { $senha = '';	}
	if (isset($_REQUEST['senha2'])) { $senha2 = $_REQUEST['senha2']; } else { $senha2 = '';	}
	
	
if ( (isset($_REQUEST['action'])) &&  ($_REQUEST['action'] == "cadastrar"))
{

	if ($email == "")
	{
		$erro = "5";
	}
	else
	{
		
		$nome 	= limpa(trim($nome));
		$email  = limpa(trim($email));
		$senha  = limpa(trim($senha));
		$senha2  = limpa(trim($senha2));
		
		// VERIFICA SE O E-MAIL EXISTE
		$sql = "Select count(*) as existe from usuarios where email='".$email."'";
		//echo $sql;die;
		$query = mysql_query($sql);
		$rs = mysql_fetch_array($query);
		if ($rs['existe'] > 0) {
			$erro = '3';
		} else {
		
			// Verifica se a senha e igual
			if ($senha == $senha2) {	
			
				$sql = "
				select case when count(*) > 0 then 'sim' else 'nao' end as JaExiste 
				from empresas where empresa = '".$empresa."';
				";		
				//echo $sql;die;
				$query = mysql_query($sql);
				$rs = mysql_fetch_array($query);
			
				if($rs["JaExiste"] == "nao"){ //EMPRESA NÃO EXITE		
		
					//INSERINDO O USUÁRIO					
					$senha .= "&D31R#i017$";
					$senha = md5($senha);
					
					$sql = "
					INSERT INTO `usuarios`
					(
					`nome`,
					`email`,
					`senha`,
					`status`)
					VALUES
					('".$nome."',
					'".$email."',
					'".$senha."',
					'A')
					";		
					mysql_query($sql);

					$sql = "Select cod_usuario from usuarios where email='". $email ."' and senha ='".$senha."'";
					//echo $sql;die;
					$query = mysql_query($sql);
					$rs = mysql_fetch_array($query);
					$cod_usuario_cadastro = $rs['cod_usuario'];

					//INSERINDO A EMPRESA
					$situacao = "A";
					$dt_cadastro = date('Y-m-d');

					$sql = "insert into empresas 
					(empresa, telefone, celular, situacao, dt_cadastro, cod_usuario_cadastro) 
					values ('".limpa($empresa)."', '".limpa($telefone)."', '".limpa($celular)."', '".limpa($situacao)."', '".limpa($dt_cadastro)."','".limpa($cod_usuario_cadastro)."');";
					//echo $sql;die;
					mysql_query($sql);
		
					$sql = "select cod_empresa from empresas where empresa = '".limpa($empresa)."';";
					$query = mysql_query($sql);
					$rs1 = mysql_fetch_array($query);
					$cod_empresa = $rs1['cod_empresa'];
		
					//VINCULAR A EMPRESA AO GRUPO
					$sql = "insert into grupo_empresas (cod_empresa) values ('".limpa($cod_empresa)."');";
					mysql_query($sql);
		
					//INSERIR TIPO CONTA
					$descricao_tipoConta = "Administrador";		
					$sql = "insert into tipo_conta (descricao, cod_empresa) values ('".limpa($descricao_tipoConta)."', ".$cod_empresa.")";
					mysql_query($sql);
		
					//retornando Tipo Conta
					$sql = "select cod_tipo_conta from tipo_conta where cod_empresa = '".limpa($cod_empresa)."';";
					$query = mysql_query($sql);
					$rs1 = mysql_fetch_array($query);
					$cod_tipo_conta = $rs1['cod_tipo_conta'];

					//INSERIR usuario na empresa
					$sql = "insert into usuarios_empresas (cod_usuario, cod_empresa) values ('".limpa($cod_usuario_cadastro)."', ".$cod_empresa.")";
					mysql_query($sql);

					//VINCULAR A usuario AO tipo conta
					$sql = "update	 usuarios
							set 	tipo_conta = ".limpa($cod_tipo_conta)."
							where 	cod_usuario = ".limpa($cod_usuario_cadastro).";
							";
					//echo $sql;die;
					mysql_query($sql);

					//CREDENCIAL
					CriarCredencial($cod_licenca, $cod_tipo_conta);


					//PREFERENCIAS
					CriarPreferencias($cod_empresa, $empresa, $telefone, $nome, $email);	
		

					//CRIAR LICENÇA
					LicenciarEmpresa_30Dias($cod_empresa, $cod_licenca);
	

					/******************************************************
					//ENVIANDO E-MAIL
					******************************************************/
					if ($flgEnviaEmail == "1") 
					{
						$assunto = "Novo cliente cadastrado";

						switch ($cod_licenca) {
							case '1':
								$descricao_licenca = "Individual";
								break;
							case '2':
								$descricao_licenca = "Empresa Sem Filial";
								break;
							case '3':
								$descricao_licenca = "Empresa Com Filial";
								break;
						}

						$mensagem = "
						<!DOCTYPE html>
						<html lang='en'>
						<head>
							<meta charset='UTF-8'>
							<meta name='viewport' content='width=device-width, initial-scale=1.0'>
							<meta http-equiv='X-UA-Compatible' content='ie=edge'>
							<title>Company System</title>
							<style>
							#titulo{
									font-size: 14px;
									font-weight: bold;
									font-family: Verdana, Geneva, Tahoma, sans-serif;
								}
								#resposta{
									font-size: 14px;
									font-family: Verdana, Geneva, Tahoma, sans-serif;
								}
							</style>
						</head>
						<body>
							<div style='padding:2px;'>
								<div><img src='http://www.companysystem.net.br/sistema/assets/img/COMPANY_SYSTEM_LOGO.png' style='width:120px;' alt=''></div>
								<div>
									<p id='resposta'>Novo cliente cadastrado!</p>
									<p id='titulo'>Licença</p>
									<p id='resposta'>$descricao_licenca</p>
									<p id='titulo'>Empresa</p>
									<p id='resposta'>$empresa</p>
									<p id='titulo'>Usuário / E-mail</p>
									<p id='resposta'> $nome / $email</p>
									<p id='titulo'>Informações de Contato</p>
									<p id='resposta'>Telefone: $telefone / Celular: $celular</p>
								</div>

							</div>
						</body>
						</html>
						";
			
						$retorno = Email($assunto, $mensagem);	

						$parametros = "?sucesso=1";

						header("Location: login.php".$parametros);
			
					}
					else
					{
						$sucesso = "1";
					}
		
				}else{
					$erro = "2";			
			
				}
			} else { // Senha
				$erro = '4';
			}
		}

	}

}

function CriarCredencial($cod_licenca, $cod_tipo_conta)
{
	$sql = "
	insert into 	tipo_conta_credencial (cod_tipo_conta, cod_credencial)
	select			".$cod_tipo_conta." as cod_tipo_conta, c.cod_credencial
	from			licencas l
	inner join		licenca_permissao lp on lp.cod_licenca = l.cod_licenca
	inner join 		credenciais c on c.cod_permissao = lp.cod_permissao
	where			l.cod_licenca = ".$cod_licenca."
	group by		lp.cod_permissao, c.cod_credencial, c.descricao
	";

	mysql_query($sql);

}


if ($sucesso == '1')
{	echo '
		<script>
			location.href = "login.php?sucesso=2";
		</script>
	';
	die;
}


	//LICENCA SELECIONADA
	$sql = "select descricao from licencas where cod_licenca = '".limpa($cod_licenca)."';";
	$query = mysql_query($sql);
	$rs1 = mysql_fetch_array($query);

	$descricao_licenca = $rs1['descricao'];

 ?>




<!DOCTYPE html>
<html lang="en" class="coming-soon">
<head>
    <meta charset="utf-8">
    <title>Cadastro</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="description" content="">
    <meta name="author" content="KaijuThemes">

    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700' rel='stylesheet' type='text/css'>
    <link type="text/css" href="assets/plugins/iCheck/skins/minimal/blue.css" rel="stylesheet">
    <link type="text/css" href="assets/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link type="text/css" href="assets/css/styles.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholdr.js enables the placeholder attribute -->
    <!--[if lt IE 9]>
        <link type="text/css" href="assets/css/ie8.css" rel="stylesheet">
        <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The following CSS are included as plugins and can be removed if unused-->
    
	<script type="text/javascript" src="cadastro.js"></script>
	
</head>

<body class="focused-form">
        
	<?php 

		if ($enviou == '1') 
		{
		?>

			<div class="alert alert-dismissable alert-success">
				<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Seu cadastro foi realizado com sucesso!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			</div>

		<?php

		}
		else if ($erro == "1")
		{
		?>

			<div class="alert alert-dismissable alert-warning">
				<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Este grupo já existe!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			</div>


		<?php
		}
		else if ($erro == "2")
		{
		?>

			<div class="alert alert-dismissable alert-warning">
				<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Empresa já existe!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			</div>

		<?php
		}
		else if ($erro == "3")
		{
		?>

			<div class="alert alert-dismissable alert-warning">
				<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Este e-mail já está cadastrado.</strong>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			</div>

		<?php		

		} 
		else if ($erro == '4') 
		{

		?>
			<div class="alert alert-dismissable alert-warning">
				<i class="fa fa-fw fa-check"></i>&nbsp; <strong>O campo senha está diferente do confirmar senha!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			</div>
	<?php
		} 
		else if ($erro == '5')
		{
	?>
			<div class="alert alert-dismissable alert-danger">
				<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Erro ao tentar cadastrar.</strong> <br>(Favor inserir os dados corretamente.)
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			</div>

	<?php 
		} 
	?>

<div class="container" id="registration-form">
	
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="panel panel-default" style="margin-top:20px;">
				<div class="panel-heading"><h2>Criar meu cadastro</h2></div>
				<div class="panel-body">

					<form name="form1" action="cadastro.php" method="post" class="form-horizontal">

						<input type="hidden" name="action" value="cadastrar">
						<input type="hidden" name="cod_licenca" value="<?php echo $cod_licenca; ?>">						

						<div class="form-group">
							<label for="Empresa" class="col-xs-4 control-label">Licença:</label>
							<?php 
							if ($cod_licenca != "") 
							{
							?>
								<div class="col-xs-8">
									<label class="control-label"><b><?php echo $descricao_licenca; ?></b></label>
								</div>
							<?php 
							} 
							else 
							{
							?>
							<div class="col-xs-8">
								<?php ComboLicenca(''); ?>
							</div>
							
							<?php
							}
							?>

						</div>

						<div class="form-group">
							<label for="Empresa" class="col-xs-4 control-label">Empresa:</label>
	                        <div class="col-xs-8">
	                        	<input type="text" class="form-control" name="empresa" id="Empresa" placeholder="Empresa" maxlength="200" value="<?php echo $empresa;?>">
	                        </div>
						</div>
						<div class="form-group">
							<label for="Nome" class="col-xs-4 control-label">Administrador:</label>
	                        <div class="col-xs-8">
	                        	<input type="text" class="form-control" name="nome" id="Nome" placeholder="Nome" required value="<?php echo $nome;?>">
	                        </div>
						</div>
						<div class="form-group">
							<label for="telefone" class="col-xs-4 control-label">Telefone:</label>
	                        <div class="col-xs-8">
	                        	<input type="text" class="form-control" name="telefone" id="telefone" placeholder="Telefone" required >
	                        </div>
						</div>
						<div class="form-group">
							<label for="celular" class="col-xs-4 control-label">celular:</label>
	                        <div class="col-xs-8">
	                        	<input type="text" class="form-control" name="celular" id="celular" placeholder="Celular" required>
	                        </div>
						</div>	

						<div class="form-group">
							<label for="Email" class="col-xs-4 control-label">E-mail (Acesso)</label>
	                        <div class="col-xs-8">
	                        	<input type="text" class="form-control" name="email" id="Email" placeholder="Email" required >
	                        </div>
						</div>
						<div class="form-group">
							<label for="Password" class="col-xs-4 control-label">Senha:</label>
	                        <div class="col-xs-8">
	                        	<input type="password" class="form-control" name="senha" id="Password" placeholder="Password" maxlength="20" required>
	                        </div>
						</div>				
						<div class="form-group">
							<label for="Password" class="col-xs-4 control-label">Confirmar Senha:</label>
	                        <div class="col-xs-8">
	                        	<input type="password" class="form-control" name="senha2" id="Password2" placeholder="Password" maxlength="20" required>
	                        </div>
						</div>

						<div class="form-group">
							<div class="col-xs-12" style="text-align:center;">
								<a onclick="Cadastrar();" class="btn btn-primary">Cadastrar</a>
							</div>
						</div>										

					</form>

					<div class="panel-footer">
						<div class="clearfix">
							<a href="login.php" class="btn btn-default pull-left">Voltar para Login</a>
							
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>



	<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script> 							<!-- Load jQuery -->
	<script type="text/javascript" src="assets/js/jqueryui-1.9.2.min.js"></script> 							<!-- Load jQueryUI -->

	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script> 								<!-- Load Bootstrap -->

	<script type="text/javascript" src="js/jquery.mask.min.js"></script>

	<script>
		$(document).ready(function(){
			$('#telefone').mask('(99)99999-9999');
			$('#celular').mask('(99)99999-9999');
		});
	</script>

	</body>

</html>