<?php include('../include/topo_interno.php');

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


	$cod_cliente 			= $_REQUEST['cod_cliente'];
	$cod_comanda 			= $_REQUEST['cod_comanda'];
	$cod_forma_pagamento	= "1";
	$flg_divida 			= $_REQUEST['flg_divida'];

	$cod_empresa			= $_SESSION['cod_empresa'];
	$cod_usuario 		 	= $_SESSION['usuario_id'];
	$cod_caixa 				= $_SESSION['cod_caixa'];

	$voltar 				= $_REQUEST['voltar'];


if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar	
	
	
	if (isset($_REQUEST['acao'])){

		if($_REQUEST['acao'] == "realizar_pagamento")
		{
			if (isset($_REQUEST["valor_dinheiro"]) && ($_REQUEST["valor_dinheiro"] != "")) { $valor = ValorPhpMysql($_REQUEST["valor_dinheiro"]); } else { $valor = 'NULL'; }

			//if ($flg_divida == "1"){ //pagar divida

				/*
				$i=0;
				while ($i < count($comandas)) 
				{
				*/	

					$valor_comanda = ValorPhpMysql(TotalComanda($cod_empresa, $cod_cliente, $cod_comanda));
				
					$sql = "
					INSERT INTO `comanda_pagamento`
					(`cod_comanda`,
					`cod_cliente`,
					`cod_empresa`,
					`cod_forma_pagamento`,
					`valor`,
					`dt_pagamento`,
					`cod_usuario_pagamento`
					)
					VALUES
					(".$cod_comanda.",
					".$cod_cliente.",
					".$cod_empresa.",
					'".$cod_forma_pagamento."',
					".$valor_comanda.",
					now(),
					".$cod_usuario.");
					";

					//echo $sql."<br>";die;

					mysql_query($sql);

					Comanda_AtualizaSituacao($cod_empresa, $cod_cliente, $cod_comanda, $cod_forma_pagamento);
					
					//Comanda_AdicionaTransacaoAoCaixa($cod_empresa, $cod_caixa, $comandas[$i], 'RECEBIMENTO_DIVIDA', 'Recebimento de Dívida', $valor_comanda, $cod_cliente);

				//$i++;

				//}

				echo "<script language='javascript'>window.location='comanda.php';</script>";die;			

			/*
			}
			else //pagamento normal
			{

				$sql = "
				INSERT INTO `comanda_pagamento`
				(`cod_comanda`,
				`cod_cliente`,
				`cod_empresa`,
				`cod_forma_pagamento`,
				`valor`,
				`dt_pagamento`,
				`cod_usuario_pagamento`
				)
				VALUES
				(".$cod_comanda.",
				".$cod_cliente.",
				".$cod_empresa.",
				'".$cod_forma_pagamento."',
				".$valor.",
				now(),
				".$cod_usuario.");
				";

				//echo $sql."<br>";die;

				mysql_query($sql);

				Comanda_AtualizaSituacao($cod_empresa, $cod_cliente, $cod_comanda, $cod_forma_pagamento);

				Comanda_AdicionaTransacaoAoCaixa($cod_empresa, $cod_caixa, $cod_comanda, 'VENDA', 'VENDA', $valor, $cod_cliente);

				echo "<script language='javascript'>window.location='comanda_pagamentos.php?sucesso=1&cod_comanda=".$cod_comanda."&cod_cliente=".$cod_cliente."';</script>";die;			

			}*/
		
			

		}
		else if($_REQUEST['acao'] == "excluir"){

			$cod_comanda_pagamento = $_REQUEST['cod_comanda_pagamento'];

			$sql = "delete from comanda_pagamento where cod_comanda_pagamento = ".$cod_comanda_pagamento."";

			//echo $sql; die;

			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='comanda_pagamentos.php?sucesso=1&cod_comanda=".$cod_comanda."&cod_cliente=".$cod_cliente."';</script>";die;

		}
	}

}

include('../include/rodape_interno.php');

?>