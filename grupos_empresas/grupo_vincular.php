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
	inner join	grupo_empresas ge on ge.cod_empresa = e.cod_empresa
	where		cod_grupo = (select cod_grupo from 	grupo_empresas where cod_empresa = ".$cod_empresa.")
	and 		e.cod_empresa <> 40;
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
                                <div class="options"></div>
                            </div>

                            <div class="container-fluid">

							<div data-widget-group="group1">

								<div class="panel panel-default" data-widget='{"draggable": "false"}'>

									<div class="panel-heading">
										<h2><?php echo $nome;?></h2>
									</div>

									<div class="panel-body">

									<table class="table" border="1" bordercolor="#EEEEEE">
									<thead>
										<tr>
											<th width="300">Filial</th>
											<th width="150">Telefone</th>
											<th width="150">Situação no Sistema</th>
											<th width="150">Data de Cadastro</th>
											<th width="300">Opções</th>
										</tr>
									</thead>
									<tbody>

									<?php
									if ($registros > 0) 
									{

										while (($rs = mysql_fetch_array($query)) && ($contador<$final)){ 
										
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
											<td align="left"><?php echo $rs['empresa']; ?></td>
											<td align="left"><?php echo $rs['telefone'];?></td>
											<td align="left"><?php echo $situacao; ?></td>
											<td align="left"><?php echo $dt_cadastro; ?></td>
											<td align='center'>
											<?php 
											if ($credencial_editar == '1') {
											?>							
												<a class="btn btn-success btn-label" href="empresa_info.php?acao=alterar&id=<?php echo $rs['cod_empresa'];?>"><i class="fa fa-edit"></i> Editar</a>&nbsp;
											<?php 
											}
											if ($credencial_excluir != '1') {
											?>
												<a class="btn btn-danger btn-label" href="empresas.php?pergunta=<?php echo $rs['cod_empresa'];?>"><i class="fa fa-times-circle"></i> Excluir</a>
											<?php
											}
											?>	
												<a class="btn btn-info btn-label" href="empresa_ver.php?id=<?php echo $rs['cod_empresa'];?>"><i class="fa fa-eye"></i> Ver</a>

												<a class="btn btn-default btn-label" href="empresa_licenca.php?cod_empresa=<?php echo $rs['cod_empresa'];?>"><i class="fa fa-eye"></i> Licenças</a>

												<a class="btn btn-default btn-label" href="../grupos_empresas/grupo_vincular.php?cod_empresa=<?php echo $rs['cod_empresa'];?>"><i class="fa fa-eye"></i> Filiais</a>

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