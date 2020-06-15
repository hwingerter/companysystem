<?php include('../include/topo_interno.php');

	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	
	
	
	
	
	$credencial_ver = 1;
	$credencial_incluir = 1;
	$credencial_editar = 1;
	$credencial_excluir = 1;


	$cod_empresa = $_SESSION['cod_empresa'];
	$cod_cliente = $_REQUEST['cod_cliente'];
	$cod_comanda = $_REQUEST['cod_comanda'];
	$voltar 	 = $_REQUEST['voltar'];

	
	$acao = '';

	//SOMAT�RIO
	$sql = "
	select 		date_format(c.dt_inclusao, '%d/%m/%Y') as dtVenda
				,sum((ci.valor * quantidade)) as TotalGeral, c1.nome as cliente, c.cod_comanda
				,(	select 		sum(c1.valor) 
					from 		comanda_pagamento c1
					where 		c1.cod_empresa = c.cod_empresa
					and 		c1.cod_cliente = c.cod_cliente
					and 		c1.cod_comanda = c.cod_comanda
				) as valor_pagamento

	from 		comanda_item ci
	inner join 	comanda c on c.cod_comanda = ci.cod_comanda
	inner join 	clientes c1 on c1.cod_cliente = c.cod_cliente
	where 		c.cod_empresa = ".$cod_empresa."
	and 		c.cod_cliente = ".$cod_cliente."
	and 		c.cod_comanda = ".$cod_comanda.";
	";
	$query = mysql_query($sql);
	$rs = mysql_fetch_array($query);

	$dtVenda			= $rs['dtVenda'];
	$cliente			= $rs['cliente'];

	$total		= TotalComanda($cod_empresa, $cod_cliente, $cod_comanda);
	$pagamento	= TotalPago($cod_empresa, $cod_cliente, $cod_comanda);
	$desconto	= Comanda_Desconto($cod_empresa, $cod_cliente, $cod_comanda);
	$creditos 	= Comanda_Creditos($cod_empresa, $cod_cliente, $cod_comanda);
	
	if($total > $pagamento){
		$falta = number_format((($total - $desconto) - $pagamento), 2);
	
	}else if($total == $pagamento){
		$falta = "0.00";
	
	}else if($total < $pagamento){
		$falta = "0.00";
		$troco = ($pagamento - ($total - $desconto));
		$troco = $troco - $creditos;
		
	}else{
		$falta = "0.00";
	}

	$total		= "R$ ".ValorMysqlPhp($total);
	$pagamento	= "R$ ".ValorMysqlPhp($pagamento);
	$falta		= "R$ ".ValorMysqlPhp($falta);
	$troco		= "R$ ".ValorMysqlPhp($troco);

