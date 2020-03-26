<?php 

require_once "include/topo_interno.php";

require_once "include/funcoes.php";

session_start();

$cod_usuario = $_SESSION['usuario_id'];
$cod_empresa = $_SESSION['cod_empresa'];
	
if ($_SESSION['usuario_conta'] == 1)
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
						order by	e.empresa
						";

					} else {

						$sql ="
						select		e.cod_empresa, e.empresa
						from 		empresas e
						inner join 	usuarios_grupos_empresas uge on uge.cod_empresa = e.cod_empresa
						inner join 	usuarios u on u.cod_usuario = uge.cod_usuario
						where 		u.cod_usuario = ".$cod_usuario."
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

							<?php if ($EhMaster) { ?>
								<tr>
									<td><b>MASTER</b></td>
									<td><a href="login_empresa.php?acao=trocar_empresa&cod_empresa=" class="btn btn-primary">Acessar</a></td>
								</tr>
							<?php
							}
	
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