<?php require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";

	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	if ($_SESSION['usuario_conta'] == '1') {
		
		$credencial_ver = 1;
		$credencial_incluir = 1;
		$credencial_editar = 1;
		$credencial_excluir = 1;
		
	}
	
	$credencial_ver = 1;
	$credencial_incluir = 1;
	$credencial_editar = 1;
	$credencial_excluir = 1;


	$cod_empresa = $_SESSION['cod_empresa'];
	$cod_cliente = $_REQUEST['cod_cliente'];



?>

	<script language="javascript" src="js/agenda.js"></script>

	<div class="static-content-wrapper">
	    <div class="static-content">
	        <div class="page-content">
	            <ol class="breadcrumb">
	                
				<li><a href="#">Principal</a></li>
				<li class="active"><a href="Agenda.php">Agenda</a></li>

	            </ol>
	            <div class="page-heading">            
	                <h1>Reservas do Cliente</h1>
	                <div class="options"></div>
	            </div>
	            <div class="container-fluid">
	                
					<div data-widget-group="group1">

							<div class="panel panel-default" data-widget='{"draggable": "false"}'>
								<div class="panel-heading">
									<h2>Lançamento</h2>
								</div>
									<div class="panel-body">

									<?php 	

									$sql = "
									select		c.cod_cliente, p.cod_profissional
												,c.nome as cliente, p.nome as profissional, date_format(a.dt_agenda, '%d/%m/%Y') as data, a.hora, a.obs
									from 		agenda a
									inner join 	clientes c on c.cod_cliente = a.cod_cliente
									inner join 	profissional p on p.cod_profissional = a.cod_profissional
									where 		a.cod_empresa = ".$cod_empresa."
									and 		c.cod_cliente = ".$cod_cliente."
									order by	a.dt_agenda desc;
									";

									$query = mysql_query($sql);

					 				?>

									<form action="profissionais.php" class="form-horizontal row-border" name='frm' method="post">

						              <input type="hidden" name="acao" value="lancar">

										<div class="form-group">

											<div class="table-responsive">
											    <table class="table" border="1" bordercolor="#EEEEEE" style="width:100%;">
											        <thead>
											            <tr>
															<th style="width:20%;">Cliente</th>
															<th style="width:25%;">Profissional</th>
															<th style="width:25%;">Data</th>
															<th style="width:25%;">Hora</th>
															<th style="width:25%;">Obs</th>
															<th style="width:10%;">&nbsp;</th>
											            </tr>
											        </thead>
											        <tbody>
											        	<?php 	

										        		while($rs = mysql_fetch_array($query))
										        		{
											        	?>
								                        <tr>
															<td align="left"><?php echo $rs['cliente'];?></td>
															<td align="left"><?php echo $rs['profissional'];?></td>
															<td align="left"><?php echo $rs['data'];?></td>
															<td align="left"><?php echo $rs['hora'];?></td>
															<td align="left"><?php echo $rs['obs'];?></td>
															<td>
																<a class="btn btn-success btn-label" href="agenda.php?acao=ver_reserva&data=<?php echo $rs['data']; ?>&cod_profissional=<?php echo $rs['cod_profissional']; ?>&cod_cliente=<?php echo $rs['cod_cliente']; ?>">
																	<i class="fa fa-eye"></i>Ver
																</a>
															</td>

														</tr>
														<?php 

														} 

														?>
													</tbody>
												</table>
											</div>


										</div>

									</form>

								</div>
							</div>

	</div> <!-- .container-fluid -->

</div>
					
	
<?php 

include('../include/rodape_interno2.php');?>