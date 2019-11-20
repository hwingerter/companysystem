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
				<li class="active"><a href="recebimento_clientes_filtro.php">Lucro Bruto</a></li>
			</ol>
			
			<div class="page-heading">            
				<h1>Lucro Bruto</h1>
			</div>
			<div class="container-fluid">
							

<form action="lucro_bruto.php" class="form-horizontal" name='frm' method="post">

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
					</div>
					<div class="row">
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
					</div>
					<div class="row">
						<div class="form-group">
							<label class="col-sm-2 control-label">Cliente</label>
							<div class="col-sm-2">
								<?php ComboCliente("", $cod_empresa); ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<label class="col-sm-2 control-label">Profissional</label>
							<div class="col-sm-2">
								<?php ComboProfissional($cod_empresa, ""); ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<label class="col-sm-2 control-label">Serviço</label>
							<div class="col-sm-2">
								<?php ComboServico($cod_empresa, ""); ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<label class="col-sm-2 control-label">Produto</label>
							<div class="col-sm-2">
								<?php ComboProduto($cod_empresa, ""); ?>
							</div>
						</div>
					</div>
					<div class="row">
							<div class="col-sm-2 col-sm-offset-2">
								<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Buscar</button>
							</div>
					</div>

				</div>
			</div>	
		</div>
	</div>

</form>

<?php include('../../include/rodape_interno_relatorio.php'); ?>