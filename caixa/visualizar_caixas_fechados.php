<?php 
	require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";
	
//*********** VERIFICA CREDENCIAIS DE USUÁRIOS *************





$credencial_ver = 1;
$credencial_incluir = 1;
$credencial_editar = 1;
$credencial_excluir = 1;

$cod_empresa 		= $_SESSION['cod_empresa'];
$cod_caixa 			= $_REQUEST['cod_caixa_antigo'];


if ($credencial_ver == '1') { //VERIFICA SE USUÁRIO POSSUI ACESSO A ESSA ÁREA
	
	//FUNÇÃ£O QUE RETORNA O TOTAL DE PAGINAS E QUANTIDADE DE REGISTRO POR PAGINAS
	$sql = "Select COUNT(cod_conta) as total from conta  ";
	if (isset($_REQUEST['acao'])){
		if ($_REQUEST['acao'] == "buscar"){
			if ($_REQUEST['nome'] != ""){
				$sql = $sql . " where descricao like '%".$_REQUEST['nome']."%' ";
			}
		}
	}	
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		if ($rs = mysql_fetch_array($query)) {
			$totalregistro = $rs['total'];
		}
	}
	
	
  	// Calcula a quantidade de paginas
	$registrosPagina = 30; // Define a quantidade de registro por Paginas
	$paginas = $totalregistro / $registrosPagina; // Calcula o total de paginas
	$resto = $totalregistro % $registrosPagina; // Pega o resto da divisÃ£o
	$paginas = intval($paginas); // Converte o resultado para inteiro
	if ($resto > 0) { $paginas = $paginas + 1; } // Se o resto maior do que 0, soma a var paginas para a paginaçÃ£o ficar correta
	
	if (isset($_REQUEST['pagina'])) {
		$pagina = $_REQUEST['pagina']; // recupera a pagina
	} else { // Primeira pagina
		$pagina = 1;
	}
	
   $inicio = ( $pagina - 1 ) * $registrosPagina; //Defini o inicio da lista
   $final = $registrosPagina + $inicio; //Define o final da lista
   $contador = 0; //Seta variavel de Contador
   
   // Converte para inteiro
   $pagina = intval($pagina);	

   $dt_inicial = "01".date("/m/Y");
   $dt_final = "15".date("/m/Y");

