<?php 

	require_once "../include/topo_interno2.php";

	require_once "../include/funcoes.php";

	require_once "../include/ler_credencial.php";
	
	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************

	$credencial_ver = 1;
	$credencial_incluir = 1;
	$credencial_editar = 1;
	$credencial_excluir = 1;
	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar	
	
	if (isset($_REQUEST['pergunta_remover'])) { $pergunta_remover = $_REQUEST['pergunta_remover']; } else { $pergunta_remover = ''; }

	$acao = '';
	
	$cod_profissional		= "";
	$cod_empresa 			= $_SESSION['cod_empresa'];
	$cod_usuario_inclusao	= $_SESSION['usuario_id'];
	$cod_caixa				= $_SESSION['cod_caixa'];

	$cod_comanda			= $_REQUEST['cod_comanda'];
	$cod_cliente			= $_REQUEST['cod_cliente'];
	$cod_comanda_item		= $_REQUEST['cod_comanda_item'];		


	if (isset($_REQUEST['acao'])){
	
		if ($_REQUEST['acao'] == "incluir_comanda"){

			if (isset($_REQUEST['cod_profissional']) && ($_REQUEST['cod_profissional'] != "")) { $cod_profissional = "'".limpa($_REQUEST['cod_profissional'])."'"; } else { $cod_profissional = 'NULL'; }
			
			if (isset($_REQUEST["valor"])) { $valor = ValorPhpMysql($_REQUEST["valor"]); } else { $valor = 'NULL'; }

			if (isset($_REQUEST["quantidade"])) { $quantidade = $_REQUEST["quantidade"]; } else { $quantidade = "NULL"; }

			if (isset($_REQUEST["flg_desconto_acrescimo"])) { $flg_desconto_acrescimo = "'".$_REQUEST["flg_desconto_acrescimo"]."'"; } else { $flg_desconto_acrescimo = "NULL"; }

			if ($_REQUEST['tipo_item'] == "1"){
				$cod_servico = $_REQUEST['cod_servico'];
				$cod_produto = 'NULL';
			}else{
				$cod_servico = 'NULL';
				$cod_produto = $_REQUEST['cod_produto'];
			}

			$percentual_desconto = "NULL";
			$valor_desconto = "NULL";
			$valor_acrescimo = "NULL";

			if ($_REQUEST['flg_desconto_acrescimo'] == "1"){

				if ($_REQUEST['percentual_desconto'] != ""){
					$percentual_desconto = $_REQUEST['percentual_desconto'];
					$valor_desconto = "NULL";
				}

				if ($_REQUEST['valor_desconto'] != ""){
					$percentual_desconto = "NULL";
					$valor_desconto = ValorPhpMysql($_REQUEST['valor_desconto']);
				}

				$valor_acrescimo = "NULL";

			}elseif ($_REQUEST['flg_desconto_acrescimo'] == "2"){

				$percentual_desconto = "NULL";
				$valor_desconto = "NULL";

				if ($_REQUEST['valor_acrescimo'] != ""){
					$valor_acrescimo = ValorPhpMysql($_REQUEST['valor_acrescimo']);
				}else{
					$valor_acrescimo = "NULL";
				}
			}
		
			/*COMISSÃO*/

			$sql = "
			select 	cod_tipo_comissao
					,case cod_tipo_comissao
						when 1 then comissao_percentual
						when 2 then comissao_fixa
					end as comissao
			from 	profissional_comissao 
			where 	cod_empresa = ".$cod_empresa." 
			and 	cod_profissional = ".$cod_profissional."
			and 	cod_servico = ".$cod_servico."
			";

			//echo $sql;die;

			$query = mysql_query($sql);
			$total = mysql_num_rows($query);

			/*echo $cod_servico."<br>";
			echo $cod_produto."<br>";
			die;*/

			if ($total > 0)
			{
				$rs    				= mysql_fetch_array($query);
				$cod_tipo_comissao	= $rs["cod_tipo_comissao"];
				$valor_comissao 	= $rs["comissao"];
			}
			else
			{
				if($cod_servico != "NULL")
				{
					$sql = "
					select 	cod_tipo_comissao
							,case cod_tipo_comissao
								when 1 then comissao_percentual
								when 2 then comissao_fixa
							end as comissao
					from 	servico
					where 	cod_empresa = ".$cod_empresa." 
					and 	cod_servico = ".$cod_servico."
					";

					//echo $sql;die;

					$query = mysql_query($sql);
					$rs    				= mysql_fetch_array($query);
					$cod_tipo_comissao	= $rs["cod_tipo_comissao"];
					$valor_comissao 	= $rs["comissao"];

				}
				elseif ($cod_produto != "NULL")
				{
					$sql = "
					select 	cod_tipo_comissao
							,case cod_tipo_comissao
								when 1 then comissao_percentual
								when 2 then comissao_fixa
							end as comissao
					from 	produtos
					where 	cod_empresa = ".$cod_empresa." 
					and 	cod_produto = ".$cod_produto."
					";
					//echo $sql;die;
					$query = mysql_query($sql);
					$rs    				= mysql_fetch_array($query);
					$cod_tipo_comissao	= $rs["cod_tipo_comissao"];
					$valor_comissao 	= $rs["comissao"];
				}

			}

			//echo $cod_tipo_comissao . " - " . $valor_comissao."<br><>";

			/*********/


			$sql = "
				INSERT INTO `comanda_item`
				(`cod_comanda`,
				`cod_empresa`,
				`cod_cliente`,
				`cod_profissional`,
				`cod_produto`,
				`cod_servico`,
				`valor`,
				`quantidade`,
				`flg_desconto_acrescimo`,
				`percentual_desconto`,
				`valor_desconto`,
				`valor_acrescimo`,
				`cod_tipo_comissao`,
				`valor_comissao`,
				`dt_inclusao`)
				VALUES
				(".$cod_comanda.", 
				".$cod_empresa.", 
				".$cod_cliente.", 
				".$cod_profissional.", 
				".$cod_produto.", 
				".$cod_servico.", 
				".$valor.", 
				".$quantidade.",
				".$flg_desconto_acrescimo.",
				".$percentual_desconto.",
				".$valor_desconto.",
				".$valor_acrescimo.",
				".$cod_tipo_comissao.",
				".$valor_comissao.",
				now())
				;";

			//echo $sql; die;

			mysql_query($sql);
		
			echo "<script language='javascript'>window.location='comanda_lista.php?cod_comanda=".$cod_comanda."&cod_cliente=".$cod_cliente."&sucesso=1';</script>";
			
		}else if ($_REQUEST['acao'] == "atualizar"){
			
			if (isset($_REQUEST['cod_profissional']) && ($_REQUEST['cod_profissional'] != "")) { $cod_profissional = "'".limpa($_REQUEST['cod_profissional'])."'"; } else { $cod_profissional = 'NULL'; }
			if (isset($_REQUEST["valor"]) && ($_REQUEST['valor'] != "")) { $valor = ValorPhpMysql($_REQUEST["valor"]); } else { $valor = 'NULL'; }
			if (isset($_REQUEST["quantidade"])) { $quantidade = $_REQUEST["quantidade"]; } else { $quantidade = "NULL"; }

			if (isset($_REQUEST["flg_desconto_acrescimo"])) { $flg_desconto_acrescimo = "'".$_REQUEST["flg_desconto_acrescimo"]."'"; } else { $flg_desconto_acrescimo = "NULL"; }


			if ($_REQUEST['tipo_item'] == "1"){
				$cod_servico = $_REQUEST['cod_servico'];
				$cod_produto = 'NULL';
			}else{
				$cod_servico = 'NULL';
				$cod_produto = $_REQUEST['cod_produto'];
			}

			$percentual_desconto = "NULL";
			$valor_desconto = "NULL";
			$valor_acrescimo = "NULL";

			if ($_REQUEST['flg_desconto_acrescimo'] == "1"){

				if ($_REQUEST['percentual_desconto'] != ""){
					$percentual_desconto = $_REQUEST['percentual_desconto'];
					$valor_desconto = "NULL";
				}

				if ($_REQUEST['valor_desconto'] != ""){
					$percentual_desconto = "NULL";
					$valor_desconto = ValorPhpMysql($_REQUEST['valor_desconto']);
				}

			}elseif ($_REQUEST['flg_desconto_acrescimo'] == "2"){

				if ($_REQUEST['valor_acrescimo'] != ""){
					$valor_acrescimo = ValorPhpMysql($_REQUEST['valor_acrescimo']);
				}else{
					$valor_acrescimo = "NULL";
				}
			}


			/*COMISSÃO*/

			$sql = "
			select 	cod_tipo_comissao
					,case cod_tipo_comissao
						when 1 then comissao_percentual
						when 2 then comissao_fixa
					end as comissao
			from 	profissional_comissao 
			where 	cod_empresa = ".$cod_empresa." 
			and 	cod_profissional = ".$cod_profissional."
			";
			$query = mysql_query($sql);
			$total = mysql_num_rows($query);

			if ($total > 0)
			{
				$rs    				= mysql_fetch_array($query);
				$cod_tipo_comissao	= $rs["cod_tipo_comissao"];
				$valor_comissao 	= $rs["comissao"];
			}
			else
			{
				if($cod_servico != "NULL")
				{
					$sql = "
					select 	cod_tipo_comissao
							,case cod_tipo_comissao
								when 1 then comissao_percentual
								when 2 then comissao_fixa
							end as comissao
					from 	servico
					where 	cod_empresa = ".$cod_empresa." 
					and 	cod_servico = ".$cod_servico."
					";
					$query = mysql_query($sql);
					$rs    				= mysql_fetch_array($query);
					$cod_tipo_comissao	= $rs["cod_tipo_comissao"];
					$valor_comissao 	= $rs["comissao"];

				}
				elseif ($cod_produto != "NULL")
				{
					$sql = "
					select 	cod_tipo_comissao
							,case cod_tipo_comissao
								when 1 then comissao_percentual
								when 2 then comissao_fixa
							end as comissao
					from 	produtos
					where 	cod_empresa = ".$cod_empresa." 
					and 	cod_produto = ".$cod_produto."
					";
					$query = mysql_query($sql);
					$rs    				= mysql_fetch_array($query);
					$cod_tipo_comissao	= $rs["cod_tipo_comissao"];
					$valor_comissao 	= $rs["comissao"];
				}

			}

			//echo $cod_tipo_comissao . " - " . $comissao; die;

			/*********/


			$sql = "

			UPDATE `comanda_item`
			SET
			`cod_profissional` = ".$cod_profissional.", 
			`cod_produto` = ".$cod_produto.", 
			`cod_servico` = ".$cod_servico.", 
			`valor` = ".$valor.", 
			`quantidade` = ".$quantidade.",
			`flg_desconto_acrescimo` = ".$flg_desconto_acrescimo.",
			`percentual_desconto` = ".$percentual_desconto.",
			`valor_desconto` = ".$valor_desconto.",
			`valor_acrescimo` = ".$valor_acrescimo.",
			`cod_tipo_comissao` = ".$cod_tipo_comissao.",
			`valor_comissao` = ".$valor_comissao."
			WHERE `cod_comanda_item` = ".$cod_comanda_item."";

			//echo $sql; die;

			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='comanda_lista.php?cod_comanda=".$cod_comanda."&cod_cliente=".$cod_cliente."&sucesso=2';</script>";
			
		}else if ($_REQUEST['acao'] == "remover_desconto"){

				$sql = "
				update 	comanda_item
				set 	flg_desconto_acrescimo = NULL
						,percentual_desconto = NULL
						,valor_desconto = NULL
						,valor_acrescimo = NULL
				where 	cod_comanda_item = ".$cod_comanda_item."
				";
	
				//echo $sql; die;
	
				mysql_query($sql);
	
				echo "<script language='javascript'>window.location='comanda_item_info.php?acao=alterar&id=".$cod_comanda_item."&cod_comanda=".$cod_comanda."&cod_cliente=".$cod_cliente."';</script>";
				die;

		}

	}


