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
				<li class="active"><a href="contas_receber_filtro.php">Contas a Receber (Dívidas de Clientes)</a></li>
			</ol>
			
			<div class="page-heading">            
				<h1>Contas a Receber (Dívidas de Clientes)</h1>
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
							

<form action="contas_receber.php" class="form-horizontal" name='frm' method="post">

	<input type='hidden' name='acao' value='buscar'>

	<div class="row">
	
		<div class="col-sm-12">

			<div class="panel panel-sky">
				<div class="panel-heading">
					<h2>Filtros</h2>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-2 control-label">Tipo de Relatório</label>
						<div class="col-sm-2">
							<select name="tipo_relatorio" class="form-control">
					
								<option value='1' selected> Sintético </option>

								<option value='2'> Detalhado</option>			
						
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Tipo de Dívida</label>
						<div class="col-sm-2">
							<select name="tipo_divida" class="form-control">

								<option value="" selected>Todos</option>
								<option value="1">Fiados</option>
								<option value="2">Cheques Devolvidos</option>

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
						<label class="col-sm-2 control-label">Cliente: </label>
						<div class="col-sm-2">
							<?php ComboBuscaCliente($cod_empresa); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Tipo de Conta</label>
						<div class="col-sm-2">
							<select name="tipo_conta" class="form-control">

								<option value=""> Todas </option>
								<option value="1">Somente a Receber</option>
								<option value="2">Somente recebidas</option>
								<option value="3">Dívidas Excluídas</option>

							</select>
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