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
	
	
if ($credencial_ver == '1') { //VERIFICA SE USU�RIO POSSUI ACESSO A ESSA �REA
	
	if (isset($_REQUEST['id'])) {
		
		$grupo   = $_REQUEST["id"];

		if (isset($_REQUEST['sucesso'])) { $sucesso = $_REQUEST['sucesso']; } else { $sucesso = ''; }
	}


	if (isset($_REQUEST['acao'])){


		$acao = $_REQUEST['acao'];

		$cod_empresa = $_REQUEST["cod_empresa"];

		if ($acao == "vincular"){
			
			$sql = "insert into grupo_empresas (cod_grupo, cod_empresa) values ('".limpa($grupo)."', '".limpa($cod_empresa)."');";
			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='grupo_vincular.php?id=".$grupo."&sucesso=1';</script>";
			
		}else if ($acao == "desvincular"){
			
			$sql = "delete from grupo_empresas where cod_grupo = '".limpa($grupo)."' and cod_empresa = '".limpa($cod_empresa)."';";
			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='grupo_vincular.php?id=".$grupo."&sucesso=2';</script>";
		
		}


	}

	
	$sql = "Select * from grupos where cod_grupo = " . $grupo;
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		if ($rs = mysql_fetch_array($query)){
			$nome = $rs['nome'];
			$status = $rs['status'];
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
                                <h1>Empresas do grupo</h1>
                                <div class="options"></div>
                            </div>

                            <div class="container-fluid">

							<?php 

								if ($sucesso == '1') {
								?>

									<div class="alert alert-dismissable alert-success">
										<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Empresa vinculada com sucesso!</strong>
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									</div>

								<?php

								}elseif ($sucesso == '2') {
								?>
									<div class="alert alert-dismissable alert-success">
										<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Empresa desvinculada com sucesso!</strong>
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									</div>
								<?php
								}


							?>
                                

							<div data-widget-group="group1">

								<div class="panel panel-default" data-widget='{"draggable": "false"}'>

									<div class="panel-heading">
										<h2><?php echo $nome;?></h2>
									</div>

									<div class="panel-body">

										<form action="grupos.php" class="form-horizontal row-border" name='frm' method="post">

											<div class="form-group">

												<label class="control-label"><b>Empresas Vinculadas</b></label>
										

												<table class="table" border="1" bordercolor="#EEEEEE" style="margin: 0 auto; width: 100%;">
								                    <thead>
								                        <tr>
								                        	<th width="20">&nbsp;</th>
															<th>Empresa</th>
								                    </thead>
								                    <tbody>
													    <?php
															//CARREGA LISTA
														$sql = "
														select			e.cod_empresa, e.empresa
														from 			empresas e
														inner join 		grupo_empresas g on g.cod_empresa = e.cod_empresa
														where 			g.cod_grupo = ".$grupo."
														order by		e.empresa asc;
														";

														$query = mysql_query($sql);

														$registros = mysql_num_rows($query);

														if ($registros > 0) 
														{
															while ($rs = mysql_fetch_array($query))
															{ 
															?>
													                        <tr>
													                        	<td align="left">
																					<a 
																						class="btn btn-danger btn-label" 
																						href="grupo_vincular.php?acao=desvincular&id=<?php echo $grupo;?>&cod_empresa=<?php echo $rs['cod_empresa'];?>">

																						<i class="fa fa-times-circle"></i>Desvincular
																					</a>
													                        	</td>
																				<td align="left"><?php echo $rs['empresa'];?></td>
													                        </tr>
													    <?php
															} // while
														?>
													                        <tr>
													                            <td align="right" colspan="8"><b>Total de registro: <?php echo $registros; ?></b></td>
													                        </tr>
													<?php
														} 
														else 
														{ // registro
														?>
													                        <tr>
													                            <td align="center" colspan="8">Não tem nenhum registro!</td>
													                        </tr>
													<?php
														}
													?>		
									                    </tbody>


												</table>

											</div>

										</form>

										<form action="grupos.php" class="form-horizontal row-border" name='frm' method="post">

											<div class="form-group">

												<label class="control-label"><b>Empresas</b></label>
										

												<table class="table" border="1" bordercolor="#EEEEEE" style="margin: 0 auto; width: 100%;">
								                    <thead>
								                        <tr>
								                        	<th width="20">&nbsp;</th>
															<th>Empresa</th>
								                    </thead>
								                    <tbody>
													    <?php
															//CARREGA LISTA
														$sql = "
														select 		e.cod_empresa, e.empresa
														from 		empresas e
														where		e.cod_empresa not in (select g.cod_empresa from grupo_empresas g)
														order by	e.empresa asc;
														";

														$query = mysql_query($sql);

														$registros = mysql_num_rows($query);

														if ($registros > 0) 
														{
															while ($rs = mysql_fetch_array($query))
															{ 
															?>
													                        <tr>
													                        	<td align="left">
																					<a 
																						class="btn btn-success btn-label" 
																						href="grupo_vincular.php?acao=vincular&id=<?php echo $grupo;?>&cod_empresa=<?php echo $rs['cod_empresa'];?>">

																						<i class="fa fa-plus-circle"></i>Vincular
																					</a>
													                        	</td>
																				<td align="left"><?php echo $rs['empresa'];?></td>
													                        </tr>
													    <?php
															} // while
														?>
													                        <tr>
													                            <td align="right" colspan="8"><b>Total de registro: <?php echo $registros; ?></b></td>
													                        </tr>
													<?php
														} 
														else 
														{ // registro
														?>
													                        <tr>
													                            <td align="center" colspan="8">Não tem nenhum registro!</td>
													                        </tr>
													<?php
														}
													?>		
									                    </tbody>

												</table>


											</div>

										</form>

										<div class="panel-footer">
											<div class="row">
												<div class="col-sm-1">
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
	
include('../include/rodape_interno2.php');
?>