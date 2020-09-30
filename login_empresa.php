<?php

require_once "config/conexao.php";

require_once "include/funcoes.php";

require_once "preferencias/preferencias_inc.php";

require_once "licenca/licenca.inc.php";

$erro = '0';

session_start();

$cod_usuario 		= $_SESSION['cod_usuario'];
$EmpresaPrincipal 	= $_SESSION['cod_empresa'];
$cod_tipo_conta 	= $_SESSION['tipo_conta'] ;

if (($cod_tipo_conta == 1) || ($cod_tipo_conta == 1)) 
{
	$EhMaster = true;
} else {
	$EhMaster = false;
}


if (isset($_REQUEST['acao']) && (($_REQUEST['acao'] == "selecionar_empresa") || ($_REQUEST['acao'] == "trocar_empresa")))
{

	/*
	$SituacaoLicencaAtual = ObterSituacaoLicencaAtual($rs['cod_empresa']);

	if ($SituacaoLicencaAtual == "I")
	{
		InativarLicencaAtualEmpresa($cod_empresa);
		echo "<script language='javascript'>window.location='login.php?erro=3';</script>"; die(); 
	}
	*/

	if ($EmpresaPrincipal == 1) 
	{
		if ($_REQUEST['cod_empresa'] != "") 
		{
			
			$cod_empresa = limpa($_REQUEST['cod_empresa']);
	
			//$_SESSION['cod_licenca'] = ObterLicencaAtual($cod_empresa);

			$sql = "
			select 		e.empresa
			from 		empresas e 
			inner join 	grupo_empresas g on g.cod_empresa = e.cod_empresa
			where 		e.cod_empresa = ".$cod_empresa."
			";
			//echo $sql;die;
			$query = mysql_query($sql);
			$rs = mysql_fetch_array($query);
	
			$_SESSION['cod_empresa']	= $cod_empresa;
			$_SESSION['empresa'] 		= $rs['empresa'];
			
		}
		else
		{
			$_SESSION['cod_empresa']	 = "";
			$_SESSION['empresa'] 		 = "";
		}	

		echo "<script language='javascript'>location.href='inicio.php';</script>";die();
	} 
	else
	{
		
		$cod_empresa = limpa($_REQUEST['cod_empresa']);

		$sql = "
		select 		e.empresa
		from 		empresas e 
		inner join 	grupo_empresas g on g.cod_empresa = e.cod_empresa
		where 		e.cod_empresa = ".$cod_empresa."
		";
		//echo $sql;die;
		$query = mysql_query($sql);
		$rs = mysql_fetch_array($query);

		$_SESSION['cod_empresa']	= $cod_empresa;
		$_SESSION['empresa'] 		= $rs['empresa'];
		//$_SESSION['cod_licenca'] 	= ObterLicencaAtual($cod_empresa);

		echo "<script language='javascript'>window.location='inicio.php';</script>";die();

	}	

}


?>
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

    </head>

    <body class="focused-form">
	<?php
	if ($erro == '1') {
	?>
	<div class="alert alert-dismissable alert-danger">
		<i class="fa fa-fw fa-times"></i>&nbsp; <strong>E-mail e/ou senha inválidos!</strong>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	</div>				
	<?php
	}
	
	?>             
<div class="container" id="login-form">
	<a href="" class="login-logo">&nbsp;</a>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="panel panel-default">

				<?php if ($EhMaster) { ?>

				<div class="panel-heading"><h2>Acessar Empresa</h2></div>
								
				<?php } else { ?>

				<div class="panel-heading"><h2>Acessar Filial</h2></div>	

				<?php } ?>

				<div class="panel-body">
					
					<form action="login_empresa.php" class="form-horizontal" id="validate-form" method="post" name="acessar">

						<input type="hidden" name="acao" value="selecionar_empresa">

						<div class="form-group">
	                        <div class="col-md-12">
	                        	<div class="input-group">	

									<span class="input-group-addon">
										<i class="fa fa-building"></i>
									</span>

									<?php 

									if ($EhMaster) 
									{
										$sql = "
										select		e.cod_empresa, e.empresa
										from 		empresas e
										";
									}
									else
									{									
										$sql ="
										select		e.cod_empresa, e.empresa
										from 		empresas e
										inner join 	usuarios_empresas uge on uge.cod_empresa = e.cod_empresa
										inner join 	usuarios u on u.cod_usuario = uge.cod_usuario
										where 		u.cod_usuario = ".$cod_usuario."
										";
									}

									$sql = $sql. "
									group by	e.cod_empresa, e.empresa
									order by 	e.empresa asc;
									";

										//echo $sql; die;

										$query = mysql_query($sql);
										$registros = mysql_num_rows($query);

										echo "<select name='cod_empresa' class='form-control' id='cod_empresa'>";

										if ($EhMaster)
										{
											echo "<option value=''>Master</option>";
										}
										while ($rs = mysql_fetch_array($query)){ 

											echo "<option value='". $rs['cod_empresa'] ."'>";

											if ($_SESSION['usuario_conta']==1){

												echo $rs['empresa'];		

												
											}else{
												echo $rs['empresa'];
											}

											echo "</option>";
										}
										echo "</select>";


									 ?>
								</div>

	                        </div>
						</div>

						<div class="form-group">	
							<div class="col-md-12">
								<div class="input-group" style="margin: 0 auto;">
									<a href="#" onclick="javascript:document.forms['acessar'].submit();" class="btn btn-primary">Acessar</a>
								</div>
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

<?php 
mysql_close();
 ?>