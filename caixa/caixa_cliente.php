<?php 
	require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";

	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	
	
	
	
	
	$credencial_ver = 1;
	$credencial_incluir = 1;
	$credencial_editar = 1;
	$credencial_excluir = 1;
	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar
	
	$acao = '';

	$cod_empresa = $_SESSION['cod_empresa'];

?>

		<script language="javascript" src="js/caixa.js"></script>

				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
								<li><a href="#">Principal</a></li>
								<li class="active"><a href="grupo_produtos.php">Grupo de Produtos</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Receber D�vidas</h1>
                                <div class="options"></div>
                            </div>
                            <div class="container-fluid">
                                

							<div data-widget-group="group1">

								<div class="panel panel-default" data-widget='{"draggable": "false"}'>
									<div class="panel-heading">
										<h2>Cliente</h2>
									</div>
									<div class="panel-body">
										<form action="comanda_cliente.php" class="form-horizontal row-border" name='frm' method="post">
							              <?php if ($acao=="alterar"){?>
							              <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
							              <input type="hidden" name="acao" value="atualizar">
							              <?php }else{?>
							              <input type="hidden" name="acao" value="incluir">
							              <?php } ?>

							              <?php  ?>

							             <?php if (TemClientesDivida($cod_empresa) > 0) { ?>

											<div class="form-group">
												<label class="col-sm-2 control-label"><b>Selecione o cliente</b></label>
												<div class="col-sm-4">
													<?php 
														ComboClienteDividas($cod_cliente, $cod_empresa);													
													?>
												</div>
											</div>
										</form>
										<div class="panel-footer">
											<div class="row">
												<div class="col-sm-8 col-sm-offset-2">
													<button class="btn-primary btn" onclick="javascript:SelecionaClienteDivida();">Selecionar</button>
													<button class="btn-default btn" onclick="javascript:window.location='caixa_gaveta_caixa.php';">Voltar</button>
												</div>
											</div>
										</div>

										<?php }else{  ?>

											<div class="form-group">
												<label class="col-sm-2 control-label">Nenhum cliente com divida.</label>
											</div>
										</form>
										<div class="panel-footer">
											<div class="row">
												<div class="col-sm-8 col-sm-offset-2">
													<button class="btn-default btn" onclick="javascript:window.location='caixa_gaveta_caixa.php';">Voltar</button>
												</div>
											</div>
										</div>

									<?php } ?>


									</div>
								</div>
							</div>
						</div>
					</div>



<?php 
} // INCLUIR OU EDITAR
include('../include/rodape_interno2.php');?>