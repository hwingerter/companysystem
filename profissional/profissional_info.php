<?php 

	require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";
	
	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	$credencial_ver = 0;
	$credencial_incluir = 0;
	$credencial_editar = 0;
	$credencial_excluir = 0;
	
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
	
	$cod_empresa = $_SESSION['cod_empresa'];

	if (isset($_REQUEST['apelido'])) { $apelido = $_REQUEST['apelido']; } else { $apelido = ''; }
	if (isset($_REQUEST['nome'])) { $nome = $_REQUEST['nome']; } else { $nome = ''; }
	if (isset($_REQUEST['telefone'])) { $telefone = $_REQUEST['telefone']; } else { $telefone = ''; }
	if (isset($_REQUEST['celular'])) { $celular = $_REQUEST['celular']; } else { $celular = ''; }
	if (isset($_REQUEST['email'])) { $email = $_REQUEST['email']; } else { $email = '';	}

	if ($_REQUEST['dia_aniversario'] != ""){
 		$dia_aniversario = "'".$_REQUEST['dia_aniversario']."'";
	}else{
		$dia_aniversario = "NULL";
	}

	if ($_REQUEST['mes_aniversario'] != ""){
 		$mes_aniversario = "'".$_REQUEST['mes_aniversario']."'";
	}else{
		$mes_aniversario = "NULL";
	}

	if ($_REQUEST['codcidade'] != ""){
 		$codcidade = "'".$_REQUEST['codcidade']."'";
	}else{
		$codcidade = "NULL";
	}

	if ($_REQUEST['codestado'] != ""){
 		$codestado = "'".$_REQUEST['codestado']."'";
	}else{
		$codestado = "NULL";
	}

	if (isset($_REQUEST['endereco'])) { $endereco = $_REQUEST['endereco']; } else { $endereco = ''; }
	if (isset($_REQUEST['bairro'])) { $bairro = $_REQUEST['bairro']; } else { $bairro = ''; }
	if (isset($_REQUEST['cep'])) { $cep = $_REQUEST['cep']; } else { $cep = ''; }

	if (isset($_REQUEST['mostrar_agenda'])) { $mostrar_agenda = $_REQUEST['mostrar_agenda']; } else { $mostrar_agenda = '0'; }
	if (isset($_REQUEST['agendamento_online'])) { $agendamento_online = $_REQUEST['agendamento_online']; } else { $agendamento_online = '0'; }
	if (isset($_REQUEST['obs'])) { $obs = $_REQUEST['obs']; } else { $obs = ''; }
	

	
	
	if (isset($_REQUEST['atualizar'])) { $atualizar = $_REQUEST['atualizar']; } else { $atualizar = ''; }
	
