<?php 

require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";

session_start();

$cod_usuario = $_SESSION['usuario_id'];
$cod_empresa = $_REQUEST['cod_empresa'];

if (isset($_REQUEST['acao']) && (($_REQUEST['acao'] == "adicionar_filial")))
{

	$cod_empresa 	= $_REQUEST['cod_empresa'];
	$cod_filial 	= $_REQUEST['cod_filial'];

	//VINCULAR A EMPRESA AO GRUPO
	$sql = "insert into grupo_empresas (cod_empresa, cod_filial) values ('".limpa($cod_empresa)."', '".limpa($cod_filial)."');";
	//echo $sql;die;
	mysql_query($sql);

	echo "<script language='javascript'>window.location='empresas_filiais.php?cod_empresa=".$cod_empresa."&sucesso=1';</script>";die;

}elseif(isset($_REQUEST['acao']) && (($_REQUEST['acao'] == "remover_filial")))
{

	$cod_grupo 		= $_REQUEST['cod_grupo'];
	$cod_empresa 	= $_REQUEST['cod_empresa'];
	$cod_filial 	= $_REQUEST['cod_filial'];

	//VINCULAR A EMPRESA AO GRUPO
	$sql = "delete from grupo_empresas where cod_empresa=".$cod_empresa." and cod_filial=".$cod_filial.";";
	//echo $sql;die;
	mysql_query($sql);

	echo "<script language='javascript'>window.location='empresas_filiais.php?cod_empresa=".$cod_empresa."&sucesso=2';</script>";die;

}

$sql = "select cod_grupo from grupo_empresas where cod_empresa = ".$cod_empresa.";";
$query = mysql_query($sql);
$rs = mysql_fetch_array($query);
$cod_grupo = $rs['cod_grupo'];

?>

<div class="static-content-wrapper">
	<div class="static-content">
		<div class="page-content">
			<ol class="breadcrumb">
				
			<li><a href="inicio.php">Inicio</a></li>

			</ol>
			<div class="page-heading">            
				<h1>Adiconar Filial</h1>
				<div class="options"></div>
			</div>
			<div class="container-fluid">
                                
				<div class="panel panel-default" data-widget='{"draggable": "false"}'>
					<div class="panel-heading">
						<h2>Empresas</h2>
					</div>
					<div class="panel-body">
				
					<?php 
					$sql = "
					select		e.cod_empresa, e.empresa
					from 		empresas e 
					where 		cod_empresa not in (select cod_filial from grupo_empresas where cod_empresa = ".$cod_empresa." and cod_filial is not null)
					and 		cod_empresa <> ".$cod_empresa."
					order by	e.empresa
					";
					//echo $sql;die;
					$query = mysql_query($sql);
					$registros = mysql_num_rows($query);
					?>

					<table class="table mb0">
						<thead>
							<tr>
								<th>Nome</th>
								<th style="width:10%;">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<?php
							while ($rs = mysql_fetch_array($query)) {
							?>
							<tr>
								<td><?php echo $rs['empresa'];?></td>
								<td><a href="empresas_adicionar_filiais.php?acao=adicionar_filial&cod_empresa=<?php echo $cod_empresa;?>&cod_filial=<?php echo $rs['cod_empresa'];?>" class="btn btn-primary">Adicionar Filial</a></td>
							</tr>
							<?php
							}
							?>
						</tbody>
										
					</table>

					<div class="panel-footer">
							<div class="row">
								<div class="col-sm-1">
									<button class="btn-default btn" onclick="javascript:window.location='empresas_filiais.php?cod_empresa=<?php echo $cod_empresa;?>';">Voltar</button>
								</div>
							</div>
						</div>

				</div>


			</div> <!-- .container-fluid -->
		</div>
	</div>
<?php 
include('../include/rodape_interno2.php');
?>