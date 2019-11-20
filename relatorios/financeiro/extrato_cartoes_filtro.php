<?php 
	
	include('../../include/topo_interno_relatorio.php'); 

	$cod_empresa = $_SESSION["cod_empresa"];

	$dt_inicial = date("d/m/Y");

	$dt_final = date("d/m/Y", strtotime('+1 month'));

?>

<div class="static-content-wrapper">
	<div class="static-content">
		<div class="page-content">
			<ol class="breadcrumb">                                
				<li><a href="#">Principal</a></li>
				<li class="active"><a href="extrato_cartoes_filtro.php">Extrato de Cartões</a></li>
			</ol>
			
			<div class="page-heading">            
				<h1>Extrato de Cartões</h1>
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
							

<form action="extrato_cartoes.php" class="form-horizontal" name='frm' method="post">

	<input type='hidden' name='acao' value='buscar'>

	<div class="row">
	
		<div class="col-sm-12">

			<div class="panel panel-sky">
				<div class="panel-heading">
					<h2>Filtros</h2>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-2 control-label">Filtrar por</label>
						<div class="col-sm-2">
							<select name="filtrar_por" class="form-control">
					
								<option value='1' selected> Data de Repasse </option>

								<option value='2'> Data de Apresentação </option>			
						
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Data Inicial</label>
						<div class="col-sm-2">

							<input type="text" class="form-control mask" 
								id="dt_inicial" 
								name="dt_inicial" 
								data-inputmask-alias="dd/mm/yyyy" 
								data-inputmask="'alias': 'date'" 
								data-val="true" 
								data-val-required="Required" 
								placeholder="dd/mm/yyyy"
								value="<?php echo $dt_inicial; ?>"
								>

						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Data Final</label>
						<div class="col-sm-2">

							<input type="text" class="form-control mask" 
								id="dt_final" 
								name="dt_final" 
								data-inputmask-alias="dd/mm/yyyy" 
								data-inputmask="'alias': 'date'" 
								data-val="true" 
								data-val-required="Required" 
								placeholder="dd/mm/yyyy"
								value="<?php echo $dt_final; ?>"
								>

						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Tipo de Cartão</label>
						<div class="col-sm-2">
							<select name="tipo_cartao" class="form-control">

								<option value="" selected>Todos</option>
								<option value="1">Apenas de Crédito</option>
								<option value="2">Cheques de Débito</option>

							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Bandeiras </label>
						<div class="col-sm-2">
							<?php comboBandeiras_Cartao($cod_empresa); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Cliente </label>
						<div class="col-sm-2">
							<?php ComboCliente('', $cod_empresa); ?>
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