<?php include('topo.php');
	
	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	
	
	
	
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "fluxo_caixa_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "fluxo_caixa_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "fluxo_caixa_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "fluxo_caixa_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}
	
if ($credencial_ver == '1') { // Verifica se o usu�rio tem a credencial de incluir ou editar	
	
	$fluxo = limpa_int($_REQUEST["id"]);
	
	$sql = "Select * from fluxo_caixa where cod_fluxo = " . $fluxo;
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		if ($rs = mysql_fetch_array($query)){
			$vencimento = DataMysqlPhp($rs['vencimento']);
			$pagamento = $rs['pagamento'];
			if ($pagamento != '') { $pagamento = DataMysqlPhp($pagamento); }
			$valor = ValorMysqlPhp($rs['valor']);
			$obs = $rs['obs'];
			$parcela = $rs['parcela'];
			$total_parcelas = $rs['total_parcelas'];
			$cod_cliente = $rs['cod_cliente'];
			$cod_financeiro = $rs['cod_financeiro'];
			
		}
	}
	
?>
	 <script src="cidade_ComboAjax.js"></script>
        <div id="wrapper">
            <div id="layout-static">
                <?php include('menu.php');?>
				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="fluxo_caixa.php">Fluxo de Caixa</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Fluxo de Caixa</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Dados do Fluxo de Caixa</h2>
		</div>
		<div class="panel-body">
			<form action="fluxo_caixa.php" class="form-horizontal row-border" name='frm' method="post">
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Cliente</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php ExibeCliente($cod_cliente);?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Descrição</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php ExibeFinanceiro($cod_financeiro);?></label>
					</div>
				</div>								
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Data do Vencimento</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $vencimento; ?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Valor</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $valor; ?></label>
					</div>
				</div>				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Data do Pagamento</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $pagamento; ?></label>
					</div>
				</div>				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Parcela</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $parcela;?></label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Total de Parcelas</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $total_parcelas;?></label>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Observações</b></label>
					<div class="col-sm-8">
						<label class="control-label"><?php echo $obs;?></label>
					</div>
				</div>
			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-default btn" onclick="javascript:window.location='fluxo_caixa.php';">Voltar</button>
					</div>
				</div>
			</div>
		</div>
	</div>



                            </div> <!-- .container-fluid -->
                        </div> <!-- #page-content -->
					</div>
<?php 
}
	
include('rodape.php');?>