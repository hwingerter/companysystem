<?php include('../../include/topo_interno_relatorio.php');
	
//*********** VERIFICA CREDENCIAIS DE USUÁRIOS *************
$credencial_ver = 0;
$credencial_incluir = 0;
$credencial_editar = 0;
$credencial_excluir = 0;

$credencial_ver = 1;
$credencial_incluir = 1;
$credencial_editar = 1;
$credencial_excluir = 1;

$cod_empresa 		= $_SESSION['cod_empresa'];

if ($credencial_ver == '1') { //VERIFICA SE USUÁRIO POSSUI ACESSO A ESSA ÁREA


?>

 	<div class="static-content-wrapper">
			<div class="static-content">
				<div class="page-content">
					<ol class="breadcrumb">                                
						<li><a href="#">Principal</a></li>
						<li class="active"><a href="visualizar_caixas_fechados.php">Caixas Fechados</a></li>
					</ol>
					
					<div class="page-heading">            
						<h1>Caixas Fechados</h1>
					</div>
				
					<form action="relatorio_caixas_fechados.php" class="form-horizontal" name='frm' method="post">

						<div class="row">
							<div class="col-sm-12">
								<div class="panel panel-sky">
									<div class="panel-heading">
										<h2>Filtros</h2>
									</div>
									<div class="panel-body">
										<div class="form-group">
											<label class="col-sm-2 control-label">Caixas Fechados</label>
											<div class="col-sm-2">
												<?php ComboReabrirCaixaAntigo($cod_empresa, $cod_caixa); ?>
											</div>
											<div class="col-sm-2">
												<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Buscar</button>
											</div>
										</div>
									</div>
								</div>	
							</div>
						</div>

					</form>


</div> <!-- .container-fluid -->
			

 <?php 
}
 
 include('../../include/rodape_interno_relatorio.php'); ?>