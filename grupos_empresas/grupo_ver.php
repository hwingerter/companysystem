<?php 

	include('../include/topo_interno.php');

	//*********** VERIFICA CREDENCIAIS DE USUÁRIOS *************
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
	
if ($credencial_ver == '1') { //VERIFICA SE USUÁRIO POSSUI ACESSO A ESSA ÁREA

	if (isset($_REQUEST['id'])) {
		$grupo = $_REQUEST["id"];
	}
		
	$sql = "
	Select g.*, l.descricao from grupos g
	left join licencas l on l.cod_licenca = g.cod_licenca
	where g.cod_grupo = " . $grupo;
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		if ($rs = mysql_fetch_array($query)){
			$nome = $rs['nome'];
			$status = $rs['status'];
			$licenca = $rs['descricao'];
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
                                <h1>Grupos de Empresas</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Visualizar Grupo</h2>
		</div>
		<div class="panel-body">
			<form action="grupos.php" class="form-horizontal row-border" name='frm' method="post">
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Nome</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $nome;?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Licenca</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $licenca;?></label>
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
} // VER
	
include('../include/rodape_interno.php')
?>