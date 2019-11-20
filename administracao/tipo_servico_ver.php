<?php include('../include/topo_interno.php');
	
	//*********** VERIFICA CREDENCIAIS DE USU¡RIOS *************
	$credencial_ver = 0;
	$credencial_incluir = 0;
	$credencial_editar = 0;
	$credencial_excluir = 0;
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "tiposervico_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "tiposervico_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "tiposervico_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "tiposervico_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}
	
if ($_SESSION['usuario_conta'] == '1') { //VERIFICA SE USU¡RIO POSSUI ACESSO A ESSA ¡REA
	
	if (isset($_REQUEST['id'])) {
		$id = $_REQUEST["id"];
	}
		
	$sql = "Select * from tipo_servico_company where cod_tipo_servico = " . $id;
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		if ($rs = mysql_fetch_array($query)){
			$descricao = $rs['descricao'];
		}
	}
	
?>
        <div id="wrapper">
            <div id="layout-static">
                <?php include('menu.php');?>
				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="tipo_servicos.php">Tipo de Servi√ßos</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Tipo de Servi√ßos</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Visualizar Tipo de Servi√ßos</h2>
		</div>
		<div class="panel-body">
			<form action="tipo_contas.php" class="form-horizontal row-border" name='frm' method="post">
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Descri√ß√£o</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $descricao;?></label>
					</div>
				</div>
			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-default btn" onclick="javascript:window.location='tipo_servicos.php';">Voltar</button>
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
include('../include/rodape_interno2.php');?>