if (isset($_REQUEST['acao'])){
	
	if ($_REQUEST['acao'] == "alterar")
	{
	
		$titulo_pagina = "Alterar Comanda";

		if (isset($_REQUEST['id'])) {
			$id 		= $_REQUEST["id"];
		}
		
		$sql = "
		select		cod_profissional, cod_produto, cod_servico, valor, quantidade, flg_desconto_acrescimo, percentual_desconto, valor_desconto, valor_acrescimo
		from		comanda_item
		where 		cod_empresa = ".$cod_empresa."
		and 		cod_comanda = ".$cod_comanda."
		and 		cod_cliente = ".$cod_cliente."
		and 		cod_comanda_item = ".$id.";
		";
		//echo $sql;die;
		$query = mysql_query($sql);
		$registros = mysql_num_rows($query);
		if ($registros > 0) {
			if ($rs = mysql_fetch_array($query)){

				$cod_profissional 	= $rs['cod_profissional'];
				$cod_produto		= $rs['cod_produto'];
				$cod_servico		= $rs['cod_servico'];
				$valor				= number_format($rs['valor'], 2, ',', '.');
				$quantidade			= $rs['quantidade'];
				$flg_desconto_acrescimo		= $rs['flg_desconto_acrescimo'];
				$percentual_desconto		= $rs['percentual_desconto'];
				$valor_desconto				= $rs['valor_desconto'];
				$valor_acrescimo			= $rs['valor_acrescimo'];

			}

		}
	
	}
	else{
		$titulo_pagina = "Nova Comanda";
	}
	
}


