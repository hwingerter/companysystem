<?php 

require_once "include/topo_interno.php";

require_once "include/funcoes.php";

session_start();

$cod_usuario = $_SESSION['cod_usuario'];
$cod_empresa = $_SESSION['cod_empresa'];
	
if ($_SESSION['cod_empresa'] == 1)
{
	$EhMaster = true;
	$titulo_pagina = "Empresa";
}
else
{
	$EhMaster = false;
	$titulo_pagina = "Minhas Filiais";
}


?>

<div class="static-content-wrapper">
	<div class="static-content">
		<div class="page-content">
			<ol class="breadcrumb">
				
			<li><a href="inicio.php">Inicio</a></li>

			</ol>
			<div class="page-heading">            
				<h1><?php echo $titulo_pagina; ?></h1>
				<div class="options"></div>
			</div>
			<div class="container-fluid">
                                
				<div class="panel panel-default" data-widget='{"draggable": "false"}'>
					<div class="panel-heading">
						<h2>Empresas</h2>
					</div>
					<div class="panel-body">
				
					<?php 

					if ($EhMaster == true) {

						$sql = "
						select		e.cod_empresa, e.empresa
						from 		empresas e 
						where 		e.situacao = 'A'
						and 		e.cod_empresa <> 1
						order by	e.empresa						
						";

					} else {

						$sql ="
						select		e.cod_empresa, e.empresa
						from 		empresas e
						where 		e.cod_empresa in (select g.cod_filial from grupo_empresas g where g.cod_empresa = ".$cod_empresa.")
						and	 		e.situacao = 'A'
						";

					}

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
								<td><a href="login_empresa.php?acao=trocar_empresa&cod_empresa=<?php echo $rs['cod_empresa'];?>" class="btn btn-primary">Acessar</a></td>
							</tr>
							<?php
							}
						?>
						</tbody>
					</table>

				</div>


			</div> <!-- .container-fluid -->
		</div>
	</div>
<?php 
require_once('include/rodape_interno.php'); 
?>