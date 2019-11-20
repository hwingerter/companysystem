<?php require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";
	
	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	if ($_SESSION['usuario_conta'] == '1') {
		
		$credencial_ver = 1;
		$credencial_incluir = 1;
		$credencial_editar = 1;
		$credencial_excluir = 1;
		
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "profissional_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "profissional_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "profissional_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "profissional_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}


$cod_empresa 		= $_SESSION['cod_empresa'];
$cod_cliente 		= $_REQUEST['cod_cliente'];
$voltar 			= urlencode(host."caixa/lista_dividas.php?cod_cliente=".$cod_cliente);


if (isset($_REQUEST['pergunta_excluir_pagamento'])) { $pergunta_excluir_pagamento = $_REQUEST['pergunta_excluir_pagamento']; } else { $pergunta_excluir_pagamento = ''; }

if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar	
	
	$acao = '';

	$cod_comanda = $_REQUEST['cod_comanda'];
	$cod_cliente = $_REQUEST['cod_cliente'];

	if (isset($_REQUEST['acao'])){

		if($_REQUEST['acao'] == "excluir_pagamento"){

			$cod_comanda_pagamento = $_REQUEST['cod_comanda_pagamento'];

			$sql = "delete from comanda_pagamento where cod_comanda_pagamento = ".$cod_comanda_pagamento."";
			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='comanda_pagamentos.php?sucesso=1&cod_comanda=".$cod_comanda."&cod_cliente=".$cod_cliente."';</script>";die;

		}
		elseif($_REQUEST['acao'] == "excluir_desconto"){

			$sql = "
			update 		comanda 
			set			valor_desconto = '0'
			where 		cod_comanda = ".$cod_comanda." 
			and 		cod_cliente = ".$cod_cliente." 
			and 		cod_empresa = ".$cod_empresa."
			";

			//echo $sql; die;

			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='comanda_pagamentos.php?sucesso=1&cod_comanda=".$cod_comanda."&cod_cliente=".$cod_cliente."';</script>";die;


		}
	}

?>

<script language="javascript" src="js/caixa.js"></script>

<div class="static-content-wrapper">
    <div class="static-content">
        <div class="page-content">
            <ol class="breadcrumb">                
				<li><a href="#">Principal</a></li>
				<li class="active"><a href="comanda_pagamentos.php">Pagamentos</a></li>
            </ol>
            <div class="page-heading">            
                <h1>Venda</h1>

            </div>

            <div class="container-fluid">

				<div data-widget-group="group1">								

						<div class="panel panel-default" data-widget='{"draggable": "false"}'>
							<div class="panel-heading">
								<h2>Dívidas do Cliente</h2>
							</div>
							<div class="panel-body">

								<form class="form-horizontal row-border" name='frm' id="frm" method="post">

									<input type="hidden" id="cod_cliente" value="<?php echo $cod_cliente; ?>">
									<input type="hidden" id="voltar" value="<?php echo $voltar; ?>">
									

									<div class="form-group">
										<label class="col-sm-2 control-label"><b>Total</b></label>
										<div class="col-sm-8">
											<label class="control-label"><?php echo $total;?></label>
										</div>
									</div>


									<div class="form-group">

										<label class="control-label"><b>Pagamentos realizados</b></label>

										<?php
										//CARREGA LISTA
										$sql = "
										select 		c.cod_comanda
													,DATE_FORMAT(c.dt_inclusao, '%d/%m/%Y') as dataVenda
													,(	select 	sum(c1.valor) 
														from 	comanda_item c1 
														where 	c1.cod_empresa=c.cod_empresa
										                and 	c1.cod_cliente = c.cod_cliente
										                and 	c1.cod_comanda = c.cod_comanda
										                ) as valor
										from 		caixa a
										inner join 	comanda c on c.cod_caixa=a.cod_caixa
										left join 	comanda_pagamento cp on cp.cod_comanda=c.cod_comanda
										where 		c.cod_empresa = ".$cod_empresa."
										and 		c.cod_cliente = ".$cod_cliente."
										and 		c.situacao = 2
										and 		cp.cod_forma_pagamento = 6
										and 		cp.cod_comanda not in (select c2.cod_comanda from comanda_pagamento c2 where c2.cod_comanda = c.cod_comanda and c2.cod_forma_pagamento = 1)
										order by 	c.dt_inclusao asc;
										";

										//echo $sql;

										$query = mysql_query($sql);

										$registros = mysql_num_rows($query);
									
										?>

										<table class="table" border="1" bordercolor="#EEEEEE" style="width: 70%;">
						                    <thead>
						                    	<tr>
													<th>
														<button class="btn-primary btn" type="button" onclick="javascript:SelecionarTodasDividas();">Todos</button>
													</th>
													<th colspan="3">
														<button class="btn-primary btn" type="button" onclick="javascript:NenhumaDividas();">Nenhuma</button>	
													</th>
						                    	</tr>
						                        <tr>						                        	
						                        	<th style="width: 1%;"></th>													
						                        	<th style="width: 20%;">Data da Venda</th>
													<th style="width: 25%; text-align:center;">Valor da Dívida</th>
													<th style="width: 20%; text-align:center;">Ver Venda</th>
						                    </thead>
						                    <tbody>
											    <?php

												if ($registros > 0) 
												{
													while ($rs = mysql_fetch_array($query))
													{ 
													?>
							                        <tr>
														<td align="left">
															<input type="checkbox" name="cod_comanda" id="cod_comanda" value="<?php echo $rs['cod_comanda']; ?>">
														</td>
														<td align="center"><?php echo $rs['dataVenda'];?></td>
														<td align="right"><?php echo ValorMysqlPhp($rs['valor']);?></td>
														<td align="center">
															<a class="btn btn-success btn-label" 
																href="ver_venda.php?cod_comanda=<?php echo $rs['cod_comanda'];?>&cod_cliente=<?php echo $cod_cliente;  ?>&voltar=<?php echo $voltar; ?>">
																<i class="fa fa-eye"></i>Ver Venda
															</a>
														</td>
							                        </tr>
											    <?php
													} // while
												?>
								                        <tr>
								                            <td align="right" colspan="8"><b>Total selecionado: R$:</b></td>
								                        </tr>
											<?php
												} 
												else 
												{ // registro
												?>
								                        <tr>
								                            <td align="center" colspan="8">Nenhum pagamento!<br></td>
								                        </tr>
											<?php
												}
											?>		
							                    </tbody>


										</table>

									</div>

									<div class="panel-footer">
										<div class="row">
											<div class="col-sm-8 col-sm-offset-2">
												<button class="btn-primary btn" type="button" onclick="javascript:PagarDividas();">Selecionar</button>
												<button type="button" class="btn-default btn" onclick="javascript:window.location='caixa_cliente.php';">Voltar</button>
											</div>
										</div>
									</div>

								</form>

							</div>
						</div>



            </div> <!-- .container-fluid -->
        </div> <!-- #page-content -->
	</div>
<?php 
}
	
include('../include/rodape_interno2.php');?>