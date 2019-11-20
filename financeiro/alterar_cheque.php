<?php 

	require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";;
	
	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	$credencial_ver = 0;
	$credencial_incluir = 0;
	$credencial_editar = 0;
	$credencial_excluir = 0;
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "produto_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "produto_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "produto_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "produto_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}

$cod_empresa = $_SESSION['cod_empresa'];
$voltar 	 = $_REQUEST['voltar'];
		
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar	
	
	$acao = '';

	if (isset($_REQUEST['acao'])) {
		
		if ($_REQUEST['acao'] == "alterar_cheque")
		{
			$cod_comanda_pagamento	= $_REQUEST["cod_comanda_pagamento"];
			$voltar 				= $_REQUEST["voltar"];

			if ( (isset($_REQUEST["valor"])) && ($_REQUEST["valor"] != "")) { $valor = ValorPhpMysql($_REQUEST["valor"]); } else { $valor = "NULL"; }

			if (isset($_REQUEST["tipo_cheque"])) { $tipo_cheque = $_REQUEST["tipo_cheque"]; } else { $tipo_cheque = ""; }

			if (isset($_REQUEST["cod_banco_1"])) { $cod_banco = $_REQUEST["cod_banco_1"]; } else { $cod_banco = ""; }

			if (isset($_REQUEST["num_cheque"])) { $num_cheque = $_REQUEST["num_cheque"]; } else { $num_cheque = ""; }

			if ((isset($_REQUEST["obs"])) && ($_REQUEST["obs"] != "")) { $obs = "'".$_REQUEST["obs"]."'"; } else { $obs = "NULL"; }

			if (isset($_REQUEST["dt_vencimento"]) && ($_REQUEST["dt_vencimento"] != "")) { $dt_vencimento = "'".DataPhpMysql($_REQUEST["dt_vencimento"])."'"; } else { $dt_vencimento = "NULL"; }

			if (isset($_REQUEST["flg_cheque_devolvido"])) 
			{ 
				$flg_cheque_devolvido = "S"; 
			} 
			else 
			{ 
				$flg_cheque_devolvido = "N"; 
			}			
				
			if ($tipo_cheque == "4") //se for a vista, apaga data de vencimento
			{
				$dt_vencimento = "NULL";
			}

			
			$sql = "
			update		comanda_pagamento
			set			
						valor = ".$valor."
			            ,cod_forma_pagamento = '".$tipo_cheque."'
			            ,dt_vencimento_cheque = ".$dt_vencimento."
			            ,cod_banco = '".$cod_banco."'
			            ,num_cheque = '".$num_cheque."'
			            ,flg_cheque_devolvido = '".$flg_cheque_devolvido."'
			            ,obs = ".$obs."
			where 		
						cod_comanda_pagamento = ".$cod_comanda_pagamento."
						";

			//echo $sql;die;

			mysql_query($sql);

			echo "<script language='javascript'>window.location='controle_cheques_recebidos.php".$voltar."&sucesso=1';</script>";
			die;
	
		}
	}
	
	if (isset($_REQUEST['acao'])){
		
		if ($_REQUEST['acao'] == "CarregarPagamento")
		{

			$cod_comanda_pagamento = $_REQUEST["cod_comanda_pagamento"];
					
			$sql = "
			select 		c.cod_cliente, c.nome, cp.valor
						,cp.cod_forma_pagamento as tipo_cheque
						,dt_vencimento_cheque as dt_vencimento
			            ,b.cod_banco
			            ,cp.num_cheque
			            ,cp.flg_cheque_devolvido
			            ,cp.obs
			from			comanda_pagamento cp
			inner join		clientes c on c.cod_cliente = cp.cod_cliente
			inner join		banco b on b.cod_banco = cp.cod_banco
			where 			cp.cod_empresa = ".$cod_empresa."
			and 			cp.cod_comanda_pagamento = ".$cod_comanda_pagamento ."
			";

			$query = mysql_query($sql);
			
			//echo $sql;

			$registros = mysql_num_rows($query);
			if ($registros > 0) {
				if ($rs = mysql_fetch_array($query)){
					$nome 					= $rs["nome"];
					$valor 					= ValorMysqlPhp($rs["valor"]);
					$tipo_cheque 			= $rs["tipo_cheque"];
					$dt_vencimento 			= DataMysqlPhp($rs["dt_vencimento"]);
					$cod_banco 				= $rs["cod_banco"];
					$num_cheque 			= $rs["num_cheque"];
					$flg_cheque_devolvido 	= $rs["flg_cheque_devolvido"];
					$obs 					= $rs["obs"];
				}
			}
		
		}
		
	}
	
