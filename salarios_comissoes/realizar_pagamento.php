<?php

	require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";;

	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	$credencial_ver = 0;
	$credencial_incluir = 0;
	$credencial_editar = 0;
	$credencial_excluir = 0;
	
$credencial_ver = 1;
$credencial_incluir = 1;
$credencial_editar = 1;
$credencial_excluir = 1;

$cod_empresa 	= $_SESSION['cod_empresa'];
$cod_caixa 		= $_SESSION['cod_caixa'];

function RetornaComissoesAPagar($cod_profissional, $data)
	{
		$listaComissoes = "";
	
		//VARRER NAS COMANDAS, OS SERVIÇOS PRESTADOS PELOS PROFISSIONAIS
		$sql = "
		select 		ci.cod_comanda_item as cod_comissao
		from 		comanda c
		inner join 	comanda_item ci on ci.cod_comanda = c.cod_comanda
		where 		ci.cod_empresa = ".$_SESSION["cod_empresa"]."
		and 		ci.cod_profissional = ".$cod_profissional."
		and 		c.dt_inclusao <= '".$data." 23:59:59'
		and 		ci.valor_comissao is not null
		and 		ci.flg_comissao_paga = 'N' and ci.dt_pagamento_comissao is null
		order by	c.dt_inclusao asc;
		";
	
		//echo $sql;die;

		$query = mysql_query($sql);
		
		while ($rs = mysql_fetch_array($query))
		{ 
			if($listaComissoes == "")
			{
				$listaComissoes = $rs["cod_comissao"];
			}
			else{
				$listaComissoes .= ",".$rs["cod_comissao"];
			}
		}
	
		return $listaComissoes;
	}



if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar
	
	$acao = '';


if (isset($_REQUEST['acao'])){

	if ($_REQUEST['acao'] == "realizar_pagamento"){
	
		$data_busca 			= $_REQUEST["data_busca"];
		$data_pagamento 		= $_REQUEST["data_pagamento"];
		$lista_profissional 	= explode(",", $_REQUEST["lista_profissional"]);

		foreach ($lista_profissional as $indice => $cod_profissional)
		{

			if(isset($_REQUEST["flg_usoudagaveta"]) && ($_REQUEST["flg_usoudagaveta"] == "N"))
			{

				$sql = "
				update		comanda_item
				set			flg_comissao_paga = 'S'
							,dt_pagamento_comissao = '".$data_pagamento."'
				where		cod_empresa = ".$cod_empresa."
				and 		cod_comanda_item in (".RetornaComissoesAPagar($cod_profissional, $data_busca)."); ";

				mysql_query($sql);

				echo "<script language='javascript'>window.location='pagamentos_realizados.php?acao=buscar&dt_pagamento_comissao=".$data_pagamento."';</script>"; die;

			}
			elseif (isset($_REQUEST["flg_usoudagaveta"]) && ($_REQUEST["flg_usoudagaveta"] == "S"))
			{

				$cod_caixa  = $_REQUEST["cod_caixa_1"];

				//recupera data do caixa selecionado
				$sql1 = "
				select date_format(dt_abertura,'%Y-%m-%d') as data_caixa from caixa where cod_empresa = ".$cod_empresa." and cod_caixa = ".$cod_caixa.";
				";
				mysql_query($sql);
				$query1 	= mysql_query($sql1);
				$rs1 		= mysql_fetch_array($query1);
				$data_caixa	= $rs1['data_caixa']." ".date('H:i:s');		

				//recupera valor da comissão até o dia selecionado.
				$sql1 = "
				select		sum(ci.valor_comissao * ci.quantidade) as valor
				from 		comanda_item ci
				where 		ci.cod_comanda_item in (".RetornaComissoesAPagar($cod_profissional, $data_busca).")
				and 		ci.cod_profissional = ".$cod_profissional.";
				";

				$query1 	= mysql_query($sql1);
				$rs1 		= mysql_fetch_array($query1);
				$valor 		= $rs1['valor'];
				$cod_caixa  = $_REQUEST["cod_caixa_1"];

				Comanda_AdicionaTransacaoAoCaixa($cod_empresa, $cod_caixa, '', 'PGTO_PROFISSIONAL', 'Pgto a Profissional', $valor, $cod_profissional);


				$sql = "
				update		comanda_item
				set			flg_comissao_paga = 'S'
							,dt_pagamento_comissao = '".$data_caixa."'
				where		cod_empresa = ".$cod_empresa."
				and 		cod_comanda_item in (".RetornaComissoesAPagar($cod_profissional, $data_busca)."); ";

				//echo $sql;die;

				mysql_query($sql);

				//die;


				echo "<script language='javascript'>window.location='pagamentos_realizados.php';</script>"; die;

			}

		}

		//echo "passeo";

		//die;	

		
		
	}
	elseif ($_REQUEST['acao'] == "desfazer_ultimo_pagamento")
	{

		//pega ultimo pagamento feito (ultima data)
		$sql1 = "
		select		date_format(ci.dt_pagamento_comissao, '%Y-%m-%d') as data, cod_comanda
					,cod_profissional
		from 		comanda_item ci
		where 		ci.cod_empresa = ".$cod_empresa."
		and 		ci.flg_comissao_paga = 'S' and ci.dt_pagamento_comissao is not null
		group by	ci.dt_pagamento_comissao
		order by	ci.dt_pagamento_comissao desc
		limit 		1
		";

		//echo $sql1;die;

		$query1 	= mysql_query($sql1);
		$rs1 		= mysql_fetch_array($query1);

		$data 				= $rs1['data'];
		$cod_comanda 		= $rs1["cod_comanda"];
		$cod_profissional 	= $rs1["cod_profissional"];

		$sql = "
		update 		comanda_item 
		set			flg_comissao_paga = 'N', dt_pagamento_comissao = null
		where 		date_format(dt_pagamento_comissao, '%Y-%m-%d') = '".$data."';
		";

		//echo $sql."<br>";die;

		mysql_query($sql);


		$sql = "
		delete 	from caixa_gaveta 
		where 	cod_empresa = ".$cod_empresa." and tipo_transacao = 'PGTO_PROFISSIONAL' and cod_usuario = ".$cod_profissional." 
		and 	date_format(dt_transacao, '%Y-%m-%d') = '".$data."'
		";

		//echo $sql."<br>";die;

		mysql_query($sql);

		//echo "<script language='javascript'>window.location='pagamentos_realizados.php';</script>"; die;

	}

	
}


		
$cod_servico		= $_REQUEST["cod_servico"];
$lista_profissional	= $_REQUEST["lista_profissional"];
$data_busca			= $_REQUEST["data_busca"];
$data_pagamento		= $_REQUEST["data_pagamento"];

