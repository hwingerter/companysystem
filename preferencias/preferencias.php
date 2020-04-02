<?php 

	require_once "../include/topo_interno2.php";

	require_once "../include/funcoes.php";

	require_once "../include/ler_credencial.php";


	
	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "tipo_conta_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "tipo_conta_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "tipo_conta_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "tipo_conta_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}
	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar
	
if (isset($_REQUEST['sucesso'])) { $sucesso = $_REQUEST['sucesso']; } else { $sucesso = ''; }

$cod_empresa = $_SESSION['cod_empresa'];
		
$sql = "select * from empresas_preferencias where cod_empresa = ".$cod_empresa;
//echo $sql;die;
$query = mysql_query($sql);
$registros = mysql_num_rows($query);
if ($registros > 0) {
	if ($rs = mysql_fetch_array($query)){
		$salao_nome = $rs["salao_nome"];
		$salao_telefone = $rs["salao_telefone"];
		$salao_proprietario = $rs["salao_proprietario"];
		$salao_email = $rs["salao_email"];
		$salao_cep = $rs["salao_cep"];
		$salao_endereco = $rs["salao_endereco"];
		$salao_numero = $rs["salao_numero"];
		$salao_complemento = $rs["salao_complemento"];
		$salao_bairro = $rs["salao_bairro"];
		$salao_cidade = $rs["salao_cidade"];
		$salao_estado = $rs["salao_estado"];
		$comissao_flg_1 = $rs["comissao_flg_1"];
		$comissao_flg_2 = $rs["comissao_flg_2"];
		$comissao_flg_3 = $rs["comissao_flg_3"];
		$comissao_flg_4 = $rs["comissao_flg_4"];
		$comissao_flg_5 = $rs["comissao_flg_5"];
		$comissao_flg_6 = $rs["comissao_flg_6"];
		$comissao_flg_7 = $rs["comissao_flg_7"];
		$agenda_hora_inicial = $rs["agenda_hora_inicial"];
		$agenda_hora_final = $rs["agenda_hora_final"];
		$agenda_intervalo = $rs["agenda_intervalo"];
		$agenda_cor_1 = $rs["agenda_cor_1"];
		$agenda_cor_2 = $rs["agenda_cor_2"];
		$agenda_flg_1 = $rs["agenda_flg_1"];
		$agenda_flg_2 = $rs["agenda_flg_2"];
		$agenda_flg_3 = $rs["agenda_flg_3"];
		$agenda_flg_4 = $rs["agenda_flg_4"];
		$cadastro_cidade_padrao = $rs["cadastro_cidade_padrao"];
		$cadastro_estado_padrao = $rs["cadastro_estado_padrao"];
		$cadastro_cep_padrao = $rs["cadastro_cep_padrao"];
		$cadastro_flag_1 = $rs["cadastro_flag_1"];
		$cadastro_flag_2 = $rs["cadastro_flag_2"];
		$cadastro_flag_3 = $rs["cadastro_flag_3"];
		$cadastro_flag_4 = $rs["cadastro_flag_4"];
		$cadastro_flag_5 = $rs["cadastro_flag_5"];
		$cadastro_flag_6 = $rs["cadastro_flag_6"];
		$cadastro_flag_7 = $rs["cadastro_flag_7"];
		$cadastro_flag_8 = $rs["cadastro_flag_8"];
		$cadastro_flag_9 = $rs["cadastro_flag_9"];
		$estoque_flg_1 = $rs["estoque_flg_1"];
	}
}


/*****************************************
			HORÁRIO PADRÃO
*****************************************/
$hora_inicial	    = "6";
$hora_final  	    = "18";

$contHorario = 0;

while($hora_inicial <= $hora_final){

	if(strlen($hora_inicial) == 1){
		$Hora = "0".$hora_inicial;
	}else{
		$Hora = $hora_inicial;
	}
	
	$vMinutos = array("00", "30");
	
	for($m=0; $m<=1; $m++)
	{
		$Minuto = $vMinutos[$m];	
	
		$Horario = $Hora.":".$Minuto;

		$vHorario[$contHorario] = $Horario;

	$contHorario++;

	}

	$hora_inicial++;	

}
		
