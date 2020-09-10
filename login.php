<!DOCTYPE html>
<html lang="en" class="coming-soon">
<head>
<meta charset="utf-8">
<title>Company System</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">
<meta name="description" content="">
<meta name="author" content="">

<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700' rel='stylesheet' type='text/css'>
<link type="text/css" href="assets/plugins/iCheck/skins/minimal/blue.css" rel="stylesheet">
<link type="text/css" href="assets/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<link type="text/css" href="assets/css/styles.css" rel="stylesheet">
<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script> 							<!-- Load jQuery -->
<script type="text/javascript" src="assets/js/jquery.validate.js"></script>
</head>

<?php
$sucesso = $_REQUEST['sucesso'];
$erro = $_REQUEST['erro'];
?>

    <body class="focused-form">
	<?php
	if ($erro == '1') {
	?>
	<div class="alert alert-dismissable alert-danger">
		<i class="fa fa-fw fa-times"></i>&nbsp; <strong>E-mail e/ou senha inválidos!</strong>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	</div>				
	<?php
	} else if ($erro == '2') {
	?>   
	<div class="alert alert-dismissable alert-danger">
		<i class="fa fa-fw fa-times"></i>&nbsp; <strong>Seu acesso está bloqueado!</strong>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	</div>				
	<?php
	} else if ($erro == '3') {
		?>   
		<div class="alert alert-dismissable alert-danger">
			<i class="fa fa-fw fa-times"></i>&nbsp; <strong>Licença foi inativada!<br>Regularize sua licença junto ao administrador.</strong>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		</div>				
		<?php
	}
	if ($sucesso == '2') {
	?>
	<div class="alert alert-dismissable alert-success">
		<i class="fa fa-fw fa-times"></i>&nbsp; <strong>Cadastro realizado com sucesso!</strong>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	</div>				
	<?php
	}	

	if ($sucesso == '3') {
	?>
	<div class="alert alert-dismissable alert-success">
		<i class="fa fa-fw fa-times"></i>&nbsp; <strong>Senha atualizada com sucesso!</strong>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	</div>				
	<?php
	}

	if ($sucesso == '4') {
		?>
		<div class="alert alert-dismissable alert-success">
			<i class="fa fa-fw fa-times"></i>&nbsp; <strong>Uma mensagem foi enviada para o seu e-mail!</strong>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		</div>				
		<?php
		}

	?>


<div class="container" id="login-form">
	<a href="index.php" class="login-logo"><img src="assets/img/COMPANY_SYSTEM_LOGO.png" style="width:250px;"></a>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading" ><h2>Administrador</h2></div>
				<div class="panel-body">
					
					<form action="usuarios/validar_acesso.php" class="form-horizontal" id="validate-form" method="post" name="acessar">
						<div class="form-group">
	                        <div class="col-xs-12">
	                        	<div class="input-group">							
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>
									<input type="text" class="form-control" placeholder="E-mail" data-parsley-minlength="6" maxlength="50" title="Preenche o e-mail" name="login" id="login" required>
								</div>
	                        </div>
						</div>
						<div class="form-group">
	                        <div class="col-xs-12">
	                        	<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-key"></i>
									</span>
									<input type="password" class="form-control" id="senha" placeholder="Senha" maxlength="10" name="senha" required>
								</div>
	                        </div>
						</div>

						<div class="form-group">
							<div class="col-xs-12">
								<a href="esqueci_senha.php" class="pull-left">Esqueçeu sua senha?</a>
								<a href="contato.php" class="pull-right">Entre em contato</a>
							</div>
						</div>

						<div class="panel-footer">
							<div class="clearfix">
								<input type="submit" class="btn btn-primary" name="signup1" value="Entrar">
								<a href="cadastro.php" class="btn btn-default pull-right">Cadastre-se aqui</a>
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
	
		$( "#validate-form" ).validate( {
			rules: {
				login: "required",
				login: {
					required: true,
					minlength: 5,
					email: true
				
				},
				senha: "required",
				senha: {
					required: true,
					minlength: 3
				}
			},
			messages: {
				//login: "Insira o e-mail"
			},
			errorElement: "em",
			errorPlacement: function ( error, element ) {

				element.parents( ".col-sm-5" ).addClass( "has-feedback" );

			},
			success: function ( label, element ) {
				// Add the span element, if doesn't exists, and apply the icon classes to it.
				if ( !$( element ).next( "span" )[ 0 ] ) {
					//console.log("entrei4 ")
					//$?/( "<span class='glyphicon glyphicon-ok form-control-feedback'></span>" ).insertAfter( $( element ) );
				}
			},
			highlight: function ( element, errorClass, validClass ) {
				$( element ).parents( ".input-group" ).addClass( "has-error" ).removeClass( "has-success" );
			},
			unhighlight: function ( element, errorClass, validClass ) {
				$( element ).parents( ".input-group" ).addClass( "has-success" ).removeClass( "has-error" );
			}
		} );
	} );
</script>
    
    <!-- Load site level scripts -->

<script type="text/javascript" src="assets/js/jqueryui-1.9.2.min.js"></script> 							<!-- Load jQueryUI -->
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script> 								<!-- Load Bootstrap -->

    </body>
</html>