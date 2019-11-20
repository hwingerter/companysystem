<?php
include('conexao.php');

require 'PHPMailerAutoload.php';
require 'class.phpmailer.php';

$existe = '1';

if (isset($_REQUEST["email"])) 
{ 

	$email = $_REQUEST["email"];

	$sql = "SELECT * FROM usuarios where email = '".$email."'";
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		if ($rs = mysql_fetch_array($query)){
			$nome  = $rs['nome'];
			$cod_usuario = $rs['cod_usuario'];
			$existe = 1;
		}
	} else {
		$existe = 0;
	}
	
	if ($existe == 1) {
		
		$assunto = 'Esqueci minha senha';
		$corpo = 'Prezado(a), '. $nome . '.<br><br>';
		$corpo .= "Para gerar uma nova senha clique nesse <a href='http://www.companysystem.net.br/atualizar_senha.php?id=". $cod_usuario ."&email=". $email ."'>Link</a>.<br><br>";
		$corpo .= "Atenciosamente,<br>Equipe Company System.";
		
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
		
		
		$mailer->Host = 'plesk12l0016.hospedagemdesites.ws'; // Servidor smtp
		//Para cPanel: 'mail.dominio.com.br' ou 'localhost';
		//Para Plesk 7 / 8 : 'smtp.dominio.com.br';
		//Para Plesk 11 / 12.5: 'smtp.dominio.com.br' ou host do servidor exemplo : 'pleskXXXX.hospedagemdesites.ws';
		
		$mailer->SMTPAuth = true;                                   // Habilita a autentica├з├гo do form
		$mailer->IsSMTP();
		$mailer->isHTML(true);                                      // Formato de email HTML
		$mailer->Port = 587;									    // Porta de conex├гo
		
		$mailer->Username = 'contato@companysystem.net.br';                  // Conta de e-mail que realizar├б o envio
		$mailer->Password = 'F!jht999';                                   // Senha da conta de e-mail				
		
		// email do destinatario
		$address = $email;
		
		$mailer->AddAddress($address);        // email do destinatario
		//$mailer->addCC("gustavodsg@gmail.com"); // copia
		$mailer->From = 'contato@companysystem.net.br';             //Obrigat├│rio ser a mesma caixa postal indicada em "username"
		$mailer->Sender = 'contato@companysystem.net.br';
		$mailer->FromName = 'Company System';          // seu nome
		$mailer->Subject = $assunto;             // assunto da mensagem
		$mailer->MsgHTML($corpo);             // corpo da mensagem
		//$mailer->AddAttachment($arquivo['tmp_name'], $arquivo['name']  );      // anexar arquivo   -   "caso n├гo queira essa op├з├гo basta comentar"
		
		if(!$mailer->Send()) {
		   echo "Erro: " . $mailer->ErrorInfo; 
		   $sucesso = '0';
		} else {
		   $sucesso = '1';
		   //echo "Mensagem enviada com sucesso!";
		}		
		
		
	}
}

?>

<!DOCTYPE html>
<html lang="en" class="coming-soon">
<head>
    <meta charset="utf-8">
    <title>Esqueceu sua senha?</title>
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
    
    </head>

    <body class="focused-form">
        
	<?php if ($existe == 0){ ?>

		<div class="alert alert-dismissable alert-danger">
			<i class="fa fa-fw fa-times"></i>&nbsp; <strong>E-mail não encontrado!</strong> Verifique novamente o e-mail digitado.
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		</div>	

	<?php }  ?>

	<?php if ($sucesso == '1'){ ?>
		<div class="alert alert-dismissable alert-success">
			<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Mensagem enviada com sucesso!</strong>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		</div>
	<?php }  ?>	       
<div class="container" id="forgotpassword-form">
	<a href="" class="login-logo">&nbsp;</a>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading"><h2>Esqueceu sua senha?</h2></div>
				<div class="panel-body">
					
					<form name="frm" action="esqueci_senha.php" method="post" class="form-horizontal">

						<div class="form-group">
	                        <div class="col-xs-12">
	                        	<p>Digite seu e-mail para resertar sua senha</p>

	                        	<div class="input-group">							
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>
									<input type="text" class="form-control" placeholder="Digite seu E-mail" name="email">
								</div>
	                        </div>
						</div>
						
				
						<div class="panel-footer">
							<div class="clearfix">

								<a href="login.php" class="btn btn-default pull-left">Voltar para Login</a>

								<button class="btn-primary btn pull-right" onclick="javascript:document.forms['frm'].submit();">Enviar</button>

							</div>
						</div>

					</form>
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