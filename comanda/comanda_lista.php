<?php require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";

	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
		
	$credencial_ver = 1;
	$credencial_incluir = 1;
	$credencial_editar = 1;
	$credencial_excluir = 1;


	$cod_empresa = $_SESSION['cod_empresa'];
	$cod_cliente = $_REQUEST['cod_cliente'];
	$cod_comanda = $_REQUEST['cod_comanda'];


if ($credencial_ver == '1') { //VERIFICA SE USU�RIO POSSUI ACESSO A ESSA �REA
	
	if (isset($_REQUEST['sucesso'])) { $sucesso = $_REQUEST['sucesso']; } else { $sucesso = ''; }
	if (isset($_REQUEST['pergunta'])) { $pergunta = $_REQUEST['pergunta']; } else { $pergunta = ''; }
	if (isset($_REQUEST['excluir'])) { $excluir = $_REQUEST['excluir']; } else { $excluir = ''; }
	if (isset($_REQUEST['pergunta_excluir_pagamento'])) { $pergunta_excluir_pagamento = $_REQUEST['pergunta_excluir_pagamento']; } else { $pergunta_excluir_pagamento = ''; }
	
	if ($excluir != '') {

		$sql = "delete from comanda_item where cod_comanda_item = ".$excluir." and cod_comanda=".$cod_comanda." and cod_cliente=".$cod_cliente." and cod_empresa=".$cod_empresa."";
		mysql_query($sql);
		
		$excluir = '1';
	}

}

if (isset($_REQUEST['acao'])){

	if($_REQUEST['acao'] == "excluir_pagamento"){

		$cod_comanda_pagamento = $_REQUEST['cod_comanda_pagamento'];

		$sql = "delete from comanda_pagamento where cod_comanda_pagamento = ".$cod_comanda_pagamento."";
		mysql_query($sql) or die (mysql_error());

		$sql = "delete from clientes_credito where cod_empresa = ".$cod_empresa." and cod_cliente = ".$cod_cliente." and cod_comanda = ".$cod_comanda."";
		mysql_query($sql) or die (mysql_error());
		
		echo "<script language='javascript'>window.location='comanda_lista.php?sucesso=3&cod_comanda=".$cod_comanda."&cod_cliente=".$cod_cliente."';</script>";die;

	}

}

	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar
	
	$acao = '';


	$sucesso = $_REQUEST['sucesso'];


	$id = $_REQUEST["cod_cliente"];

	$sql = "select nome from clientes where cod_cliente = " . $id;
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		if ($rs = mysql_fetch_array($query)){
			$nome = $rs['nome'];
		}
	}


	//SOMAT�RIO
	$sql = "
	select		sum((valor * quantidade)) as Total
	from		comanda_item
	where 		cod_empresa = ".$cod_empresa."
	and 		cod_comanda = ".$cod_comanda."
	and 		cod_cliente = ".$cod_cliente.";
	";
	$query = mysql_query($sql);
	$rs = mysql_fetch_array($query);

	$Total = number_format($rs['Total'], 2, ',', '.');


	