if ($atualizar != '1') {
	
	if (isset($_REQUEST['acao'])) {
		
		if ($_REQUEST['acao'] == "incluir"){
			
			$sql = "insert into profissional 
			(cod_empresa, apelido, nome, dia_aniversario, mes_aniversario, telefone, celular, email, endereco, bairro, cep ";
			if ($estado != '') { $sql .= ", estado"; }
			if ($cidade != '') { $sql .= ", cidade"; }

			$sql .= ", mostrar_agenda, agendamento_online, obs) 
			values 
			('".limpa($cod_empresa)."', '".limpa($apelido)."', '".limpa($nome)."', ".limpa($dia_aniversario).", ".limpa($mes_aniversario)."
			,'". limpa($telefone) ."', '". limpa($celular) ."', '".limpa($email)."', '". limpa($endereco) ."', '". limpa($bairro) ."','". limpa($cep) ."' ";
			
			if ($estado != '') { $sql .= ",". limpa_int($estado); }
			if ($cidade != '') { $sql .= ",". limpa_int($cidade); }

			$sql .= ", '". limpa($mostrar_agenda) ."', '". limpa($agendamento_online) ."', '". limpa($obs) ."')";

			//echo $sql; die;

			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='profissionais.php?sucesso=1';</script>";
			
		}else if ($_REQUEST['acao'] == "atualizar"){
			

		$sql = "
		UPDATE profissional
		SET
		cod_empresa = '".limpa($cod_empresa)."',
		apelido = '".limpa($apelido)."',
		nome = '".limpa($nome)."',
		cpf = '".limpa($cpf)."',
		telefone = '".limpa($telefone)."',
		celular = '".limpa($celular)."',
		email = '".limpa($email)."',
		dia_aniversario = ".limpa($dia_aniversario).",
		mes_aniversario = ".limpa($mes_aniversario).",
		cep = '".limpa($cep)."',
		endereco = '".limpa($endereco)."',
		bairro = '".limpa($bairro)."',
		cidade = ".limpa($codcidade).",
		estado = ".limpa($codestado).",
		obs = '".limpa($obs)."',
		mostrar_agenda = '".limpa($mostrar_agenda)."',
		agendamento_online = '".limpa($agendamento_online)."'
		WHERE cod_profissional = ".$_REQUEST['id']."";

		//echo $sql; die;

			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='profissionais.php?sucesso=2';</script>";
			
		}
		
	}
	
	if (isset($_REQUEST['acao'])){
		
		if ($_REQUEST['acao'] == "alterar"){
			
			$acao = $_REQUEST['acao'];
			
			if (isset($_REQUEST['id'])) {
				$id = $_REQUEST["id"];
			}
			
			$sql = "Select * from profissional where cod_profissional = " . $id;
			$query = mysql_query($sql);
			$registros = mysql_num_rows($query);
			if ($registros > 0) {
				if ($rs = mysql_fetch_array($query)){
					$apelido = $rs['apelido'];
					$nome = $rs['nome'];
					$empresa = $rs['empresa'];
					$email = $rs['email'];
					$dia_aniversario = $rs['dia_aniversario'];
					$mes_aniversario = $rs['mes_aniversario'];
					$cpf = $rs['cpf'];
					$endereco = $rs['endereco'];
					$cep = $rs['cep'];
					$estado = $rs['estado'];
					$cidade = $rs['cidade'];
					$telefone = $rs['telefone'];
					$celular = $rs['celular'];
					$bairro = $rs['bairro'];
					$obs = $rs['obs'];
					$mostrar_agenda =  $rs['mostrar_agenda'];
					$agendamento_online =  $rs['agendamento_online'];
					
				}
			}
		
		}
		
	}

}
	
?>
	 <script src="../js/cidade_ComboAjax.js"></script>
	<script language='JavaScript'>
	function Atualizar() {
		document.forms['frm'].action = "profissional_info.php?atualizar=1";
		document.forms['frm'].submit();
	}
	</script>	 
				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="profissionais.php">Profissional</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Profissional</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Dados do Profissional</h2>
		</div>
		<div class="panel-body">

			<form action="profissional_info.php" class="form-horizontal row-border" name='frm' method="post">
				
              <?php if ($acao=="alterar"){?>
              <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
              <input type="hidden" name="acao" value="atualizar">
              <?php }else{?>
              <input type="hidden" name="acao" value="incluir">
              <?php } ?>						
				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Apelido</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $apelido;?>" name="apelido" maxlength="100">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Nome Completo</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $nome;?>" name="nome" maxlength="100">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Telefone</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $telefone;?>" name="telefone" maxlength="100">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Celular</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $celular;?>" name="celular" maxlength="100">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>E-mail</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $email;?>" name="email" maxlength="200">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Dia Aniversário</b></label>
					<div class="col-sm-8">
					  <select name="dia_aniversario" class="form-control">
						<option value="">Selecione...</option>

						<?php 
						$i=1;
						while($i <= 31){
						?>
							<option value="<?php echo $i;?>"
								<?php if ($dia_aniversario == $i) { echo " Selected "; } ?>
								><?php echo $i; ?></option>
						<?php 
						$i++;
						}
						?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Mês Aniversário</b></label>
					<div class="col-sm-8">
					  <select name="mes_aniversario" class="form-control">
						<option value="">Selecione...</option>

						<?php 
						$i=1;
						while($i <= 12){
						?>
							<option value="<?php echo $i;?>"
								<?php if ($mes_aniversario == $i) { echo " Selected "; } ?>
							 ><?php echo RetornaMes($i); ?></option>
						<?php 
						$i++;
						}
						?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>CEP</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $cep;?>" name="cep" maxlength="10">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Endereço</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $endereco;?>" name="endereco" maxlength="200">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Bairro</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $bairro;?>" name="bairro" maxlength="200">
					</div>
				</div>
				<?php 
				if ($cidade != '') {
				?>
				<script language='JavaScript'>EditaCidade('<?php echo $estado; ?>','<?php echo $cidade; ?>');</script>
				<?php
				}
				?>				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Estado</b></label>
					<div class="col-sm-8">
					  <select name="codestado" Onchange='atualizaCidade(this.value);' class="form-control">
						<option value="">UF</option>
	                    <?php
	                    $query = mysql_query("select * from estados order by uf asc") or die (mysql_error());
						while($rs = mysql_fetch_array($query)){
						?>
						<option value="<?php echo $rs['cod_estado'];?>"
						<?php if ($estado == $rs['cod_estado']) { echo " Selected"; }?>
						><?php echo htmlentities($rs['uf']);?></option>
	                    <?php
						}
						?>
					  </select>						
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Cidade</b></label>
					<div class="col-sm-8">
                    <div id="city">
				  	<select name="codcidade" class="form-control">
						<option value="">Selecione</option>
 					</select>
					</div>						
					</div>
				</div>	
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Observações</b></label>
					<div class="col-sm-1">
						<textarea name="obs" class="form-control" style="width:800px; height:200px;"><?php echo $obs; ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Mostrar na Agenda</b></label>
					<div class="col-sm-1">
						<input type="checkbox" class="form-control" name="mostrar_agenda" value="1"
							<?php if($mostrar_agenda == 1) { echo "checked"; } ?>
						>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Utiliza Agendamento Online</b></label>
					<div class="col-sm-1">
						<input type="checkbox" class="form-control" name="agendamento_online" value="1"
							<?php if($agendamento_online == 1) { echo "checked"; } ?>
						>
					</div>
				</div>
			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Gravar</button>
						<button class="btn-default btn" onclick="javascript:window.location='profissionais.php';">Cancel</button>
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