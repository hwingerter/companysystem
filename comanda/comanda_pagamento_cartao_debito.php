<?php require_once "../include/topo_interno2.php";

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


	//CLIente
	$sql = "select	nome from clientes where cod_cliente = ".$_REQUEST['cod_cliente'].";";
	$query = mysql_query($sql);
	$rs = mysql_fetch_array($query);
	$nome_cliente = $rs['nome'];

	$cod_cliente 			= $_REQUEST['cod_cliente'];
	$cod_comanda 			= $_REQUEST['cod_comanda'];
	$cod_forma_pagamento	= $_REQUEST['cod_forma_pagamento'];

	$voltar = "?cod_comanda=".$cod_comanda."&cod_cliente=".$cod_cliente."";

	$cod_empresa			= $_SESSION['cod_empresa'];
	$cod_usuario 			= $_SESSION['usuario_id'];
	$cod_caixa				= $_SESSION['cod_caixa'];

	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar	
	
	
	if (isset($_REQUEST['acao'])){

		if($_REQUEST['acao'] == "realizar_pagamento"){

			/************************************************
			//INSERINDO CARTOES DEBITO
			************************************************/
			if (isset($_REQUEST["qtd_cartao_debito"]) && ($_REQUEST["qtd_cartao_debito"] != "0")) { 
			
				$qtd_cartao_debito = $_REQUEST["qtd_cartao_debito"];

				$soma_parcelas = 0;

				for($i=1; $i<=$qtd_cartao_debito; $i++){

					if (isset($_REQUEST["cod_cartao_debito_".$i])) { $cod_cartao_debito = limpa($_REQUEST["cod_cartao_debito_".$i]); } else { $cod_cartao_debito = "NULL"; }
					if (isset($_REQUEST["valor_cartao_debito_".$i])) { $valor = ValorPhpMysql($_REQUEST["valor_cartao_debito_".$i]); } else { $valor = "NULL"; }
				
					$soma_parcelas += $valor;

					$sql = "

					INSERT INTO `comanda_pagamento`
					(`cod_empresa`,
					`cod_cliente`,
					`cod_comanda`,
					`cod_forma_pagamento`,
					`cod_cartao`,
					`valor`,
					`dt_pagamento`,
					`cod_usuario_pagamento`)
					VALUES
					('".$cod_empresa."',
					'".$cod_cliente."',
					'".$cod_comanda."',
					'".$cod_forma_pagamento."',
					'".$cod_cartao_debito."',
					'".$valor."',
					now(),
					'".$cod_usuario."'
					);

					";

					//echo $sql; die;
					mysql_query($sql);

				}

			}

			Comanda_AtualizaSituacao($cod_empresa, $cod_cliente, $cod_comanda, $cod_forma_pagamento);
			
			Comanda_AdicionaTransacaoAoCaixa($cod_empresa, $cod_caixa, $cod_comanda, 'VENDA', 'VENDA', $soma_parcelas, $cod_cliente);

			echo "<script language='javascript'>window.location='comanda_pagamentos.php?sucesso=1&cod_comanda=".$cod_comanda."&cod_cliente=".$cod_cliente."';</script>";die;

		}
		else if($_REQUEST['acao'] == "excluir"){

			$cod_comanda_cartao = $_REQUEST['cod_comanda_cartao'];

			$sql = "delete from comanda_pagamento_cartao_debito where cod_comanda_cartao = ".$cod_comanda_cartao."";

			//echo $sql; die;

			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='comanda_pagamentos.php?sucesso=1&cod_comanda=".$cod_comanda."&cod_cliente=".$cod_cliente."';</script>";die;

		}


	}


/************************
 * calculos 
 ***********************/
$total 		= TotalComanda($cod_empresa, $cod_cliente, $cod_comanda);
$desconto	= Comanda_Desconto($cod_empresa, $cod_cliente, $cod_comanda);
$recebido	= TotalPago($cod_empresa, $cod_cliente, $cod_comanda);

if($total > $recebido){
	$falta = number_format((($total - $desconto) - $recebido), 2);

}else if($total == $recebido){
	$falta = "0.00";

}else if($total < $recebido){
	$falta = "0.00";
	$troco = number_format(($recebido - $total), 2);
	
}else{
	$falta = "0.00";
}

