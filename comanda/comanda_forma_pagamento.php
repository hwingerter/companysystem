<?php require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";

	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	$credencial_ver = 1;
	$credencial_incluir = 1;
	$credencial_editar = 1;
	$credencial_excluir = 1;
	
	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar
	
	$nome 			= $_REQUEST["nome"];
	$cod_comanda 	= $_REQUEST['cod_comanda'];
	$cod_cliente 	= $_REQUEST['cod_cliente'];
	$flg_divida 	= $_REQUEST['flg_divida'];
	$voltar 		= $_REQUEST['voltar'];

	$voltar2 		= "comanda_forma_pagamento.php?flg_divida=".$flg_divida."&cod_comanda=".$cod_comanda."&cod_cliente=".$cod_cliente."&voltar=".urldecode($voltar);
?>

	<script language="javascript" src="js/comanda.js"></script>

	<div class="static-content-wrapper">
	    <div class="static-content">
	        <div class="page-content">

	            <ol class="breadcrumb">	                
					<li><a href="#">Principal</a></li>
					<li class="active"><a href="comanda.php">Comandas</a></li>
	            </ol>
	            
	            <div class="page-heading">            
	                <h1>Recebimento</h1>
	                <div class="options"></div>
	            </div>

	            <div class="container-fluid">
					<div class="panel panel-default" data-widget='{"draggable": "false"}'>
						<div class="panel-heading">
							<h2>Pagamento</h2>
						</div>
						<div class="panel-body">

							<form action="grupo_produto_info.php" class="form-horizontal row-border" name='frm' method="post">

								<input type="hidden" name="cod_comanda" id="cod_comanda" value="<?php echo $cod_comanda; ?>">
								<input type="hidden" name="cod_cliente" id="cod_cliente" value="<?php echo $cod_cliente; ?>">
								<input type="hidden" name="flg_divida" id="flg_divida" value="<?php echo $flg_divida; ?>">
								<input type="hidden" name="voltar" id="voltar" value="<?php echo urlencode($voltar2); ?>">

								<div class="form-group">
									<label class="col-sm-3 control-label"><b>Selecione forma de pagamento</b></label>
									<div class="col-sm-3">
									<?php
										ComboFormaPagamento();
									?>					
									</div>
								</div>

							</form>
							<div class="panel-footer">
								<div class="row">
									<div class="col-sm-8 col-sm-offset-2">
										<button class="btn-primary btn" onclick="javascript:SelecionarFormaPagamento();">Avançar</button>
										<button class="btn-default btn" onclick="javascript:window.location='comanda_pagamentos.php?flg_divida=<?php echo $flg_divida;?>&cod_comanda=<?php echo $cod_comanda;?>&cod_cliente=<?php echo $cod_cliente;?>&voltar=<?php echo urlencode($voltar); ?>';">Voltar</button>
									</div>
								</div>
							</div>
						</div>
					</div>
	            </div> <!-- .container-fluid -->



<?php 
} // INCLUIR OU EDITAR
include('../include/rodape_interno2.php');?>