<?php

	require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";
	
	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	if ($_SESSION['usuario_conta'] == '1') {
		
		$credencial_ver = 1;
		$credencial_incluir = 1;
		$credencial_editar = 1;
		$credencial_excluir = 1;
		
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "profissional_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "profissional_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "profissional_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "profissional_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}
	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar	
	
	$acao = '';
	
	$cod_profissional	= $_REQUEST['id'];
	$cod_empresa 		= $_SESSION['cod_empresa'];
	$cod_horario		= $_REQUEST['cod_horario'];
	$nome 				= urlencode($_REQUEST['nome']);

	if (isset($_REQUEST['diadasemana'])) { $diadasemana = $_REQUEST['diadasemana']; } else { $diadasemana = ''; }
	if (isset($_REQUEST['inicio'])) { $inicio = $_REQUEST['inicio']; } else { $inicio = ''; }
	if (isset($_REQUEST['fim'])) { $fim = $_REQUEST['fim']; } else { $fim = ''; }

if (isset($_REQUEST['acao'])){
	
	if ($_REQUEST['acao'] == "incluir"){
		
		//$sql = "insert into grupos (cod_licenca, nome, status) values ('". limpa($cod_licenca) ."', '".limpa($nome)."', '". limpa($status) ."')";

		$sql = "
		INSERT INTO `companysystem`.`profissional_horario`
		(`cod_empresa`,
		`cod_profissional`,
		`dia_semana`,
		`horario_inicio`,
		`horario_fim`
		)
		VALUES
		('".limpa($cod_empresa)."',
		'".limpa($cod_profissional)."',
		'".limpa($diadasemana)."',
		'".limpa($inicio)."',
		'".limpa($fim)."'
		)";

		//echo $sql; die;

		mysql_query($sql);
		
		echo "<script language='javascript'>window.location='profissionais_horario.php?id=".$cod_profissional."&sucesso=1';</script>";
		
	}else if ($_REQUEST['acao'] == "atualizar"){
		
		$sql = "update grupos set cod_licenca = '". limpa($cod_licenca) ."', nome='".limpa($nome)."', status='". limpa($status) ."' where cod_grupo = ".$_REQUEST['id'];
		mysql_query($sql);
		
		echo "<script language='javascript'>window.location='profissionais_horario.php?id=".$cod_profissional."&sucesso=2';</script>";
	
	}else if ($_REQUEST['acao'] == "excluir"){
		
		$sql = "delete from profissional_horario where cod_horario = ".$cod_horario." and cod_profissional=".$cod_profissional."";
		mysql_query($sql);
		
		echo "<script language='javascript'>window.location='profissionais_horario.php?id=".$cod_profissional."&sucesso=2&nome=".$nome."';</script>";
	
	}
	
}

if (isset($_REQUEST['acao'])){
	
	if ($_REQUEST['acao'] == "alterar"){
		
		$acao = $_REQUEST['acao'];
		
		if (isset($_REQUEST['id'])) {
			$grupo = $_REQUEST["id"];
		}
		
		$sql = "Select * from grupos where cod_grupo = " . $grupo;
		$query = mysql_query($sql);
		$registros = mysql_num_rows($query);
		if ($registros > 0) {
			if ($rs = mysql_fetch_array($query)){
				$nome = $rs['nome'];
				$status = $rs['status'];
				$cod_licenca = $rs['cod_licenca'];
			}
		}
	
	}
	
}
	
$nome = urlencode($_REQUEST['nome']);

?>
				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
							<li><a href="#">Principal</a></li>
							<li class="active"><a href="profissionais_horario.php">Horário</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Horário</h1>
                                <div class="options">
									<a class="btn btn-midnightblue btn-label" href="profissionais_horario_info.php?id=<?php echo $cod_profissional; ?>&cod_empresa=<?php echo $cod_empresa; ?>&nome=<?php echo $nome; ?>"><i class="fa fa-plus-circle"></i> Novo</a>
								</div>
                            </div>


                            <div class="container-fluid">

								<div data-widget-group="group1">								

										<div class="panel panel-default" data-widget='{"draggable": "false"}'>
											<div class="panel-heading">
												<h2>Dados do Horário</h2>
											</div>
											<div class="panel-body">

												<div class="form-group">

													<label class="control-label"><b>Profissional: </b> <?php echo $_GET['nome']; ?> </label>
												</div>

												<form action="grupos.php" class="form-horizontal row-border" name='frm' method="post">

													<div class="form-group">

														<label class="control-label"><b>Horarios</b></label>

														<div style="margin:2px 0 5px 1px;">

														</div>

														<table class="table" border="1" bordercolor="#EEEEEE" style="margin: 0 auto; width: 100%;">
										                    <thead>
										                        <tr>
										                        	<th style="width: 25%;">Dia Semana</th>
																	<th style="width: 25%;">De</th>
																	<th style="width: 25%;">Até</th>
																	<th style="width: 25%;">&nbsp;</th>
										                    </thead>
										                    <tbody>
															    <?php
																	//CARREGA LISTA
																$sql = "
																select 		ph.cod_horario, p.nome, ph.dia_semana, ph.horario_inicio, ph.horario_fim
																from 		profissional_horario ph
																inner join	profissional p on p.cod_profissional = ph.cod_profissional
																where		p.cod_empresa = ".$cod_empresa."
																and 		p.cod_profissional = ".$cod_profissional."
																order by	ph.dia_semana, ph.horario_inicio;
																";

																$query = mysql_query($sql);

																$registros = mysql_num_rows($query);

																if ($registros > 0) 
																{
																	while ($rs = mysql_fetch_array($query))
																	{ 
																	?>
											                        <tr>
																		<td align="left"><?php echo DiaDaSemana($rs['dia_semana']);?></td>
																		<td align="left"><?php echo $rs['horario_inicio'];?></td>
																		<td align="left"><?php echo $rs['horario_fim'];?></td>
																		<td>
																			<a 
																				class="btn btn-default btn-label" 
																				href="profissionais_horario_info.php?acao=alterar&id=<?php echo $cod_profissional;?>&cod_horario=<?php echo $rs['cod_horario'];  ?>&nome=<?php echo $nome; ?>">
																				<i class="fa fa-times-circle"></i>Editar
																			</a>

																			<a 
																				class="btn btn-danger btn-label" 
																				href="profissionais_horario.php?acao=excluir&id=<?php echo $cod_profissional;?>&cod_horario=<?php echo $rs['cod_horario'];?>&nome=<?php echo $nome; ?>">

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

												<button class="btn-default btn" onclick="javascript:window.location='profissionais.php?id=<?php echo $cod_profissional; ?>&cod_empresa=<?php echo $cod_empresa; ?>';">Voltar</button>


											</div>
										</div>



                            </div> <!-- .container-fluid -->

<?php 
}
	
	include('../include/rodape_interno2.php');

?>