/************************
 * apresentação
 ***********************/
$total 		= "R$ ".ValorMysqlPhp($total);
$recebido	= "R$ ".ValorMysqlPhp($recebido);
$desconto	= "R$ ".ValorMysqlPhp($desconto);
$falta		= "R$ ".ValorMysqlPhp($falta);

?>

		<script language="javascript" src="js/comanda.js"></script>
		<script language="javascript" src="../js/mascaramoeda.js"></script>

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
                                

								<div data-widget-group="group1">

										<div class="panel panel-default" data-widget='{"draggable": "false"}'>
											<div class="panel-heading">
												<h2>Recebimento</h2>
											</div>
											<div class="panel-body">

												<form action="comanda_pagamento_cartao_debito.php" class="form-horizontal row-border" name='frm' method="post">

									              <input type="hidden" name="acao" value="realizar_pagamento">
									              <input type="hidden" name="cod_comanda" value="<?php echo $cod_comanda; ?>">
									              <input type="hidden" name="cod_cliente" value="<?php echo $cod_cliente; ?>">
												  <input type="hidden" name="cod_forma_pagamento" value="<?php echo $cod_forma_pagamento; ?>">

													<div class="form-group">
														<label class="col-sm-2 control-label"><b>Cliente</b></label>
														<div class="col-sm-8"><?php echo $nome_cliente; ?></div>
													</div>

													<div class="form-group">
														<label class="col-sm-2 control-label"><b>Total</b></label>
														<div class="col-sm-8"><?php echo $total; ?></div>
													</div>

													<div class="form-group">
														<label class="col-sm-2 control-label"><b>Desconto</b></label>
														<div class="col-sm-8"><?php echo $desconto; ?></div>
													</div>

													<div class="form-group">
														<label class="col-sm-2 control-label"><b>Total a Receber</b></label>
														<div class="col-sm-8"><?php echo $falta; ?></div>
													</div>

													<div class="form-group">

														<p class="mb20" style="border-bottom:1px solid black;">Cartão de Débito</p>

														<div class="col-sm-4 col-sm-offset-1">
															<label class="col-sm-2 control-label"><b>Cartões</b></label>
															<div class="col-sm-8">
															<select name='qtd_cartao_debito' class="form-control col-sm-offset-1" style="width: 100px;" onChange="javascript:AbrirPagamentoCartaoDebito(this.value);">
															  	<?php for ($i=1; $i<=12; $i++) {?>
																<option value="<?php echo $i; ?>" <?php if ($parcelas == $i) { echo " Selected"; }?>><?php echo $i;?></option>
																<?php
																	  }
																?>
															</select>
															</div>
														</div>

													</div>

													<?php 

													//NUMERO DE CART�ES DE DEBITO

													for ($i=1; $i<=12; $i++) { 

														if($i > 1){
															$ocultar = " style='display:none;' ";
														}

														?>

														<div id="cartao_debito_<?php echo $i;?>" <?php echo $ocultar; ?> >

															<div class="form-group">
																<label class="col-md-3 col-sm-offset-1 control-label"><b><?php echo $i; ?>a Cartao</b></label>
															</div>

															<div class="form-group">
																<label class="col-sm-2 control-label"><b>Bandeira</b></label>
																<div class="col-sm-8">
																	<?php comboCartaoDebito($cod_empresa, $i, ''); ?>
																</div>
															</div>

															<div class="form-group">
																<label class="col-sm-2 control-label"><b>Valor(R$)</b></label>
																<div class="col-sm-8">
																	<input type="text" class="form-control" value="" name="valor_cartao_debito_<?php echo $i;?>" id="valor_cartao_debito_<?php echo $i;?>" maxlength="100"
																	onKeyPress="return(moeda(this,'.',',',event));" >
																</div>
															</div>

														</div>

													<?php } ?>

												</form>

												<div class="panel-footer">
													<div class="row">
														<div class="col-sm-8 col-sm-offset-2">
															<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Realizar Pagamento</button>
															<button class="btn-default btn" onclick="javascript:window.location='comanda_forma_pagamento.php<?php echo $voltar; ?>';">Voltar</button>
														</div>
													</div>
												</div>

											</div>
										</div>



                            </div> <!-- .container-fluid -->
					
	
<?php 
}


include('../include/rodape_interno2.php');?>