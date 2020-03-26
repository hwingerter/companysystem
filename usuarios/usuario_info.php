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
	}
	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar	
	
if (isset($_REQUEST['acao'])){

	$acao = '';
	
	if (isset($_REQUEST['nome'])) { $nome = $_REQUEST['nome']; } else { $nome = ''; }
	if (isset($_REQUEST['email'])) { $email = $_REQUEST['email']; } else { $email = '';	}
	if (isset($_REQUEST['tipo_conta'])) { $tipo_conta = $_REQUEST['tipo_conta']; } else { $tipo_conta = '';	}
	if (isset($_REQUEST['senha'])) { $senha = $_REQUEST['senha']; } else { $senha = '';	}
	if (isset($_REQUEST['status'])) { $status = $_REQUEST['status']; } else { $status = ''; }

	$cod_usuario_cadastro = $_SESSION['usuario_id'];
	$dt_cadastro = date('Y-m-d');
	
	if ($_REQUEST['acao'] == "incluir"){
		
		$cod_empresa 	= $_SESSION['cod_empresa'];

		$sql = "insert into usuarios (nome, email, status, tipo_conta";
		if ($senha != '') { 
			$sql .= ", senha"; 
			$senha .= "&D31R#i017$";
			$senha = md5($senha);
		}
		$sql .= "
		,cod_usuario_cadastro, dt_cadastro
		) values ('".limpa($nome)."', '". limpa($email) ."','". limpa($status) ."', ". limpa_int($tipo_conta);
		if ($senha != '') { $sql .= ",'". $senha ."'"; }
		$sql .= "
		,'". limpa($cod_usuario_cadastro) ."'
		,'". limpa($dt_cadastro) ."'
		)";
		//echo$sql;die;
		mysql_query($sql);

		//retornando usuarios cadastrado
		$sql = "select max(cod_usuario) as cod_usuario from usuarios where cod_usuario_cadastro = ".$cod_usuario_cadastro.";";
		//echo$sql;die;
		$query = mysql_query($sql);
		$rs1 = mysql_fetch_array($query);
		$cod_usuario = $rs1['cod_usuario'];

		//VINCULAR A EMPRESA AO GRUPO
		$sql = "insert into usuarios_grupos_empresas (cod_usuario, cod_empresa) 
				values ('".limpa($cod_usuario)."', '".limpa($cod_empresa)."');";
		//echo$sql;die;
		mysql_query($sql);
		
		echo "<script language='javascript'>window.location='usuarios.php?sucesso=1';</script>";
		
	}else if ($_REQUEST['acao'] == "atualizar"){
		
		$cod_grupo = $_SESSION['cod_grupo'];

		$sql = "update usuarios set nome='".limpa($nome)."', status='". limpa($status) ."', email = '". limpa($email) ."', tipo_conta = ". $tipo_conta;
		if ($senha != '') { 
			$senha .= "&D31R#i017$";
			$senha = md5($senha);
			$sql .= ", senha = '". $senha ."'"; 
		}
		$sql .= " where cod_usuario = ".$_REQUEST['id'];
		mysql_query($sql);
		
		echo "<script language='javascript'>window.location='usuarios.php?sucesso=2';</script>";
	
	}
	
}

if (isset($_REQUEST['acao'])){
	
	if ($_REQUEST['acao'] == "alterar"){
		
		$acao = $_REQUEST['acao'];
		
		if (isset($_REQUEST['id'])) {
			$usuario = $_REQUEST["id"];
		}
		
		$sql = "Select * from usuarios where cod_usuario = " . $usuario;
		$query = mysql_query($sql);
		$registros = mysql_num_rows($query);
		if ($registros > 0) {
			if ($rs = mysql_fetch_array($query)){
				$nome = $rs['nome'];
				$status = $rs['status'];
				$email = $rs['email'];
				$tipo_conta = $rs['tipo_conta'];
			}
		}
	
	}
	
}

	$cod_grupo = $_SESSION['cod_grupo'];

	if ($_REQUEST['acao'] == ""){
		$voltar = urlencode("../usuarios/usuario_info.php");
	}
	else {
		$voltar = urlencode("../usuarios/usuario_info.php?acao=alterar&id=".$usuario);
	}


	
?>
				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="usuarios.php">Usuários</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Usuário</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Dados do Usuário</h2>
		</div>
		<div class="panel-body">
			<form action="usuario_info.php" class="form-horizontal row-border" name='frm' method="post">
              <?php if ($acao=="alterar"){?>
              <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
              <input type="hidden" name="acao" value="atualizar">
              <?php }else{?>
              <input type="hidden" name="acao" value="incluir">
			  <?php } ?>				
			  
			  <div class="form-group">
					<label class="col-sm-2 control-label"><b>Tipo Conta</b></label>
					<div class="col-sm-8">
						<?php
							ComboTipoConta($cod_empresa, $tipo_conta);
						?>						
					</div>
					<div class="col-sm-2">
							<button class="btn-primary btn" type="button" onclick="javascript:location.href='../perfil/tipo_conta_info.php?voltar=<?php echo $voltar;?>';">+</button>
						</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Nome</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" <?php if ($acao == "alterar"){echo "value='". $nome ."'";}?> name="nome" maxlength="100">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>E-mail</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" <?php if ($acao == "alterar"){echo "value='". $email ."'";}?> name="email" maxlength="255">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Senha</b></label>
					<div class="col-sm-4">
						<input type="password" class="form-control" value="" name="senha" maxlength="10"> 						
					</div>
					<!--div class="col-sm-4">
						<button class="btn-danger btn" onclick="javascript:document.forms['frm'].submit();">Resetar Senha</button>
					</div-->
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
						<button class="btn-default btn" onclick="javascript:window.location='usuarios.php';">Voltar</button>
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

require_once "../include/rodape_interno2.php";

?>