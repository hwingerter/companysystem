<?php 

require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";

	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************

	for ($i=0; $i < count($credenciais); $i++) 
	{ 
		switch($credenciais[$i])
		{
			case "caixa_abrir":
			$credencial_incluir = 1;		
			break;		
		}
	}

	$cod_empresa	= $_SESSION['cod_empresa'];
	$cod_usuario 	= $_SESSION['cod_usuario'];

	
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
			".$cod_usuario.");
			";

			//echo $sql; die;

			mysql_query($sql);

			$sql = "
			select		max(cod_caixa) as NovoCaixaAberto
			from		caixa
			where 		cod_empresa = ".$cod_empresa."
			and 		situacao = 1;
			";
			$query 					= mysql_query($sql);
			$rs 					= mysql_fetch_array($query);
			$_SESSION["cod_caixa"] 	= $rs["NovoCaixaAberto"];
	
			Comanda_AdicionaTransacaoAoCaixa($cod_empresa, $rs["NovoCaixaAberto"], '', 'INICIO', 'Inicial da Gaveta', $valor, $cod_usuario);

			echo "<script language='javascript'>window.location='../comanda/comanda.php';</script>";die;			

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
												<label class="col-sm-3 control-label"><b>Informe o quanto de dinheiro tem na gaveta agora:</b></label>
											</div>

											<div class="form-group">
												<label class="col-sm-2 control-label"><b>Valor Inicial da Gaveta</b></label>
												<div class="col-sm-2">
												  <input type="text" class="form-control" name="valor_dinheiro" id="valor_dinheiro" onKeyPress="return(moeda(this,'.',',',event));">
												</div>
											</div>

										</form>

										<div class="panel-footer">
											<div class="row">
												<div class="col-sm-8 col-sm-offset-2">
													<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Abrir Caixa</button>
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