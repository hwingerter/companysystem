<?php 
	
	include('../../include/topo_interno_relatorio.php'); 

	$cod_empresa = $_SESSION["cod_empresa"];

	$dt_inicial = date("d/m/Y");

	$dt_final = date("d/m/Y", strtotime('+1 month'));

	$dias_ausentes = 60;
	$ultimos = 365;

?>

<div class="static-content-wrapper">
	<div class="static-content">
		<div class="page-content">
			<ol class="breadcrumb">                                
				<li><a href="#">Principal</a></li>
				<li class="active"><a href="clientes_ausentes_salao_dias_filtro.php">Clientes ausentes do salão a mais de X dias</a></li>
			</ol>
			
			<div class="page-heading">            
				<h1>Clientes ausentes do salão a mais de X dias</h1>
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
							

<form action="clientes_ausentes_salao_dias.php" class="form-horizontal" name='frm' method="post">

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
							<div class="col-md-3">
								<label class="control-label"><b>Mostrar clientes ausentes do salão a mais de </b></label>
							</div>
							<div class="col-md-1">
								<input type="text" class="form-control" name="dias_ausentes" maxlength="3" value="<?php echo $dias_ausentes; ?>">
							</div>
							<label class="control-label"><b> dias</b></label>
						</div>
					</div>

					<div class="row">
						<div class="form-group">
							<div class="col-md-3">
								<label class="control-label"><b>mas que vieram nos últimos</b></label>
							</div>
							
							<div class="col-md-1">
								<input type="text" class="form-control" name="ultimos" maxlength="100" value="365">
							</div>
							<label class="control-label"><b> dias</b></label>
						</div>
					</div>


					<div class="row">
							<div class="col-sm-8 col-sm-offset-1">
								<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Buscar</button>
							</div>
						</div>
				</div>
			</div>	
		</div>
	</div>

</form>

<?php include('../../include/rodape_interno_relatorio.php'); ?>