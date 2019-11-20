<?php 
require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";
include('../include/usuario.php');
	
	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	//if ($_SESSION['usuario_conta'] == '1') {
		
		$credencial_ver = 1;
		$credencial_incluir = 1;
		$credencial_editar = 1;
		$credencial_excluir = 1;
		
	//}
	
	
if ($credencial_editar == '1') { //VERIFICA SE USU�RIO POSSUI ACESSO A ESSA �REA
	
	$acao = '';

	$cod_empresa = $_SESSION["cod_empresa"];
	$cod_estoque = $_REQUEST["cod_estoque"];
	$cod_produto = $_REQUEST["cod_produto"];
	
	if (isset($_REQUEST["cod_produto"])) { $cod_produto = $_REQUEST["cod_produto"]; } else { $cod_produto = "NULL"; }
	if (isset($_REQUEST["cod_tipo_movimentacao"])) { $cod_tipo_movimentacao = $_REQUEST["cod_tipo_movimentacao"]; } else { $cod_tipo_movimentacao = "NULL"; }
	if (isset($_REQUEST["dt_movimentacao"])) { $dt_movimentacao = DataPhpMysql($_REQUEST["dt_movimentacao"]); } else { $dt_movimentacao = "NULL"; }
	if (isset($_REQUEST["quantidade"])) { $quantidade = $_REQUEST["quantidade"]; } else { $quantidade = "NULL"; }
	if (isset($_REQUEST["custo_medio"]) && ($_REQUEST["custo_medio"] != "")) { $custo_medio = ValorPhpMysql($_REQUEST["custo_medio"]); } else { $custo_medio = "NULL"; }
	if (isset($_REQUEST["gera_conta_pagamento"])) { $gera_conta_pagamento = $_REQUEST["gera_conta_pagamento"]; } else { $gera_conta_pagamento = "NULL"; }
	if (isset($_REQUEST["cod_fornecedor"]) && ($_REQUEST["cod_fornecedor"] != "")) { $cod_fornecedor = $_REQUEST["cod_fornecedor"]; } else { $cod_fornecedor = "NULL"; }
	if (isset($_REQUEST["cod_cliente"]) && ($_REQUEST["cod_cliente"] != "")) { $cod_cliente = $_REQUEST["cod_cliente"]; } else { $cod_cliente = "NULL"; }
	if (isset($_REQUEST["nota_fiscal"]) && ($_REQUEST["nota_fiscal"] != "")) { $nota_fiscal = "'".$_REQUEST["nota_fiscal"]."'"; } else { $nota_fiscal = "NULL"; }
	if (isset($_REQUEST["obs"]) && ($_REQUEST["obs"] != "")) { $obs = "'".$_REQUEST["obs"]."'"; } else { $obs = "NULL"; }


if (isset($_REQUEST['acao'])){
	
	if ($_REQUEST['acao'] == "novo")
	{	

		$sql = "
		INSERT INTO `estoque`
		(`cod_produto`,
		`cod_tipo_movimentacao`,
		`dt_movimentacao`,
		`quantidade`,
		`custo_medio_compra`,
		`gerar_conta_pagamento`,
		`cod_fornecedor`,
		`cod_cliente`,
		`nota_fiscal`,
		`obs`)
		VALUES
		('".$cod_produto."',
		'".$cod_tipo_movimentacao."',
		'".$dt_movimentacao."',
		'".$quantidade."',
		".$custo_medio.",
		'".$gera_conta_pagamento."',
		".$cod_fornecedor.",
		".$cod_cliente.",
		".$nota_fiscal.",
		".$obs.");
		";

		echo $sql;die;

		mysql_query($sql);

		echo "<script language='javascript'>window.location='extrato_estoque.php?cod_produto=".$cod_produto."&sucesso=1';</script>"; die;
		
	}else if ($_REQUEST['acao'] == "atualizar"){
	

		$sql = "
		UPDATE `claudio_company`.`estoque`
		SET
		`cod_tipo_movimentacao` = '".$cod_tipo_movimentacao."',
		`dt_movimentacao` = '".$dt_movimentacao."',
		`quantidade` = '".$quantidade."',
		`custo_medio_compra` = ".$custo_medio.",
		`gerar_conta_pagamento` = '".$gera_conta_pagamento."',
		`cod_fornecedor` = ".$cod_fornecedor.",
		`cod_cliente` = ".$cod_cliente.",
		`nota_fiscal` = ".$nota_fiscal.",
		`obs` = ".$obs."
		WHERE `cod_estoque` = ".$cod_estoque.";";

		//echo $sql;die;

		mysql_query($sql);
		
		echo "<script language='javascript'>window.location='extrato_estoque.php?cod_produto=".$cod_produto."&sucesso=2';</script>"; die;
	
	}
	
}

if (isset($_REQUEST['acao'])){
	
	if ($_REQUEST['acao'] == "alterar"){
		
		$acao = $_REQUEST['acao'];
		
		if (isset($_REQUEST['cod_estoque'])) {$cod_estoque = $_REQUEST["cod_estoque"];}
		
		$sql = "Select * from estoque where cod_estoque = " . $cod_estoque;
		$query = mysql_query($sql);
		$registros = mysql_num_rows($query);
		if ($registros > 0) {
			if ($rs = mysql_fetch_array($query)){

				$cod_produto			= $rs['cod_produto'];
				$cod_tipo_movimentacao 	= $rs['cod_tipo_movimentacao'];
				$dt_movimentacao		= DataMysqlPhp($rs['dt_movimentacao']);

				$quantidade = $rs["quantidade"];

				$custo_total = number_format(($rs["quantidade"] * $rs["custo_medio_compra"]), 2);

				$custo_total = ValorMysqlPhp($custo_total, 2);

				$custo_medio = ValorMysqlPhp(number_format($rs["custo_medio_compra"], 2));

				$gerar_conta_pagamento = $rs["gerar_conta_pagamento"];
				$cod_fornecedor = $rs["cod_fornecedor"];
				$cod_cliente = $rs["cod_cliente"];
				$nota_fiscal = $rs["nota_fiscal"];
				$obs = $rs["obs"];

			}
		}

	}
	
}


?>
				<script language="javascript" type="text/javascript" src="estoque.js"></script>
				<script language="javascript" src="../js/mascaramoeda.js"></script>

				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">                                
								<li><a href="#">Principal</a></li>
								<li class="active"><a href="lancar_compra.php">Lançar Compra</a></li>
                            </ol>
                            <div class="page-heading">            
                                <h1>Lançar Compra</h1>
                                <div class="options">
								</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Lançar Compra</h2>
		</div>
		<div class="panel-body">

			<form action="lancar_compra.php" class="form-horizontal row-border" name='frm' method="post">
				
              <?php if ($acao=="alterar"){?>
	              <input type="hidden" name="cod_estoque" value="<?php echo $_REQUEST['cod_estoque']; ?>">
	              <input type="hidden" name="acao" value="atualizar">
              <?php }else{?>
              	<input type="hidden" name="acao" value="novo">
              	<input type="hidden" name="pagina_anterior" value="lancar_compra">
              <?php } ?>				

              <input type="hidden" name="devolucao_venda" id="devolucao_venda">
              <input type="hidden" name="cod_produto" value="<?php echo $cod_produto; ?>">

				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Produto</b></label>
					<div class="col-sm-8">
						<?php comboProdutoEstoque($cod_empresa, $cod_produto); ?>
					</div>
					<?php if (($_REQUEST['acao'] == "alterar") && ($cod_produto != "")){ ?>
						<script>
							EstoqueAtual("<?php echo $cod_produto; ?>");
							document.getElementById("cod_produto").disabled = "true";
						</script>
					<?php } ?>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Estoque Atual</b></label>
					<div class="col-sm-8" id="quadro_estoque_atual">
						
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Tipo de Movimentação</b></label>
					<div class="col-sm-8">
						<?php ComboTipoMovimentacao($cod_empresa, $cod_tipo_movimentacao); ?>
					</div>
				</div>				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Data da Movimentação</b></label>
					<div class="col-sm-8">
						<input type="text" id="datepicker" name="dt_movimentacao" <?php if ($acao == "alterar"){echo "value='". $dt_movimentacao ."'";}?>>
					</div>
				</div>				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Quantidade</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="quantidade" id="quantidade"  maxlength="255" onKeyUp="CalcularCustoTotal();" onblur="EstoqueAposMovimentacao(this.value);" <?php if ($acao == "alterar"){echo "value='". $quantidade ."'";}?> >
					</div>
				</div>	
				<div class="form-group" id="BoxCustoMedioCompra">
					<label class="col-sm-2 control-label"><b>Custo Unit. Médio de Compra</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="custo_medio" id="custo_medio" maxlength="255" onKeyUp="CalcularCustoTotal();" onKeyPress="return(moeda(this,'.',',',event));" <?php if ($acao == "alterar"){echo "value='". $custo_medio ."'";}?>>
					</div>
				</div>	
				<div class="form-group" id="BoxCustoTotal">
					<label class="col-sm-2 control-label"><b>Custo Total</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="custo_total" id="custo_total" maxlength="255" readonly <?php if ($acao == "alterar"){echo "value='". $custo_total ."'";}?>>
					</div>
				</div>	
				<div class="form-group" id="BoxGerarConta">
					<label class="col-sm-2 control-label"><b>Gerar Conta ou Pagamento</b></label>
					<div class="col-sm-8">

						<input type="radio" name="gera_conta_pagamento" id="gera_conta_pagamento" value="1" 
						<?php if (($acao == "alterar") && ($gerar_conta_pagamento=="1")) { echo " checked ";} ?> checked onClick="javascript:InfoGeraConta('1');" > Sim


						<input type="radio" name="gera_conta_pagamento" id="gera_conta_pagamento" value="2" 
						<?php if (($acao == "alterar") && ($gerar_conta_pagamento=="2")) { echo " checked ";} ?>  onClick="javascript:InfoGeraConta('2');"> Não

					</div>
				</div>	
				<div class="form-group" id="BoxInfoGerarConta" style="display:none;">
					<div class="col-sm-12">
						<div class="panel panel-default">
							<div class="panel-heading"><h2>Mensagem</h2></div>
							<div class="panel-body" style="height: 190px;">
								<p>Quando se realiza uma entrada no estoque, é importante gerar uma Conta (a pagar ou já paga), pois, 
								assim, o sistema contabilizará os valores gastos. Deste modo, os relatórios financeiros ficarão corretos. </p>
								<p>Se você não cadastrar uma Conta, para o sistema será como se você não tivesse gastos para comprar o produto.
								Isso fará com que os relatórios financeiros, como o Fluxo de Caixa, por exemplo, fiquem incorretos.</p>
								<p>Sendo assim, é aconselhável deixar a opção "Gerar Conta ou Pagamento" marcada como SIM, a não ser que você
								já tenha cadastrado manualmente a conta relacionada à aquisição dos produtos.</p>
							</div>
						</div>
					</div>
				</div>

				<?php if ($gerar_conta_pagamento != ""){ ?>
					<script>InfoGeraConta("<?php echo $gerar_conta_pagamento; ?>");</script>
				<?php } ?>

				<div class="form-group" id="BoxCliente" style="display:none;">
					<label class="col-sm-2 control-label"><b>Cliente</b></label>
					<div class="col-sm-8">
						<?php ComboCliente($cod_cliente, $cod_empresa); ?>
					</div>
				</div>	
				<div class="form-group" id="BoxFornecedor">
					<label class="col-sm-2 control-label"><b>Fornecedor</b></label>
					<div class="col-sm-8">
						<?php ComboFornecedor($cod_fornecedor, $cod_empresa); ?>
					</div>
				</div>	
				<div class="form-group" id="BoxNotaFiscal">
					<label class="col-sm-2 control-label"><b>Nota Fiscal</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" <?php if ($acao == "alterar"){echo "value='". $nota_fiscal ."'";}?> name="nota_fiscal" id="nota_fiscal" maxlength="255">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Observações</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" <?php if ($acao == "alterar"){echo "value='". $obs ."'";}?> name="obs" maxlength="255">
					</div>
				</div>
				<div class="form-group" id="BoxEstoqueAposMovimentacao">
					<label class="col-sm-2 control-label"><b>Estoque após movimentação</b></label>
					<div class="col-sm-8" id="quadro_estoque_apos_compra">
						
					</div>
				</div>
			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-primary btn" onclick="javascript:LancarCompra();">Salvar</button>
						<!--button class="btn-default btn" onclick="javascript:window.location='extrato_estoque.php?cod_produto=<?php echo $cod_produto; ?>';">Voltar</button-->
					</div>
				</div>
			</div>
		</div>
	</div>



                            </div> <!-- .container-fluid -->
                        </div> <!-- #page-content -->
					</div>
<?php 
}


if ($_REQUEST['acao'] == "alterar"){
?>

<script>
	SelecionarTipoMovimentacao("<?php echo $cod_tipo_movimentacao; ?>");	
</script>

<?php

}
	
	include('../include/rodape_interno2.php');

?>