?>

	<script src="js/salarios_comissoes.js"></script>

	<div class="static-content-wrapper">
        <div class="static-content">
            <div class="page-content">
                <ol class="breadcrumb">
                    
					<li><a href="#">Principal</a></li>
					<li class="active"><a href="personalizar_comissao.php?cod_profissional=<?php echo $cod_profissional; ?>">Personalizar Comissão</a></li>

                </ol>
                <div class="page-heading">            
                    <h1>Realizar Pagamentos</h1>
                    <div class="options">
					</div>
                </div>
                <div class="container-fluid">

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Pagamento</h2>
		</div>
		<div class="panel-body">

			<form action="realizar_pagamento.php" class="form-horizontal row-border" name='frm' method="post">

              <input type="hidden" name="lista_profissional" value="<?php echo $lista_profissional; ?>">
              <input type="hidden" name="data_busca" value="<?php echo $data_busca; ?>">
              <input type="hidden" name="data_pagamento" value="<?php echo $data_pagamento; ?>">
              <input type="hidden" name="acao" value="realizar_pagamento">
              
				<div class="form-group" id="UsouDaGaveta">
				<label class="col-sm-3 control-label"><b>Usou dinheiro da gaveta?</b></label>
				<div class="col-sm-4">
					<?php ComboComissaoUsoDeGavetaParaPagamento("CaixaDia", "1",  $cod_empresa); ?>
				</div>
				</div>
				<div class="form-group" id="CaixaDia" style="display:none;">
					<label class="col-sm-2 control-label"><b>Do caixa:</b></label>
					<div class="col-sm-2" id="IdCaixaDia">		
					</div>
				</div>

			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Salvar</button> &nbsp;
						<button class="btn-default btn" onclick="javascript:window.location='listar_pagamento_comissoes.php';">Voltar</button>
					</div>
				</div>
			</div>
		</div>
	</div>



<?php 
} // INCLUIR OU EDITAR

	include('../include/rodape_interno2.php');

?>