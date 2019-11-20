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

	$cod_empresa			= $_SESSION['cod_empresa'];
	$cod_usuario_pagamento 	= $_SESSION['usuario_id'];

	$voltar = "?cod_comanda=".$cod_comanda."&cod_cliente=".$cod_cliente."";

	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar	
	
	
	if (isset($_REQUEST['acao'])){

		if($_REQUEST['acao'] == "realizar_pagamento"){

			if (isset($_REQUEST["valor_gorjeta"]) && ($_REQUEST["valor_gorjeta"] != "")) { $valor = ValorPhpMysql($_REQUEST["valor_gorjeta"]); } else { $valor = 'NULL'; }

			foreach ($_POST['cod_profissional'] as $cod_profissional)
			{
				$sql = "
				INSERT INTO `comanda_pagamento`
				(`cod_comanda`,
				`cod_cliente`,
				`cod_empresa`,
				`cod_forma_pagamento`,
				`valor`,
				`cod_profissional_gorjeta`,
				`dt_pagamento`,
				`cod_usuario_pagamento`
				)
				VALUES
				(".$cod_comanda.",
				".$cod_cliente.",
				".$cod_empresa.",
				'".$cod_forma_pagamento."',
				".$valor.",
				".$cod_profissional.",
				now(),
				".$cod_usuario_pagamento.");
				";
	
				//echo $sql; die;
	
				mysql_query($sql);
			}			

			Comanda_AtualizaSituacao($cod_empresa, $cod_cliente, $cod_comanda, $cod_forma_pagamento);
			
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
												<h2>Gorjetas</h2>
											</div>
											<div class="panel-body">

												<form action="comanda_pagamento_gorjeta.php" class="form-horizontal row-border" name='frm' method="post">

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
														<label class="col-sm-2 control-label"><b>Troco</b></label>
														<div class="col-sm-8"><?php echo "R$ ".ValorMysqlPhp($troco); ?></div>
													</div>

													<?php 
													//lista de profissionais da empresa
													
													$sql = "
													select		p.nome, p.cod_profissional
																,(
																select 	count(*)
																from 	comanda_item ci
																where 	ci.cod_empresa = p.cod_empresa
																and 	ci.cod_cliente = ".$cod_cliente."
																and 	ci.cod_comanda = ".$cod_comanda."
																and 	ci.cod_profissional = p.cod_profissional
																) as trabalhou
													from 		profissional p 
													where 		cod_empresa = ".$cod_empresa."
													order by	p.nome asc;
													";			
													$query = mysql_query($sql);										
													?>
													<div class="form-group">
														<label class="col-sm-2 control-label"><b>Profissionais</b></label>
														<div class="col-sm-8">

														<table align="left" class="table" border="1" bordercolor="#EEEEEE" style="margin: 0 auto; width: 80%;">
										                    <thead>
										                        <tr>
																	<th style="width: 1%;">&nbsp;</th>
																	<th style="width: 25%;">Nome</th>
										                    </thead>
										                    <tbody>

															<?php while ($rs = mysql_fetch_array($query)){ ?>
															<tr>
																<td align="left"><input type="checkbox" name="cod_profissional[]" value="<?php echo $rs['cod_profissional'];?>" 
																					<?php if ($rs['trabalhou'] > 0){ echo " checked "; } ?> ></td>
																<td align="left"><?php echo $rs['nome'];?></td>
															</tr>
															<?php 	
															}
														  	?>

															</tbody>
														</table>

														</div>
													</div>

													<div class="form-group">
														<label class="col-sm-2 control-label"><b>Valor da Gorjeta</b></label>
														<div class="col-sm-2">
														  <input type="text" class="form-control" name="valor_gorjeta" id="valor_gorjeta" maxlength="10" onKeyPress="return(moeda(this,'.',',',event));">				
														</div>
													</div>

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