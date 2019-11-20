<?php 

	session_start();

	require_once "../config/conexao.php";

	require_once "../include/funcoes.php";
	
//*********** VERIFICA CREDENCIAIS DE USUÁRIOS *************

$cod_empresa 		= $_SESSION['cod_empresa'];
$cod_profissional	= $_REQUEST['cod_profissional'];
$data 				= $_REQUEST['data'];


//Dia selecionado
$dia_da_semana = date('w', strtotime(DataPhpMysql($data)));


/*****************************************
			HORÁRIO PADRÃO
*****************************************/

$hora_inicial	= explode(':',$_SESSION['agenda_hora_inicial']);
$hora_inicial	= $hora_inicial[0];

$hora_final	    = explode(':',$_SESSION['agenda_hora_final']);
$hora_final	    = $hora_final[0];

$agenda_intervalo 	= $_SESSION['agenda_intervalo'];

//echo "hora_inicial: ".$hora_inicial."<br>";
//echo "hora_final: ".$hora_final."<br><br>";

$hora = $hora_inicial;

$contHorario = 0;

while($hora < $hora_final)
{
	for($m=0; $m<=59; $m++)
	{
		$h = strlen($hora) == 1 ? "0".$hora : $hora;

		$m = strlen($m) == 1 ? "0".$m : $m;

		if ($m % $agenda_intervalo == 0) 
		{
			$horario = $h.":".$m;

			$vHorario[$contHorario] = $horario;

			//echo $vHorario[$contHorario]."<br>";

			$contHorario++;
		}		

	}
	
	$hora++;	

}
//die;


/*****************************************
			HORÁRIO FUNCIONÁRIO
*****************************************/
$sql = "
select		p.horario_inicio, horario_fim
from		profissional_horario p
where 		p.cod_empresa = ".$cod_empresa."
and 		p.cod_profissional = ".$cod_profissional."
and 		p.dia_semana = ".$dia_da_semana.";
";

$query = mysql_query($sql);

$vHorarioProfissional = array();

$contaHora = 0;

while ($rs = mysql_fetch_array($query))
{
	$hora_inicial	= explode(":", $rs["horario_inicio"]);
	$hora_inicio 	= $hora_inicial[0];

	$hora_final  	= explode(":", $rs["horario_fim"]);
	$hora_fim 		= $hora_final[0];
	
	while($hora_inicio < $hora_fim)
	{

		if(strlen($hora_inicio) == 1){
			$Hora = "0".$hora_inicio;
		}else{
			$Hora = $hora_inicio;
		}

		$vMinutos = array("00", "30");

		for($m=0; $m<=1; $m++)
		{
			$Minuto = $vMinutos[$m];	
		
			$Horario = $Hora.":".$Minuto;

			$vHorarioProfissional[$contaHora] = $Horario;

			$contaHora++;

		}

		$hora_inicio++;

	}	

	
}


function Temhorario($dia_da_semana, $dia, $data, $horario)
{

	echo $dia_da_semana." - ".$dia;

	if($dia == $dia_da_semana)
	{

		$i=0;
		while ($i<=count($vHorarioFuncionario))
		{
			if($vHorarioFuncionario[$i][1] >=  $horario)
			{
				echo "sim";
			}
			$i++;
		}

	}

}

function HoraJaMarcada($cod_empresa, $cod_profissional, $data, $hora)
{
	$sql = "
	
	select 		c.cod_cliente, c.nome as cliente, a.cor
	from 		agenda a
	left join 	clientes c on c.cod_cliente = a.cod_cliente
	where 		a.cod_empresa = ".$cod_empresa."
	and 		a.cod_profissional = ".$cod_profissional."
	and 		a.dt_agenda = '".DataPhpMysql($data)."'
	and 		a.hora = '".$hora."';
	";

	//echo $sql."<br>";

	$query = mysql_query($sql);

	$rs = mysql_fetch_array($query);

	return $rs['cod_cliente']."|".$rs['cliente']."|".$rs['cor'];
}

?>

                   
	<div data-widget-group="group1">

			<div class="panel panel-default" data-widget='{"draggable": "false"}'>

				<div class="panel-heading">
					<h2>Horários Disponíveis</h2>
				</div>										

				<form class="form-horizontal">

					<div class="panel-body">
					
						<div class="form-group">

							<label class="control-label"><b>Horários</b></label>

							<table class="table" border="1" bordercolor="#EEEEEE" style=" width: 60%;">
								<thead>
									<tr>
										<th style="width: 2%;">Data</th>
										<th style="width: 2%;">Hora</th>
										<th style="width: 12%;">Cliente</th>
										<th style="width: 2%; text-align:center;">Reserva</th>
								</thead>
								<tbody>
									<?php

									//VARRE HORÁRIOS

									$contHorario = 0;

									while ($contHorario < count($vHorario)){


										$InicioHoraFunc = 0;
										$tem_hora = false;

										while($InicioHoraFunc <= count($vHorarioProfissional))
										{
											if ($vHorarioProfissional[$InicioHoraFunc] == $vHorario[$contHorario])
											{
												$tem_hora = true;
											}

										$InicioHoraFunc++;
										}

										$cliente =  HoraJaMarcada($cod_empresa, $cod_profissional, $data, $vHorario[$contHorario]);

										if($cliente != "")
										{
											$cliente = explode("|", $cliente);
											$codigo  = $cliente[0];
											$nome    = $cliente[1];
											$cor 	 = $cliente[2];
										}
										else
										{
											$codigo = "";
											$nome = "";
											$cor = "";
										}
										
									?>
										<tr>
											<td align="left"><?php echo $data;?></td>

											<td align="center"><?php echo $vHorario[$contHorario]; ?></td>

											<td align="center" style="background-color: <?php echo $cor; ?>">
												<?php 
												if ($nome != "")
												{
													echo $nome;
												} 
												else
												{
													echo "&nbsp;";
												}
												?>
											</td>

											<td align="center">
											
												<?php 

													if ($tem_hora == true){ 

														if ($codigo == "")
														{
														?>
													
															<button type="button" class="btn-success btn" onclick="Reservar('<?php echo DataPhpMysql($data); ?>', '<?php echo $vHorario[$contHorario]; ?>', '<?php echo $cod_profissional; ?>');">Reservar</button>

														<?php 

														}
														else
														{
														?>
														
															<button type="button" class="btn-danger btn" onclick="CancelarReserva('<?php echo DataPhpMysql($data); ?>', '<?php echo $vHorario[$contHorario]; ?>', '<?php echo $cod_profissional; ?>', '<?php echo $codigo; ?>');">Cancelar</button>
														
														<?php
														}

													} 

												?>

											</td>
										</tr>

									<?php

										$contHorario++;

									}

									?>

									</tbody>


							</table>

						</div>

					</div>

				</form>

			</div>
		
	</div> <!-- .container-fluid -->
