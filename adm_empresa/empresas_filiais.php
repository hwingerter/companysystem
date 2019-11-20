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
	
	

	$cod_empresa = $_REQUEST['cod_empresa'];
	
	$sql = "
	select		e.cod_empresa, e.empresa, e.telefone, e.situacao, date_format(e.dt_cadastro, '%d/%m/%Y') as dt_cadastro
	from		empresas e
	where		e.cod_empresa in (select cod_filial from grupo_empresas where cod_empresa = ".$cod_empresa.")
	order by	e.empresa;
	";
	//echo $sql;die;
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	
?>

				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
								<li><a href="#">Principal</a></li>
								<li class="active"><a href="grupo_vincular.php?cod_empresa=<?php echo $cod_empresa;?>">Filiais</a></li>

                            </ol>

                            <div class="page-heading">            
                                <h1>Filiais da Empresa</h1>
								<div class="options">
								<?php 
								if ($credencial_incluir == '1') {
								?>
								<a class="btn btn-midnightblue btn-label" href="empresas_adicionar_filiais.php?cod_empresa=<?php echo $cod_empresa;?>"><i class="fa fa-plus-circle"></i>Nova Filial</a>
								<?php
								}
								?>	
								</div>
                            </div>

                            <div class="container-fluid">

							<div data-widget-group="group1">

								<div class="panel panel-default" data-widget='{"draggable": "false"}'>

									<div class="panel-heading">
										<h2><?php echo $nome;?></h2>
									</div>

									<div class="panel-body">

										<div class="table-vertical">

											<table  class="table table-striped" border="1" bordercolor="#EEEEEE">
											<thead>
												<tr>
													<th width="300">Filial</th>
													<th width="150">Situação no Sistema</th>
													<th width="150">Data de Cadastro</th>
													<th width="10">&nbsp;</th>
												</tr>
											</thead>
											<tbody>

											<?php
											if ($registros > 0) 
											{

												while ($rs = mysql_fetch_array($query)){ 
												
													$cod_grupo = $rs['cod_grupo'];
													$empresa = $rs['empresa'];
													$telefone = $rs['telefone'];
													
													$dt_cadastro = $rs['dt_cadastro'];
										
													$situacao = "";
													if($rs['situacao'] == "A"){
														$situacao = '<label class="label label-success">Ativa</label>';
													}elseif($rs['situacao'] == "I"){
														$situacao = '<label class="label label-danger">Bloqueada</label>';
													}
												?>
												<tr>
													<td data-title="Nome" align="left"><?php echo $rs['empresa']; ?></td>
													<td data-title="Situação" align="left"><?php echo $situacao; ?></td>
													<td data-title="Data Cadastro" align="left"><?php echo $dt_cadastro; ?></td>
													<td data-title="Opção" align="center">
														<a href="empresas_adicionar_filiais.php?acao=remover_filial&cod_empresa=<?php echo $cod_empresa;?>&cod_grupo=<?php echo $cod_grupo; ?>&cod_filial=<?php echo $rs['cod_empresa'];?>" class="btn btn-danger">Remover Filial</a>
													</td>
												</tr>
												<?php
												} // while
												?>
													<tr>
														<td align="right" colspan="7"><b>Total de registro: <?php echo $registros; ?></b></td>
													</tr>
											<?php
											}
												else
											{ 
											?>
											<tr>
												<td align="center" colspan="7">Nenhum registro encontrado</td>
											</tr>	
											<tr>
												<td align="right" colspan="7"><b>Total de registro: <?php echo $registros; ?></b></td>
											</tr>	
											<?php
											}
											?>
											</tbody>
											</table>

										</div>

										<div class="panel-footer">
											<div class="row">
												<div class="col-sm-1">
													<button class="btn-default btn" onclick="javascript:window.location='../adm_empresa/empresas.php';">Voltar</button>
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