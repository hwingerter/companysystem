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
	$cod_horario 		= $_REQUEST["cod_horario"];
	$nome 				= $_REQUEST["nome"];
	

	if (isset($_REQUEST['diadasemana'])) { $diadasemana = $_REQUEST['diadasemana']; } else { $diadasemana = ''; }
	if (isset($_REQUEST['inicio'])) { $inicio = $_REQUEST['inicio']; } else { $inicio = ''; }
	if (isset($_REQUEST['fim'])) { $fim = $_REQUEST['fim']; } else { $fim = ''; }

if (isset($_REQUEST['acao'])){
	
	if ($_REQUEST['acao'] == "incluir"){
		
		//$sql = "insert into grupos (cod_licenca, nome, status) values ('". limpa($cod_licenca) ."', '".limpa($nome)."', '". limpa($status) ."')";

		$sql = "
		INSERT INTO `profissional_horario`
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
		
		echo "<script language='javascript'>window.location='profissionais_horario.php?id=".$cod_profissional."&sucesso=1&nome=".$nome."';</script>";
		
	}else if ($_REQUEST['acao'] == "atualizar"){
		
		//$sql = "update grupos set cod_licenca = '". limpa($cod_licenca) ."', nome='".limpa($nome)."', status='". limpa($status) ."' where cod_grupo = ".$_REQUEST['id'];

$sql = "

	UPDATE `profissional_horario`
	SET
	`dia_semana` = '".$diadasemana."',
	`horario_inicio` = '".$inicio."',
	`horario_fim` = '".$fim."'
	WHERE `cod_horario` = ".$cod_horario." and cod_profissional = '".$cod_profissional."';
	";

	//echo $sql; die;

		mysql_query($sql);
		
		echo "<script language='javascript'>window.location='profissionais_horario.php?id=".$cod_profissional."&sucesso=2&nome=".$nome."';</script>";
	
	}
	
}

if (isset($_REQUEST['acao'])){
	
	if ($_REQUEST['acao'] == "alterar"){
		
		$acao = $_REQUEST['acao'];
		
		if (isset($_REQUEST['id'])) {
			$id 		= $_REQUEST["id"];
			$cod_horario = $_REQUEST["cod_horario"];
		}
		
		$sql = "select * from profissional_horario where cod_profissional=".$id." and cod_horario = ".$cod_horario."";
		//echo $sql; die;
		$query = mysql_query($sql);
		$registros = mysql_num_rows($query);
		if ($registros > 0) {
			if ($rs = mysql_fetch_array($query)){
				$dia_semana 		= $rs['dia_semana'];
				$horario_inicio		= $rs['horario_inicio'];
				$horario_fim		= $rs['horario_fim'];
			}
		}
	
	}
	
}
	
$nome = $_REQUEST["nome"];

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
                                <div class="options"></div>
                            </div>
                            <div class="container-fluid">
                                

								<div data-widget-group="group1">

										<div class="panel panel-default" data-widget='{"draggable": "false"}'>
											<div class="panel-heading">
												<h2>Dados do Horário</h2>
											</div>
											<div class="panel-body">

												<form action="profissionais_horario_info.php" class="form-horizontal row-border" name='frm' method="post">

									              <input type="hidden" name="id" value="<?php echo $cod_profissional; ?>">
									              <input type="hidden" name="cod_empresa" value="<?php echo $cod_empresa; ?>">
									              <input type="hidden" name="nome" value="<?php echo $nome; ?>">

									              <?php if ($acao=="alterar"){?>
									              <input type="hidden" name="cod_horario" value="<?php echo $cod_horario; ?>">
									              <input type="hidden" name="acao" value="atualizar">
									              <?php }else{?>
									              <input type="hidden" name="acao" value="incluir">
									              <?php } ?>			

													<div class="form-group">
														<label class="col-sm-2 control-label"><b>Dia da Semana</b></label>
														<div class="col-sm-8">
														  <select name="diadasemana" class="form-control">
										                    <?php
										                    $i=0;
															while($i <= 6){
															?>
															<option value="<?php echo $i;?>"
															<?php if ($dia_semana == $i) { echo " Selected"; }?>
															><?php echo DiaDaSemana($i);?></option>
										                    <?php
										                    $i++;
															}
															?>
														  </select>						
														</div>
													</div>

													<div class="form-group">
														<label class="col-sm-2 control-label"><b>Das</b></label>
														<div class="col-sm-8">
														  <select name="inicio" class="form-control">
										                    <?php

															$i=6;

															while($i <= 22){

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

																if($horario_inicio == $Horario){
																?>
																<option value="<?php echo $Horario; ?>" selected><?php echo $Horario;?></option>
																<?php

																}else{
																?>
																<option value="<?php echo $Horario; ?>"><?php echo $Horario;?></option>
																<?php
																}

																?>


										                    	<?php

										                    	}


										                    $i++;
															}
															?>
														  </select>						
														</div>
													</div>

													<div class="form-group">
														<label class="col-sm-2 control-label"><b>Até</b></label>
														<div class="col-sm-8">
														  <select name="fim" class="form-control">
										                    <?php

															$i=6;

															while($i <= 22){

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

																	if($horario_fim == $Horario){
																	?>
																	<option value="<?php echo $Horario; ?>" selected><?php echo $Horario;?></option>
																	<?php
																	}else{
																	?>
																	<option value="<?php echo $Horario; ?>"><?php echo $Horario;?></option>
																	<?php
																	}
																}
										                    $i++;
															}
															?>
														  </select>						
														</div>
													</div>

												</form>

												<div class="panel-footer">
													<div class="row">
														<div class="col-sm-8 col-sm-offset-2">
															<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Gravar</button>
															<button class="btn-default btn" onclick="javascript:window.location='profissionais_horario.php?id=<?php echo $cod_profissional; ?>';">Cancel</button>
														</div>
													</div>
												</div>

											</div>
										</div>



                            </div> <!-- .container-fluid -->

<?php 
}
	
	include('../include/rodape_interno2.php');

?>