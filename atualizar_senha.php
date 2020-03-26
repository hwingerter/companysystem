<?php

require_once "config/conexao.php";

require_once "include/funcoes.php";

	
if (isset($_REQUEST["email"])) 
{ 

	$email = $_REQUEST["email"];
	$id = $_REQUEST["id"];

	$sql = "SELECT * FROM usuarios where email = '".$email."' and cod_usuario = ".$id;
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
    <title>Atualizar Senha</title>
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
			<i class="fa fa-fw fa-times"></i>&nbsp; <strong>Dados não encontrado!</strong> Use a ferramenta de Esqueci minha senha.
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		</div>	

	<?php 
		die;
	}  ?>
	
<div class="container" id="forgotpassword-form">
	<a href="" class="login-logo">&nbsp;</a>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading"><h2>Atualizar Senha</h2></div>
				<div class="panel-body">
					
					<form name="frm" action="esqueci_senha_email.php" method="post" class="form-horizontal">

						<input type="hidden" name="email" value="<?php echo $email; ?>">

						<div class="form-group">
	                        <div class="col-xs-12">
	                        	<p>Nova Senha</p>

	                        	<div class="input-group">							
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>
									<input type="password" class="form-control" placeholder="Nova Senha" name="nova_senha">
								</div>
	                        </div>
						</div>

						<div class="form-group">
	                        <div class="col-xs-12">
	                        	<p>Confirme Nova Senha</p>

	                        	<div class="input-group">							
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>
									<input type="password" class="form-control" placeholder="Confirme Nova Senha" name="confirme_nova_senha">
								</div>
	                        </div>
						</div>
						
				
						<div class="panel-footer">
							<div class="clearfix">

								<a href="login.php" class="btn btn-default pull-left">Voltar para Login</a>

								<button class="btn-primary btn pull-right" onclick="javascript:document.forms['frm'].submit();">Salvar</button>

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