?>

<script language='JavaScript'>

$(document).ready(function() {

	function limpa_formulário_cep() {
		// Limpa valores do formulário de cep.
		$("#rua").val("");
		$("#bairro").val("");
		//$("#cidade").val("");
		//$("#uf").val("");
		//$("#ibge").val("");
	}
	
	//Quando o campo cep perde o foco.
	$("#cep").blur(function() {

		//Nova variável "cep" somente com dígitos.
		var cep = $(this).val().replace(/\D/g, '');

		//Verifica se campo cep possui valor informado.
		if (cep != "") {

			//Expressão regular para validar o CEP.
			var validacep = /^[0-9]{8}$/;

			//Valida o formato do CEP.
			if(validacep.test(cep)) {

				//Preenche os campos com "..." enquanto consulta webservice.
				$("#rua").val("...");
				$("#bairro").val("...");
				$("#cidade").val("...");
				$("#uf").val("...");

				//Consulta o webservice viacep.com.br/
				$.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

					if (!("erro" in dados)) {
						//Atualiza os campos com os valores da consulta.
						$("#rua").val(dados.logradouro);
						$("#bairro").val(dados.bairro);
						$("#cidade").val(dados.localidade);
						$("#uf").val(dados.uf);
					} //end if.
					else {
						//CEP pesquisado não foi encontrado.
						limpa_formulário_cep();
						alert("CEP não encontrado.");
					}
				});
			} //end if.
			else {
				//cep é inválido.
				limpa_formulário_cep();
				alert("Formato de CEP inválido.");
			}
		} //end if.
		else {
			//cep sem valor, limpa formulário.
			limpa_formulário_cep();
		}
	});

});

</script>	 