?>
			<div class="static-content-wrapper">
                <div class="static-content">
                    <div class="page-content">
                        <ol class="breadcrumb">
                            
							<li><a href="#">Principal</a></li>
							<li class="active"><a href="grupo_produtos.php">Grupo de Produtos</a></li>

                        </ol>
                        <div class="page-heading">            
                            <h1>Comanda</h1>
                            <div class="options">
						  	  <?php 
							  if ($credencial_incluir == '1') {
							  ?>
								<a class="btn btn-midnightblue btn-label" href="comanda_item_info.php?cod_comanda=<?php echo $cod_comanda; ?>&cod_cliente=<?php echo $cod_cliente; ?>"><i class="fa fa-plus-circle"></i> Novo Serviço ou Produto</a>
							  <?php
							  }
							  ?>	
							</div>
                        </div>
                        <div class="container-fluid">                               

						<?php 
						if ($pergunta_excluir_pagamento != '') {
						?>
						<div class="alert alert-dismissable alert-info">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<strong>Deseja realmente excluir esse pagamento?</strong><br>
							<br><a class="btn btn-success" href="comanda_lista.php?acao=excluir_pagamento&cod_comanda_pagamento=<?php echo $pergunta_excluir_pagamento;?>&cod_comanda=<?php echo $cod_comanda;?>&cod_cliente=<?php echo $cod_cliente;  ?>">Sim</a>
							&nbsp;&nbsp;&nbsp; 
							<a class="btn btn-danger" href="comanda_lista.php?cod_comanda=<?php echo $cod_comanda;?>&cod_cliente=<?php echo $cod_cliente;  ?>">Não</a>
						</div>				
						<?php
						}
						?>

						<?php
						if ($sucesso == 'pagamento_dinheiro') {
						?>
						<div class="alert alert-dismissable alert-success">
							<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Pagamento em dinheiro realizado com sucesso!</strong>
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						</div>
						<?php
						} 
						?>


						<?php
						if ($sucesso == '1') {
						?>
						<div class="alert alert-dismissable alert-success">
							<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Dados gravados com sucesso!</strong>
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						</div>
						<?php
						} 
						?>

						<?php

						if ($sucesso == '2') {
						?>
						<div class="alert alert-dismissable alert-success">
							<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Dados atualizados com sucesso!</strong>
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						</div>
						<?php
						} 

						if ($sucesso == '3') {
							?>
							<div class="alert alert-dismissable alert-success">
								<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Pagamento excluído com sucesso!</strong>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							</div>
							<?php
							} 

						if ($pergunta != '') {
						?>
						<div class="alert alert-dismissable alert-info">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<strong>Deseja realmente excluir esse item da comanda ?</strong><br>
							<br>
							<a class="btn btn-success" href="comanda_lista.php?excluir=<?php echo $pergunta;?>&cod_comanda=<?php echo $cod_comanda;?>&cod_cliente=<?php echo $cod_cliente; ?>">Sim</a>&nbsp;&nbsp;&nbsp;
							<a class="btn btn-danger" href="comanda_lista.php?cod_comanda=<?php echo $cod_comanda;?>&cod_cliente=<?php echo $cod_cliente; ?>">Não</a>
						</div>				
						<?php
						}

						if ($excluir == '1') {
						?>
						<div class="alert alert-dismissable alert-success">
							<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Item deletado com sucesso!</strong>
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						</div>
						<?php
						} 

						?>

						<div data-widget-group="group1">
							<div class="panel panel-default" data-widget='{"draggable": "false"}'>
								<div class="panel-heading">
									<h2>Cliente</h2>
								</div>

								<div class="panel-body">

									<form action="grupo_produto_info.php" class="form-horizontal row-border" name='frm' method="post">
						              <?php if ($acao=="alterar"){?>
						              <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
						              <input type="hidden" name="acao" value="atualizar">
						              <?php }else{?>
						              <input type="hidden" name="acao" value="incluir">
						              <?php } ?>		

										<div class="form-group">
											<label class="col-sm-2 control-label"><b>Cliente</b></label>
											<div class="col-sm-8">
												<?php echo $nome; ?>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-2 control-label"><b>SubTotal</b></label>
											<div class="col-sm-8">
												<?php echo "R$ ".$Total; ?>
											</div>
										</div>

										<div class="form-group">

											<label class="control-label"><b>Lista de Serviço/Produtos</b></label>

											<div style="margin:2px 0 5px 1px;">

											</div>

											<table class="table" border="1" bordercolor="#EEEEEE" style="margin: 0 auto; width: 100%;">
							                    <thead>
							                        <tr>
							                        	<th style="width: 15%;">Descrição</th>
														<th style="width: 5%;">Quantidade</th>
														<th style="width: 10%;">Valor Total</th>
														<th style="width: 15%;">Profissional</th>
														<th style="width: 15%;">&nbsp;</th>
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
														while ($rs = mysql_fetch_array($query))
														{ 

															$valor_total = number_format($rs['valor_total'], 2, ',', '.');


														?>
								                        <tr>
															<td align="left"><?php echo $rs['descricao']; ?></td>
															<td align="left"><?php echo $rs['quantidade'];?></td>
															<td align="left"><?php echo $valor_total;?></td>
															<td align="left"><?php echo $rs['profissional'];?></td>
															<td align="center">
																<a 
																	class="btn btn-success btn-label" 
																	href="comanda_item_info.php?acao=alterar&id=<?php echo $rs['cod_comanda_item']; ?>&cod_comanda=<?php echo $cod_comanda; ?>&cod_cliente=<?php echo $cod_cliente;?>">
																	<i class="fa fa-times-circle"></i>Editar
																</a>
																&nbsp;
																<a 
																	class="btn btn-danger btn-label" 
																	href="comanda_lista.php?pergunta=<?php echo $rs['cod_comanda_item']; ?>&cod_comanda=<?php echo $cod_comanda; ?>&cod_cliente=<?php echo $cod_cliente; ?>">

																	<i class="fa fa-times-circle"></i>Excluir
																	
																</a>
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
												                            <td align="center" colspan="8">Nenhum registro!<br></td>
												                        </tr>
												<?php
													}
												?>		
								                    </tbody>


											</table>

										</div>

										<div class="form-group">

											<label class="control-label"><b>Pagamento</b></label>

											<?php
											//CARREGA LISTA
											$sql = "
											select		f.descricao as forma_pagamento
														,p.cod_comanda_pagamento,p.cod_comanda
														,IFNULL(p.valor, 0.0) as valor
														,DATE_FORMAT(p.dt_pagamento, '%d/%m/%Y %H:%i hs') as dataPagamento
														,u.nome as atendente 
														,p.num_parcelas
											from 		comanda_pagamento p
											inner join 	usuarios u on u.cod_usuario = p.cod_usuario_pagamento
											inner join 	formas_pagamento f on f.cod_forma_pagamento = p.cod_forma_pagamento
											where 		p.cod_empresa = ".$cod_empresa."
											and 		p.cod_cliente = ".$cod_cliente."
											and 		p.cod_comanda in (".$cod_comanda.")
											order by	p.dt_pagamento asc
											";

											//echo "<br>".$sql;
											$query = mysql_query($sql);
											$registro_pagamento = mysql_num_rows($query);
											$flgPago = mysql_num_rows($query);
											?>

											<table class="table" border="1" bordercolor="#EEEEEE" style="margin: 0 auto; width: 100%;">
												<thead>
													<tr>
														<th style="width: 12%;">Forma</th>
														<th style="width: 12%;">Pago em</th>
														<th style="width: 12%; text-align:center;">Valor</th>
														<th style="width: 25%;">Pago por</th>
														<th style="width: 15%;">&nbsp;</th>
												</thead>
												<tbody>
													<?php

													if ($registros > 0) 
													{
														while ($rs = mysql_fetch_array($query))
														{ 
														
															if($rs['num_parcelas'] != "")
															{
																$valor =  $rs['num_parcelas'].'x '.number_format($rs['valor'], 2, ',', '.');
															}
															else
															{
																$valor = "R$ ".number_format($rs['valor'], 2, ',', '.');
															}


														?>
														<tr>
															<td align="left"><?php echo $rs['forma_pagamento'];?></td>
															<td align="center"><?php echo $rs['dataPagamento'];?></td>
															<td align="right"><?php echo $valor; ?></td>
															<td align="center"><?php echo $rs['atendente'];?></td>
															<td>
																<!--a 
																	class="btn btn-default btn-label" 
																	href="comanda_pagamentos.php?acao=alterar&cod_comanda=<?php echo $cod_comanda;?>&cod_cliente=<?php echo $cod_cliente;  ?>">
																	<i class="fa fa-times-circle"></i>Editar
																</a-->

																<a 
																	class="btn btn-danger btn-label" 
																	href="comanda_lista.php?pergunta_excluir_pagamento=<?php echo $rs['cod_comanda_pagamento'];?>&cod_comanda_pagamento=<?php echo $rs['cod_comanda_pagamento'];?>&cod_comanda=<?php echo $cod_comanda;?>&cod_cliente=<?php echo $cod_cliente;  ?>">

																	<i class="fa fa-times-circle"></i>Excluir
																	
																</a>
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

									</form>

									<div class="panel-footer">
										<div class="row">
											<div class="col-sm-8">
												<!--button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Avan�ar</button-->

												<?php if ($flgPago == 0) {?>

												<a class="btn btn-info btn-label" href="comanda_forma_pagamento.php?flg_divida=&cod_comanda=<?php echo $cod_comanda;?>&cod_cliente=<?php echo $cod_cliente; ?>&voltar=comanda.php"><i class="fa fa-money"></i>Receber</a>

												<?php } ?>

												<button class="btn-default btn" onclick="javascript:window.location='comanda.php';">Voltar</button>
											</div>
										</div>
									</div>
								</div>
							</div>

					</div> <!-- .container-fluid -->
<?php 
} // INCLUIR OU EDITAR
include('../include/rodape_interno2.php');?>