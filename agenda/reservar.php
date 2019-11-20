<?php 
require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";


	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
$credencial_ver = 0;
$credencial_incluir = 0;
$credencial_editar = 0;
$credencial_excluir = 0;

$credencial_ver = 1;
$credencial_incluir = 1;
$credencial_editar = 1;
$credencial_excluir = 1;

$cod_empresa 		= $_SESSION['cod_empresa'];
$data  				= $_REQUEST['data'];
$hora  				= $_REQUEST['hora'];
$cod_profissional 	= $_REQUEST['cod_profissional'];
$cod_cliente 		= $_REQUEST['cod_cliente'];


	if (isset($_REQUEST['acao'])){
		
		if ($_REQUEST['acao'] == "efetuar_reserva"){

			$cod_cliente = $_REQUEST['cod_cliente'];
			$cod_servico = $_REQUEST['cod_servico'];

			if (isset($_REQUEST["telefone"])) { $telefone = $_REQUEST["telefone"]; } else { $telefone = ""; }
			if (isset($_REQUEST["repetir"])) { $repetir = $_REQUEST["repetir"]; } else { $repetir = "0"; }
			if (isset($_REQUEST["cor"])) { $cor = $_REQUEST["cor"]; } else { $cor = ""; }
			if (isset($_REQUEST["obs"]) && ($_REQUEST["obs"] != "")) { $obs = $_REQUEST["obs"]; } else { $obs = "NULL"; }

			if ($repetir == 0) { //NUNCA REPETE

				$sql = "
				INSERT INTO `agenda`
				(`dt_agenda`,
				`hora`,
				`cod_empresa`,
				`cod_cliente`,
				`cod_profissional`,
				`cod_servico`,
				`telefone`,
				`repetir`,
				`cor`,
				`obs`)
				VALUES
				('".$data."',
				'".$hora."',
				'".$cod_empresa."',
				'".$cod_cliente."',
				'".$cod_profissional."',
				'".$cod_servico."',
				'".$telefone."',
				'".$repetir."',
				'".$cor."',
				'".$obs."');
				";

				//echo $sql;die;

				mysql_query($sql);
			}
			else //REPETE UMA SEMANA EM DIANTE
			{

				switch ($repetir) {
					case '1':
						$dias = 7;
						break;
					case '2':
						$dias = 15;
						break;
					case '3':
						$dias = $repetir * 7;
						break;
					
					default:
						$dias = 15;
						break;
				}

				if($repetir == 1)
				{
					$dias = 7;
				}
				elseif ($repetir == 2)
				{
					$dias = 15;
				}
				elseif ($repetir >= 3)
				{
					$dias = $repetir * 7;
				}

				//echo DataMysqlPhp($data)."<br><br>";

				$nova_data = $data; //date("d/m/Y", strtotime("+".$dias." days", strtotime($data)));

				$ano_atual = date('Y');

				$contDias = $dias;

				$proximo_ano = $ano_atual+1;

				//echo $nova_data."<br>";

				//echo "proximo ano: ".$proximo_ano."<br><br><br>";

				while($ano_atual < $proximo_ano)
				{

					$sql = "
					INSERT INTO `agenda`
					(`dt_agenda`,
					`hora`,
					`cod_empresa`,
					`cod_cliente`,
					`cod_profissional`,
					`cod_servico`,
					`telefone`,
					`repetir`,
					`cor`,
					`obs`)
					VALUES
					('".$nova_data."',
					'".$hora."',
					'".$cod_empresa."',
					'".$cod_cliente."',
					'".$cod_profissional."',
					'".$cod_servico."',
					'".$telefone."',
					'".$repetir."',
					'".$cor."',
					'".$obs."');
					";

					//echo $sql."<br>";

					mysql_query($sql);

					$nova_data = DataPhpMysql(date("d/m/Y", strtotime("+".$contDias." days", strtotime($data))));				

					//echo $nova_data."<br>";

					$contDias += $dias;
				
					$ano_atual = date("Y", strtotime($nova_data));	

				}
				//die;


			}

			//die;


			echo "<script language='javascript'>window.location='agenda.php?sucesso=1&acao=atualizar&data=".$data."&cod_profissional=".$cod_profissional."';</script>"; die;


		}else if ($_REQUEST['acao'] == "cancelar_reserva"){

			$hora  				= $_REQUEST['hora'];
			$cod_profissional 	= $_REQUEST['cod_profissional'];
			
			
			$sql = "delete from agenda where dt_agenda = '".$data."' and hora = '".$hora."' and cod_profissional = ".$cod_profissional." and cod_cliente = ".$cod_cliente." ";
			//echo $sql;die;
			mysql_query($sql);

			
			echo "<script language='javascript'>window.location='agenda.php?sucesso=2';</script>"; die;
		
		}



	}




?>

	<script language="javascript" src="js/agenda.js"></script>

	<div class="static-content-wrapper">
		<div class="static-conten">
		    <div class="page-content">
		        <div class="container-fluid">            
					
					<div data-widget-group="group1">

						<div class="panel panel-default" data-widget='{"draggable": "false"}'>

							<div class="panel-heading">
								<h2>Agenda</h2>
							</div>

							<div class="panel-body">

								<form name='frm' class="form-horizontal" action="reservar.php" method="post">

									<input type="hidden" name="acao" value="efetuar_reserva">
									<input type="hidden" name="data" value="<?php echo $data; ?>">
									<input type="hidden" name="hora" value="<?php echo $hora; ?>">
									<input type="hidden" name="cod_profissional" value="<?php echo $cod_profissional; ?>">

									<div class="form-group">
										<label class="col-sm-2 control-label"><b>Data</b></label>
										<div class="col-sm-8"><?php echo DataMysqlPhp($data)." ".$hora; ?></div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label"><b>Cliente</b></label>
										<div class="col-sm-4">
											<?php ComboCliente('', $cod_empresa); ?>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-2 control-label"><b>Telefone</b></label>
										<div class="col-sm-4">
											<input type="text" class="form-control" value="<?php echo $telefone;?>" name="telefone" maxlength="100">
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label"><b>Serviço</b></label>
										<div class="col-sm-4">
											<?php ComboServico($cod_empresa, ''); ?>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label"><b>Observações</b></label>
										<div class="col-sm-4">
											<textarea name="obs" class="form-control" style="width:100%; height:100px;"></textarea>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label"><b>Repetir</b></label>
										<div class="col-sm-4">
											<?php ComboRepetir(''); ?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label"><b>Cor</b></label>
										<div class="col-sm-4">
											<input type="text" class="form-control cpicker" name="cor" id="cpicker" data-color-format="hex" value="#67B2E4">
										</div>
									</div>

									<div class="panel-footer">
										<div class="row">
											<div class="col-sm-8 col-sm-offset-2">
												<button type="button" class="btn-success btn" onclick="javascript:EfeturarReserva();">Efetuar Reserva</button>
												<button type="button" class="btn-default btn" onclick="javascript:window.location='agenda.php';">Voltar</button>
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

	include('../include/rodape_interno2.php');
?>