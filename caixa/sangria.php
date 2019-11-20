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

	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar	
	
	
	if (isset($_REQUEST['acao'])){

		if($_REQUEST['acao'] == "abrir"){

			if (isset($_REQUEST["valor_dinheiro"]) && ($_REQUEST["valor_dinheiro"] != "")) { $valor = ValorPhpMysql($_REQUEST["valor_dinheiro"]); } else { $valor = 'NULL'; }

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
			now(),
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

										<form action="caixa_abrir_novo_caixa.php" class="form-horizontal row-border" name='frm' method="post">

							              <input type="hidden" name="acao" value="abrir">

											<div class="form-group">
												<label class="col-sm-5 control-label"><b>O valor que você está retirando da gaveta é para pagar uma conta (ou despesa) do salão?</b></label>
											</div>

											<div class="form-group">
												<div class="col-sm-1">
													<button type="button" class="btn-success btn" onclick="javascript:document.forms['frm'].submit();">Sim</button>											
												</div>												
												<div class="col-sm-1">
													<button type="button" class="btn-danger btn" onclick="javascript:location.href='sangria_retirada.php';">Não</button>
												</div>
											</div>

										</form>

										<div class="panel-footer">
											<div class="row">
												<div class="col-sm-8">
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