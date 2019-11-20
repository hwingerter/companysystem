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
	
	/*for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "usuario_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "usuario_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "usuario_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "usuario_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}*/
	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar	
	
	$acao = '';
	
	if (isset($_REQUEST['nome'])) { $nome = $_REQUEST['nome']; } else { $nome = ''; }
	if (isset($_REQUEST['cod_licenca'])) { $cod_licenca = $_REQUEST['cod_licenca']; } else { $cod_licenca = ''; }
	if (isset($_REQUEST['status'])) { $status = $_REQUEST['status']; } else { $status = ''; }

if (isset($_REQUEST['acao'])){
	
	if ($_REQUEST['acao'] == "incluir"){
		
		$sql = "insert into grupos (cod_licenca, nome, status) values ('". limpa($cod_licenca) ."', '".limpa($nome)."', '". limpa($status) ."')";
		mysql_query($sql);
		
		echo "<script language='javascript'>window.location='grupos.php?sucesso=1';</script>";
		
	}else if ($_REQUEST['acao'] == "atualizar"){
		
		$sql = "update grupos set cod_licenca = '". limpa($cod_licenca) ."', nome='".limpa($nome)."', status='". limpa($status) ."' where cod_grupo = ".$_REQUEST['id'];
		mysql_query($sql);
		
		echo "<script language='javascript'>window.location='grupos.php?sucesso=2';</script>";
	
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
	
?>
				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="grupos.php">Grupos</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Grupo de Empresas</h1>
                                <div class="options"></div>
                            </div>
                            <div class="container-fluid">
                                

								<div data-widget-group="group1">

										<div class="panel panel-default" data-widget='{"draggable": "false"}'>
											<div class="panel-heading">
												<h2>Dados do Grupo</h2>
											</div>
											<div class="panel-body">

												<form action="grupo_info.php" class="form-horizontal row-border" name='frm' method="post">

									              <?php if ($acao=="alterar"){?>
									              <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
									              <input type="hidden" name="acao" value="atualizar">
									              <?php }else{?>
									              <input type="hidden" name="acao" value="incluir">
									              <?php } ?>				

													<div class="form-group">
														<label class="col-sm-2 control-label"><b>Nome</b></label>
														<div class="col-sm-8">
															<input type="text" class="form-control" <?php if ($acao == "alterar"){echo "value='". $nome ."'";}?> name="nome" maxlength="100">
														</div>
													</div>


													<div class="form-group">
														<label class="col-sm-2 control-label"><b>Licença</b></label>
														<div class="col-sm-8">
														  <select name="cod_licenca" class="form-control">
															<option value="">Selecione a Licença </option>
										                    <?php
										                    $query = mysql_query("select cod_licenca, descricao from licencas order by descricao asc") or die (mysql_error());
															while($rs = mysql_fetch_array($query)){
															?>
															<option value="<?php echo $rs['cod_licenca'];?>"
															<?php if ($cod_licenca == $rs['cod_licenca']) { echo " Selected"; }?>
															><?php echo htmlentities($rs['descricao']);?></option>
										                    <?php
															}
															?>
														  </select>						
														</div>
													</div>

													<div class="form-group">
														<label class="col-sm-2 control-label"><b>Status</b></label>
														<div class="col-sm-8">
															<select class="form-control" id="source" name="status">
																<option value="A" <?php if ($acao == "alterar"){ if ($status == 'A') { echo "selected"; } }?>>Ativo</option>
																<option value="I" <?php if ($acao == "alterar"){ if ($status == 'I') { echo "selected"; } }?>>Inativo</option>
															</select>
														</div>
													</div>

												</form>

												<div class="panel-footer">
													<div class="row">
														<div class="col-sm-8 col-sm-offset-2">
															<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Gravar</button>
															<button class="btn-default btn" onclick="javascript:window.location='grupos.php';">Voltar</button>
														</div>
													</div>
												</div>
											</div>
										</div>



                            </div> <!-- .container-fluid -->
                        </div> <!-- #page-content -->
					</div>
<?php 
}
	
include('../include/rodape_interno2.php');
?>