
<?php 

include('funcoes.php');

if ( (isset($_REQUEST['action'])) &&  ($_REQUEST['action'] == "contato")){
	
	$nome 	= limpa($_REQUEST['nome']);
	$email  = limpa($_REQUEST['email']);
	$telefone  = limpa($_REQUEST['telefone']);
	$cod_assunto  = limpa($_REQUEST['assunto']);
	$texto  = limpa($_REQUEST['mensagem']);
	

	switch ($cod_assunto) {

		case '1':
				$assunto = "Dúvidas";
			break;
		
		case '1':
				$assunto = "Elogios";
			break;

		case '1':
				$assunto = "Sugestão";
			break;

		case '1':
				$assunto = "Reclamação";
			break;
		default:
				$assunto = "Dúvidas";
			break;
	}



	$corpo = "<b>Formulário enviado</b><br><br>";
	$corpo .= "<b>Nome:</b> " . $nome . "<br><br>"; 
	$corpo .= "<b>telefone:</b> " . $telefone . "<br><br>"; 
	$corpo .= "<b>Email:</b> " . $email . "<br><br>"; 
	$corpo .= "<b>Assunto:</b> " . $assunto . "<br><br>";
	$corpo .= "<b>Texto:</b> <br>" . $texto . "<br>";

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
	$mailer->FromName = "Contato - ". $nome;          // seu nome
	$mailer->Subject = $assunto;             // assunto da mensagem
	$mailer->MsgHTML($corpo);             // corpo da mensagem
	//$mailer->AddAttachment($arquivo['tmp_name'], $arquivo['name']  );      // anexar arquivo   -   "caso nâ”œÐ³o queira essa opâ”œÐ·â”œÐ³o basta comentar"
	
	if(!$mailer->Send()) {
	   echo "Erro: " . $mailer->ErrorInfo; 
	} else {
	   $enviou = '1';
	}

}


 ?>




<!DOCTYPE html>
<html lang="en" class="coming-soon">
<head>
    <meta charset="utf-8">
    <title>Contato</title>
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
    
	<script type="text/javascript" src="contato.js"></script>

    </head>

    <body class="focused-form">
        
	<?php
	if ($enviou == '1') {
	?>
	<div class="alert alert-dismissable alert-success">
		<i class="fa fa-fw fa-times"></i>&nbsp; <strong>Mensagem enviada com sucesso!</strong>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	</div>				
	<?php
	}
	?>
        
<div class="container" id="registration-form">
	<span class="login-logo" style="margin-top:10px;">&nbsp;</span>
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading"><h2>Entre em contato conosco</h2></div>
				<div class="panel-body">

					<form name="form1" action="contato.php" method="post" class="form-horizontal">

						<input type="hidden" name="action" value="contato">

						<div class="form-group">
							<label for="FullName" class="col-xs-3 control-label">Nome</label>
	                        <div class="col-xs-8">
	                        	<input type="text" class="form-control" name="nome" id="Nome" placeholder="Nome" required>
	                        </div>
	                       
						</div>
						<div class="form-group">
							<label for="Email" class="col-xs-3 control-label">E-mail</label>
	                        <div class="col-xs-8">
	                        	<input type="text" class="form-control" name="email" id="Email" placeholder="E-mail" required>
	                        </div>
						</div>
						<div class="form-group">
							<label for="Email" class="col-xs-3 control-label">Telefone</label>
	                        <div class="col-xs-8">
	                        	<input type="text" class="form-control" name="telefone" id="Email" placeholder="Telefone" required>
	                        </div>
						</div>
						<div class="form-group">
							<label for="Email" class="col-xs-3 control-label">Assunto</label>
	                        <div class="col-xs-8">
	                        	<select class="form-control" name="assunto" id="assunto">
	                        		<option value="0">Qual assunto?</option>
	                        		<option value="1">Dúvidas</option>
	                        		<option value="2">Elogios</option>
	                        		<option value="3">Sugestãos</option>
	                        		<option value="4">Reclamação</option>
	                        	</select>
	                        </div>
						</div>
						<div class="form-group">
							<label for="Email" class="col-xs-3 control-label">Mensagem</label>
	                        <div class="col-xs-8">
	                        	<textarea name="mensagem" class="form-control" style="width:100%; height:100px;"></textarea>
	                        </div>
						</div>
					</form>

					<div class="panel-footer">
						<div class="clearfix">
							<a href="login.php" class="btn btn-default pull-left">Voltar para Login</a>
							<a onclick="EnviarMensagem();" class="btn btn-primary pull-right">Enviar Mensagem</a>
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

<!-- End loading site level scripts -->
    <!-- Load page level scripts-->
    
    <!-- End loading page level scripts-->
    </body>
</html>