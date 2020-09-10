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
 	<script type="text/javascript">
		document.onkeyup=function(e){
			if(e.which == 13) {
				document.acessar.submit();
			}
		}
	</script>

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
									<input type="text" class="form-control" placeholder="Email Username" data-parsley-minlength="6" placeholder="At least 6 characters" required>
								</div>
	                        </div>
						</div>

						<div class="form-group">
	                        <div class="col-xs-12">
	                        	<div class="input-group">							
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>
									<input type="text" class="form-control" placeholder="E-mail" data-parsley-minlength="6" maxlength="50" 
									title="Preenche o e-mail"
									name="login" id="login">
								</div>
	                        </div>
						</div>
						<div class="form-group">
	                        <div class="col-xs-12">
	                        	<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-key"></i>
									</span>
									<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Senha" maxlength="10" name="senha">
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
								<!-- <a href="#" onclick="javascript:document.forms['acessar'].submit();" class="btn btn-primary pull-left">Entrar</a> -->
								<button type="submit" class="btn btn-primary" name="signup1" value="Sign up">Entrar</button>
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
	$.validator.setDefaults( {
		submitHandler: function () {
			alert( "submitted!" );
		}
	} );

	$( document ).ready( function () {

		$( "#validate-form" ).validate( {
			rules: {
				login: "required",
				login: {
					required: true,
					minlength: 2
				}
			},
			messages: {
				login: "Insira o e-mail"
			},
			errorElement: "em",
			errorPlacement: function ( error, element ) {
					// Add the `help-block` class to the error element
					//error.addClass( "has-error" );

					// Add `has-feedback` class to the parent div.form-group
					// in order to add icons to inputs
					element.parents( ".col-sm-5" ).addClass( "has-feedback" );

					if ( element.prop( "type" ) === "checkbox" ) {
						//error.insertAfter( element.parent( "label" ) );
					} else {
						//error.insertAfter( element );
						//element.attr("value", "Type your answer here");
					}

					// Add the span element, if doesn't exists, and apply the icon classes to it.
					if ( !element.next( "span" )[ 0 ] ) {
						//$( "<span class='glyphicon glyphicon-remove form-control-feedback'></span>" ).insertAfter( element );
					}
				}/*,
				success: function ( label, element ) {
					// Add the span element, if doesn't exists, and apply the icon classes to it.
					if ( !$( element ).next( "span" )[ 0 ] ) {
						console.log("entrei4 ")
						$( "<span class='glyphicon glyphicon-ok form-control-feedback'></span>" ).insertAfter( $( element ) );
					}
				}*/,
				highlight: function ( element, errorClass, validClass ) {
					$( element ).parents( ".input-group" ).addClass( "has-error" ).removeClass( "has-success" );
					//$( element ).next( "span" ).addClass( "glyphicon-remove" ).removeClass( "glyphicon-ok" );
				},
				unhighlight: function ( element, errorClass, validClass ) {
					$( element ).parents( ".input-group" ).addClass( "has-success" ).removeClass( "has-error" );
					//$( element ).next( "span" ).addClass( "glyphicon-ok" ).removeClass( "glyphicon-remove" );
				}
		} );
	} );
</script>
    
    <!-- Load site level scripts -->

<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script> -->


    <!-- Load site level scripts -->

<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script> -->

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