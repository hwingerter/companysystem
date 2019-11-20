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

	$cod_empresa			= $_SESSION['cod_empresa'];
	$cod_cliente 			= $_REQUEST['cod_cliente'];
	$cod_comanda 			= $_REQUEST['cod_comanda'];
	$cod_usuario_pagamento 	= $_SESSION['usuario_id'];
	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar	
	
	
	if (isset($_REQUEST['acao'])){

		if($_REQUEST['acao'] == "adicionar"){

			if (isset($_REQUEST["valor"]) && ($_REQUEST["valor"] != "")) { $valor = ValorPhpMysql($_REQUEST["valor"]); } else { $valor = 'NULL'; }

			$sql = "
			update 		comanda 
			set 		valor_desconto = ".$valor." 
			where 		cod_comanda = ".$cod_comanda." 
			and 		cod_cliente = ".$cod_cliente." 
			and 		cod_empresa = ".$cod_empresa." ";

			//echo $sql;die;

			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='comanda_pagamentos.php?sucesso=1&cod_comanda=".$cod_comanda."&cod_cliente=".$cod_cliente."';</script>";die;

		}
	}


	//Verificar se já houve pagamento
	$sql = "
	select		(select (i.valor * i.quantidade)
				from comanda_item i 
				where 		i.cod_empresa = p.cod_empresa 
				and 		i.cod_cliente = p.cod_cliente	 
				and 		i.cod_comanda = p.cod_comanda) as total_comanda
				,sum(p.valor) as total_pago
	from 		comanda_pagamento p
	where 		p.cod_comanda = ".$cod_comanda."
	and 		p.cod_cliente = ".$cod_cliente."
	and 		p.cod_empresa = ".$cod_empresa."
	;
	";

	$query = mysql_query($sql);
	$rs = mysql_fetch_array($query);

	$total_comanda 	= $rs['total_comanda'];
	$total_pago 	= $rs['total_pago'];
	$troco 			= $total_pago - $total_comanda;


	if($_REQUEST['acao'] == "inserir_desconto"){
		$acao = "adicionar";
	}

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
												<h2>Desconto</h2>
											</div>
											<div class="panel-body">

												<form action="comanda_pagamento_desconto.php" class="form-horizontal row-border" name='frm' method="post">

									              <input type="hidden" name="acao" value="<?php echo $acao;?>">

									              <input type="hidden" name="cod_comanda" value="<?php echo $cod_comanda; ?>">
									              <input type="hidden" name="cod_cliente" value="<?php echo $cod_cliente; ?>">

													<div class="form-group">
														<label class="col-sm-2 control-label"><b>Cliente</b></label>
														<div class="col-sm-8"><?php echo $nome_cliente; ?></div>
													</div>

													<div class="form-group">
														<label class="col-sm-2 control-label"><b>Valor da Créditos</b></label>
														<div class="col-sm-2">
														  <input type="text" class="form-control" name="valor" id="valor" maxlength="10" onKeyPress="return(moeda(this,'.',',',event));">				
														</div>
													</div>

												</form>

												<div class="panel-footer">
													<div class="row">
														<div class="col-sm-8 col-sm-offset-2">
															<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Dar Desconto</button>
															<button class="btn-default btn" onclick="javascript:window.location='comanda_pagamentos.php?cod_comanda=<?php echo $cod_comanda;?>&cod_cliente=<?php echo $cod_cliente;?>';">Cancel</button>
														</div>
													</div>
												</div>

											</div>
										</div>



                            </div> <!-- .container-fluid -->
	
<?php 
}


include('../include/rodape_interno2.php');?>