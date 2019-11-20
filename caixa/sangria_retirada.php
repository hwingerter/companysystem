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
	$cod_usuario 			= $_SESSION['usuario_id'];
	$cod_caixa 				= $_SESSION['cod_caixa'];

	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar	
	
	
	if (isset($_REQUEST['acao'])){

		if($_REQUEST['acao'] == "sangria"){

			if (isset($_REQUEST["valor"]) && ($_REQUEST["valor"] != "")) { $valor = ValorPhpMysql($_REQUEST["valor"]); } else { $valor = 'NULL'; }

			$descricao = "Sangria - ".$_POST['obs'];

			$sql = "
			INSERT INTO `caixa_gaveta`
			(`cod_caixa`,
			`cod_empresa`,
			`tipo_transacao`,			
			`descricao`,			
			`valor`,
			`cod_usuario`,
			`dt_transacao`
			)
			VALUES
			(".$cod_caixa.",
			".$cod_empresa.",
			'SANGRIA',
			'".$descricao."',
			".$valor.",
			".$cod_usuario.",
			now()
			);
			";

			//echo $sql; die;

			mysql_query($sql);

			echo "<script language='javascript'>window.location='caixa_gaveta_caixa.php?sucesso=5';</script>";die;			

		}
		else if($_REQUEST['acao'] == "excluir"){

			$cod_comanda_pagamento = $_REQUEST['cod_comanda_pagamento'];

			$sql = "delete from comanda_pagamento where cod_comanda_pagamento = ".$cod_comanda_pagamento."";

			//echo $sql; die;

			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='comanda_pagamentos.php?sucesso=2&cod_comanda=".$cod_comanda."&cod_cliente=".$cod_cliente."';</script>";die;

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
						<li class="active"><a href="grupo_produtos.php">Gaveta do Caixa</a></li>
						</ol>
                    <div class="page-heading">            
                        <h1>Caixa</h1>
                        <div class="options"></div>
                    </div>
                    <div class="container-fluid">
                        

						<div data-widget-group="group1">

								<div class="panel panel-default" data-widget='{"draggable": "false"}'>
									<div class="panel-heading">
										<h2>Abrir Novo Caixa</h2>
									</div>
									<div class="panel-body">

										<form action="sangria_retirada.php" class="form-horizontal row-border" name='frm' method="post">

							              <input type="hidden" name="acao" value="sangria">

											<div class="form-group">
												<label class="col-sm-9 control-label"><b>O valor sairá da gaveta do caixa, mas não constará no relatório "Fluxo de Caixa", pois você informou na tela anterior que não é relacionado
												a gasto do salão.</b></label>
											</div>

											<div class="form-group">
												<label class="col-sm-1 control-label"><b>Valor</b></label>
												<div class="col-sm-1">
													<select name="tipo" id="tipo" class="form-control">
													
														<option value='1'> Dinheiro </option>
												
														<option value='2'> Cheques </option>
												
													</select>
												</div>												
											</div>

											<div class="form-group">
												<label class="col-sm-1 control-label"><b>Valor</b></label>
												<div class="col-sm-2">
												  <input type="text" class="form-control" name="valor" id="valor" onKeyPress="return(moeda(this,'.',',',event));">
												</div>
											</div>

											<div class="form-group">
												<label class="col-sm-1 control-label"><b>Observações</b></label>
												<div class="col-sm-2">
												  <textarea name="obs" style="width:100%; height: auto;"></textarea>
												</div>
											</div>

											<div class="panel-footer">
												<div class="row">
													<div class="col-sm-8 col-sm-offset-1">
														<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Salvar</button>
														<button class="btn-default btn" onclick="javascript:window.location='sangria.php';">Voltar</button>
													</div>
												</div>
											</div>

										</form>

									</div>
								</div>
                    	</div>
                    	
                    </div> <!-- .container-fluid -->
					
	
<?php 
}


include('../include/rodape_interno2.php');?>