?>
			<div class="static-content-wrapper">
                <div class="static-content">
                    <div class="page-content">
                        <ol class="breadcrumb">
                            
							<li><a href="#">Principal</a></li>
							<li class="active"><a href="comanda_historico_vendas.php">Histórico de Vendas - Detalhes</a></li>

                        </ol>
                        <div class="page-heading">            
                            <h1>Histórico de Vendas - Detalhes</h1>
                        </div>
                        <div class="container-fluid">                               


						<div data-widget-group="group1">
							<div class="panel panel-default" data-widget='{"draggable": "false"}'>
								<div class="panel-heading">
									<h2>Venda</h2>
								</div>
								

								<form class="form-horizontal">

									<div class="panel-body">

										<div class="form-group">
											<label class="col-sm-3 control-label"><b>Cliente</b></label>
											<div class="col-sm-8">
												<?php echo $cliente ." - ".$dtVenda; ?>

											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label"><b>Total da Venda</b></label>
											<div class="col-md-2">
												<?php echo $total; ?>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label"><b>Pagamentos</b></label>
											<div class="col-sm-8">
												<?php echo $pagamento; ?>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label"><b>Troco</b></label>
											<div class="col-sm-8">
												<?php echo $troco; ?>
											</div>
										</div>

										<div class="form-group">

											<label class="control-label"><b>Itens da Venda</b></label>

											<div style="margin:2px 0 5px 1px;">

											</div>

											<table class="table" border="1" bordercolor="#EEEEEE" style="margin: 0 auto; width: 100%;">
												<thead>
													<tr>
														<th style="width: 25%;">Descrição</th>
														<th style="width: 10%;">Quantidade</th>
														<th style="width: 10%;">Valor Total</th>
														<th style="width: 25%;">Profissional</th>
												</thead>
												<tbody>
													<?php
														//CARREGA LISTA
													$sql = "
													select 		ci.cod_comanda_item, 
																case
																	when ci.cod_servico is not null then s.nome
																	when ci.cod_produto is not null then p2.descricao
																end as descricao
																,ci.quantidade
																,(ci.valor * ci.quantidade) as ValorTotal
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
														while ($rs = mysql_fetch_array($query))
														{ 
														?>
														<tr>
															<td align="left"><?php echo $rs['descricao']; ?></td>
															<td align="left"><?php echo $rs['quantidade'];?></td>
															<td align="left"><?php echo ValorMysqlPhp($rs['ValorTotal']);?></td>
															<td align="left"><?php echo $rs['profissional'];?></td>
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
																			<td align="center" colspan="8">Nenhum registro!<br></td>
																		</tr>
												<?php
													}
												?>		
													</tbody>


											</table>

										</div>

										<div class="form-group">

											<label class="control-label"><b>Pagamentos realizados</b></label>

											<?php
											//CARREGA LISTA
											$sql = "
											select		f.descricao as forma_pagamento				
														,p.cod_comanda_pagamento,p.cod_comanda
														,IFNULL(p.valor, 0.0) as valor
														,IFNULL(p.valor_fiado, 0.0) as valor_fiado
														,DATE_FORMAT(p.dt_pagamento, '%d/%m/%Y %H:%m hs') as dataPagamento
														,u.nome as atendente 
											from 		comanda_pagamento p
											inner join 	usuarios u on u.cod_usuario = p.cod_usuario_pagamento
											inner join 	formas_pagamento f on f.cod_forma_pagamento = p.cod_forma_pagamento
											where 		p.cod_empresa = ".$cod_empresa."
											and 		p.cod_cliente = ".$cod_cliente."
											and 		p.cod_comanda = ".$cod_comanda."
											order by	p.dt_pagamento asc
											";

											//echo $sql;

											$query = mysql_query($sql);

											$registros = mysql_num_rows($query);

											?>

											<table class="table" border="1" bordercolor="#EEEEEE" style="margin: 0 auto; width: 100%;">
												<thead>
													<tr>
														<th style="width: 12%;">Forma</th>
														<th style="width: 12%;">Pago em</th>
														<th style="width: 12%; text-align:center;">Valor</th>
														<th style="width: 12%; text-align:center;">Fiado</th>
														<th style="width: 25%;">Pago por</th>
x												</thead>
												<tbody>
													<?php

													if ($registros > 0) 
													{
														while ($rs = mysql_fetch_array($query))
														{ 
														?>
														<tr>
															<td align="left"><?php echo $rs['forma_pagamento'];?></td>
															<td align="center"><?php echo $rs['dataPagamento'];?></td>
															<td align="right"><?php echo ValorMysqlPhp($rs['valor']);?></td>
															<td align="right"><?php echo ValorMysqlPhp($rs['valor_fiado']);?></td>
															<td align="center"><?php echo $rs['atendente'];?></td>
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
									
										<div class="panel-footer">
											<div class="row">
												<div class="col-sm-8">

													<?php if ( (isset($voltar)) && ($voltar != "")){ ?>

														<button type="button" class="btn-default btn" onclick="javascript:window.location='<?php echo $voltar; ?>'">Voltar</button>

													<?php }else{ ?>

														<button type="button" class="btn-default btn" onclick="javascript:window.location='comanda_historico_vendas.php';">Voltar</button>

													<?php } ?>

												</div>
											</div>
										</div>

									</div>

								</form>

							</div>

						</div> <!-- .container-fluid -->
<?php 

include('../include/rodape_interno.php');?>