?>

		<script language="javascript" src="js/comanda.js"></script>

                <div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">                                
								<li><a href="#">Principal</a></li>
								<li class="active"><a href="comanda.php">Caixa</a></li>
                            </ol>
							
                            <div class="page-heading">            
                            	<h1>Visualizar Caixas Fechados</h1>
                            </div>
                     
							<form action="visualizar_caixas_fechados.php" class="form-horizontal" name='frm' method="post">

								<input type='hidden' name='acao' value='ver_caixa_fechado'>

								<div class="row">
									<div class="col-sm-12">
										<div class="panel panel-sky">
											<div class="panel-heading">
												<h2>Filtros</h2>
											</div>
											<div class="panel-body">
												<div class="form-group">
													<label class="col-sm-2 control-label">Caixas Fechados</label>
													<div class="col-sm-2">
														<?php ComboReabrirCaixaAntigo($cod_empresa, $cod_caixa); ?>
													</div>
														<div class="col-sm-2">
															<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Buscar</button>
														</div>
												</div>

												<div class="panel-footer">
													<div class="row">

													</div>
												</div>
											</div>
										</div>	
									</div>
								</div>

							</form>


						<?php 

							if (isset($_REQUEST['acao'])){
								
								if ($_REQUEST['acao'] == "ver_caixa_fechado"){

									$sql = "
									select		format(sum(cg.valor), 2) as SaldoInicialDinheiro
									from		caixa c
									inner join 	caixa_gaveta cg on cg.cod_caixa = c.cod_caixa
									where 		cg.cod_caixa = ".$cod_caixa."
									and 		cg.cod_empresa = ".$cod_empresa."
									and 		cg.descricao = 'Inicial da Gaveta'
									order by 	cg.dt_transacao asc;
									";

									$query = mysql_query($sql);
									$registros = mysql_num_rows($query);
									$rs = mysql_fetch_array($query);
									$SaldoInicialEmDinheiro = ValorMysqlPhp($rs['SaldoInicialDinheiro']);

									$sql = "
									select		format(sum(cg.valor), 2) as SangriaEmDinheiro
									from		caixa c
									inner join 	caixa_gaveta cg on cg.cod_caixa = c.cod_caixa
									where 		cg.cod_caixa = ".$cod_caixa."
									and 		cg.cod_empresa = ".$cod_empresa."
									and 		cg.descricao like '%Sangria%'
									order by 	cg.dt_transacao asc;
									";
									$query = mysql_query($sql);
									$registros = mysql_num_rows($query);
									$rs = mysql_fetch_array($query);
									$SangriaEmDinheiro = ValorMysqlPhp($rs['SangriaEmDinheiro']);

									$sql = "
									select		format(sum(cg.valor), 2) as ReforcoEmDinheiro
									from		caixa c
									inner join 	caixa_gaveta cg on cg.cod_caixa = c.cod_caixa
									where 		cg.cod_caixa = ".$cod_caixa."
									and 		cg.cod_empresa = ".$cod_empresa."
									and 		cg.descricao like '%Reforco%'
									order by 	cg.dt_transacao asc;
									";
									$query = mysql_query($sql);
									$registros = mysql_num_rows($query);
									$rs = mysql_fetch_array($query);
									$ReforcoEmDinheiro = ValorMysqlPhp($rs['ReforcoEmDinheiro']);

									$SaldoEmDinheiro = ($SaldoInicialEmDinheiro + $ReforcoEmDinheiro) - $SangriaEmDinheiro;
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

													<table class="table" border="1" bordercolor="#EEEEEE" style="width: 50%;">
														<thead>
															<tr>
																<th style="width: 25%;">Saldo Inicial em Dinheiro</th>
																<td style="width: 25%;">+ R$ <?php echo $SaldoInicialEmDinheiro; ?></td>
															</tr>
															<tr>
																<th style="width: 25%;">Reforços em Dinheiro</th>
																<td style="width: 25%;">+ R$ <?php echo $ReforcoEmDinheiro; ?></td>
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
																,cg.descricao
													            ,u.nome
																,cg.valor
													from		caixa c
													inner join 	caixa_gaveta cg on cg.cod_caixa = c.cod_caixa
													inner join 	usuarios u on u.cod_usuario = cg.cod_usuario = u.cod_usuario
													where 		c.cod_caixa = ".$cod_caixa."
													and 		c.cod_empresa = ".$cod_empresa."
													order by 	cg.dt_transacao asc;
													";
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
																	<td align="center"><?php echo $rs['nome'];?></td>
																	<td align="right"><?php echo ValorMysqlPhp($rs['valor']);?></td>
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
													select		DATE_FORMAT(cg.dt_transacao, '%d/%m/%Y - %H:%m') as data_hora
																,cg.descricao
													            ,u.nome
																,cg.valor
													from		caixa c
													inner join 	caixa_gaveta cg on cg.cod_caixa = c.cod_caixa
													inner join 	usuarios u on u.cod_usuario = cg.cod_usuario = u.cod_usuario
													where 		c.cod_caixa = ".$cod_caixa."
													and 		c.cod_empresa = ".$cod_empresa."
													order by 	cg.dt_transacao asc;
													";

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
														</thead>
														<tbody>
															<?php

															if ($registros == 0) 
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

							<?php } 
							}
							?>






        

</div> <!-- .container-fluid -->
			
<?php
 } // VER 
	
include('../include/rodape_interno2.php');
?>

<script type="text/javascript">
	$(document).ready(function() {
	  $(":input[data-inputmask-mask]").inputmask();
	  $(":input[data-inputmask-alias]").inputmask();
	  $(":input[data-inputmask-regex]").inputmask("Regex");

	});
</script>