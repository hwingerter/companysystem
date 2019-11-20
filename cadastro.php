<?php 

	require_once "config/conexao.php";

	require_once "include/funcoes.php";

	require_once "preferencias/preferencias_inc.php";

	require_once "licenca/licenca.inc.php";

	$flgEnviaEmail = "0";
	$erro = '0';

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
	
	
if ( (isset($_REQUEST['action'])) &&  ($_REQUEST['action'] == "cadastrar")){
	
	if ($email == "")
	{
		$erro = "5";
	}
	else
	{

		$cod_licenca = trim(limpa($_REQUEST['cod_licenca']));
		
		$nome 	= limpa($nome);
		$email  = limpa($email);
		$senha  = limpa($senha);
		$senha2  = limpa($senha2);
		
		// VERIFICA SE O E-MAIL EXISTE
		$sql = "Select count(*) as existe from usuarios where email='". $email ."'";
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
					$sql = "insert into usuarios_grupos_empresas (cod_usuario, cod_empresa) values ('".limpa($cod_usuario_cadastro)."', ".$cod_empresa.")";
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
					LicenciarEmpresa($cod_empresa, $cod_licenca);
	

					if ($flgEnviaEmail == "1") 
					{

						/******************************************************
						//ENVIANDO E-MAIL
						******************************************************/
			
						$corpo = "<b>Novo usuário cadastrado! </b><br><br>";
						$corpo .= "<b>Nome:</b> " . $nome . "<br><br>"; 
						$corpo .= "<b>Email:</b> " . $email . "<br><br>"; 
						$corpo .= "<b>Empresa:</b> " . $empresa . "<br><br>";
						$corpo .= "<b>Telefone:</b> " . str_replace("'", "",$telefone) . "<br><br>";
						$corpo .= "<b>Celular:</b> " . str_replace("'","",$celular) . "<br><br>";
						$corpo .= "<b>Licença:</b> " . $descricao_licenca . "<br><br>";
			
						require 'PHPMailerAutoload.php';
						require 'class.phpmailer.php';
			
						$mailer = new PHPMailer;
			
						//$mailer->SMTPDebug = 2;                               
			
						$mailer->isSMTP();                                      // funcao mailer para usar SMTP
			
						$mailer->SMTPOptions = array(
							'ssl' => array(
								'verify_peer' => false,
								'verify_peer_name' => false,
								'allow_self_signed' => true
							)
						);
			
			
						//$mailer->Host = 'plesk12l0016.hospedagemdesites.ws'; // Servidor smtp
						$mailer->Host = 'smtp.companysystem.net.br'; // Servidor smtp
						//Para cPanel: 'mail.dominio.com.br' ou 'localhost';
						//Para Plesk 7 / 8 : 'smtp.dominio.com.br';
						//Para Plesk 11 / 12.5: 'smtp.dominio.com.br' ou host do servidor exemplo : 'pleskXXXX.hospedagemdesites.ws';
			
						$mailer->CharSet = 'UTF-8';
						$mailer->SMTPAuth = true;                                   // Habilita a autenticaâ”œÐ·â”œÐ³o do form
						$mailer->IsSMTP();
						$mailer->isHTML(true);                                      // Formato de email HTML
						$mailer->Port = 587;									    // Porta de conexâ”œÐ³o
			
						$mailer->Username = 'contato@companysystem.net.br';                  // Conta de e-mail que realizarâ”œÐ± o envio
						$mailer->Password = 'F!jht999';                                   // Senha da conta de e-mail - Ja está configurado com a senha e o e-mail correto.
			
						// email do destinatario
						$address = "contato@companysystem.net.br"; // Quando for esqueci minha senha manda para o e-mail do dono da conta. Quando for a pagina de contato manda para contato@companysystem.net.br
			
						$mailer->AddAddress($address);        // email do destinatario
						//$mailer->addCC("hwingerter@gmail.com"); // copia
						$mailer->From = 'contato@companysystem.net.br';             //Obrigatâ”œâ”‚rio ser a mesma caixa postal indicada em "username"
						$mailer->Sender = 'contato@companysystem.net.br';
						$mailer->FromName = $nome;          // seu nome
						$mailer->Subject = "Novo Cadastro";             // assunto da mensagem
						$mailer->MsgHTML($corpo);             // corpo da mensagem
						//$mailer->AddAttachment($arquivo['tmp_name'], $arquivo['name']  );      // anexar arquivo   -   "caso nâ”œÐ³o queira essa opâ”œÐ·â”œÐ³o basta comentar"
			
						if(!$mailer->Send()) {
						echo "Erro: " . $mailer->ErrorInfo; 
						} else {
						$enviou = '1';
						}
			
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


if ($sucesso == '1'){
	echo '
		<script>
			location.href = "login.php?sucesso=2";
		</script>
	';
	die;
}


	$cod_licenca = $_REQUEST['cod_licenca'];

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

		if ($enviou == '1') {
		?>

			<div class="alert alert-dismissable alert-success">
				<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Seu cadastro foi realizado com sucesso!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			</div>

		<?php

		}else if ($erro == "1"){
		?>

			<div class="alert alert-dismissable alert-warning">
				<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Este grupo já existe!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			</div>


		<?php
		}else if ($erro == "2"){
		?>

			<div class="alert alert-dismissable alert-warning">
				<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Empresa já existe!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			</div>

		<?php
		}else if ($erro == "3"){
		?>

			<div class="alert alert-dismissable alert-warning">
				<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Este e-mail já está cadastrado.</strong>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			</div>

		<?php		

		} else if ($erro == '4') {

		?>
			<div class="alert alert-dismissable alert-warning">
				<i class="fa fa-fw fa-check"></i>&nbsp; <strong>O campo senha está diferente do confirmar senha!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			</div>
	<?php
		} else if ($erro == '5') {
	?>
			<div class="alert alert-dismissable alert-danger">
				<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Erro ao tentar cadastrar.</strong> <br>(Favor inserir os dados corretamente.)
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			</div>

	<?php } ?>

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

							<?php if ($cod_licenca != "") 
							{
							?>
								<label for="Empresa" class="col-xs-4 control-label">Licença:</label>
								<div class="col-xs-8"><label class="control-label"><b><?php echo $descricao_licenca; ?></b></label></div>
							<?php 
							} else {
							?>
							<label for="Empresa" class="col-xs-4 control-label">Licença:</label>
							<div class="col-xs-8">
								<?php
									ComboLicenca('');
								}
								?>
							</div>

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

    
    
    <!-- Load site level scripts -->

<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script> -->

<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script> 							<!-- Load jQuery -->
<script type="text/javascript" src="assets/js/jqueryui-1.9.2.min.js"></script> 							<!-- Load jQueryUI -->

<script type="text/javascript" src="assets/js/bootstrap.min.js"></script> 								<!-- Load Bootstrap -->

<script type="text/javascript" src="assets/plugins/easypiechart/jquery.easypiechart.js"></script> 		<!-- EasyPieChart-->
<script type="text/javascript" src="assets/plugins/sparklines/jquery.sparklines.min.js"></script>  		<!-- Sparkline -->
<script type="text/javascript" src="assets/plugins/jstree/dist/jstree.min.js"></script>  				<!-- jsTree -->

<script type="text/javascript" src="assets/plugins/codeprettifier/prettify.js"></script> 				<!-- Code Prettifier  -->
<script type="text/javascript" src="assets/plugins/bootstrap-switch/bootstrap-switch.js"></script> 		<!-- Swith/Toggle Button -->

<script type="text/javascript" src="assets/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js"></script>  <!-- Bootstrap Tabdrop -->

<script type="text/javascript" src="assets/plugins/iCheck/icheck.min.js"></script>     					<!-- iCheck -->

<script type="text/javascript" src="assets/js/enquire.min.js"></script> 									<!-- Enquire for Responsiveness -->

<script type="text/javascript" src="assets/plugins/bootbox/bootbox.js"></script>							<!-- Bootbox -->

<script type="text/javascript" src="assets/plugins/simpleWeather/jquery.simpleWeather.min.js"></script> <!-- Weather plugin-->

<script type="text/javascript" src="assets/plugins/nanoScroller/js/jquery.nanoscroller.min.js"></script> <!-- nano scroller -->

<script type="text/javascript" src="assets/plugins/jquery-mousewheel/jquery.mousewheel.min.js"></script> 	<!-- Mousewheel support needed for jScrollPane -->

<script type="text/javascript" src="assets/js/application.js"></script>
<script type="text/javascript" src="assets/demo/demo.js"></script>
<script type="text/javascript" src="assets/demo/demo-switcher.js"></script>

<script type="text/javascript" src="js/jquery.mask.min.js"></script>

<script>
	$(document).ready(function(){
		$('#telefone').mask('(99) 9999-9999');
		$('#celular').mask('(99) 99999-9999');
	});
</script>

<!-- End loading site level scripts -->
    <!-- Load page level scripts-->
    
    <!-- End loading page level scripts-->
    </body>
</html>