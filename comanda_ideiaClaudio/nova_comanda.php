<?php

include('../include/topo_interno.php');

$credencial_ver = 0;
$credencial_incluir = 0;
$credencial_editar = 0;
$credencial_excluir = 0;

$credencial_ver = 1;
$credencial_incluir = 1;
$credencial_editar = 1;
$credencial_excluir = 1;

$cod_empresa 			= $_SESSION['cod_empresa'];
$cod_usuario_inclusao 	= $_SESSION['usuario_id'];	
$cod_caixa 				= $_SESSION['cod_caixa'];	
$cod_comanda_item		= $_REQUEST['cod_comanda_item'];

if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar

if((isset($_REQUEST['cod_cliente'])) && ($_REQUEST['cod_cliente'] != "")){
	$cod_cliente = $_REQUEST['cod_cliente'];
}

if((isset($_REQUEST['cod_comanda'])) && ($_REQUEST['cod_comanda'] != "")){
	$cod_comanda = $_REQUEST['cod_comanda'];
}

if (isset($_REQUEST['acao']) && ($_REQUEST['acao'] == "EditarItemComanda"))
{			
	$cod_comanda_item = $_REQUEST['cod_comanda_item'];	

	$sql = "
	select		cod_profissional, cod_produto, cod_servico, valor, quantidade, flg_desconto_acrescimo, percentual_desconto, valor_desconto, valor_acrescimo
	from		comanda_item
	where 		cod_empresa = ".$cod_empresa."
	and 		cod_comanda = ".$cod_comanda."
	and 		cod_cliente = ".$cod_cliente."
	and 		cod_comanda_item = ".$cod_comanda_item.";
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

?>

    <script language="javascript" src="js/comanda.js"></script>
	<script language="javascript" src="../js/mascaramoeda.js"></script>

    <div class="static-content-wrapper">
        <div class="static-content">
            <div class="page-content">
                <ol class="breadcrumb">

                    <li><a href="../inicio.php">Início</a></li>
                    <li><a href="comanda.php">Comanda</a></li>
                    <li class="active"><a href="nova_comanda.php">Nova Comanda</a></li>

                </ol>
                <div class="page-heading">
                    <h1>Nova Comanda</h1>
					<div class="options">
						<a class="btn btn-midnightblue btn-label" href="nova_comanda.php"><i class="fa fa-plus-circle"></i> Nova Comanda </a>
					</div>
                </div>
                <div class="container-fluid">

					<?php
						if ( (isset($_REQUEST['acao'])) && ($_REQUEST['acao'] == "pergunta_excluir_item")) {
					?>

					<div id="CaixaPerguntaExclusao" class="alert alert-dismissable alert-info">
						<input type="hidden" name="cod_comanda_item_excluir" id="cod_comanda_item_excluir">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<strong>Deseja realmente excluir esse item da comanda ?</strong><br>
						<br>
						<a class="btn btn-success" href="gravar_comanda.php?acao=excluir_item_comanda&cod_comanda=<?php echo $cod_comanda;?>&cod_cliente=<?php echo $cod_cliente; ?>&cod_comanda_item=<?php echo $cod_comanda_item; ?>">Sim</a>&nbsp;&nbsp;&nbsp;
						<a class="btn btn-danger" href="nova_comanda.php?acao=listar_itens&cod_comanda=<?php echo $cod_comanda;?>&cod_cliente=<?php echo $cod_cliente; ?>">Não</a>
					</div>

					<?php
						}
					?>


                    <div data-widget-group="group1">

                        <div id="CaixaNovoItem" style="display:block;" class="panel panel-default">
                            <div class="panel-heading">
                                <h2>Editar Venda</h2>
                            </div>
                            <div class="panel-body">

                                <form name='FormNovoItem' method="post" action="gravar_comanda.php"  class="form-horizontal row-border">

									<input type="hidden" name="cod_cliente" value="<?php echo $_REQUEST['cod_cliente']; ?>">
									<input type="hidden" name="cod_comanda" value="<?php echo $_REQUEST['cod_comanda']; ?>">
									<input type="hidden" name="acao" value="Gravar">

									<div class="form-group">
										<label class="col-sm-2 control-label"><b>Cliente:</b></label>
										<div class="col-sm-4">
											<?php 
												$sql = "
												Select 		cod_cliente, nome
												from 		clientes
												where 		cod_empresa = ".$cod_empresa."	
												order by 	nome asc";
												//echo $sql;die;	

												$query = mysql_query($sql);
												$registros = mysql_num_rows($query);
												if ($registros > 0) {
													echo "<select name='cod_cliente' class='form-control'>";
													echo "<option value='0'>Selecione...</option>";
													while ($rs = mysql_fetch_array($query)){ 
														echo "<option value='". $rs['cod_cliente'] ."'";

														if($cod_cliente == $rs['cod_cliente']) echo " selected ";

														echo ">"; 
														echo $rs['nome'];									
														echo "</option>";
													}
													echo "</select>";
												} 
											?>
										</div>
										<div class="col-sm-4">
											<button type="button" class="btn-success btn" onclick="NovoCliente();">Novo Cliente</button>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label"><b>Profissional</b></label>
										<div class="col-sm-4">
											<?php ComandaComboProfissional($cod_empresa, $cod_profissional); ?>
										</div>
										<div class="col-sm-4">
											<button type="button" class="btn-success btn" onclick="NovoProfissional();">Novo Profissional</button>
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-8">
											<label class="col-sm-3 control-label"><b></b></label>
											<div class="col-sm-4">
												<?php 
												echo "<select name='tipo_item' class='form-control' onchange='AbreTipoItem(this.value);'>";
												echo "<option value='1' selected>Serviço</option>";
												echo "<option value='2'>Produto</option>";
												echo "</select>";
												?>
											</div>
										</div>
									</div>

										<div class="form-group" id="CaixaServico">
											<label class="col-sm-2 control-label"><b>Serviço</b></label>
											<div class="col-sm-4">
												<?php ComandaComboServico($cod_empresa, $cod_servico); ?>
											</div>
											<div class="col-sm-2">
												<button type="button" class="btn-success btn" onclick="NovoServico();">Novo Serviço</button>
											</div>
										</div>

										<div class="form-group" id="CaixaProduto" style="display: none;">
											<label class="col-sm-2 control-label"><b>Produto</b></label>
											<div class="col-sm-4">
												<?php ComandaComboProduto($cod_empresa, $cod_produto); ?>
											</div>
											<div class="col-sm-2">
												<button type="button" class="btn-success btn" onclick="NovoProduto();">Novo Produto</button>
											</div>
										</div>

										<script>AbreTipoItem("1");</script>

										<div class="form-group">
											<label class="col-sm-2 control-label"><b>Quantidade</b></label>
											<div class="col-sm-1">
												<?php
												echo "<select name='quantidade' id='quantidade' class='form-control' onclick='javascript:CalculaQuantidadeValor(this.value);'>";
												$contQuantidade = 1;
												while ($contQuantidade <= 10){ 
													echo "<option value='".$contQuantidade."'";
													echo ">"; 
													echo $contQuantidade;
													echo "</option>";
													$contQuantidade++;
												}
												echo "</select>";
												?>	
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-2 control-label"><b>Valor Unitário</b></label>
											<div class="col-sm-2" id="IdValor">
												<input type="text" class="form-control" value="<?php echo $valor;?>" name="valor" id="valor_unitario" maxlength="10" onKeyPress="return(moeda(this,'.',',',event));">
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-2 control-label"><b>Desconto/Acréscimo</b></label>
											<div class="col-sm-2">
												<?php 
												echo "<select name='flg_desconto_acrescimo' class='form-control' onchange='SelecionaDescAcres(this.value);'>";
												echo "<option value='0'>Sem Desconto/Acréscimo</option>";
												echo "<option value='1'>Desconto Percentual</option>";
												echo "<option value='2'>Desconto Valor</option>";
												echo "<option value='3'>Acréscimo</option>";
												echo "</select>";
												?>
											</div>
											<!--div class="col-sm-2">
												<input type="button" class="btn-danger btn" onclick="RemoverDescontoEAcrescimo('<?php echo $id; ?>', '<?php echo $cod_comanda; ?>', '<?php echo $cod_cliente; ?>');" value="Remover Desconto/Acréscimo">
											</div-->
										</div>

										<div id="CaixaDescontoPercentual" style="display:none;">
											<div class="form-group">
												<label class="col-sm-2 control-label"><b>%</b></label>
												<div class="col-sm-1">
													<input type="text" class="form-control" value="<?php echo $percentual_desconto;?>" name="percentual_desconto" maxlength="10">				
												</div>
											</div>
										</div>

										<div id="CaixaDescontoValor" style="display:none;">
											<div class="form-group">
												<label class="col-sm-2 control-label"><b>R$</b></label>
												<div class="col-sm-2">
													<input type="text" class="form-control" value="<?php echo $valor_desconto;?>" name="valor_desconto" maxlength="10" onKeyPress="return(moeda(this,'.',',',event));">				
												</div>
											</div>
										</div>

										<div id="CaixaAcrescimo" style="display:none;">
											<div class="form-group">
												<label class="col-sm-2 control-label"><b>R$</b></label>
												<div class="col-sm-2">
													<input type="text" class="form-control" value="<?php echo $valor_acrescimo;?>" name="valor_acrescimo" maxlength="10" onKeyPress="return(moeda(this,'.',',',event));">				
												</div>
											</div>
										</div>
                                </form>
								<div class="panel-footer">
									<div class="row">
										<div class="col-sm-8 col-sm-offset-2">
											<button class="btn-primary btn" onclick="javascript:document.forms['FormNovoItem'].submit();">Gravar</button>&nbsp;
											<button class="btn-default btn" onclick="javascript:location.href='comanda.php';">Listar Comandas</button>
										</div>
									</div>
								</div>

                            </div>

                        </div>


						<div id="CaixaListarItemComanda" style="display:block;" class="panel panel-sky" data-widget='{"draggable": "false"}'>

							<div class="panel-heading">
								<h2>Lista de Serviços/Produtos</h2>
							</div>

							<div class="panel-body">

								<form action="#" class="form-horizontal row-border" name='frm' method="post">

									<div class="table-vertical">

										<table class="table table-striped" border="1" bordercolor="#EEEEEE" style="margin: 0 auto; width: 100%;">
											<thead>
												<tr>
													<th style="width: 25%;">Descrição</th>
													<th style="width: 1%;">Quantidade</th>
													<th style="width: 5%;">Valor Total</th>
													<th style="width: 20%;">Profissional</th>
													<th style="width: 10%; text-align:center;">&nbsp;</th>
											</thead>
											<tbody>
												
												<?php
												if ($cod_comanda != "") 
												{

														//CARREGA LISTA
													$sql = "
													select 		ci.cod_comanda_item, 
																case
																	when ci.cod_servico is not null then s.nome
																	when ci.cod_produto is not null then p2.descricao
																end as descricao
																,ci.quantidade
																,(ci.valor * ci.quantidade) as valor_total
																,case 
																	when ci.cod_profissional is not null then p.nome
																	else 'Sem Comissão' end as profissional                
													from 		comanda_item ci
													left join 	profissional p on p.cod_profissional = ci.cod_profissional	
													left join 	servico s on s.cod_servico = ci.cod_servico
													left join 	produtos p2 on p2.cod_produto = ci.cod_produto
													where 		ci.cod_empresa = ".$cod_empresa."
													and 		ci.cod_comanda = ".$cod_comanda."
													order by  	ci.dt_inclusao asc;
													";

													//echo $sql; die;

													$query = mysql_query($sql);

													$registros = mysql_num_rows($query);

													if ($registros > 0) 
													{	
														$subtotal = 0.0;

														while ($rs = mysql_fetch_array($query))
														{ 

															$valor_total = number_format($rs['valor_total'], 2, ',', '.');
															$subtotal += $rs['valor_total'];
														?>
														<tr>
															<td align="left" data-title="Descrição">
																<?php echo $rs['descricao']; ?>
															</td>
															<td align="left" data-title="Quantidade">
																<?php echo $rs['quantidade'];?>
															</td>
															<td align="right" data-title="Valor Total">
																<?php echo "R$ ".$valor_total;?>
															</td>
															<td align="left" data-title="Profisional">
																<?php echo $rs['profissional'];?>
															</td>
															<td>
																<a class="btn btn-success btn-label" Onclick="EditarItem('<?php echo $cod_cliente;?>', '<?php echo $cod_comanda; ?>', '<?php echo $rs['cod_comanda_item']; ?>');">
																	<i class="fa fa-times-circle"></i>Editar
																</a>
																<a class="btn btn-danger btn-label" onclick="PerguntaExluirItemComanda('<?php echo $cod_cliente;?>', '<?php echo $cod_comanda; ?>', '<?php echo $rs['cod_comanda_item']; ?>');" >

																	<i class="fa fa-times-circle"></i>Excluir

																</a>
															</td>
														</tr>
													<?php
														}

													?>
														<tr>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td align="right"><?php echo "R$ ".number_format($subtotal, 2, ',', '.'); ?></td>
															<tr>
															<td align="right" colspan="8"><b>Total de registro: <?php echo $registros; ?></b></td>
														</tr>
														</tr>
													<?php

													}
													else 
													{ // registro
													?>
														<tr>
															<td align="center" colspan="8">Nenhum item selecionado!
																<br>
															</td>
														</tr>
														<?php
													}
												}
												else
												{
												?>
												<tr>
													<td align="center" colspan="8">Nenhum item selecionado!
														<br>
													</td>
												</tr>
												<?php } ?>

											</tbody>

										</table>

									</div>
							</div>

						</div>



					</div>
				</div>
	
<?php 
	
} // INCLUIR OU EDITAR


//if (isset($_REQUEST['acao']) && ($_REQUEST['acao'] == "EditarItemComanda")){
	?>
	<script>//IncluirItem();</script>
<?php
//}


include('../include/rodape_interno.php');
?>