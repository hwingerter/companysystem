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
	$cod_comanda 		= $_REQUEST['cod_comanda'];


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
		

$total 		= TotalComanda($cod_empresa, $cod_cliente, $cod_comanda);
$fiado		= TotalFiado($cod_empresa, $cod_cliente, $cod_comanda);
$recebido	= TotalPago($cod_empresa, $cod_cliente, $cod_comanda) - $fiado;

$Voltar 	= $_REQUEST['voltar'];

?>
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
								<h2>Detalhes da Venda</h2>
							</div>
							<div class="panel-body">

								<form class="form-horizontal row-border" name='frm' method="post">

									<div class="form-group">
										<label class="col-sm-2 control-label"><b>Total da Venda:</b></label>
										<div class="col-sm-8">
											<label class="control-label"><?php echo ValorMysqlPhp($total);?></label>
										</div>
									</div>

									<?php if ($fiado != "0"): ?>
										<div class="form-group">
											<label class="col-sm-2 control-label"><b>Fiado:</b></label>
											<div class="col-sm-8">
												<label class="control-label"><?php echo ValorMysqlPhp($fiado);?></label>
											</div>
										</div>										
									<?php endif ?>

									<div class="form-group">
										<label class="col-sm-2 control-label"><b>Recebido:</b></label>
										<div class="col-sm-8">
											<label class="control-label"><?php echo ValorMysqlPhp(number_format($recebido, 2));?></label>
										</div>
									</div>

									<div class="form-group">

										<label class="control-label"><b>Itens da Venda:</b></label>

										<?php
										//CARREGA LISTA
										$sql = "
										select 		case
														when ci.cod_servico is not null then s.nome
										                when ci.cod_produto is not null then p.descricao
													end as descricao
													,ci.quantidade, ci.valor
													,p1.nome as profissional
										from 		comanda c
										inner join 	comanda_item ci on ci.cod_comanda = c.cod_comanda
										left join 	servico s on s.cod_servico = ci.cod_servico
										left join 	produtos p on p.cod_produto = ci.cod_produto
										left join 	profissional p1 on p1.cod_profissional=ci.cod_profissional
										where 		c.cod_empresa = ".$cod_empresa."
										and 		c.cod_cliente = ".$cod_cliente."
										and 		c.cod_comanda = ".$cod_comanda.";
										";

										//echo $sql;

										$query = mysql_query($sql);

										$registros = mysql_num_rows($query);
									
										?>

										<table class="table" border="1" bordercolor="#EEEEEE" style="margin: 0 auto; width: 100%;">
						                    <thead>
						                        <tr>
													<th style="width: 20%;">Descrição</th>
						                        	<th style="width: 20%;">Qtd</th>
													<th style="width: 20%; text-align:center;">Valor Total</th>
													<th style="width: 20%; text-align:center;">Profissional</th>
						                    </thead>
						                    <tbody>
											    <?php

												if ($registros > 0) 
												{
													while ($rs = mysql_fetch_array($query))
													{ 
													?>
							                        <tr>
														<td align="left"><?php echo $rs['descricao'];?></td>
														<td align="center"><?php echo $rs['quantidade'];?></td>
														<td align="right"><?php echo ValorMysqlPhp($rs['valor']);?></td>
														<td align="center"><?php echo $rs['profissional'];?></td>
							                        </tr>
											    <?php
													} // while
												?>
											<?php
												} 
												else 
												{ // registro
												?>
											<?php
												}
											?>		
							                    </tbody>


										</table>

									</div>

									<div class="form-group">

										<label class="control-label"><b>Pagamentos</b></label>

										<?php
										//CARREGA LISTA
										$sql = "
										select		f.descricao as forma_pagamento
													,p.cod_comanda_pagamento,p.cod_comanda
													,IFNULL(p.valor, 0.0) as valor
													,IFNULL(p.valor_fiado, 0.0) as valor_fiado
													,DATE_FORMAT(p.dt_pagamento, '%d/%m/%Y') as dataPagamento
													,u.nome as atendente 
													,p.num_parcelas
										from 		comanda_pagamento p
										inner join 	usuarios u on u.cod_usuario = p.cod_usuario_pagamento
										inner join 	formas_pagamento f on f.cod_forma_pagamento = p.cod_forma_pagamento
										where 		p.cod_empresa = ".$cod_empresa."
										and 		p.cod_cliente = ".$cod_cliente."
										and 		p.cod_comanda = ".$cod_comanda."
										order by	p.dt_pagamento asc
										";

										//echo $sql;

										$query = mysql_query($sql);

										$registros = mysql_num_rows($query);
									
										?>

										<table class="table" border="1" bordercolor="#EEEEEE" style="margin: 0 auto; width: 100%;">
						                    <thead>
						                        <tr>
													<th style="width: 12%;">Forma de Pagamento</th>
													<th style="width: 12%; text-align:center;">Valor</th>
						                        	<th style="width: 12%;">Pagamento</th>
						                        	<th style="width: 12%;">Vencimento</th>
													<th style="width: 25%;">Observação</th>
						                    </thead>
						                    <tbody>
											    <?php

												if ($registros > 0) 
												{
													while ($rs = mysql_fetch_array($query))
													{ 
													?>
							                        <tr>
														<td align="left"><?php echo $rs['forma_pagamento'];?></td>
														<td align="right"><?php echo ValorMysqlPhp($rs['valor']);?></td>
														<td align="center"><?php echo $rs['dataPagamento'];?></td>
														<td align="right"><?php echo ValorMysqlPhp($rs['valor_fiado']);?></td>
														<td align="center"><?php echo $rs['atendente'];?></td>
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


								<button class="btn-default btn" onclick="javascript:window.location='<?php echo $Voltar; ?>';">Voltar</button>


							</div>
						</div>



            </div> <!-- .container-fluid -->
        </div> <!-- #page-content -->
	</div>
<?php 
}
	
include('../include/rodape_interno2.php');?>