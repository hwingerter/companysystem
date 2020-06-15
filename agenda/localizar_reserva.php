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

if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar
	
	$acao = '';

	$cod_usuario_inclusao = $_SESSION['usuario_id'];	
	$cod_caixa = $_SESSION['cod_caixa'];

	if (isset($_REQUEST['acao'])){
		
		if ($_REQUEST['acao'] == "abrir_agenda"){

			$dt_agenda = date('Y-m-d');

			$hora_inicial	= "6";
			$hora_final  	= "10";


			$sql = "
			select 		cod_profissional
			from 		profissional
			where 		cod_empresa = ".$cod_empresa.";
			";

			$query = mysql_query($sql);

			while($rs = mysql_fetch_array($query))
			{


				//VARRE HORÁRIOS

				$i= $hora_inicial;

				while($i < $hora_final){

					if(strlen($i) == 1){
						$Hora = "0".$i;
					}else{
						$Hora = $i;
					}
					
					$vMinutos = array("00", "30");
					
					for($m=0; $m<=1; $m++)
					{
						$Minuto = $vMinutos[$m];	

						$Horario = $Hora.":".$Minuto;
					
						$sql="

						INSERT INTO `claudio_company`.`agenda`
						(`dt_agenda`,
						`hora`,
						`cod_empresa`,
						`cod_profissional`,
						`cod_servico`,
						`telefone`,
						`repetir`,
						`cor`,
						`obs`)
						VALUES
						('".$dt_agenda."',
						'".$Horario."',
						'".$cod_empresa."',
						'".$rs['cod_profissional']."',
						NULL,
						NULL,
						NULL,
						NULL,
						NULL);

						";

						echo $sql."<br>";

						mysql_query($sql);

					}

					$i++;

				}

			}


			echo "<script language='javascript'>window.location='agenda.php?sucesso=1';</script>"; die;
			
		}else if ($_REQUEST['acao'] == "fechar_caixa"){

			$cod_caixa = $_REQUEST['cod_caixa'];
			
			$sql = "update caixa set situacao = 2 where cod_caixa = ".$cod_caixa." and cod_empresa = ".$cod_empresa." ";
			mysql_query($sql);

			unset($_SESSION["cod_caixa"]);
			
			echo "<script language='javascript'>window.location='caixa_gaveta_caixa.php?sucesso=2';</script>"; die;
		
		}
		
	}

	if($cod_caixa != ""){


		$sql = "
		select		DATE_FORMAT(dt_abertura, '%d/%m/%Y %H:%m:%s') as dt_abertura, cod_caixa
		from		caixa
		where 		cod_caixa = ".$cod_caixa."
		";

		//echo $sql;die;

		$query = mysql_query($sql);
		$registros = mysql_num_rows($query);
		$rs = mysql_fetch_array($query);
		if ($registros > 0) {
			$situacao = 1; //aberta
			$dt_abertura = $rs["dt_abertura"];
			$cod_caixa = $rs["cod_caixa"];
		}else{
			$situacao = 2; //fechada
		}

	}else{
		$situacao = 2; //fechada
	}
		
}

$diasemana = array('Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sabado');

$dt_abertura = date('d/m/Y');

//$diasemana_numero = date('w', strtotime($data));

//echo "dia da semana ".$diasemana_numero;

//$dia_semana =  $diasemana[$diasemana_numero]." <br>(".date('d/m/Y').")";



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
							
							<div data-widget-group="group1">

								<div class="panel panel-default" data-widget='{"draggable": "false"}'>

									<div class="panel-heading">
										<h2>Localizar Reserva</h2>
									</div>

									<div class="panel-body">

										<form class="form-horizontal" name='frm' method="post">

											<div class="form-group">
												<label class="col-sm-2 control-label"><b>Cliente</b></label>
												<div class="col-sm-4">
													<?php ComboCliente('', $cod_empresa); ?>
												</div>
											</div>
											
											<div class="panel-footer">
												<div class="row">
													<div class="col-sm-8 col-sm-offset-2">
														<button type="button" class="btn-primary btn" onclick="javascript:ConsultarAgenda();">Consultar Agenda</button>
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