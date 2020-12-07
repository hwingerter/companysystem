<?php include('topo.php');
	
	//*********** VERIFICA CREDENCIAIS DE USUáRIOS *************
	
	
	
	
	

	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "conta_ver") {
			$credencial_ver = 1;
			break;
		}

	}

	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "conta_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "conta_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "conta_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}
	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) 
{ // Verifica se o usuário tem a credencial de incluir ou editar	
	

	$acao = '';
	
	
	$cod_usuario 	= $_SESSION["usuario_id"];
	$cod_grupo	 	= $_SESSION['cod_grupo_empresa'];
	$cod_empresa 	= $_SESSION['cod_empresa'];
	
	$cod_conta	 	= $_REQUEST['id'];
	$cod_fornecedor = $_REQUEST["cod_fornecedor"];
	$flg_paga 		= "N";
	$flg_quitada 	= "N";
	$flg_usoudagaveta = "N";

	if (isset($_REQUEST['acao'])) {

		if ($_REQUEST['acao'] == "incluir"){

			$pagina_anterior = $_REQUEST["pagina_anterior"];

			//LANCAMENTO DE COMPRA

			if ($pagina_anterior == "lancar_compra")
			{
				
				if (isset($_REQUEST["cod_produto"])) { $cod_produto = $_REQUEST["cod_produto"]; } else { $cod_produto = "NULL"; }
				if (isset($_REQUEST["cod_tipo_movimentacao"])) { $cod_tipo_movimentacao = $_REQUEST["cod_tipo_movimentacao"]; } else { $cod_tipo_movimentacao = "NULL"; }
				if (isset($_REQUEST["dt_movimentacao"])) { $dt_movimentacao = DataPhpMysql($_REQUEST["dt_movimentacao"]); } else { $dt_movimentacao = "NULL"; }
				if (isset($_REQUEST["quantidade"])) { $quantidade = $_REQUEST["quantidade"]; } else { $quantidade = "NULL"; }
				if (isset($_REQUEST["custo_medio"])) { $custo_medio = ValorPhpMysql($_REQUEST["custo_medio"]); } else { $custo_medio = "NULL"; }
				if (isset($_REQUEST["custo_total"])) { $custo_total = ValorPhpMysql($_REQUEST["custo_total"]); } else { $custo_total = "NULL"; }
				if (isset($_REQUEST["gera_conta_pagamento"])) { $gera_conta_pagamento = $_REQUEST["gera_conta_pagamento"]; } else { $gera_conta_pagamento = "NULL"; }
				if (isset($_REQUEST["cod_fornecedor"])) { $cod_fornecedor = $_REQUEST["cod_fornecedor"]; } else { $cod_fornecedor = "NULL"; }
				if (isset($_REQUEST["nota_fiscal"])) { $nota_fiscal = $_REQUEST["nota_fiscal"]; } else { $nota_fiscal = "NULL"; }
				if (isset($_REQUEST["obs"])) { $obs = $_REQUEST["obs"]; } else { $obs = "NULL"; }

				$sql = "
				INSERT INTO `estoque`
				(`cod_produto`,
				`cod_tipo_movimentacao`,
				`dt_movimentacao`,
				`quantidade`,
				`custo_total`,
				`custo_medio_compra`,
				`gerar_conta_pagamento`,
				`cod_fornecedor`,
				`nota_fiscal`,
				`obs`)
				VALUES
				('".$cod_produto."',
				'".$cod_tipo_movimentacao."',
				'".$dt_movimentacao."',
				'".$quantidade."',
				'".$custo_total."',
				'".$custo_medio."',
				'".$gera_conta_pagamento."',
				'".$cod_fornecedor."',
				'".$nota_fiscal."',
				'".$obs."');
				";

				//echo $sql;die;

				mysql_query($sql);

			}


			$descricao 		= "'".limpa($_REQUEST["descricao"])."'";

			if (isset($_REQUEST["nota_fiscal"]) && ($_REQUEST["nota_fiscal"] != "")) { $nota_fiscal = "'".limpa($_REQUEST["nota_fiscal"])."'"; } else { $nota_fiscal = "NULL"; }
			if (isset($_REQUEST["dt_nota_fiscal"]) && ($_REQUEST["dt_nota_fiscal"] != "")) { $dt_nota_fiscal = "'".DataPhpMysql($_REQUEST["dt_nota_fiscal"])."'"; } else { $dt_nota_fiscal = "NULL"; }
			if (isset($_REQUEST["obs"]) && ($_REQUEST["obs"] != "")) { $obs = "'".limpa($_REQUEST["obs"])."'"; } else { $obs = "NULL"; }


			//INSERINDO A CONTA PAI
			if (isset($_REQUEST["valor_1"])) { $valor = ValorPhpMysql($_REQUEST["valor_1"]); } else { $valor = "NULL"; }
			if (isset($_REQUEST["dt_vencimento_1"]) && ($_REQUEST["dt_vencimento_1"] != "")) { $dt_vencimento = "'".DataPhpMysql($_REQUEST["dt_vencimento_1"])."'"; } else { $dt_vencimento = "NULL"; }
			
			$flg_paga 			=  "'".$_REQUEST["flg_paga_1"]."'";
			$flg_quitada 		=  "'".$_REQUEST["flg_quitar_automatico_1"]."'";
			$flg_usoudagaveta 	=  "'".$_REQUEST["flg_usoudagaveta_1"]."'";
			$cod_caixa 			=  "'".$_REQUEST["cod_caixa_1"]."'";

			if (isset($_REQUEST["dt_quitacao_1"]) && ($_REQUEST["dt_quitacao_1"] != "")) { $dt_quitacao = "'".DataPhpMysql($_REQUEST["dt_quitacao_1"])."'"; } else { $dt_quitacao = "NULL"; }

			$sql = "
			INSERT INTO `conta`
			(`cod_empresa`,
			`cod_fornecedor`,
			`descricao`,
			`parcela`,
			`valor`,
			`dt_vencimento`,
			`dt_quitacao`,
			`flg_paga`,
			`flg_usoudagaveta`,
			`cod_caixa`,
			`flg_quitar_automatico`,
			`nota_fiscal`,
			`dt_nota_fiscal`,
			`obs`,
			`cod_usuario`)
			VALUES
			(".$cod_empresa.",
			".$cod_fornecedor.",
			".$descricao.",
			1,
			".$valor.",
			".$dt_vencimento.",
			".$dt_quitacao.",
			".$flg_paga.",
			".$flg_usoudagaveta.",
			".$cod_caixa.",
			".$flg_quitada.",
			".$nota_fiscal.",
			".$dt_nota_fiscal.",
			".$obs.",
			".$cod_usuario.");
			";

			//echo $sql; die;
			mysql_query($sql);


			//INSERINDO AS CONTAS FILHAS (PARCELAS)
			if (isset($_REQUEST["parcela"])) { 
				$numero_parcelas = $_REQUEST["parcela"]; 
			}

			if ($numero_parcelas > 1){

				//RETORNANDO A CONTA PAI
				$sql = "
				select	min(cod_conta) as contaPai
				from 	conta
				where 	cod_empresa = ".$cod_empresa." and cod_usuario = ".$cod_usuario."";
				$query 	= mysql_query($sql);
				$rs 	= mysql_fetch_array($query);
				$contaPai = $rs['contaPai'];

				$sql = "
				update 	conta
				set 	cod_contaPai = ".$contaPai." where cod_conta = ".$contaPai." and cod_usuario = ".$cod_usuario."";
				mysql_query($sql);

				for($i=2; $i<=$numero_parcelas; $i++){

					if (isset($_REQUEST["valor_".$i])) { $valor = ValorPhpMysql($_REQUEST["valor_".$i]); } else { $valor = "NULL"; }
					if (isset($_REQUEST["dt_vencimento_".$i]) && ($_REQUEST["dt_vencimento_".$i] != "")) { $dt_vencimento = "'".DataPhpMysql($_REQUEST["dt_vencimento_".$i])."'"; } else { $dt_vencimento = "NULL"; }
					if (isset($_REQUEST["dt_quitacao"]) && ($_REQUEST["dt_quitacao"] != "")) { $dt_quitacao = "'".DataPhpMysql($_REQUEST["dt_quitacao"])."'"; } else { $dt_quitacao = "NULL"; }

					$flg_paga 			=  "'".$_REQUEST["flg_paga_".$i]."'";
					$flg_usoudagaveta 	=  "'".$_REQUEST["flg_usoudagaveta_".$i]."'";
					$cod_caixa 			=  "'".$_REQUEST["cod_caixa_".$i]."'";
					$flg_quitada 		=  "'".$_REQUEST["flg_quitar_automatico_".$i]."'";	

					
					$sql = "
					INSERT INTO `conta`
					(`cod_contaPai`,
					`cod_empresa`,
					`cod_fornecedor`,
					`descricao`,
					`parcela`,
					`valor`,
					`dt_vencimento`,
					`dt_quitacao`,
					`flg_paga`,
					`flg_usoudagaveta`,
					`cod_caixa`,
					`flg_quitar_automatico`,
					`nota_fiscal`,
					`dt_nota_fiscal`,
					`obs`,
					`cod_usuario`)
					VALUES
					(".$contaPai.",
					".$cod_empresa.",
					".$cod_fornecedor.",
					".$descricao.",
					".$i.",
					".$valor.",
					".$dt_vencimento.",
					".$dt_quitacao.",
					".$flg_paga.",
					".$flg_usoudagaveta.",
					".$cod_caixa.",
					".$flg_quitada.",
					".$nota_fiscal.",
					".$dt_nota_fiscal.",
					".$obs.",
					".$cod_usuario.");
					";

					//echo $sql;

					mysql_query($sql);
			
				}

			}
			//die;


			if ($pagina_anterior == "lancar_compra")
			{
				echo "<script language='javascript'>window.location='estoque/estoque_atual.php?sucesso=1';</script>";
				die;
			}
			else
			{
				echo "<script language='javascript'>window.location='conta.php?sucesso=1';</script>";
				die;
			}


		}else if ($_REQUEST['acao'] == "atualizar"){
			
			$descricao 		= "'".limpa($_REQUEST["descricao"])."'";

			if (isset($_REQUEST["nota_fiscal"]) && ($_REQUEST["nota_fiscal"] != "")) { $nota_fiscal = "'".limpa($_REQUEST["nota_fiscal"])."'"; } else { $nota_fiscal = "NULL"; }
			if (isset($_REQUEST["dt_nota_fiscal"]) && ($_REQUEST["dt_nota_fiscal"] != "")) { $dt_nota_fiscal = "'".DataPhpMysql($_REQUEST["dt_nota_fiscal"])."'"; } else { $dt_nota_fiscal = "NULL"; }
			if (isset($_REQUEST["obs"]) && ($_REQUEST["obs"] != "")) { $obs = "'".limpa($_REQUEST["obs"])."'"; } else { $obs = "NULL"; }


			//INSERINDO A CONTA PAI
			if (isset($_REQUEST["valor_1"])) { $valor = ValorPhpMysql($_REQUEST["valor_1"]); } else { $valor = "NULL"; }
			if (isset($_REQUEST["dt_vencimento_1"]) && ($_REQUEST["dt_vencimento_1"] != "")) { $dt_vencimento = "'".DataPhpMysql($_REQUEST["dt_vencimento_1"])."'"; } else { $dt_vencimento = "NULL"; }
			
			$flg_paga 			=  "'".$_REQUEST["flg_paga_1"]."'";
			$flg_usoudagaveta 	=  "'".$_REQUEST["flg_usoudagaveta_1"]."'";

			if ($_REQUEST["flg_usoudagaveta_1"] == "S"){
				$cod_caixa  =  "'".$_REQUEST["cod_caixa_1"]."'";
			}else{
				$cod_caixa  =  "NULL";
			}
			
			$flg_quitada 		=  "'".$_REQUEST["flg_quitar_automatico_1"]."'";	
			if (isset($_REQUEST["dt_quitacao_1"]) && ($_REQUEST["dt_quitacao_1"] != "")) { $dt_quitacao = "'".DataPhpMysql($_REQUEST["dt_quitacao_1"])."'"; } else { $dt_quitacao = "NULL"; }

			$sql = "
			update `conta`
			set
			`cod_fornecedor` = ".$cod_fornecedor."
			,`descricao` = ".$descricao."
			,`valor` = ".$valor."
			,`dt_vencimento` = ".$dt_vencimento."
			,`dt_quitacao` = ".$dt_quitacao."
			,`flg_paga` = ".$flg_paga."
			,`flg_usoudagaveta` = ".$flg_usoudagaveta."
			,`cod_caixa` = ".$cod_caixa."
			,`flg_quitar_automatico` = ".$flg_quitada."
			,`nota_fiscal` = ".$nota_fiscal."
			,`dt_nota_fiscal` = ".$dt_nota_fiscal."
			,`obs` = ".$obs."
			where `cod_conta` = ".$cod_conta."
			and  	parcela = 1;
			";


			//echo $sql; die;

			mysql_query($sql);
			

			//APAGAR PARCELAS FILHAS E INSERIR NOVAMENTE
			$sql = "delete from conta where  cod_contaPai = ".$cod_conta." and cod_contaPai <> cod_conta; ";
			mysql_query($sql);

			if (isset($_REQUEST["parcela"])) { 
				$numero_parcelas = $_REQUEST["parcela"]; 
			}

			if ($numero_parcelas > 1){

				for($i=2; $i<=$numero_parcelas; $i++){


					if (isset($_REQUEST["valor_".$i])) { $valor = ValorPhpMysql($_REQUEST["valor_".$i]); } else { $valor = "NULL"; }
					if (isset($_REQUEST["dt_vencimento_".$i]) && ($_REQUEST["dt_vencimento_".$i] != "")) { $dt_vencimento = "'".DataPhpMysql($_REQUEST["dt_vencimento_".$i])."'"; } else { $dt_vencimento = "NULL"; }
					if (isset($_REQUEST["dt_quitacao_".$i]) && ($_REQUEST["dt_quitacao_".$i] != "")) { $dt_quitacao = "'".DataPhpMysql($_REQUEST["dt_quitacao_".$i])."'"; } else { $dt_quitacao = "NULL"; }

					$flg_paga 		=  "'".$_REQUEST["flg_paga_".$i]."'";
					$flg_usoudagaveta 	=  "'".$_REQUEST["flg_usoudagaveta_".$i]."'";

					if ($_REQUEST["flg_usoudagaveta_".$i] == "S"){
						$cod_caixa  =  "'".$_REQUEST["cod_caixa_".$i]."'";
					}else{
						$cod_caixa  =  "NULL";
					}

					$flg_quitada 	=  "'".$_REQUEST["flg_quitar_automatico_".$i]."'";	
					
					$sql = "
					INSERT INTO `conta`
					(`cod_contaPai`,
					`cod_empresa`,
					`cod_fornecedor`,
					`descricao`,
					`parcela`,
					`valor`,
					`dt_vencimento`,
					`dt_quitacao`,
					`flg_paga`,
					`flg_usoudagaveta`,
					`cod_caixa`,
					`flg_quitar_automatico`,
					`nota_fiscal`,
					`dt_nota_fiscal`,
					`obs`,
					`cod_usuario`)
					VALUES
					(".$cod_conta.",
					".$cod_empresa.",
					".$cod_fornecedor.",
					".$descricao.",
					".$i.",
					".$valor.",
					".$dt_vencimento.",
					".$dt_quitacao.",
					".$flg_paga.",
					".$flg_usoudagaveta.",
					".$cod_caixa.",
					".$flg_quitada.",
					".$nota_fiscal.",
					".$dt_nota_fiscal.",
					".$obs.",
					".$cod_usuario.");
					";

					//echo $sql; //die;

					mysql_query($sql);
			
				}

			}

			//die;

			echo "<script language='javascript'>window.location='conta.php?sucesso=2';</script>";
			
		}


	}

	
	if ($credencial_ver == '1') { //VERIFICA SE USUáRIO POSSUI ACESSO A ESSA áREA

		if (isset($_REQUEST['acao'])) {
			
			if ($_REQUEST['acao'] == "alterar"){
				
				$acao = $_REQUEST['acao'];
				
				if (isset($_REQUEST['id'])) {
					$id = $_REQUEST["id"];
				}
				
				$sql = "
				select 		c.descricao, c.nota_fiscal, c.dt_nota_fiscal, c.obs, c.cod_fornecedor
							,(select count(*) from conta where cod_contaPai = c.cod_contaPai) as parcelas
				from 		conta c
				where 		c.cod_conta = ".$id." 
				and 		c.cod_empresa = ".$cod_empresa."
				group by 	cod_contaPai, descricao, nota_fiscal, dt_nota_fiscal, obs, cod_fornecedor";

				$query = mysql_query($sql);
				$registros = mysql_num_rows($query);
				if ($registros > 0) {
					if ($rs = mysql_fetch_array($query)){

						$cod_fornecedor = $rs["cod_fornecedor"];
						$descricao = $rs["descricao"];						
						$nota_fiscal = $rs["nota_fiscal"];
						$obs = $rs["obs"];
						$parcelas = $rs["parcelas"];

						if ($rs["dt_nota_fiscal"] != ""){
							$data_nota_fiscal = DataMysqlPhp($rs["dt_nota_fiscal"]);
						}

					}
				}
			
			}

		}

	}


$pagina_anterior = $_POST["pagina_anterior"];	

if ($pagina_anterior == "lancar_compra")
{
	$cod_produto = $_POST["cod_produto"];
	$cod_tipo_movimentacao = $_POST["cod_tipo_movimentacao"];
	$valor = number_format($_POST["custo_total"],2);
	$nota_fiscal =  $_POST["nota_fiscal"];

	$sql = "
	select 		concat((select descricao from tipo_movimentacao where cod_tipo_movimentacao = ".$cod_tipo_movimentacao.")
				,' - '
	            ,(select descricao from produtos where cod_produto = ".$cod_grupo.")) as descricao
	";

	$query = mysql_query($sql);
	$rs = mysql_fetch_array($query);

	$descricao = $rs["descricao"];

	$dt_movimentacao = $_POST["dt_movimentacao"];	
	$quantidade = $_POST["quantidade"];	
	$custo_total = $_POST["custo_total"];	
	$custo_medio = $_POST["custo_medio"];	
	$gera_conta_pagamento = $_POST["gera_conta_pagamento"];	
	$cod_fornecedor = $_POST["cod_fornecedor"];	
	$nota_fiscal = $_POST["nota_fiscal"];	
	$obs = $_POST["obs"];	

}


?>

		<script language="javascript" src="conta.js"></script>

        <div id="wrapper">
            <div id="layout-static">
                <?php include('menu.php');?>
				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
								<li><a href="#">Principal</a></li>
								<li class="active"><a href="conta.php">Contas e Despesas</a></li>

                            </ol>

        <div class="page-heading">            
            <h1>Adicionar Conta a Pagar ou Despesa</h1>
            <div class="options"></div>
        </div>
        <div class="container-fluid">
            

		<div data-widget-group="group1">

			<div class="panel panel-default" data-widget='{"draggable": "false"}'>

				<div class="panel-heading">
					<h2>Adicionar Conta a Pagar ou Despesa</h2>
				</div>

				<div class="panel-body">

					<form action="conta_info.php" class="form-horizontal" name='frm' method="post">

		              <?php if ($acao=="alterar"){?>

			              <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
			              <input type="hidden" name="acao" value="atualizar">

		              <?php }else{?>
		              	
		              	<input type="hidden" name="acao" value="incluir">

		              <?php } ?>				

		              	<input type="hidden" name="pagina_anterior" value="<?php echo $pagina_anterior; ?>">
		              	<input type="hidden" name="cod_produto" value="<?php echo $cod_produto; ?>">
		              	<input type="hidden" name="dt_movimentacao" value="<?php echo $dt_movimentacao; ?>">
		              	<input type="hidden" name="cod_tipo_movimentacao" value="<?php echo $cod_tipo_movimentacao; ?>">
		              	<input type="hidden" name="quantidade" value="<?php echo $quantidade; ?>">
		              	<input type="hidden" name="custo_total" value="<?php echo $custo_total; ?>">
		              	<input type="hidden" name="custo_medio" value="<?php echo $custo_medio; ?>">
		              	<input type="hidden" name="gera_conta_pagamento" value="<?php echo $gera_conta_pagamento; ?>">
		              	<input type="hidden" name="cod_fornecedor" value="<?php echo $cod_fornecedor; ?>">
		              	<input type="hidden" name="nota_fiscal" value="<?php echo $nota_fiscal; ?>">
		              	<input type="hidden" name="obs" value="<?php echo $obs; ?>">

						<div class="form-group">
							<label class="col-sm-2 control-label"><b>Descrição</b></label>
							<div class="col-sm-8">
								<input type="text" class="form-control" value="<?php echo $descricao;?>" name="descricao" id="descricao" maxlength="200">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label"><b>Fornecedor</b></label>
							<div class="col-sm-8">
							<?php 
								ComboFornecedor($cod_fornecedor, $cod_empresa); 
							?>
							</div>
						</div>

						<div class="form-group">
							<p class="mb20" style="border-bottom:1px solid black;">Parcelas</p>

							<div class="col-sm-4 col-sm-offset-1">
								<label class="col-sm-2 control-label"><b>Parcelas</b></label>
								<div class="col-sm-8">
								<select name='parcela' class="form-control col-sm-offset-1" style="width: 100px;" onChange="javascript:Parcela(this.value);">
								  	<?php for ($i=1; $i<=12; $i++) {?>
									<option value="<?php echo $i; ?>" <?php if ($parcelas == $i) { echo " Selected"; }?>><?php echo $i;?></option>
									<?php
										  }
									?>
								</select>
								</div>
							</div>
						</div>


						<?php for ($i=1; $i<=12; $i++) { 

							if($i > 1){
								$ocultar = " style='display:none;' ";
							}

							?>

							<div id="Parcela_<?php echo $i;?>" <?php echo $ocultar; ?> >

								<div class="form-group">
									<label class="col-md-2 control-label"><b><?php echo $i; ?>a Parcela</b></label>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label"><b>Valor(R$)</b></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $valor;?>" name="valor_<?php echo $i;?>" id="valor_<?php echo $i;?>" maxlength="200">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label"><b>Vencimento</b></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $dt_vencimento;?>" name="dt_vencimento_<?php echo $i;?>" id="dt_vencimento_<?php echo $i;?>" maxlength="200">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label"><b>Parcela já paga</b></label>
									<div class="col-sm-8">
										<?php ComboContaPaga($i, $flg_paga); ?>
									</div>
								</div>
								<div class="form-group" id="UsouDaGaveta_<?php echo $i; ?>" style="display: none;">
									<label class="col-sm-2 control-label"><b>Usou $ da Gaveta?</b></label>
									<div class="col-sm-8">
										<?php ComboUsouDaGaveta('IdCaixaDia_', $i, $flg_usoudagaveta, $cod_empresa); ?>
									</div>
								</div>
								<div class="form-group" id="CaixaDia_<?php echo $i; ?>" style="display: none;">
									<label class="col-sm-2 control-label"><b>Do caixa:</b></label>
									<div class="col-sm-8" id="IdCaixaDia_<?php echo $i; ?>">
										
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label"><b>Quitar automaticamente</b></label>
									<div class="col-sm-8">
										<?php ComboQuitarAutomaticamente($i, $flg_quitada); ?>
									</div>
								</div>
								<div class="form-group" id="quitacao_<?php echo $i; ?>" style="display: none;">
									<label class="col-sm-2 control-label"><b>Quitação</b></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $dt_quitacao;?>" name="dt_quitacao_<?php echo $i;?>" id="dt_quitacao_<?php echo $i;?>" maxlength="200">
									</div>
								</div>

							</div>

						<?php } ?>

						<p class="mb20" style="border-bottom:1px solid black;">Nota Fiscal</p>

						<div class="form-group">
							<label class="col-sm-2 control-label"><b>Nota Fiscal</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" value="<?php echo $nota_fiscal;?>" name="nota_fiscal" maxlength="10">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label"><b>Data NF</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" value="<?php echo $data_nota_fiscal;?>" name="dt_nota_fiscal" maxlength="10">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label"><b>Observação</b></label>
							<div class="col-sm-8">
								<textarea name="obs" class="form-control" cols="50" rows="4"><?php echo $obs; ?></textarea>
							</div>
						</div>

					</form>

				</div>

				<div class="panel-footer">
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Gravar</button>

							<?php 

							if ($pagina_anterior != ""){ ?>

							<button type="button" class="btn-default btn" onClick="javascript:window.history.go(-1);">Voltar</button>

							<?php }else{ ?>

							<button type="button" class="btn-default btn" onclick="javascript:window.location='conta.php';">Voltar</button>

							<?php } ?>

						</div>
					</div>
				</div>

			</div>

		</div>

<?php

	if ($_REQUEST['acao'] == "alterar"){

		$sql = "
		select 		c.parcela, c.valor, c.dt_vencimento, c.flg_paga, c.flg_usoudagaveta, flg_quitar_automatico, dt_quitacao, cod_caixa
		from 		conta c
		where 		c.cod_contaPai = ".$id." or c.cod_conta = ".$id."  
		and 		c.cod_empresa = ".$cod_empresa."
		";
		
		//echo $sql;

		$query = mysql_query($sql);
		$registros = mysql_num_rows($query);
		if ($registros > 0) {
			while ($rs = mysql_fetch_array($query)){

				$parcela = $rs["parcela"];

				if($rs['dt_quitacao'] != ""){
					$dt_quitacao = DataMysqlPhp($rs['dt_quitacao']);	
				}
				else{
					$dt_quitacao = "";		
				}
				


				?>
				<script>

					document.getElementById("valor_<?php echo $parcela; ?>").value = "<?php echo ValorMysqlPhp($rs['valor']); ?>";
					document.getElementById("dt_vencimento_<?php echo $parcela; ?>").value = "<?php echo DataMysqlPhp($rs['dt_vencimento']); ?>";
					document.getElementById("Parcela_<?php echo $parcela; ?>").style.display = "block";

					document.getElementById("flg_paga_<?php echo $parcela; ?>").value = "<?php echo $rs['flg_paga']; ?>";
					document.getElementById("flg_usoudagaveta_<?php echo $parcela; ?>").value = "<?php echo $rs['flg_usoudagaveta']; ?>";

					ContaPaga('<?php echo $parcela; ?>', '<?php echo $rs["flg_paga"]; ?>');

					CarregaDataCaixa('CaixaDia_', '<?php echo $parcela; ?>', '<?php echo $cod_empresa; ?>', '<?php echo $rs['flg_usoudagaveta']; ?>', '<?php echo $rs['cod_caixa']; ?>');

					document.getElementById("dt_quitacao_<?php echo $parcela; ?>").value = "<?php echo $dt_quitacao; ?>";

					document.getElementById("flg_quitar_automatico_<?php echo $parcela; ?>").value = "<?php echo $rs['flg_quitar_automatico']; ?>";



				</script>


				<?php


			}
		}

	}


}

include('rodape.php');

?>