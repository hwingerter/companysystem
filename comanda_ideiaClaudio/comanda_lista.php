<?php include('../include/topo_interno.php');

	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	$credencial_ver = 0;
	$credencial_incluir = 0;
	$credencial_editar = 0;
	$credencial_excluir = 0;
	
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
	
	if ($excluir != '') {

		$sql = "delete from comanda_item where cod_comanda_item = ".$excluir." and cod_comanda=".$cod_comanda." and cod_cliente=".$cod_cliente." and cod_empresa=".$cod_empresa."";
		mysql_query($sql);
		
		$excluir = '1';
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
                            <h1>Nova Comanda</h1>
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
						if ($sucesso == '1') {
						?>
						<div class="alert alert-dismissable alert-success">
							<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Dados gravados com sucesso!</strong>
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						</div>
						<?php
						} 

						if ($sucesso == '2') {
						?>
						<div class="alert alert-dismissable alert-success">
							<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Dados atualizados com sucesso!</strong>
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
							                        	<th style="width: 10%;">Descrição</th>
														<th style="width: 5%;">Quantidade</th>
														<th style="width: 10%;">Valor Total</th>
														<th style="width: 20%;">Profissional</th>
														<th style="width: 10%;">&nbsp;</th>
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
															<td>
																<a 
																	class="btn btn-success btn-label" 
																	href="comanda_item_info.php?acao=alterar&id=<?php echo $rs['cod_comanda_item']; ?>&cod_comanda=<?php echo $cod_comanda; ?>&cod_cliente=<?php echo $cod_cliente;?>">
																	<i class="fa fa-times-circle"></i>Editar
																</a>

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

									</form>
									<div class="panel-footer">
										<div class="row">
											<div class="col-sm-8">
												<!--button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Avan�ar</button-->
												<button class="btn-default btn" onclick="javascript:window.location='comanda.php';">Voltar</button>
											</div>
										</div>
									</div>
								</div>
							</div>

					</div> <!-- .container-fluid -->
<?php 
} // INCLUIR OU EDITAR
include('../include/rodape_interno.php');?>