?>
	 <script src="../js/mascaramoeda.js"></script>
	 <script src="conta.js"></script>

				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <div class="page-heading">            
                                <h1>Alterar Cheque</h1>
                                <div class="options"></div>
                            </div>
                            <div class="container-fluid">
                                

							<div data-widget-group="group1">

								<div class="panel panel-default" data-widget='{"draggable": "false"}'>
									<div class="panel-heading">
										<h2>Alterar Cheque</h2>
									</div>
									<div class="panel-body">

										<form action="alterar_cheque.php" class="form-horizontal row-border" name='frm' method="post">

											<input type="hidden" name="acao" value="alterar_cheque">
											<input type="hidden" name="voltar" value="<?php echo $voltar; ?>">
											<input type="hidden" name="cod_comanda_pagamento" value="<?php echo $cod_comanda_pagamento; ?>">											

											<div class="form-group">
												<label class="col-sm-2 control-label"><b>Emitente</b></label>
												<div class="col-sm-8"><input type="text" class="form-control" value="<?php echo $nome;?>" readonly name="nome" maxlength="10"></div>
											</div>
											<div class="form-group">
												<label class="col-sm-2 control-label"><b>Valor (R$)</b></label>
												<div class="col-sm-8">
													<input type="text" class="form-control" value="<?php echo $valor;?>" name="valor" onKeyPress="return(moeda(this,'.',',',event));">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-2 control-label"><b>Tipo do Cheque</b></label>
												<div class="col-sm-4">
													<select name="tipo_cheque" id="tipo_cheque" class="form-control" onchange="javascript:MostrarCaixaDataVencimento(this.value);">
													
														<option value='4' <?php if($tipo_cheque == "4"){ echo " selected "; } ?>> à vista </option>
												
														<option value='5' <?php if($tipo_cheque == "5"){ echo " selected "; } ?>> a prazo </option>
											
													</select>
												</div>
											</div>
											<div class="form-group" id="caixa_dt_vencimento" style="display: none;">
												<label class="col-sm-2 control-label"><b>Vencimento</b></label>
												<div class="col-sm-2">

													<input type="text" class="form-control mask" 
														id="dt_vencimento" 
														name="dt_vencimento" 
														data-inputmask-alias="dd/mm/yyyy" 
														data-inputmask="'alias': 'date'" 
														data-val="true" 
														data-val-required="Required" 
														placeholder="dd/mm/yyyy"
														value="<?php echo $dt_vencimento; ?>"
														>

												</div>
											</div>
										<div class="form-group">
											<label class="col-sm-2 control-label"><b>Banco</b></label>
											<div class="col-sm-4">
											<?php ComboBanco($cod_empresa, '1', $cod_banco); ?>
											</div>
										</div>	
											<div class="form-group">
												<label class="col-sm-2 control-label"><b>Nro do Cheque</b></label>
												<div class="col-sm-4">
													<input type="text" class="form-control" value="<?php echo $num_cheque;?>" name="num_cheque" maxlength="10">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-2 control-label"><b>Observações</b></label>
												<div class="col-sm-4">
													<textarea name="obs" class="form-control" style="width:320px; height:200px;"><?php echo $obs; ?></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-2 control-label"><b>Cheque Devolvido (Ex.: sem fundo)</b></label>
												<div class="col-sm-8">
													<label class="checkbox-inline icheck">
														<input type="checkbox" name="flg_cheque_devolvido" 
														<?php 
															if ($flg_cheque_devolvido == "S"){ echo " checked "; }
														?>							
														> 
														Permite
													</label>
												</div>
											</div>
										</form>
										<div class="panel-footer">
											<div class="row">
												<div class="col-sm-8 col-sm-offset-2">
													<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Salvar</button>
													<button class="btn-default btn" onclick="javascript:window.location='controle_cheques_recebidos.php<?php echo $voltar; ?>';">Voltar</button>
												</div>
											</div>
										</div>
									</div>
								</div>



            </div> <!-- .container-fluid -->
        </div> <!-- #page-content -->

<?php 
}
	
?>
<script language="Javascript" type="text/javascript">
	MostrarCaixaDataVencimento("<?php echo $tipo_cheque; ?>");
</script>
<?php
	
	include('../include/rodape_interno2.php');

?>