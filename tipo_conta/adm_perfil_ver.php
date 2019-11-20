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
	
if ($credencial_ver == '1') { //VERIFICA SE USU�RIO POSSUI ACESSO A ESSA �REA	
	
	if (isset($_REQUEST['id'])) {
		$tipo = $_REQUEST["id"];
	}
		
	$sql = "
	select		t.descricao, g.nome as grupo 
	from 		tipo_conta t 
	left join 	grupos g on g.cod_grupo = t.cod_grupo 
	where 		t.cod_tipo_conta = ".$tipo.";";
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		if ($rs = mysql_fetch_array($query)){
			$descricao 	= $rs['descricao'];
			$grupo 		= $rs['grupo'];
		}
	}
	
?>
				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">                                
								<li><a href="#">Principal</a></li>
								<li class="active"><a href="adm_perfil.php">Tipo de Conta</a></li>
                            </ol>
                            <div class="page-heading">            
                                <h1>Tipo de Conta</h1>
                                <div class="options">
								</div>
                            </div>
                            <div class="container-fluid">
                                

								<div data-widget-group="group1">

									<div class="panel panel-default" data-widget='{"draggable": "false"}'>
										<div class="panel-heading">
											<h2>Visualizar Tipo de Conta</h2>
										</div>
										<div class="panel-body">

											<form action="adm_perfil.php" class="form-horizontal row-border" name='frm' method="post">

												<div class="row">

													<div class="form-group">
														<label class="col-sm-2 control-label"><b>Descrição</b></label>
														<div class="col-sm-8">
															<label class="control-label"><?php echo $descricao;?></label>
														</div>
													</div>

												</div>

												<div class="row">

													<div class="form-group">

														<label class="col-sm-2 control-label"><b>Grupo</b></label>

														<div class="col-sm-8">
															<label class="control-label"><?php echo $grupo;?></label>
														</div>

													</div>
												</div>

											</form>

											<div class="panel-footer">
												<div class="row">
													<div class="col-sm-8 col-sm-offset-2">
														<button class="btn-default btn" onclick="javascript:window.location='adm_perfil.php';">Voltar</button>
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

include('../include/rodape_interno2.php');

?>