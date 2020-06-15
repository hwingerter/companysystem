<?php 

require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";


	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************





$credencial_ver = 1;
$credencial_incluir = 1;
$credencial_editar = 1;
$credencial_excluir = 1;

$cod_empresa = $_SESSION['cod_empresa'];

if (isset($_REQUEST['sucesso'])) { $sucesso = $_REQUEST['sucesso']; } else { $sucesso = ''; }

$diasemana = array('Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sabado');

$dt_abertura = date('d/m/Y');

//Verifica se tem agenda hoje;

$sql = "
	select count(*) as temHorario from agenda where cod_empresa = ".$cod_empresa." and dt_agenda = '".DataPhpMysql($dt_abertura)."';
";
$query = mysql_query($sql);

$rs = mysql_fetch_array($query);

$temHorario = $rs['temHorario'];


?>

		<script language="javascript" src="js/agenda.js"></script>

			<div class="static-content-wrapper">
                <div class="static-conten">
                    <div class="page-content">
                        <ol class="breadcrumb">                          
							<li><a href="#">Principal</a></li>
							<li class="active"><a href="agenda.php">Agenda</a></li>
                        </ol>
						</div>
                        <div class="container-fluid">            
							
							<?php
							if ($sucesso == '1') {
							?>
							<div class="alert alert-dismissable alert-success">
								<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Reserva realizada com sucesso!</strong>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							</div>
							<?php
							
							}elseif ($sucesso == '2') {
							?>
							<div class="alert alert-dismissable alert-success">
								<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Reserva cancelada!</strong>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							</div>
							<?php
							}elseif ($sucesso == '3') {
							?>
							<div class="alert alert-dismissable alert-success">
								<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Último caixa aberto com sucesso!</strong>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							</div>
							<?php
							}elseif ($sucesso == '4') {
							?>
							<div class="alert alert-dismissable alert-success">
								<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Caixa antigo reaberto com sucesso!</strong>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							</div>
							<?php 
							}elseif ($sucesso == '5') {
							?>
							<div class="alert alert-dismissable alert-success">
								<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Sangria realizada com sucesso!</strong>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							</div>
							<?php 
							}elseif ($sucesso == '6') {
							?>
							<div class="alert alert-dismissable alert-success">
								<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Reforço realizado com sucesso!</strong>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							</div>
							<?php 
							}elseif ($sucesso == '7') {
							?>
							<div class="alert alert-dismissable alert-success">
								<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Vale emitido com sucesso!</strong>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							</div>
							<?php 
							}

							 ?>
							<div data-widget-group="group1">

								<div class="panel panel-default" data-widget='{"draggable": "false"}'>

									<div class="panel-heading">
										<h2>Agenda</h2>
									</div>

									<div class="panel-body">

										<form class="form-horizontal" name='frm' method="post">

											<div class="form-group">
												<label class="col-sm-2 control-label"><b>Data</b></label>
												<div class="col-sm-8">
													<input type="text" id="datepicker">
												</div>
											</div>

											<div class="form-group">
												<label class="col-sm-2 control-label"><b>Funcionário</b></label>
												<div class="col-sm-4">
													<?php ComboFuncionario($cod_empresa, ''); ?>
												</div>
											</div>
											
											<div class="panel-footer">
												<div class="row">
													<div class="col-sm-8 col-sm-offset-2">
														<button type="button" class="btn-primary btn" onclick="javascript:MostrarAgenda();">Mostrar Agenda</button>
													</div>
												</div>
											</div>

										</form>

									</div>

								</div>

								<div id="Quadro" style="width:100%;">

								</div>

							</div>

						</div> <!-- .container-fluid -->

<?php 

if ($_REQUEST['acao'] == "ver_reserva")
{
	$data 				= $_REQUEST['data'];
	$cod_profissional	= $_REQUEST['cod_profissional'];
	$cod_cliente		= $_REQUEST['cod_cliente'];

?>
	<script>
		ExibirAgendaReservacliente('<?php echo $data; ?>', '<?php echo $cod_profissional; ?>', '<?php echo $cod_cliente; ?>');
	</script>
<?php
}

	include('../include/rodape_interno2.php');
?>