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
	$cod_caixa 				= $_SESSION['cod_caixa'];

	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar	
	
	
	if (isset($_REQUEST['acao'])){

		if($_REQUEST['acao'] == "emitir_vale"){

			if (isset($_REQUEST["valor"]) && ($_REQUEST["valor"] != "")) { $valor = ValorPhpMysql($_REQUEST["valor"]); } else { $valor = 'NULL'; }

			$cod_usuario		 	= $_REQUEST["cod_profissional"];

			$descricao = "Vale - ".$_POST['obs'];

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
			'VALE',
			'".$descricao."',
			".$valor.",
			".$cod_usuario.",
			now()
			);
			";

			//echo $sql; die;

			mysql_query($sql);

			echo "<script language='javascript'>window.location='caixa_gaveta_caixa.php?sucesso=7';</script>";die;		

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
										<h2>Emitir Vale</h2>
									</div>
									<div class="panel-body">

										<form action="emitir_vale.php" class="form-horizontal row-border" name='frm' method="post">

							              <input type="hidden" name="acao" value="emitir_vale">
	
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
												<label class="col-sm-1 control-label"><b>Profissional</b></label>
												<div class="col-sm-1"><?php comboProfissional($cod_empresa, ""); ?></div>												
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