<script src="../js/jquery.mask.min.js"></script>

				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <div class="page-heading mb0">            
                                <h1>Preferências</h1>
							</div>
							
                            <div class="page-tabs">
                                <ul class="nav nav-tabs">                                    
									<li class="active"><a data-toggle="tab" href="#tab1">Dados do Salão</a></li>
									<li><a data-toggle="tab" href="#tab2">Comissões</a></li>
									<li><a data-toggle="tab" href="#tab3">Agenda</a></li>
									<li><a data-toggle="tab" href="#tab4">Cadastros</a></li>
									<li><a data-toggle="tab" href="#tab5">Estoques</a></li>
                                </ul>
                            </div>

                            <div class="container-fluid">
								
							<?php
							if ($sucesso == '1') {
							?>
								<div class="alert alert-dismissable alert-success">
									<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Preferências atualizadas com sucesso!</strong>
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								</div>
							<?php
							}
							?>


								<div class="tab-content">
									<div class="tab-pane active" id="tab1">

										<div class="row">
											<div class="col-md-12">
												<div class="panel panel-default">
													<div class="panel-heading"><h2>Dados do Salão</h2></div>
													<div class="panel-body">
													
														<form name="form1" action="gravar_preferencias.php" method="post" class="form-horizontal">

															<input type="hidden" name="acao" value="dados_salao">

															<div class="form-group">
																<label for="Empresa1" class="col-md-1 col-lg-2 control-label">Nome do Salão:</label>
																<div class="col-md-4">
																	<input type="text" class="form-control" name="salao_nome" id="Empresa1" placeholder="Empresa1" maxlength="200" value="<?php echo $salao_nome;?>">
																</div>
															</div>

															<div class="form-group">
																<label for="Empresa" class="col-md-1 col-lg-2 control-label">Telefone do Salão (Com DDD):</label>
																<div class="col-md-4">
																	<input type="text" class="form-control" name="salao_telefone" id="Empresa" placeholder="Empresa" maxlength="200" value="<?php echo $salao_telefone;?>">
																</div>
															</div>

															<div class="form-group">
																<label for="Empresa" class="col-md-1 col-lg-2 control-label">Nome do Proprietário:</label>
																<div class="col-md-4">
																	<input type="text" class="form-control" name="salao_proprietario" id="Empresa" placeholder="Empresa" maxlength="200" value="<?php echo $salao_proprietario;?>">
																</div>
															</div>

															<div class="form-group">
																<label for="Empresa" class="col-md-1 col-lg-2 control-label">E-mail para contato:</label>
																<div class="col-md-4">
																	<input type="text" class="form-control" name="salao_email" id="Empresa" placeholder="Empresa" maxlength="200" value="<?php echo $salao_email;?>">
																</div>
															</div>

															<div class="form-group">
																<label for="Empresa" class="col-md-1 col-lg-2 control-label">CEP:</label>
																<div class="col-md-4">
																	<input type="text" class="form-control" name="salao_cep" id="cep" placeholder="Empresa" maxlength="200" value="<?php echo $salao_cep;?>">
																</div>
															</div>

															<div class="form-group">
																<label for="Empresa" class="col-md-1 col-lg-2 control-label">Endereço:</label>
																<div class="col-md-4">
																	<input type="text" class="form-control" name="salao_endereco" id="rua" placeholder="Empresa" maxlength="200" value="<?php echo $salao_endereco;?>">
																</div>
															</div>

															<div class="form-group">
																<label for="Empresa" class="col-md-1 col-lg-2 control-label">Número:</label>
																<div class="col-md-4">
																	<input type="text" class="form-control" name="salao_numero" id="Empresa" placeholder="Empresa" maxlength="200" value="<?php echo $salao_numero;?>">
																</div>
															</div>

															<div class="form-group">
																<label for="Empresa" class="col-md-1 col-lg-2 control-label">Complemento:</label>
																<div class="col-md-4">
																	<input type="text" class="form-control" name="salao_complemento" id="Empresa" placeholder="Empresa" maxlength="200" value="<?php echo $salao_complemento;?>">
																</div>
															</div>

															<div class="form-group">
																<label for="Empresa" class="col-md-1 col-lg-2 control-label">Bairro:</label>
																<div class="col-md-4">
																	<input type="text" class="form-control" name="salao_bairro" id="bairro" placeholder="bairro" maxlength="200" value="<?php echo $salao_bairro;?>">
																</div>
															</div>

															<div class="form-group">
																<label for="Empresa" class="col-md-1 col-lg-2 control-label">Cidade:</label>
																<div class="col-md-4">
																	<input type="text" class="form-control" name="salao_cidade" id="cidade" placeholder="Empresa" maxlength="200" value="<?php echo $salao_cidade;?>">
																</div>
															</div>

															<div class="form-group">
																<label for="Empresa" class="col-md-1 col-lg-2 control-label">Estado:</label>
																<div class="col-md-4">
																	<input type="text" class="form-control" name="salao_estado" id="uf" placeholder="Empresa" maxlength="200" value="<?php echo $salao_estado;?>">
																</div>
															</div>

															<div class="form-group">
																<div class="col-md-12 col-sm-offset-2">
																	<button class="btn-primary btn" onclick="javascript:document.forms['form1'].submit();">Atualizar</button>
																</div>
															</div>							

														</form>

													</div>
												</div>
											</div>
										</div>

									</div>
									<div class="tab-pane" id="tab2">

										<div class="row">
											<div class="col-md-12">
												<div class="panel panel-default">
													<div class="panel-heading"><h2>Comissões</h2></div>
													<div class="panel-body">
														<form name="form2" action="gravar_preferencias.php" method="post" class="form-horizontal">

															<input type="hidden" name="acao" value="comissoes">

															<div class="form-group">
																<div class="col-md-4">
																	<label class="checkbox-inline icheck">
																	<input type="checkbox" name="comissao_flg_1" id="area11" <?php if($comissao_flg_1) echo " checked " ?> > Considerar descontos da venda ao calcular comissões percentuais
																	</label>
																</div>
															</div>

															<div class="form-group">
																<div class="col-md-4">
																	<label class="checkbox-inline icheck">
																	<input type="checkbox" name="comissao_flg_2" id="area11" <?php if($comissao_flg_2) echo " checked " ?> > Considerar acréscimos da venda ao calcular comissões percentuais
																	</label>
																</div>
															</div>

															<div class="form-group">
																<div class="col-md-8">
																	<label class="checkbox-inline icheck">
																	<input type="checkbox" name="comissao_flg_3" id="area11" <?php if($comissao_flg_3) echo " checked " ?> > Bloquear comissões de dívidas não quitadas (fiados, cheques pré-datados não vencidos e cheques devolvidos)
																	</label>
																</div>
															</div>

															<div class="form-group">
																<div class="col-md-8">
																	<label class="checkbox-inline icheck">
																	<input type="checkbox" name="comissao_flg_4" id="area11" <?php if($comissao_flg_4) echo " checked " ?> > Bloquear comissões de cartões de crédito até que a operadora repasse os valores.
																	</label>
																</div>
															</div>

															<div class="form-group">
																<div class="col-md-8">
																	<label class="checkbox-inline icheck">
																	<input type="checkbox" name="comissao_flg_5" id="area11" <?php if($comissao_flg_5) echo " checked " ?> > Bloquear comissões de cartões de débito até que a operadora repasse os valores.
																	</label>
																</div>
															</div>

															<div class="form-group">
																<div class="col-md-8">
																	<label class="checkbox-inline icheck">
																	<input type="checkbox" name="comissao_flg_6" id="area11" <?php if($comissao_flg_6) echo " checked " ?> > Bloquear taxas de cartões de crédito das comissões dos profissionais.
																	</label>
																</div>
															</div>

															<div class="form-group">
																<div class="col-md-8">
																	<label class="checkbox-inline icheck">
																	<input type="checkbox" name="comissao_flg_7" id="area11" <?php if($comissao_flg_7) echo " checked " ?> > Bloquear taxas de cartões de débitos das comissões dos profissionais.
																	</label>
																</div>
															</div>

															<div class="form-group">
																<div class="col-md-12 col-sm-offset-2">
																	<button class="btn-primary btn" onclick="javascript:document.forms['form2'].submit();">Atualizar</button>
																</div>
															</div>		

														</form>
													</div>
												</div>
											</div>
										</div>

									</div>
									<div class="tab-pane" id="tab3">

										<div class="row">
											<div class="col-md-12">
												<div class="panel panel-default">
													<div class="panel-heading"><h2>Agenda</h2></div>
													<div class="panel-body">

														<form name="form3" action="gravar_preferencias.php" method="post" class="form-horizontal">

															<input type="hidden" name="acao" value="agenda">

															<div class="form-group">
																<label for="Empresa1" class="col-md-3 col-lg-2 control-label">Horário inicial e final da agenda:</label>
																<div class="col-md-1 col-lg-1">																	
																	<select name="agenda_hora_inicial" class="form-control">
																		<?php

																		$i=6;

																		while($i <= 10){

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

																			if($agenda_hora_inicial == $Horario){
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

																<div class="col-md-1">
																<label for="Empresa1" class="col-md-3 col-lg-2 control-label">às</label>
																</div>

																<div class="col-md-1 col-lg-1">
																	<select name="agenda_hora_final" class="form-control">
																		<?php

																		$i=16;

																		while($i <= 23){

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

																			if($agenda_hora_final == $Horario){
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
																<label for="Empresa1" class="col-md-1 col-lg-2 control-label">Intervalo de horário padrão da agenda:</label>
																<div class="col-md-2">
																<select name="agenda_intervalo" class="form-control"> 
																		<?php

																		$i=10;
																		$selecionar = "";

																		while($i <= 55)
																		{
																			if ($i % 5 == 0)
																			{
																				if ($agenda_intervalo == $i) {
																					$selecionar = " selected ";
																				}

																			?>
																				<option value="<?php echo $i; ?>" <?php echo $selecionar; ?>><?php echo $i;?> Minutos</option>
																			<?php
																			$selecionar = "";
																			}

																			?>
																		<?php

																		$i++;
																		}
																		?>
																		<option value="60" <?php if ($agenda_intervalo == "60") { echo " selected "; }?> >1 Hora</option>
																	</select>	
																</div>
															</div>

															<div class="form-group">
																<label for="Empresa1" class="col-md-1 col-lg-2 control-label">Cores automáticas da agenda</label>
																<div class="col-md-2">
																	<input type="text" class="form-control cpicker" name="agenda_cor_1" id="cpicker" data-color-format="hex" value="<?php echo $agenda_cor_1; ?>">
																</div>
																<div class="col-md-2">
																	<input type="text" class="form-control cpicker" name="agenda_cor_2" id="cpicker2" data-color-format="hex" value="<?php echo $agenda_cor_2; ?>">
																</div>
															</div>

															<div class="form-group">
																<div class="col-md-4">
																	<label class="checkbox-inline icheck">
																	<input type="checkbox" name="agenda_flg_1" id="area11" <?php if($agenda_flg_1) echo " checked " ?> > Usar duração do cadastro do serviço ao agendar.
																	</label>
																</div>
															</div>

															<div class="form-group">
																<div class="col-md-4">
																	<label class="checkbox-inline icheck">
																	<input type="checkbox" name="agenda_flg_2" id="area11" <?php if($agenda_flg_2) echo " checked " ?> > Permitir alterar datas passadas na agenda.
																	</label>
																</div>
															</div>

															<div class="form-group">
																<div class="col-md-8">
																	<label class="checkbox-inline icheck">
																	<input type="checkbox" name="agenda_flg_3" id="area11" <?php if($agenda_flg_3) echo " checked " ?> > Exibir opção de mudar intervalo de horário na agenda.
																	</label>
																</div>
															</div>

															<div class="form-group">
																<div class="col-md-8">
																	<label class="checkbox-inline icheck">
																	<input type="checkbox" name="agenda_flg_4" id="area11" <?php if($agenda_flg_4) echo " checked " ?> > Exibir caixa de grupos de profissionais na agenda.
																	</label>
																</div>
															</div>

														</form>

														<div class="form-group">
															<div class="col-md-12 col-sm-offset-0">
																<button class="btn-primary btn" onclick="javascript:document.forms['form3'].submit();">Atualizar</button>
															</div>
														</div>		

													</div>
												</div>
											</div>
										</div>

									</div>
									<div class="tab-pane" id="tab4">

										<div class="row">
											<div class="col-md-12">
												<div class="panel panel-default">
													<div class="panel-heading"><h2>Cadastros</h2></div>
													<div class="panel-body">
														<form name="form4" action="gravar_preferencias.php" method="post" class="form-horizontal">

															<input type="hidden" name="acao" value="cadastros">

															<div class="form-group">
																<label class="col-sm-2 control-label"><b>Cidade Padrão</b></label>
																<div class="col-sm-4">
																	<input type="text" class="form-control" value="<?php echo $cadastro_cidade_padrao;?>" name="cadastro_cidade_padrao" id="cadastro_cidade_padrao" maxlength="45">
																</div>
															</div>

															<div class="form-group">
																<label class="col-sm-2 control-label"><b>Estado Padrão</b></label>
																<div class="col-sm-1">
																<select name="cadastro_estado_padrao" class="form-control">
																	<option value="">--</option>
																	<?php
																	$query = mysql_query("select * from estados order by uf asc") or die (mysql_error());
																	while($rs = mysql_fetch_array($query)){
																	?>
																	<option value="<?php echo $rs['cod_estado'];?>"
																	<?php if ($cadastro_estado_padrao == $rs['cod_estado']) { echo " Selected"; }?>
																	><?php echo htmlentities($rs['uf']);?></option>
																	<?php
																	}
																	?>
																</select>						
																</div>
															</div>
															
															<div class="form-group">
																<label class="col-sm-2 control-label"><b>CEP Padrão</b></label>
																<div class="col-sm-1">
																	<input type="text" class="form-control" value="<?php echo $cadastro_cep_padrao;?>" name="cadastro_cep_padrao" id="cadastro_cep_padrao" maxlength="8">
																</div>
															</div>

															<div class="form-group">
																<label class="col-sm-3 control-label"><b>Campos que alertam cadastro incompleto</b></label>
															</div>

															<div class="form-group">
																<div class="col-md-8">
																	<label class="checkbox-inline icheck">
																	<input type="checkbox" name="cadastro_flag_6" id="area11" <?php if($cadastro_flag_6) echo " checked " ?> > Nome Completo
																	</label>
																</div>
															</div>

															<div class="form-group">
																<div class="col-md-8">
																	<label class="checkbox-inline icheck">
																	<input type="checkbox" name="cadastro_flag_7" id="area11" <?php if($cadastro_flag_7) echo " checked " ?> > Telefone ou Celular
																	</label>
																</div>
															</div>

															<div class="form-group">
																<div class="col-md-8">
																	<label class="checkbox-inline icheck">
																	<input type="checkbox" name="cadastro_flag_8" id="area11" <?php if($cadastro_flag_8) echo " checked " ?> > Aniversário
																	</label>
																</div>
															</div>

															<div class="form-group">
																<div class="col-md-8">
																	<label class="checkbox-inline icheck">
																	<input type="checkbox" name="cadastro_flag_9" id="area11" <?php if($cadastro_flag_9) echo " checked " ?> > E-mail
																	</label>
																</div>
															</div>

															<div class="form-group">
																<div class="col-md-8">
																	<label class="checkbox-inline icheck">
																	<input type="checkbox" name="cadastro_flag_5" id="area11" <?php if($cadastro_flag_5) echo " checked " ?> > CEP
																	</label>
																</div>
															</div>

															<div class="form-group">
																<div class="col-md-4">
																	<label class="checkbox-inline icheck">
																	<input type="checkbox" name="cadastro_flag_1" id="area11" <?php if($cadastro_flag_1) echo " checked " ?> > Endereço
																	</label>
																</div>
															</div>

															<div class="form-group">
																<div class="col-md-4">
																	<label class="checkbox-inline icheck">
																	<input type="checkbox" name="cadastro_flag_2" id="area11" <?php if($cadastro_flag_2) echo " checked " ?> > Bairro
																	</label>
																</div>
															</div>

															<div class="form-group">
																<div class="col-md-8">
																	<label class="checkbox-inline icheck">
																	<input type="checkbox" name="cadastro_flag_3" id="area11" <?php if($cadastro_flag_3) echo " checked " ?> > Cidade
																	</label>
																</div>
															</div>

															<div class="form-group">
																<div class="col-md-8">
																	<label class="checkbox-inline icheck">
																	<input type="checkbox" name="cadastro_flag_4" id="area11" <?php if($cadastro_flag_4) echo " checked " ?> > Estado
																	</label>
																</div>
															</div>

															<div class="form-group">
																<div class="col-md-12 col-sm-offset-2">
																	<button class="btn-primary btn" onclick="javascript:document.forms['form4'].submit();">Atualizar</button>
																</div>
															</div>		

														</form>
													</div>
												</div>
											</div>
										</div>

									</div>
									
									<div class="tab-pane" id="tab5">

										<div class="row">
											<div class="col-md-12">
												<div class="panel panel-default">
													<div class="panel-heading"><h2>Estoque</h2></div>
													<div class="panel-body">
														<form name="form5" action="gravar_preferencias.php" method="post" class="form-horizontal">

															<input type="hidden" name="acao" value="estoque">

															<div class="form-group">
																<div class="col-md-4">
																	<label class="checkbox-inline icheck">
																	<input type="checkbox" name="estoque_flg_1" id="estoque_flg_1" <?php if($estoque_flg_1) echo " checked " ?> > 
																	Atualizar automaticamente o campo "Custo", no cadastro de cada produto, de acordo com o custo médio do produto em estoque.
																	</label>
																</div>
															</div>
														</form>

														<div class="form-group">
															<div class="col-md-12 col-sm-offset-2">
																<button class="btn-primary btn" onclick="javascript:document.forms['form5'].submit();">Atualizar</button>
															</div>
														</div>

													</div>
												</div>												
											</div>
											
									</div>

									</div>

								</div>	</div></div>
								
						

<?php 
}
include('../include/rodape_interno2.php');
?>

<script>
	$(document).ready(function(){
		$('#telefone').mask('(99) 9999-9999');
		$('#celular').mask('(99) 99999-9999');
		$('#cep').mask('99999-999');		
		$('#cadastro_cep_padrao').mask('99999-999');		
	});

	$('#cpicker2').colorpicker()

</script>