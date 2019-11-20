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
	
if ($credencial_ver == '1') { //VERIFICA SE USU�RIO POSSUI ACESSO A ESSA �REA
	
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
			$senha = $rs['senha'];
			$tipo_conta = $rs['tipo_conta'];
		}
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
                                <h1>Usuários</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Visualizar Usuário</h2>
		</div>
		<div class="panel-body">
			<form action="usuarios.php" class="form-horizontal row-border" name='frm' method="post">
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Nome</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $nome;?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>E-mail</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $email;?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Tipo Conta</b></label>
					<div class="col-sm-8">
						<label class="control-label">					
						<?php
							echo ExibeTipoConta($tipo_conta);
						?>
						</label>						
					</div>
				</div>				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Status</b></label>
					<div class="col-sm-8">
						<label class="control-label">
						<?php if ($status == 'A') { echo "Ativo"; } else if ($status == 'I') { echo "Inativo"; }?>
						</label>
					</div>
				</div>
			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-default btn" onclick="javascript:window.location='usuarios.php';">Voltar</button>
					</div>
				</div>
			</div>
		</div>
	</div>


	</div> <!-- .container-fluid -->

<?php 
} // VER

include('../include/rodape_interno2.php');
?>