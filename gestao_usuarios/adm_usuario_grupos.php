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
	
	if (isset($_REQUEST['cod_usuario'])) {
		
		$usuario = $_REQUEST["cod_usuario"];
		$sucesso = $_REQUEST["sucesso"];

	}


	if (isset($_REQUEST['acao'])){


		$acao = $_REQUEST['acao'];

		$cod_usuario 	= $_REQUEST["cod_usuario"];
		$nome_usuario	= $_REQUEST["nome_usuario"];
		$cod_grupo		= $_REQUEST["cod_grupo"];
		$cod_empresa	= $_REQUEST["cod_empresa"];		

		if ($acao == "vincular"){
			
			$sql = "insert into usuarios_grupos_empresas (cod_usuario, cod_grupo, cod_empresa) 
						values ('".limpa($cod_usuario)."', '".limpa($cod_grupo)."', '".limpa($cod_empresa)."');";

			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='adm_usuario_grupos.php?cod_usuario=".$cod_usuario."&cod_grupo=".$cod_grupo."&nome_usuario=".$nome_usuario."&sucesso=1';</script>";
			
		}else if ($acao == "vincular_todos"){
			
			$sql = "
			insert into usuarios_grupos_empresas
						(cod_usuario, cod_grupo, cod_empresa)
			select		'".$cod_usuario."' as cod_usuario, '".$cod_grupo."' as cod_grupo, e.cod_empresa
			from		empresas e
			inner join	grupo_empresas ge on ge.cod_empresa = e.cod_empresa
			where		ge.cod_grupo = ".$cod_grupo;

			//echo $sql; die;

			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='adm_usuario_grupos.php?cod_usuario=".$cod_usuario."&cod_grupo=".$cod_grupo."&nome_usuario=".$nome_usuario."&sucesso=1';</script>";
		
		}else if ($acao == "desvincular"){
			
			$sql = "delete from usuarios_grupos_empresas 
						where cod_grupo = '".limpa($cod_grupo)."' and cod_empresa = '".limpa($cod_empresa)."' and cod_usuario = '".limpa($cod_usuario)."' ;";

			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='adm_usuario_grupos.php?cod_usuario=".$cod_usuario."&cod_grupo=".$cod_grupo."&nome_usuario=".$nome_usuario."&sucesso=2';</script>";
		
		}


	}

	$cod_usuario 	= $_REQUEST['cod_usuario'];
	$cod_grupo		= $_REQUEST['cod_grupo'];
	$nome_usuario	= $_REQUEST['nome_usuario'];
	

