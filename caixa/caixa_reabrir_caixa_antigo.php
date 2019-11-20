<?php 

require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";

	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	if ($_SESSION['usuario_conta'] == '1') {
		
		$credencial_ver = 1;
		$credencial_incluir = 1;
		$credencial_editar = 1;
		$credencial_excluir = 1;
		
	}
	
	$credencial_ver = 1;
	$credencial_incluir = 1;
	$credencial_editar = 1;
	$credencial_excluir = 1;


	$cod_empresa			= $_SESSION['cod_empresa'];
	$cod_usuario_pagamento 	= $_SESSION['usuario_id'];

	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar	
	
	
	if (isset($_REQUEST['acao'])){

		if($_REQUEST['acao'] == "reabrir_caixa_antigo"){

			if (isset($_REQUEST["cod_caixa_antigo"]) && ($_REQUEST["cod_caixa_antigo"] != "")) { $cod_caixa_antigo = $_REQUEST["cod_caixa_antigo"]; }

			$sql = "
			update caixa set situacao = 1 where cod_empresa = ".$cod_empresa." and cod_caixa = ".$cod_caixa_antigo." 
			";
			//echo $sql;die;
			mysql_query($sql);

			$_SESSION["cod_caixa"] = $cod_caixa_antigo;

			echo "<script language='javascript'>window.location='caixa_gaveta_caixa.php?sucesso=4';</script>";die;			

		}

	}

	$cod_caixa = $_SESSION["cod_caixa"];




?>

		<script language="javascript" src="js/caixa.js"></script>

		<div class="static-content-wrapper">
            <div class="static-content">
                <div class="page-content">
					<ol class="breadcrumb">
						<li><a href="#">Principal</a></li>
						<li class="active"><a href="grupo_produtos.php">Gaveta do Caixa</a></li>
						</ol>
                    <div class="page-heading">            
                        <h1>Caixa</h1>
                        <div class="options"></div>
                    </div>
                    <div class="container-fluid">
                        

						<div data-widget-group="group1">

								<div class="panel panel-default" data-widget='{"draggable": "false"}'>
									<div class="panel-heading">
										<h2>Reabrir Caixa Antigo</h2>
									</div>
									<div class="panel-body">

										<form action="caixa_reabrir_caixa_antigo.php" class="form-horizontal row-border" name='frm' method="post">

							              <input type="hidden" name="acao" value="reabrir_caixa_antigo">

											<div class="form-group">
												<label class="col-sm-4 control-label"><b>Mostrar apenas os últimos 10 caixas.</b></label>
												<input type="radio" name="ultimos" id="ultimos" Onclick="Javascript:Ultimos10('<?php echo $cod_empresa; ?>');">
											</div>

											<div class="form-group">
												<label class="col-sm-4 control-label"><b>Selecine o caixa que deseja reabrir</b></label>
												<div class="col-sm-3" id="divAjax">
												  <?php ComboReabrirCaixaAntigo($cod_empresa, $cod_caixa); ?>
												</div>
											</div>

										</form>

										<div class="panel-footer">
											<div class="row">
												<div class="col-sm-8 col-sm-offset-2">
													<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Abrir Caixa</button>
													<button class="btn-default btn" onclick="javascript:window.location='caixa_gaveta_caixa.php<?php echo $voltar; ?>';">Voltar</button>
												</div>
											</div>
										</div>

									</div>
								</div>
                    	</div>
                    	
                    </div> <!-- .container-fluid -->
					
	
<?php 
}


include('../include/rodape_interno2.php');?>