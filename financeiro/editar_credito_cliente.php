<?php 

require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";;

	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	if ($_SESSION['usuario_conta'] == '1') {
		
		$credencial_ver = 1;
		$credencial_incluir = 1;
		$credencial_editar = 1;
		$credencial_excluir = 1;
		
	}
	
	$credencial_ver = 1;
	$credencial_incluir = 1;
	$credencial_editar = 1;
	$credencial_excluir = 1;


	$cod_empresa			= $_SESSION['cod_empresa'];
	$cod_cliente 			= $_REQUEST['cod_cliente'];
	$cod_credito 			= $_REQUEST['cod_credito'];

	if (isset($_REQUEST['excluir'])) { $excluir = $_REQUEST['excluir']; } else { $excluir = ''; }

	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar	
	
	
	if (isset($_REQUEST['acao'])){

		if($_REQUEST['acao'] == "inserir_credito")
		{

			if (isset($_REQUEST["valor"]) && ($_REQUEST["valor"] != "")) { $valor = ValorPhpMysql($_REQUEST["valor"]); } else { $valor = 'NULL'; }

			$sql = "
				INSERT INTO `clientes_credito`
				(`cod_empresa`,
				`cod_cliente`,
				`valor`,
				`movimentacao`,
				`data`
				)
				VALUES
				(".$cod_empresa.",
				".$cod_cliente.",
				".$valor.",
				'CREDITO',
				now()
				);
			";

			//echo $sql; die;

			mysql_query($sql);

			echo "<script language='javascript'>window.location='ver_credito_cliente.php?cod_cliente=".$cod_cliente."&sucesso=1';</script>";die;		

		}
		elseif($_REQUEST['acao'] == "atualizar_credito") 
		{

			if (isset($_REQUEST["valor"]) && ($_REQUEST["valor"] != "")) { $valor = ValorPhpMysql($_REQUEST["valor"]); } else { $valor = 'NULL'; }


			$sql = "
				update 	`clientes_credito`
				set			`valor` = ".$valor."
				where		cod_empresa = ".$cod_empresa."
				and			cod_cliente	 = ".$cod_cliente."
				and			cod_credito = ".$cod_credito."
			";

			//echo $sql; die;

			mysql_query($sql);

			echo "<script language='javascript'>window.location='ver_credito_cliente.php?cod_cliente=".$cod_cliente."&sucesso=2';</script>";die;		

		}
		elseif($_REQUEST['acao'] == "excluir_credito") 
		{
			$sql = "
				delete from `clientes_credito` where	cod_empresa = ".$cod_empresa."	and	cod_cliente	= ".$cod_cliente." and	cod_credito = ".$cod_credito." 
			";

			//echo $sql; die;

			mysql_query($sql);

			echo "<script language='javascript'>window.location='ver_credito_cliente.php?cod_cliente=".$cod_cliente."&sucesso=3';</script>";die;		

		}

	}


	if (isset($_REQUEST['acao'])){

		if($_REQUEST['acao'] == "editar_credito")
		{
			$sql = "
			select 		valor 
			from 			clientes_credito 
			where 		cod_empresa = ".$_SESSION['cod_empresa']."
			and 			cod_cliente = ".$cod_cliente."
			and 			cod_credito = ".$cod_credito."
		";
	
		$query 	= mysql_query($sql);
		$rs 		= mysql_fetch_array($query);
		$valor = ValorMysqlPhp($rs['valor']);

		}
	}



?>

		<script language="javascript" src="js/comanda.js"></script>
		<script language="javascript" src="../js/mascaramoeda.js"></script>

		<div class="static-content-wrapper">
            <div class="static-content">
                <div class="page-content">
					<ol class="breadcrumb">
						<li><a href="#">Principal</a></li>
						<li class="active"><a href="credito_clientes.php">Créditos de Cliente</a></li>
						</ol>
                    <div class="page-heading">            
                        <h1>Crédito de Cliente</h1>
                        <div class="options"></div>
                    </div>
                    <div class="container-fluid">
                        

						<div data-widget-group="group1">

								<div class="panel panel-default" data-widget='{"draggable": "false"}'>
									<div class="panel-heading">
										<h2>Crédito de Cliente</h2>
									</div>
									<div class="panel-body">

										<form action="editar_credito_cliente.php" class="form-horizontal row-border" name='frm' method="post">

											<?php if ( (isset($_REQUEST['acao'])) && ($_REQUEST['acao'] == "editar_credito")) {?>

												<input type="hidden" name="acao" value="atualizar_credito">
												<input type="hidden" name="cod_cliente" value="<?php echo $cod_cliente; ?>">
												<input type="hidden" name="cod_credito" value="<?php echo $cod_credito; ?>">

											<?php
											} 
											else 
											{
												?>
												<input type="hidden" name="acao" value="inserir_credito">
												<input type="hidden" name="cod_cliente" value="<?php echo $cod_cliente; ?>">

											<?php
											}
											?>

											<div class="form-group">
												<label class="col-sm-1 control-label"><b>Valor</b></label>
												<div class="col-sm-2">
												  <input type="text" class="form-control" name="valor" id="valor" onKeyPress="return(moeda(this,'.',',',event));" value="<?php echo $valor; ?>">
												</div>
											</div>

										</form>

											<div class="panel-footer">
												<div class="row">
													<div class="col-sm-8 col-sm-offset-1">
														<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Salvar</button>
														<button class="btn-default btn" onclick="javascript:window.location='ver_credito_cliente.php?cod_cliente=7';">Voltar</button>
													</div>
												</div>
											</div>

									</div>
								</div>
                    	</div>
                    	
                    </div> <!-- .container-fluid -->
					
	
<?php 
}


include('../include/rodape_interno2.php');?>