?>

				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
								<li><a href="#">Principal</a></li>
								<li class="active"><a href="grupos.php">Grupos</a></li>

                            </ol>

                            <div class="page-heading">            
                                <h1>Usuário / Grupo de Empresas</h1>
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
										<h2><b>Usuário: &nbsp; </b></h2> <label><?php echo $nome_usuario;?></label>
									</div>

									<div class="panel-body">

										<form action="grupos.php" class="form-horizontal row-border" name='frm' method="post">

											<div class="form-group">

												<label class="control-label"><b>Empresas já vinculadas ao Usuário</b></label>
										

												<table class="table" border="1" bordercolor="#EEEEEE" style="margin: 0 auto; width: 100%;">
								                    <thead>
								                        <tr>
								                        	<th width="10">&nbsp;</th>
								                        	<th width="200">Grupo</th>
															<th width="200">Empresa</th>
								                    </thead>
								                    <tbody>
													    <?php
															//CARREGA LISTA
														$sql = "
														select 			e.cod_empresa, e.empresa, g.cod_grupo, g.nome as grupo
														from			usuarios_grupos_empresas uge
														inner join  	empresas e on e.cod_empresa = uge.cod_empresa
														inner join		grupo_empresas ge on ge.cod_empresa = e.cod_empresa
														inner join		grupos g on g.cod_grupo = ge.cod_grupo
														where			uge.cod_usuario = ".$cod_usuario."
														order by		g.nome asc,  e.empresa asc;
														";

														$query = mysql_query($sql);

														$registros = mysql_num_rows($query);

														if ($registros > 0) 
														{
															while ($rs = mysql_fetch_array($query))
															{ 
															?>
													                        <tr>
													                        	<td align="center">
																					<a 
																						class="btn btn-danger btn-label" 
																						href="adm_usuario_grupos.php?acao=desvincular&cod_usuario=<?php echo $cod_usuario;?>&cod_grupo=<?php echo $rs['cod_grupo'];?>&cod_empresa=<?php echo $rs['cod_empresa'];?>&nome_usuario=<?php echo $nome_usuario; ?>">

																						<i class="fa fa-times-circle"></i>Desvincular
																					</a>
													                        	</td>
																				<td align="left"><?php echo $rs['grupo'];?></td>
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
													                            <td align="center" colspan="8">Nenuma empresa vinculada!<br></td>
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

											</div>

											<div class="form-group">

												<label class="control-label"><b>Empresas</b></label>

												<?php if ($cod_grupo != "") { ?>
												<div class="col-sm-12">
												
													<a 	class="btn btn-success btn-label" 
														href="adm_usuario_grupos.php?acao=vincular_todos&cod_usuario=<?php echo $cod_usuario;?>&cod_grupo=<?php echo $cod_grupo;?>&nome_usuario=<?php echo $nome_usuario; ?>">
														<i class="fa fa-plus-circle"></i>Vincular Todas
													</a>

												</div>
												<?php } ?>

											</div>

											<div class="form-group">

												<div class="col-sm-12">

													<table class="table" border="1" bordercolor="#EEEEEE" style="margin: 0 auto; width: 100%;">
								                    <thead>
								                        <tr>
								                        	<th width="10">&nbsp;</th>
								                        	<th width="200">Grupo</th>
															<th width="200">Empresa</th>
								                    </thead>
								                    <tbody>
													    <?php
															//CARREGA LISTA

													   	if ($cod_grupo != "") {

															$sql = "
															select 			e.cod_empresa, e.empresa, g.cod_grupo, g.nome as grupo
															from			empresas e
															inner join		grupo_empresas ge on ge.cod_empresa = e.cod_empresa
															inner join		grupos g on g.cod_grupo = ge.cod_grupo
															where			e.cod_empresa not in 
																			(	select 	e1.cod_empresa 
																				from 	usuarios_grupos_empresas e1
															                    where	e1.cod_usuario = ".$cod_usuario."
															                )
															and				g.cod_grupo = ".$cod_grupo."
															order by		g.nome asc,  e.empresa asc;
															";

															$query = mysql_query($sql);

															$registros = mysql_num_rows($query);

															if ($registros > 0) 
															{
																while ($rs = mysql_fetch_array($query))
																{ 
																?>
											                        <tr>
											                        	<td align="center">
																			<a 	class="btn btn-success btn-label" 
																				href="adm_usuario_grupos.php?acao=vincular&cod_usuario=<?php echo $cod_usuario;?>&cod_grupo=<?php echo $rs['cod_grupo'];?>&cod_empresa=<?php echo $rs['cod_empresa'];?>&nome_usuario=<?php echo $nome_usuario; ?>">
																				<i class="fa fa-plus-circle"></i>Vincular
																			</a>
											                        	</td>
																		<td align="left"><?php echo $rs['grupo'];?></td>
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

														}
														else{
														?>
									                        <tr>
									                            <td align="center" colspan="8">Não foi encontrado o grupo deste usuario.</td>
									                        </tr>

														<?php 
														}
														?>		

									                    </tbody>

												</table>

												</div>

											</div>


										</form>

										<div class="panel-footer">
											<div class="row">
												<div class="col-sm-1">
													<button class="btn-default btn" onclick="javascript:window.location='adm_usuarios.php';">Voltar</button>
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