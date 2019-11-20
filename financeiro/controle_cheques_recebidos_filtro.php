<?php 
	
	require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";; 

	$cod_empresa = $_SESSION["cod_empresa"];

?>

<div class="static-content-wrapper">
	<div class="static-content">
		<div class="page-content">
			<ol class="breadcrumb">                                
				<li><a href="#">Principal</a></li>
				<li class="active"><a href="controle_cheques_recebidos_filtro.php">Controle de Cheques Recebidos</a></li>
			</ol>
			
			<div class="page-heading">            
				<h1>Controle de Cheques Recebidos</h1>
				<div class="options">
				<?php 
				if ($credencial_incluir == '1') {
				?>
				<a class="btn btn-midnightblue btn-label" href="conta_info.php"><i class="fa fa-plus-circle"></i> Novo</a>
				<?php
				}
				?>	
				</div>
			</div>
			<div class="container-fluid">
							

<form action="controle_cheques_recebidos.php" class="form-horizontal" name='frm' method="post">

	<input type='hidden' name='acao' value='buscar'>

	<div class="row">
	
		<div class="col-sm-12">

			<div class="panel panel-sky">
				<div class="panel-heading">
					<h2>Filtros</h2>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="form-group">
							<label class="col-sm-2 control-label">Tipos de Cheque</label>
							<div class="col-sm-4">
								<select name="tipo_cheque" class="form-control">
								
									<option value=''> Todos os Cheques </option>
							
									<option value='1'> Cheques pré-datados </option>

									<option value='2'> Cheques à vista </option>			

									<option value='3'> Cheques Devolvidos </option>	
							
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Emitidos</label>
							<div class="col-sm-4">
								<select name="ultimos_meses" class="form-control">
								
									<option value=''> em qualquer data </option>
							
									<option value='1'> no último mês </option>

									<option value='3'> nos últimos 3 meses </option>

									<option value='6'> nos últimos 6 meses </option>

									<option value='12'> nos últimos 12 meses </option>

									<option value='36'> nos últimos 36 meses </option>
						
								</select>
							</div>
						</div>
					</div>					
					<div class="row">
						<div class="col-sm-12 col-sm-offset-2">
							<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Buscar</button>
						</div>
					</div>
				</div>
			</div>	
		</div>
	</div>

</form>

<?php include('../include/rodape_interno2.php'); ?>