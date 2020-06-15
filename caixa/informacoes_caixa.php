<?php 
require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";


	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	
	
	
	
	
$credencial_ver = 1;
$credencial_incluir = 1;
$credencial_editar = 1;
$credencial_excluir = 1;
	
if (isset($_REQUEST['sucesso'])) { $sucesso = $_REQUEST['sucesso']; } else { $sucesso = ''; }

if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar
	
	$acao = '';

	$cod_empresa = $_SESSION['cod_empresa'];
	$cod_usuario_inclusao = $_SESSION['usuario_id'];	
	$cod_caixa = $_SESSION['cod_caixa'];

?>

		<script language="javascript" src="js/caixa.js"></script>

			<div class="static-content-wrapper">
                <div class="static-content">
                    <div class="page-content">
                        <ol class="breadcrumb">
                            
							<li><a href="#">Principal</a></li>
							<li class="active"><a href="caixa_gaveta_caixa.php">Gaveta do Caixa</a></li>

                        </ol>
                       
						<?php    

							$sql = "
							select		format(sum(cg.valor), 2) as SaldoInicialDinheiro
							from 		caixa_gaveta cg
							WHERE		cg.cod_caixa = ".$cod_caixa."
							and 		cg.tipo_transacao = 'INICIO'
							";
							$query = mysql_query($sql);
							$registros = mysql_num_rows($query);
							$rs = mysql_fetch_array($query);
							$SaldoInicialEmDinheiro = $rs['SaldoInicialDinheiro'];


							//PGTO_PROFISSIONAL
							$sql = "
							select		format(sum(cg.valor), 2) as pgto_profissional
							from 		caixa_gaveta cg
							WHERE		cg.cod_caixa = ".$cod_caixa."
							and 		cg.tipo_transacao = 'PGTO_PROFISSIONAL'
							";
							$query = mysql_query($sql);
							$registros = mysql_num_rows($query);
							$rs = mysql_fetch_array($query);
							$total_pagamento_profissional = $rs['pgto_profissional'];


							$sql = "
							select		format(sum(cg.valor), 2) as recebimento_divida
							from 		caixa_gaveta cg
							WHERE		cg.cod_caixa = ".$cod_caixa."
							and 		cg.tipo_transacao = 'RECEBIMENTO_DIVIDA'
							";
							$query = mysql_query($sql);
							$registros = mysql_num_rows($query);
							$rs = mysql_fetch_array($query);
							$recebimento_divida = $rs['recebimento_divida'];

							$sql = "
							select		format(sum(cg.valor), 2) as cheque
							from 		caixa_gaveta cg
							inner join 	comanda c on c.cod_comanda = cg.cod_comanda
							inner join 	comanda_pagamento cp on cp.cod_comanda = c.cod_comanda
							WHERE		c.cod_empresa = ".$cod_empresa."
							AND			cg.cod_caixa = ".$cod_caixa."
							and 		cg.tipo_transacao = 'VENDA'
							and 		cp.cod_forma_pagamento = 4

							";
							$query = mysql_query($sql);
							$registros = mysql_num_rows($query);
							$rs = mysql_fetch_array($query);
							$cheque = $rs['cheque'];

							$sql = "
							select		format(sum(cg.valor), 2) as SangriaEmDinheiro
							from 		caixa_gaveta cg
							WHERE		cg.cod_caixa = ".$cod_caixa."
							and 		cg.tipo_transacao = 'SANGRIA'
							";
							$query = mysql_query($sql);
							$registros = mysql_num_rows($query);
							$rs = mysql_fetch_array($query);
							$SangriaEmDinheiro = ValorMysqlPhp($rs['SangriaEmDinheiro']);

							$sql = "
							select		format(sum(cg.valor), 2) as Vale
							from 		caixa_gaveta cg
							WHERE		cg.cod_caixa = ".$cod_caixa."
							and 		cg.tipo_transacao = 'VALE'
							";
							$query = mysql_query($sql);
							$registros = mysql_num_rows($query);
							$rs = mysql_fetch_array($query);
							$Vale = ValorMysqlPhp($rs['Vale']);

							$sql = "
							select		format(sum(cg.valor), 2) as ReforcoEmDinheiro
							from 		caixa_gaveta cg
							WHERE		cg.cod_caixa = ".$cod_caixa."
							and 		cg.tipo_transacao = 'REFORCO'
							";
							$query = mysql_query($sql);
							$registros = mysql_num_rows($query);
							$rs = mysql_fetch_array($query);
							$ReforcoEmDinheiro = ValorMysqlPhp($rs['ReforcoEmDinheiro']);

							$sql = "
							select		format(sum(cg.valor), 2) as Venda
							from 		caixa_gaveta cg
							WHERE		cg.cod_caixa = ".$cod_caixa."
							and 		cg.tipo_transacao = 'VENDA'
							";
							$query = mysql_query($sql);
							$rs = mysql_fetch_array($query);
							$Venda = ValorMysqlPhp($rs['Venda']);

							echo $venda;

							$SaldoEmDinheiro = ($SaldoInicialEmDinheiro + $ReforcoEmDinheiro + $Venda) - $SangriaEmDinheiro;
							$SaldoEmDinheiro = ValorMysqlPhp(number_format($SaldoEmDinheiro, 2));

							?>

							<div data-widget-group="group1">
								<div class="panel panel-default" data-widget='{"draggable": "false"}'>
									<div class="panel-heading">
										<h2>Informações Caixa</h2>
									</div>										

									<form class="form-horizontal">

										<div class="panel-body">

											<div class="form-group">
												<label class="control-label"><b>Saldo da Gaveta: </b></label>
												<label class="control-label"><?php echo SaldoCaixa($cod_empresa, $cod_caixa); ?></label>											
											</div>

											<div class="form-group">

												<label class="control-label"><b>Saldo Detalhado</b></label>

												<div style="margin:2px 0 5px 1px;">

												</div>

												<table class="table" border="1" bordercolor="#EEEEEE" style="width: 70%;">
													<thead>
														<tr>
															<th style="width: 25%;">Dinheiro - Saldo Inicial em Dinheiro</th>
															<td style="width: 25%;">+ R$ <?php echo $SaldoInicialEmDinheiro; ?></td>
														</tr>
														<tr>
															<th style="width: 25%;">Dinheiro - Dívidas recebidas em Dinheiro</th>
															<td style="width: 25%;">+ R$ <?php echo $recebimento_divida; ?></td>
														</tr>
														<tr>
															<th style="width: 25%; text-align: right;">Saldo em Dinheiro</th>
															<td style="width: 25%;">R$ <?php echo ValorMysqlPhp(number_format(($SaldoInicialEmDinheiro + $recebimento_divida), 2)); ?></td>
														</tr>
														<tr>
															<td colspan="2">&nbsp;</td>
														</tr>
														<tr>
															<th style="width: 25%;">Pagamentos a profissionais com dinheiro do caixa</th>
															<td style="width: 25%;">- R$ <?php echo ValorMysqlPhp($total_pagamento_profissional); ?></td>
														</tr>
														<tr>
															<td colspan="2">&nbsp;</td>
														</tr>
														<tr>
															<th style="width: 25%;">Cheques a Vista - Vendas em Cheques a vista</th>
															<td style="width: 25%;">R$ <?php echo ValorMysqlPhp(number_format(($cheque), 2)); ?></td>
														</tr>
														<tr>
															<th style="width: 25%;">Cheques a Vista - Saída de cheques à vista em negociação de dívidas</th>
															<td style="width: 25%;">- R$ <?php echo ValorMysqlPhp(number_format(($cheque_negociacao), 2)); ?></td>
														</tr>
														<tr>
															<th style="width: 25%; text-align: right;">Saldo em Cheques à Vista</th>
															<td style="width: 25%;">R$ <?php echo ValorMysqlPhp(number_format(($cheque + $cheque_negociacao), 2)); ?></td>
														</tr>
														<tr>
															<td colspan="2">&nbsp;</td>
														</tr>
														<tr>
															<th style="width: 25%;">Fiado - Vendas fiadas</th>
															<td style="width: 25%;">R$ <?php echo ValorMysqlPhp(number_format(($cheque), 2)); ?></td>
														</tr>
														<tr>
															<th style="width: 25%;">Fiado - Recebimento de dívidas fiadas</th>
															<td style="width: 25%;">R$ <?php echo ValorMysqlPhp(number_format(($cheque), 2)); ?></td>
														</tr>
														<tr>
															<th style="width: 25%; text-align: right">Saldo fiado</th>
															<td style="width: 25%;">R$ <?php echo ValorMysqlPhp(number_format(($cheque), 2)); ?></td>
														</tr>
														<tr>
															<td colspan="2">&nbsp;</td>
														</tr>
														<tr>
															<th style="width: 25%;">Vendas em Dinheiro</th>
															<td style="width: 25%;">- R$ <?php echo $Venda; ?></td>
														</tr>
														<tr>
															<th style="width: 25%;">Fiados em Dinheiro</th>
															<td style="width: 25%;">- R$ <?php echo $fiado; ?></td>
														</tr>
														<tr>
															<th style="width: 25%;">Reforços em Dinheiro</th>
															<td style="width: 25%;">+ R$ <?php echo $ReforcoEmDinheiro; ?></td>
														</tr>
														<tr>
															<th style="width: 25%;">Vales em Dinheiro</th>
															<td style="width: 25%;">- R$ <?php echo $Vale; ?></td>
														</tr>
														<tr>
															<th style="width: 25%;">Sangrias em Dinheiro</th>
															<td style="width: 25%;">- R$ <?php echo $SangriaEmDinheiro; ?></td>
														</tr>
														<tr>
															<th style="width: 25%;">Saldo em Dinheiro</th>
															<td style="width: 25%;">+ R$ <?php echo $SaldoEmDinheiro; ?></td>
														</tr>
													</thead>
												</table>

											</div>

											<div class="form-group">

												<label class="control-label"><b>Extrato da Gaveta</b></label>

												<?php
												//CARREGA LISTA
												$sql = "
												select		DATE_FORMAT(cg.dt_transacao, '%d/%m/%Y - %H:%m') as data_hora
															,cg.tipo_transacao
															,cg.descricao
												            ,cg.cod_comanda, co.cod_cliente
															,case cg.tipo_transacao 
																when 'INICIO' then 'Administrador'
												                when 'PGTO_PROFISSIONAL' then (select p.nome from profissional p where p.cod_profissional = cg.cod_usuario)
																else (select cli.nome from clientes cli where cli.cod_cliente = cg.cod_usuario)
															end NomeUsuario
															,case cg.tipo_transacao 
																when 'INICIO' then c.valor
																when 'PGTO_PROFISSIONAL' then cg.valor
																else
																	(select sum(cp1.valor) from comanda_pagamento cp1 where cp1.cod_comanda=cg.cod_comanda and cp1.cod_forma_pagamento=1) 
																end as 'Dinheiro'
												            ,(select sum(cp1.valor) from comanda_pagamento cp1 where cp1.cod_comanda=cg.cod_comanda and cp1.cod_forma_pagamento=2) as 'C_Debito'
												            ,(select sum(cp1.valor*cp1.num_parcelas) from comanda_pagamento cp1 where cp1.cod_comanda=cg.cod_comanda and cp1.cod_forma_pagamento=3) as 'C_Credito'
												            ,(select sum(cp1.valor) from comanda_pagamento cp1 where cp1.cod_comanda=cg.cod_comanda and cp1.cod_forma_pagamento=4) as 'Ch_Vista'
												            ,(select sum(cp1.valor) from comanda_pagamento cp1 where cp1.cod_comanda=cg.cod_comanda and cp1.cod_forma_pagamento=5) as 'Ch_Prazo'
												            ,(select sum(cp1.valor) from comanda_pagamento cp1 where cp1.cod_comanda=cg.cod_comanda and cp1.cod_forma_pagamento=6) as 'Fiado'
												from		caixa c
												inner join 	caixa_gaveta cg on cg.cod_caixa = c.cod_caixa
												left join 	comanda co on co.cod_comanda = cg.cod_comanda
												where 		c.cod_caixa = ".$cod_caixa."
												and 		c.cod_empresa = ".$cod_empresa."
												order by 	cg.dt_transacao asc;
												";
												//echo $sql;
												$query = mysql_query($sql);
												$registros = mysql_num_rows($query);
												?>
												<table class="table" border="1" bordercolor="#EEEEEE" style="margin: 0 auto; width: 100%;">
													<thead>
														<tr>
															<th style="width: 12%;">Data e Hora</th>
															<th style="width: 12%;">Descrição</th>
															<th style="width: 12%;">Envolvido</th>
															<th style="width: 12%; text-align:center;">Dinheiro</th>
															<th style="width: 12%; text-align:center;">C.Débito</th>
															<th style="width: 12%; text-align:center;">C.Crédito</th>
															<th style="width: 12%; text-align:center;">Ch.Vista</th>
															<th style="width: 12%; text-align:center;">Ch.Prazo</th>
															<th style="width: 12%; text-align:center;">Fiado</th>
															<th style="width: 12%; text-align:center;">Detalhes</th>
													</thead>
													<tbody>
														<?php

														if ($registros > 0) 
														{
															while ($rs = mysql_fetch_array($query))
															{ 
															?>
															<tr>
																<td align="left"><?php echo $rs['data_hora'];?></td>
																<td align="center"><?php echo $rs['descricao'];?></td>
																<td align="center"><?php echo $rs['NomeUsuario'];?></td>
																<td align="right"><?php echo ValorMysqlPhp($rs['Dinheiro']);?></td>
																<td align="right"><?php echo ValorMysqlPhp($rs['C_Debito']);?></td>
																<td align="right"><?php echo ValorMysqlPhp($rs['C_Credito']);?></td>
																<td align="right"><?php echo ValorMysqlPhp($rs['Ch_Vista']);?></td>
																<td align="right"><?php echo ValorMysqlPhp($rs['Ch_Prazo']);?></td>
																<td align="right">
																	<?php 
																		if ($rs['tipo_transacao'] == "RECEBIMENTO_DIVIDA") {
																			echo "-".ValorMysqlPhp($rs['Fiado']);
																		}
																		else{
																			echo ValorMysqlPhp($rs['Fiado']);	
																		}
																	?>																			
																</td>
																<td align="right">

																	<?php if ($rs['cod_comanda'] != "") { ?>
																		<button type="button" class="btn-success btn" onclick="javascript:window.location='ver_venda.php?cod_cliente=<?php echo $rs['cod_cliente'];?>&cod_comanda=<?php echo $rs['cod_comanda'];?>&voltar=<?php echo urlencode("informacoes_caixa.php") ?>';">Detalhes</button>
																	<?php } ?>

																</td>
															</tr>
														<?php
															} // while
														?>
																			<tr>
																				<td align="right" colspan="8"><b>Total de registro: <?php echo $registros; ?></b></td>
																			</tr>
													<?php
														} 
														else 
														{ // registro
														?>
																			<tr>
																				<td align="center" colspan="8">Nenhum pagamento!<br></td>
																			</tr>
													<?php
														}
													?>		
														</tbody>


												</table>

											</div>

											<div class="form-group">

												<label class="control-label"><b>Cheques na Gaveta</b></label>

												<?php
												//CARREGA LISTA
												$sql = "
												Select 		c.cod_comanda, cli.cod_cliente, cli.nome, b.descricao, cp.num_cheque, cp.valor
															,DATE_FORMAT(cp.dt_pagamento, '%d/%m/%Y - %H:%m') as data_pagamento, DATE_FORMAT(cp.dt_vencimento_cheque, '%d/%m/%Y - %H:%m') as data_vencimento
												from 		clientes cli
												inner join	comanda c on c.cod_cliente = cli.cod_cliente
												inner join 	comanda_pagamento cp on cp.cod_comanda = c.cod_comanda
												inner join 	banco b on b.cod_banco = cp.cod_banco
												where 		cp.cod_empresa = ".$cod_empresa."
												and 		c.cod_caixa = ".$cod_caixa."
												and 		cp.cod_forma_pagamento = 4
												group by 	cli.cod_cliente, cli.nome
												order by 	cp.dt_pagamento asc;
												";
												//echo $sql;die;

												$query = mysql_query($sql);

												$registros = mysql_num_rows($query);

												?>

												<table class="table" border="1" bordercolor="#EEEEEE" style="margin: 0 auto; width: 100%;">
													<thead>
														<tr>
															<th style="width: 12%; text-align:left;">Emitente</th>
															<th style="width: 12%; text-align:left;">Valor</th>
															<th style="width: 12%; text-align:left;">Lançamento</th>
															<th style="width: 12%; text-align:left;">Vencimento</th>
															<th style="width: 12%; text-align:left;">Banco</th>
															<th style="width: 12%; text-align:left;">Nro Cheque</th>
															<th style="width: 25%;">Ver Venda</th>
													</thead>
													<tbody>
														<?php

														if ($registros > 0) 
														{
															while ($rs = mysql_fetch_array($query))
															{ 
															?>
															<tr>
																<td style="width: 12%;"><?php echo $rs['nome'];?></td>
																<td style="width: 12%;"><?php echo ValorMysqlPhp($rs['valor']);?></td>
																<td style="width: 12%;"><?php echo $rs['data_pagamento'];?></td>
																<td style="width: 12%;"><?php echo $rs['data_vencimento'];?></td>
																<td style="width: 12%;"><?php echo $rs['banco'];?></td>
																<td style="width: 12%;"><?php echo $rs['num_cheque'];?></td>

																
																<td style="width: 12%;">
																	<?php if ($rs['cod_comanda'] != "") { ?>
																		<button type="button" class="btn-success btn" 
																			onclick="javascript:window.location='ver_venda.php?cod_cliente=<?php echo $rs['cod_cliente'];?>&cod_comanda=<?php echo $rs['cod_comanda'];?>&voltar=<?php echo urlencode("informacoes_caixa.php") ?>';">Ver Venda</button>
																	<?php } ?>
																</td>
															</tr>
														<?php
															} // while
														?>
																			<tr>
																				<td align="right" colspan="8"><b>Total de registro: <?php echo $registros; ?></b></td>
																			</tr>
													<?php
														} 
														else 
														{ // registro
														?>
																			<tr>
																				<td align="center" colspan="8">Nenhum chegue encontrado!<br></td>
																			</tr>
													<?php
														}
													?>		
														</tbody>


												</table>

											</div>
									
											<div class="panel-footer">
												<div class="row">
													<div class="col-sm-8">
														<button type="button" class="btn-default btn" onclick="javascript:window.location='caixa_gaveta_caixa.php';">Voltar</button>
													</div>
												</div>
											</div>
										
										</div>

									</form>

								</div>



	</div> <!-- .container-fluid -->

<?php 
}


include('../include/rodape_interno2.php');
?>