$cod_empresa	= $_SESSION['cod_empresa'];
$nome 			= $_REQUEST["nome"];

if (isset($_REQUEST['cod_servico_inserido']) && ($_REQUEST['cod_servico_inserido'] != "")){
	$cod_servico = $_REQUEST["cod_servico_inserido"];
}

if (isset($_REQUEST['cod_produto_inserido']) && ($_REQUEST['cod_produto_inserido'] != "")){
	$cod_produto = $_REQUEST["cod_produto_inserido"];
}


?>

		<script language="javascript" src="js/comanda.js"></script>
		<script language="javascript" src="../js/mascaramoeda.js"></script>


				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
							<li><a href="#">Principal</a></li>
							<li class="active"><a href="profissionais_horario.php">Horário</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1><?php echo $titulo_pagina; ?></h1>
                                <div class="options"></div>
                            </div>
                            <div class="container-fluid">

								<?php if ($Erro == "1") {?>
									<div class="alert alert-dismissable alert-danger">
										<i class="fa fa-fw fa-check"></i>&nbsp; <strong><?php echo $MensagemErro; ?></strong>
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									</div>	
								<?php } ?>


								<?php 
								if ($pergunta_remover != '') {
								?>
								<div class="alert alert-dismissable alert-info">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<strong>Deseja realmente remover o Desconto/Acréscimo?</strong><br>
									<br><a class="btn btn-success" href="comanda_item_info.php?acao=remover_desconto&cod_comanda_item=<?php echo $pergunta_remover;?>&cod_comanda=<?php echo $cod_comanda; ?>&cod_cliente=<?php echo $cod_cliente; ?>">Sim</a>&nbsp;&nbsp;&nbsp; <a class="btn btn-danger" href="comanda.php">Não</a>
								</div>				
								<?php
								}
								?>

								<div data-widget-group="group1">

										<div class="panel panel-default" data-widget='{"draggable": "false"}'>
											<div class="panel-heading">
												<h2>Novo item na comanda</h2>
											</div>
											<div class="panel-body">

												<form action="comanda_item_info.php" class="form-horizontal row-border" name='frm' method="post">

									              <input type="hidden" name="cod_empresa" id="cod_empresa" value="<?php echo $cod_empresa; ?>">
									              <input type="hidden" name="cod_comanda" id="cod_comanda" value="<?php echo $cod_comanda; ?>">
									              <input type="hidden" name="cod_cliente" id="cod_cliente" value="<?php echo $cod_cliente; ?>">

									              <?php if ($_REQUEST['acao']=="alterar"){?>
												  <input type="hidden" name="acao" value="atualizar">
									              <input type="hidden" name="cod_comanda_item" value="<?php echo $id; ?>">
									              
									              <?php }else{?>
									              <input type="hidden" name="acao" value="incluir_comanda">
									              <input type="hidden" name="cod_usuario_inclusao" value="<?php echo $cod_usuario_inclusao; ?>">

									              <?php } ?>			

													<div class="form-group">
														<label class="col-sm-2 control-label"><b>Profissional</b></label>
														<div class="col-sm-4">
														  <?php ComboProfissional($cod_empresa, $cod_profissional); ?>
														</div>
													</div>

													<div class="form-group">
														<div class="col-sm-8">
															<label class="col-sm-3 control-label"><b>Selecione</b></label>
															<div class="col-sm-4">
																<div class="checkbox-inline">
																	<input type="radio" name="tipo_item" id="tipo_item1" value="1" onclick="AbreTipoItem('1');" >&nbsp;Serviço 
																</div>
																<div class="checkbox-inline">
																	<input type="radio" name="tipo_item" id="tipo_item2" value="2" onclick="AbreTipoItem('2');">&nbsp;Produto
																</div>
															</div>
														</div>
													</div>

													<div class="form-group" id="CaixaServico">
														<label class="col-sm-2 control-label"><b>Serviço</b></label>
														<div class="col-sm-4">
															<?php ComboServico($cod_empresa, $cod_servico); ?>
														</div>
														<div class="col-sm-2">
															<button type="button" class="btn-success btn" onclick="NovoServico();">Novo Serviço</button>
														</div>
													</div>

													<div class="form-group" id="CaixaProduto" style="display: none;">
														<label class="col-sm-2 control-label"><b>Produto</b></label>
														<div class="col-sm-4">
															<?php ComboProduto($cod_empresa, $cod_produto); ?>
														</div>
														<div class="col-sm-2">
															<button type="button" class="btn-success btn" onclick="NovoProduto();">Novo Produto</button>
														</div>
													</div>

													<div class="form-group">
														<label class="col-sm-2 control-label"><b>Valor Unitário</b></label>
														<div class="col-sm-2">
															<label id="lblCarregandoValorUnitario" style="display:none;" class="label label-primary">Carregando...</label>
															<label id="lblValorUnitario" class="control-label">R$ 0,00</label>
														</div>
													</div>

													<div class="form-group">
														<label class="col-sm-2 control-label"><b>Quantidade</b></label>
														<div class="col-sm-1">
															<select name="quantidade" id="quantidade" class="form-control" onChange="CalcularSubTotal();">

															<option value="" selected> ... </option>

															<?php 
															$i=1;
															while ($i <= 10)
															{ 
															?>
																<option value="<?php echo $i; ?>"> <?php echo $i; ?> </option>
															<?php 
															$i++;
															}

															?>

															</select>
														</div>
													</div>

													<div class="form-group">
														<div class="col-sm-8">
															<label class="col-sm-3 control-label"><b>Selecione</b></label>
															<div class="col-sm-8">
																<div class="checkbox-inline">
																	<input type="radio" name="flg_desconto_acrescimo" id="tipo_item" value="1" <?php if($flg_desconto_acrescimo  == "1") {echo " checked "; } ?> onclick="SelecionaDescAcres('1');" >&nbsp;Desconto 
																</div>
																<div class="checkbox-inline">
																	<input type="radio" name="flg_desconto_acrescimo" id="tipo_item" value="2" <?php if($flg_desconto_acrescimo  == "2") {echo " checked "; } ?> onclick="SelecionaDescAcres('2');">&nbsp;Acréscimo
																</div>
																<div class="checkbox-inline">
																	<input type="button" class="btn-danger btn" onclick="RemoverDescontoEAcrescimo('<?php echo $id; ?>', '<?php echo $cod_comanda; ?>', '<?php echo $cod_cliente; ?>');" value="Remover Desconto/Acréscimo">
																</div>
															</div>
														</div>
													</div>

													<div id="caixa_desconto" style="display:none;">
														<div class="form-group">
															<label class="col-sm-2 control-label"><b>%</b></label>
															<div class="col-sm-8">
															  <input type="text" class="form-control" value="<?php echo $percentual_desconto;?>" name="percentual_desconto" maxlength="10">				
															</div>
														</div>

														<div class="form-group">
															<label class="col-sm-2 control-label"><b>R$</b></label>
															<div class="col-sm-8">
															  <input type="text" class="form-control" value="<?php echo $valor_desconto;?>" name="valor_desconto" maxlength="10" onKeyPress="return(moeda(this,'.',',',event));">				
															</div>
														</div>
													</div>

													<div id="caixa_acrescimo" style="display:none;">
														<div class="form-group">
															<label class="col-sm-2 control-label"><b>R$</b></label>
															<div class="col-sm-8">
															  <input type="text" class="form-control" value="<?php echo $valor_acrescimo;?>" name="valor_acrescimo" maxlength="10" onKeyPress="return(moeda(this,'.',',',event));">				
															</div>
														</div>
													</div>

												</form>

												<div class="panel-footer">
													<div class="row">
														<div class="col-sm-8 col-sm-offset-2">
															<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Gravar</button>
															<button class="btn-default btn" onclick="javascript:window.location='comanda_lista.php?cod_comanda=<?php echo $cod_comanda;?>&cod_cliente=<?php echo $cod_cliente;?>';">Voltar</button>
														</div>
													</div>
												</div>

											</div>
										</div>



                            </div> <!-- .container-fluid -->
					
	<?php

	if (isset($_REQUEST['cod_servico_inserido']) && ($_REQUEST['cod_servico_inserido'] != "")){
	?>
		<script type="text/javascript">
			document.frm.tipo_item[0].checked=true;
			AbreTipoItem('1');
		</script>
	<?php
	}elseif (isset($_REQUEST['cod_produto_inserido']) && ($_REQUEST['cod_produto_inserido'] != "")){
		?>
			<script type="text/javascript">
				document.frm.tipo_item[1].checked=true;
				AbreTipoItem('2');
			</script>
		<?php
	}

	if ( ($_REQUEST['acao']=="alterar") || ($_REQUEST['cod_produto_inserido']!="")){

		 if ($cod_servico != ""){ ?>

			<script type="text/javascript">
				document.frm.tipo_item[0].checked=true;
				AbreTipoItem('1');
				CarregarValorServico('<?php echo $cod_empresa; ?>', document.getElementById('cod_servico').value);
			</script>

		<?php }else{ ?>

			<script type="text/javascript">
				document.frm.tipo_item[1].checked=true;
				AbreTipoItem('2');
				CarregarValorProduto('<?php echo $cod_empresa; ?>', document.getElementById('cod_produto').value);
			</script>

		<?php }  ?>

		<?php if ($quantidade != ""){ ?>
			<script type="text/javascript">
				document.getElementById("quantidade").value="<?php echo $quantidade; ?>";
			</script>
		<?php } ?>


		<?php		 
		if($flg_desconto_acrescimo != ""){
		?>
			<script>SelecionaDescAcres('<?php echo $flg_desconto_acrescimo; ?>');</script>
		<?php
		}

	}
	else{
		?>
		<script type="text/javascript">
			document.frm.tipo_item[0].checked=true;
			AbreTipoItem('1');
		</script>
		<?php 
	}
}


include('../include/rodape_interno2.php');?>