<?php include('../include/topo_interno.php');
	
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

if (isset($_REQUEST['pergunta_excluir_pagamento'])) { $pergunta_excluir_pagamento = $_REQUEST['pergunta_excluir_pagamento']; } else { $pergunta_excluir_pagamento = ''; }

if (($credencial_incluir == '1') || ($credencial_editar == '1')) 
{ // Verifica se o usu�rio tem a credencial de incluir ou editar	
	
	$acao = '';

	$cod_comanda = $_REQUEST['cod_comanda'];
	$cod_cliente = $_REQUEST['cod_cliente'];

	if (isset($_REQUEST['acao'])){

		if($_REQUEST['acao'] == "excluir_pagamento"){

			$cod_comanda_pagamento = $_REQUEST['cod_comanda_pagamento'];

			$sql = "delete from comanda_pagamento where cod_comanda_pagamento = ".$cod_comanda_pagamento."";
			mysql_query($sql);

			$sql = "delete from clientes_credito where cod_empresa = ".$cod_empresa." and cod_cliente = ".$cod_cliente." and cod_comanda = ".$cod_comanda."";
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


$flg_divida = $_REQUEST['flg_divida'];

if ($_REQUEST['voltar'] != "") {
	$voltar 	= $_REQUEST['voltar'];
}else{
	$voltar 	= "comanda.php";
}




/************************
 * calculos 
 ***********************/
$total 		= TotalComanda($cod_empresa, $cod_cliente, $cod_comanda);
$fiado 		= TotalFiado($cod_empresa, $cod_cliente, $cod_comanda);
$desconto	= Comanda_Desconto($cod_empresa, $cod_cliente, $cod_comanda);
$creditos 	= Comanda_Creditos($cod_empresa, $cod_cliente, $cod_comanda);
$recebido	= TotalPago($cod_empresa, $cod_cliente, $cod_comanda) - $fiado;


if($total > $recebido){
	$falta = number_format((($total - $desconto) - $recebido), 2);

}else if($total == $recebido){
	$falta = "0.00";

}else if($total < $recebido){
	$falta = "0.00";
	$troco = ($recebido - ($total - $desconto));
	$troco = $troco - $creditos;
	
}else{
	$falta = "0.00";
}

/************************
 * apresentação
 ***********************/
$total 		= "R$ ".number_format($total, 2, ',', '.');
$recebido	= "R$ ".number_format($recebido, 2, ',', '.');
$falta		= "R$ ".number_format($falta, 2, ',', '.');

if ($troco != "") {
	$troco		= "R$ ".number_format($troco, 2, ',', '.');
}


?>
<div class="static-content-wrapper">
    <div class="static-content">
        <div class="page-content">
            <ol class="breadcrumb">                
				<li><a href="#">Principal</a></li>
				<li class="active"><a href="comanda_pagamentos.php">Pagamentos</a></li>
            </ol>
            <div class="page-heading">            
                <h1>Comanda</h1>
                <div class="options">
					<a class="btn btn-midnightblue btn-label" href="comanda_forma_pagamento.php?flg_divida=<?php echo $flg_divida; ?>&cod_comanda=<?php echo $cod_comanda; ?>&cod_cliente=<?php echo $cod_cliente; ?>&voltar=<?php echo urlencode($voltar); ?>"><i class="fa fa-plus-circle"></i> Novo Pagamento</a>
				</div>
            </div>

            <div class="container-fluid">

				<?php 
				if ($pergunta_excluir_pagamento != '') {
				?>
				<div class="alert alert-dismissable alert-info">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<strong>Deseja realmente excluir esse pagamento realizado?</strong><br>
					<br><a class="btn btn-success" href="comanda_pagamentos.php?acao=excluir_pagamento&cod_comanda_pagamento=<?php echo $pergunta_excluir_pagamento;?>&cod_comanda=<?php echo $cod_comanda;?>&cod_cliente=<?php echo $cod_cliente;  ?>">Sim</a>
					&nbsp;&nbsp;&nbsp; 
					<a class="btn btn-danger" href="comanda_pagamentos.php?cod_comanda=<?php echo $cod_comanda;?>&cod_cliente=<?php echo $cod_cliente;  ?>">Não</a>
				</div>				
				<?php
				}
				?>

				<div data-widget-group="group1">								

						<div class="panel panel-default" data-widget='{"draggable": "false"}'>
							<div class="panel-heading">
								<h2>Painel de Pagamentos</h2>
							</div>
							<div class="panel-body">

								<form class="form-horizontal row-border" name='frm' method="post">

									<div class="form-group">
										<label class="col-sm-2 control-label"><b>Total</b></label>
										<div class="col-sm-8">
											<label class="control-label"><?php echo $total;?></label>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label"><b>Desconto</b></label>
										<div class="col-sm-8">
											<label class="control-label"><?php echo "R$ ".ValorMysqlPhp($desconto);?></label>
											&nbsp;
											<?php 
											if ($desconto == "0.00"){?>
												<button type="button" class="btn-success btn" onclick="javascript:window.location='comanda_pagamento_desconto.php?acao=inserir_desconto&cod_comanda=<?php echo $cod_comanda;?>&cod_cliente=<?php echo $cod_cliente;?>';">Adicionar</button>
											
											<?php }else{?>															
												<button type="button" class="btn-danger btn" onclick="javascript:window.location='comanda_pagamentos.php?acao=excluir_desconto&cod_comanda=<?php echo $cod_comanda;?>&cod_cliente=<?php echo $cod_cliente;?>';">Remover</button>
											<?php } ?>

										</div>
									</div>

									<?php if ($recebido != $fiado): ?>
										
									<div class="form-group">
										<label class="col-sm-2 control-label"><b>Fiado</b></label>
										<div class="col-sm-8">
											<label class="control-label"><?php echo "R$ ".$fiado;?></label>
										</div>
									</div>

									<?php endif ?>

									<div class="form-group">
										<label class="col-sm-2 control-label"><b>Recebido</b></label>
										<div class="col-sm-8">
											<label class="control-label"><?php echo $recebido;?></label>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label"><b>Faltam</b></label>
										<div class="col-sm-8">
											<label class="control-label"><?php echo $falta;?></label>
										</div>
									</div>

									<?php if ($troco != ""): ?>
										
									<div class="form-group">
										<label class="col-sm-2 control-label"><b>Troco</b></label>
										<div class="col-sm-8">
											<label class="control-label"><?php echo $troco;?></label>
										</div>
									</div>

									<?php endif ?>

									<?php if ($creditos != ""): ?>
										
									<div class="form-group">
										<label class="col-sm-2 control-label"><b>Créditos</b></label>
										<div class="col-sm-8">
											<label class="control-label"><?php echo "R$ ".ValorMysqlPhp($creditos);?></label>
										</div>
									</div>

									<?php endif ?>

									<div class="form-group">

										<label class="control-label"><b>Pagamentos realizados</b></label>

										<?php
										//CARREGA LISTA
										$sql = "
										select		f.descricao as forma_pagamento
													,p.cod_comanda_pagamento,p.cod_comanda
													,IFNULL(p.valor, 0.0) as valor
													,DATE_FORMAT(p.dt_pagamento, '%d/%m/%Y %H:%i hs') as dataPagamento
													,u.nome as atendente 
													,p.num_parcelas
										from 		comanda_pagamento p
										inner join 	usuarios u on u.cod_usuario = p.cod_usuario_pagamento
										inner join 	formas_pagamento f on f.cod_forma_pagamento = p.cod_forma_pagamento
										where 		p.cod_empresa = ".$cod_empresa."
										and 		p.cod_cliente = ".$cod_cliente."
										and 		p.cod_comanda in (".$cod_comanda.")
										order by	p.dt_pagamento asc
										";

										//echo $sql;

										$query = mysql_query($sql);

										$registros = mysql_num_rows($query);
									
										?>

										<table class="table" border="1" bordercolor="#EEEEEE" style="margin: 0 auto; width: 100%;">
						                    <thead>
						                        <tr>
													<th style="width: 12%;">Forma</th>
						                        	<th style="width: 12%;">Pago em</th>
													<th style="width: 12%; text-align:center;">Valor</th>
													<th style="width: 25%;">Pago por</th>
													<th style="width: 20%;">&nbsp;</th>
						                    </thead>
						                    <tbody>
											    <?php

												if ($registros > 0) 
												{
													while ($rs = mysql_fetch_array($query))
													{ 
													
														if($rs['num_parcelas'] != "")
														{
															$valor =  $rs['num_parcelas'].'x '.number_format($rs['valor'], 2, ',', '.');
														}
														else
														{
															$valor = "R$ ".number_format($rs['valor'], 2, ',', '.');
														}


													?>
							                        <tr>
														<td align="left"><?php echo $rs['forma_pagamento'];?></td>
														<td align="center"><?php echo $rs['dataPagamento'];?></td>
														<td align="right"><?php echo $valor; ?></td>
														<td align="center"><?php echo $rs['atendente'];?></td>
														<td>
															<!--a 
																class="btn btn-default btn-label" 
																href="comanda_pagamentos.php?acao=alterar&cod_comanda=<?php echo $cod_comanda;?>&cod_cliente=<?php echo $cod_cliente;  ?>">
																<i class="fa fa-times-circle"></i>Editar
															</a-->

															<a 
																class="btn btn-danger btn-label" 
																href="comanda_pagamentos.php?pergunta_excluir_pagamento=<?php echo $rs['cod_comanda_pagamento'];?>&cod_comanda_pagamento=<?php echo $rs['cod_comanda_pagamento'];?>&cod_comanda=<?php echo $cod_comanda;?>&cod_cliente=<?php echo $cod_cliente;  ?>">

																<i class="fa fa-times-circle"></i>Excluir
																
															</a>
														</td>
							                        </tr>
											    <?php
													} // while
												?>
											                        <tr>
											                            <td align="right" colspan="8"><b>Total de registro: <?php echo $registros; ?></b></td>
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

								</form>

								<button class="btn-default btn" onclick="javascript:window.location='<?php echo $voltar; ?>';">Voltar</button>


							</div>
						</div>



            </div> <!-- .container-fluid -->
        </div> <!-- #page-content -->
	</div>
<?php 
}
	
include('../include/rodape_interno.php');?>