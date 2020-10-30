<?php

require_once "config/conexao.php";

require_once "include/funcoes.php";

require_once "include/email.php";

$existe = '1';

if (isset($_REQUEST["email"])) 
{ 

	$email = trim($_REQUEST["email"]);

	$sql = "select cod_usuario, nome from usuarios where email = '".$email."'";
	//echo $sql;die;
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
						<p id='resposta'>Prezado(a), $nome</p>
						<p id='resposta'>Para gerar uma nova senha, <a href='http://www.companysystem.net.br/sistema/atualizar_senha.php?id=$cod_usuario&email=$email'>Clique Aqui</a>.</p>
						<p id='resposta'>Caso não tenha solicitado este procedimento, pedimos que descarte.</p>
						<p id='resposta'>Atenciosamente,<br>Equipe Company System.</p>
					</div>
				</div>
			</body>
			</html>
		";

		$retorno = EmailEsqueciMinhaSenha($email, $assunto, $mensagem);	

		$parametros = "?sucesso=4";

		header("Location: login.php".$parametros);

		$sucesso = 1;		
		
	}
}

if(isset($conexao)) 
{   
    mysql_close($conexao);
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
		<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="assets/js/jquery.validate.js"></script>
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
                <div class="col-md-4 col-md-offset-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2>Esqueceu sua senha?</h2>
                        </div>
                        <div class="panel-body">
						<form class="form-horizontal" id="frm" action="esqueci_senha.php" method="post">
						<div class="form-group">
							<div class="col-sm-3">
								<label for="empresa" class="control-label">E-mail:</label>
							</div>
	                        <div class="col-sm-12">
	                        	<input type="text" class="form-control" name="email" id="email" maxlength="100">
	                        </div>
						</div>
						<div class="panel-footer">
							<div class="clearfix">
								<input type="submit" class="btn btn-primary" name="Entrar" value="Resetar minha senha">
								<a href="login.php" class="btn btn-default pull-right">Voltar</a>
							</div>
						</div>

					</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

		<script type="text/javascript">

			$.validator.setDefaults({
				submitHandler: function(form) {
					form.submit();
					return false;
				}
			});

			$( document ).ready( function () {

				$( "#frm" ).validate( {
					rules: {
						email: {
							required: true,
							minlength: 5,
							email: true
						},
					},
					messages: {
						email: "Favor preencher um e-mail válido!"
					},
					errorElement: "em",
					errorPlacement: function ( error, element ) {
					// Add the `help-block` class to the error element
					error.addClass( "help-block" );
					error.insertAfter( element );
					},
					success: function ( label, element ) {
						// Add the span element, if doesn't exists, and apply the icon classes to it.
						//if ( !$( element ).next( "span" )[ 0 ] ) {
							//error.insertAfter( element );
						//}
					},
					highlight: function ( element, errorClass, validClass ) {
						$( element ).parents( ".form-group" ).addClass( "has-error" ).removeClass( "has-success" );
					},
					unhighlight: function ( element, errorClass, validClass ) {
						$( element ).parents( ".form-group" ).addClass( "has-success" ).removeClass( "has-error" );
					}
				} );
			} );
			</script>	


    </body>
</html>