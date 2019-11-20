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
	$cod_usuario		 	= $_SESSION['usuario_id'];
	$cod_caixa 				= $_SESSION['cod_caixa'];

	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar	
	
	
	if (isset($_REQUEST['acao'])){

		if($_REQUEST['acao'] == "reforco"){

			if (isset($_REQUEST["valor"]) && ($_REQUEST["valor"] != "")) { $valor = ValorPhpMysql($_REQUEST["valor"]); } else { $valor = 'NULL'; }

			$descricao = "Reforço - ".$_POST['obs'];

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
			'REFORCO',
			'".$descricao."',
			".$valor.",
			".$cod_usuario.",
			now()
			);
			";

			//echo $sql; die;

			mysql_query($sql);

			echo "<script language='javascript'>window.location='caixa_gaveta_caixa.php?sucesso=6';</script>";die;		

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
										<h2>Reforço</h2>
									</div>
									<div class="panel-body">

										<form action="reforco.php" class="form-horizontal row-border" name='frm' method="post">

							              <input type="hidden" name="acao" value="reforco">

											<div class="form-group">
												<label class="col-sm-8 control-label" style="text-align:left;"><b>
													Reforço é quando se coloca dinheiro na Gaveta do Caixa, por exemplo para inserir troco. 
													<br>O valor entra na "Gaveta do Caixa", mas não entra no relatório "Fluxo de Caixa", pois não representa dinheiro gerado pelas atividades do salão.
													<br>(Como, por exemplo, no caso de uma venda ou recebimento de dívida).
												</b></label>
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
														<button class="btn-default btn" onclick="javascript:window.location='caixa_gaveta_caixa.php';">Voltar</button>
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