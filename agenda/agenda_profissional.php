<?php 
	
	require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";
	
//*********** VERIFICA CREDENCIAIS DE USUÁRIOS *************
$credencial_ver = 0;
$credencial_incluir = 0;
$credencial_editar = 0;
$credencial_excluir = 0;

$credencial_ver = 1;
$credencial_incluir = 1;
$credencial_editar = 1;
$credencial_excluir = 1;

$cod_empresa 		= $_SESSION['cod_empresa'];
$cod_profissional	= $_REQUEST['cod_profissional'];
$data 				= $_REQUEST['data'];


if ($credencial_ver == '1') { //VERIFICA SE USUÁRIO POSSUI ACESSO A ESSA ÁREA
	
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


   $sqlCliente = "select cod_cliente, nome from clientes where cod_empresa = ".$cod_empresa." order by nome asc;";
   $query = mysql_query($sqlCliente);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {

		$i = 0;
		while ($rs = mysql_fetch_array($query)) { 
			$clientes[$i][0] = $rs["cod_cliente"];
			$clientes[$i][1] = $rs["nome"];
			$i++;
		}
	}

	if (isset($_REQUEST['acao'])){
		
		if ($_REQUEST['acao'] == "reservar"){


		}

	}


?>

		<script language="javascript" src="js/agenda.js"></script>

                <div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">                                
								<li><a href="#">Principal</a></li>
								<li class="active"><a href="agenda.php">Agenda</a></li>
                            </ol>
							
                            <div class="page-heading">            
                            	<h1>Agenda Profissional</h1>
                            </div>
                     
							<div data-widget-group="group1">
									<div class="panel panel-default" data-widget='{"draggable": "false"}'>
										<div class="panel-heading">
											<h2>Agenda de Horários</h2>
										</div>										

										<form class="form-horizontal">

											<div class="panel-body">
											
												<div class="form-group">

													<label class="control-label"><b>Horários</b></label>

													<?php
													//CARREGA LISTA
													$sql = "
													select		a.cod_agenda, a.hora, c.cod_cliente, c.nome as cliente
													from		agenda a
													left join 	clientes c on c.cod_cliente = a.cod_cliente
													where 		a.cod_empresa = ".$cod_empresa."
													and 		a.cod_profissional = ".$cod_profissional."
													and	 		a.dt_agenda = '".$data."'
													order by	hora asc;
													";
													$query = mysql_query($sql);

													$registros = mysql_num_rows($query);

													?>

													<table class="table" border="1" bordercolor="#EEEEEE" style=" width: 40%;">
														<thead>
															<tr>
																<th style="width: 2%;">Hora</th>
																<th style="width: 12%;">Cliente</th>
																<th style="width: 2%; text-align:center;">Reserva</th>
														</thead>
														<tbody>
															<?php

															if ($registros > 0) 
															{
																while ($rs = mysql_fetch_array($query))
																{ 
																?>
																<tr>
																	<td align="left"><?php echo $rs['hora'];?></td>
																	<td align="center">

																		<select name="cod_cliente" id="cod_cliente" class="form-control">
																			<option value="">Selecione...</option>
																		<?php 

																			$i=0;
																			while ($i < count($clientes))
																			{ 
																			?>
																				<option value="<?php echo $clientes[$i][0]; ?>"> <?php echo $clientes[$i][1]; ?> </option>
																			<?php

																			$i++;
																			}

																		?>

																		</select>

																	</td>
																	<td align="center">
																		<button type="button" class="btn-success btn" onclick="Reservar('<?php echo $data; ?>', '<?php echo $cod_profissional; ?>', '<?php echo $rs['cod_agenda'];?>');">Reservar</button>
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

												<div class="panel-footer">
													<div class="row">
														<div class="col-sm-8">
															<button type="button" class="btn-default btn" onclick="javascript:window.location='agenda.php';">Voltar</button>
														</div>
													</div>
												</div>

											</div>

										</form>

									</div>
							</div>

        

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