<?php 

require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";

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
	$cod_usuario_pagamento 	= $_SESSION['usuario_id'];

	$sucesso				= $_REQUEST['sucesso'];
	$erro					= $_REQUEST['erro'];

	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar	
	
	
	if (isset($_REQUEST['acao'])){

		if($_REQUEST['acao'] == "cadastrar_caixa_antigo"){

			if (isset($_REQUEST["dt_inicial"]) && ($_REQUEST["dt_inicial"] != "")) { $dt_inicial = DataPhpMysql($_REQUEST["dt_inicial"]); } else { $dt_inicial = 'NULL'; }

			if (isset($_REQUEST["valor"]) && ($_REQUEST["valor"] != "")) { $valor = ValorPhpMysql($_REQUEST["valor"]); } else { $valor = 'NULL'; }

			if (ExisteDataNoCaixa($cod_empresa, $dt_inicial) == "nao"){

				$sql = "
				INSERT INTO `caixa`
				(`cod_empresa`,
				`dt_abertura`,
				`descricao`,
				`valor`,
				`cod_usuario`
				)
				VALUES
				(".$cod_empresa.",
				'".$dt_inicial."',
				'Inicial da Gaveta',
				".$valor.",
				".$cod_usuario_pagamento.");
				";

				//echo $sql; die;

				mysql_query($sql);

				$sql = "
				select		max(cod_caixa) as NovoCaixaAberto
				from		caixa
				where 		cod_empresa = ".$cod_empresa."
				and 		situacao = 1;
				";
				$query 	= mysql_query($sql);
				$rs 	= mysql_fetch_array($query);
				$_SESSION["cod_caixa"] = $rs["NovoCaixaAberto"];
		
				echo "<script language='javascript'>window.location='caixa_gaveta_caixa.php?sucesso=1';</script>";die;	


			}else{
				echo "<script language='javascript'>window.location='caixa_cadastrar_caixa_antigo.php?erro=2';</script>";die;	
			}
		

		}

	}





?>

		<script language="javascript" src="js/caixa.js"></script>
		<script language="javascript" src="../js/mascaramoeda.js"></script>

		<div class="static-content-wrapper">
            <div class="static-content">
                <div class="page-content">
					<ol class="breadcrumb">
						<li><a href="#">Principal</a></li>
						<li class="active"><a href="grupo_produtos.php">Gaveta do Caixa</a></li>
						</ol>
                    <div class="page-heading">            
                        <h1>Caixa</h1>
                        <div class="options"></div>
                    </div>
                    <div class="container-fluid">
							<?php
							if ($sucesso == '1') {
							?>
							<div class="alert alert-dismissable alert-success">
								<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Caixa aberto com sucesso!</strong>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							</div>
							<?php
							
							}

							if ($erro == '2') {
							?>
							<div class="alert alert-dismissable alert-danger">
								<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Já existe um caixa aberto com esta data!</strong>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							</div>
							<?php
							}?>

						<div data-widget-group="group1">

								<div class="panel panel-default" data-widget='{"draggable": "false"}'>
									<div class="panel-heading">
										<h2>Reabrir Caixa Antigo</h2>
									</div>
									<div class="panel-body">

										<form action="caixa_cadastrar_caixa_antigo.php" class="form-horizontal row-border" name='frm' method="post">

							              <input type="hidden" name="acao" value="cadastrar_caixa_antigo">

											<div class="form-group">
												<label class="col-sm-4 control-label"><b>Serve para cadastrar comandas com datas antigas</b></label>
											</div>

											<div class="form-group">
												<label class="col-sm-2 control-label"><b>Data</b></label>
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
											</div>

										<div class="form-group">
											<label class="col-sm-2 control-label"><b>Valor inicial (Dinheiro) R$</b></label>
											<div class="col-sm-1">
											  <input type="text" class="form-control" name="valor" id="valor" size="40" onKeyPress="return(moeda(this,'.',',',event));"> 
											</div>
										</div>

										</form>

										<div class="panel-footer">
											<div class="row">
												<div class="col-sm-8 col-sm-offset-2">
													<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Ok</button>
													<button class="btn-default btn" onclick="javascript:window.location='caixa_gaveta_caixa.php<?php echo $voltar; ?>';">Voltar</button>
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

<script type="text/javascript">
	$(document).ready(function() {
	  $(":input[data-inputmask-mask]").inputmask();
	  $(":input[data-inputmask-alias]").inputmask();
	  $(":input[data-inputmask-regex]").inputmask("Regex");
	});
</script>