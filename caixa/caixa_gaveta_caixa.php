<?php 

	require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";


	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	
	
	
	
	
	$credencial_ver = 1;
	$credencial_incluir = 1;
	$credencial_editar = 1;
	$credencial_excluir = 1;
	
if (isset($_REQUEST['sucesso'])) { $sucesso = $_REQUEST['sucesso']; } else { $sucesso = ''; }

if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar
	
	$acao = '';

	$cod_empresa = $_SESSION['cod_empresa'];
	$cod_usuario_inclusao = $_SESSION['usuario_id'];	
	$cod_caixa = $_SESSION['cod_caixa'];

	if (isset($_REQUEST['acao'])){
		
		if ($_REQUEST['acao'] == "abrir_ultimo_caixa"){
			
			//retorna a comanda criada
			$sql = "
			select		c1.cod_caixa as ultimo_caixa
						,date_format(c1.dt_abertura,'%d/%m/%Y %H:%i:%s') as dt_abertura
			from 		caixa c1
			where 		c1.cod_empresa = ".$cod_empresa."
			order by 	c1.cod_caixa desc
			limit 		1;
			";
			
			$query = mysql_query($sql);

			$rs = mysql_fetch_array($query);

			$_SESSION["cod_caixa"] 		= $rs['ultimo_caixa'];
			$_SESSION["dt_abertura"] 	= $rs['dt_abertura'];

			$sql = "update caixa set situacao = 1 where cod_caixa = ".$rs['ultimo_caixa']." and cod_empresa = ".$cod_empresa." ";

			mysql_query($sql);

			echo "<script language='javascript'>window.location='caixa_gaveta_caixa.php?sucesso=3';</script>"; die;
			
		}else if ($_REQUEST['acao'] == "fechar_caixa"){

			$cod_caixa = $_REQUEST['cod_caixa'];
			
			$sql = "update caixa set situacao = 2 where cod_empresa = ".$cod_empresa." ";
			mysql_query($sql);

			unset($_SESSION["cod_caixa"]);
			
			echo "<script language='javascript'>window.location='caixa_gaveta_caixa.php?sucesso=2';</script>"; die;
		
		}
		
	}

	if(isset($cod_caixa) && ($cod_caixa != ""))
	{
		$sql = "
		select		DATE_FORMAT(dt_abertura, '%d/%m/%Y %H:%i:%s') as dt_abertura, cod_caixa
		from		caixa
		where 		cod_caixa = ".$cod_caixa."
		";

		//echo $sql;die;

		$query = mysql_query($sql);
		$registros = mysql_num_rows($query);
		$rs = mysql_fetch_array($query);
		if ($registros > 0) {
			$situacao = 1; //aberta
			$dt_abertura = $rs["dt_abertura"];
			$cod_caixa = $rs["cod_caixa"];
		}else{
			$situacao = 2; //fechada
		}

	}else{
		$situacao = 2; //fechada
	}
		
}

?>

		<script language="javascript" src="js/caixa.js"></script>

			<div class="static-content-wrapper">
                <div class="static-content">
                    <div class="page-content">
                        <ol class="breadcrumb">
                            
							<li><a href="#">Principal</a></li>
							<li class="active"><a href="grupo_produtos.php">Gaveta do Caixa</a></li>

                        </ol>
                        <div class="container-fluid">            
							
							<?php
							if ($sucesso == '1') {
							?>
							<div class="alert alert-dismissable alert-success">
								<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Caixa aberto com sucesso!</strong>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							</div>
							<?php
							
							}elseif ($sucesso == '2') {
							?>
							<div class="alert alert-dismissable alert-success">
								<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Caixa fechado!</strong>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							</div>
							<?php
							}elseif ($sucesso == '3') {
							?>
							<div class="alert alert-dismissable alert-success">
								<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Último caixa aberto com sucesso!</strong>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							</div>
							<?php
							}elseif ($sucesso == '4') {
							?>
							<div class="alert alert-dismissable alert-success">
								<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Caixa antigo reaberto com sucesso!</strong>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							</div>
							<?php 
							}elseif ($sucesso == '5') {
							?>
							<div class="alert alert-dismissable alert-success">
								<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Sangria realizada com sucesso!</strong>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							</div>
							<?php 
							}elseif ($sucesso == '6') {
							?>
							<div class="alert alert-dismissable alert-success">
								<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Reforço realizado com sucesso!</strong>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							</div>
							<?php 
							}elseif ($sucesso == '7') {
							?>
							<div class="alert alert-dismissable alert-success">
								<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Vale emitido com sucesso!</strong>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							</div>
							<?php 
							}

							 ?>
							<div data-widget-group="group1">

								<div class="panel panel-default" data-widget='{"draggable": "false"}'>
									<div class="panel-heading">
										<h2>Gaveta do Caixa</h2>
									</div>
									<div class="panel-body">

										<?php 
										if($situacao == 1){ ?>

											<form class="form-horizontal row-border" name='frm' method="post">
										
												<input type="hidden" name="cod_caixa" id="cod_caixa" value="<?php echo $cod_caixa; ?>" >

												<div class="form-group">
													<label class="col-sm-3 control-label"><b>(Aberta em <?php echo $dt_abertura; ?>)</b></label>
												</div>

												<div class="form-group">
												<label class="col-sm-2 control-label"><b>Selecione uma opção</b></label>
													<div class="col-sm-2">
														<?php comboGavetaCaixaAberto(); ?>
													</div>
													<div class="col-sm-1">
														<button type="button" class="btn-success btn" onclick="CaixaAberto();">Selecionar</button>
													</div>
												</div>

											</form>

										<?php

										}elseif($situacao == 2){ ?>

											<form class="form-horizontal row-border" name='frm' method="post">
											
												<div class="form-group">
													<label class="col-sm-3 control-label"><b>O caixa está fechado</b></label>
												</div>

												<div class="form-group">
													<label class="col-sm-2 control-label"><b>Selecione uma opção</b></label>
													<div class="col-sm-2">
														<?php 
														comboGavetaCaixaFechado(); 
														?>
													</div>
													<div class="col-sm-2">
														<button type="button" class="btn-success btn" onclick="CaixaFechado();">Selecionar</button>
													</div>
												</div>

											</form>

									<?php } ?>
	
										</div>

								</div>



							



	</div> <!-- .container-fluid -->

<?php 



include('../include/rodape_interno2.php');
?>