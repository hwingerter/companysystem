<?php 
	
	include('../../include/topo_interno_relatorio.php'); 

	$cod_empresa = $_SESSION["cod_empresa"];

?>

<div class="static-content-wrapper">
	<div class="static-content">
		<div class="page-content">
			<ol class="breadcrumb">                                
				<li><a href="#">Principal</a></li>
				<li class="active"><a href="conta.php">Contas e Despesas</a></li>
			</ol>
			
			<div class="page-heading">            
				<h1>Contas e Despesas</h1>
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
							

<form action="conta.php" class="form-horizontal" name='frm' method="post">

	<input type='hidden' name='acao' value='buscar'>

	<div class="row">
	
		<div class="col-sm-12">

			<div class="panel panel-sky">
				<div class="panel-heading">
					<h2>Filtros</h2>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-2 control-label">Fornecedor</label>
						<div class="col-sm-6">
							<?php ComboFornecedor($cod_fornecedor, $cod_empresa); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Tipo</label>
						<div class="col-sm-8">
							<label class="radio-inline icheck">
								<input type="radio" name="status" value="N" <?php if($_REQUEST['status'] == "N") {echo " checked "; } ?> >&nbsp;A Pagar
							</label>
							<label class="radio-inline icheck">
								<input type="radio" name="status" value="S" <?php if($_REQUEST['status'] == "S") {echo " checked "; } ?> >&nbsp;Já Quitadas
							</label>
							<label class="radio-inline icheck">
								<input type="radio" name="status" value="" <?php if($_REQUEST['status'] == "") {echo " checked "; } ?> >&nbsp;Todas
							</label>
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
								value="<?php if (isset($_REQUEST['dt_inicial'])){ if ($_REQUEST['dt_inicial'] != ""){ echo $_REQUEST['dt_inicial']; } }?>"
								>

						</div>
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
								value="<?php if (isset($_REQUEST['dt_final'])){ if ($_REQUEST['dt_final'] != ""){ echo $_REQUEST['dt_final']; } }?>"
								>

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