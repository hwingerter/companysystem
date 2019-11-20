<?php require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";
	
//*********** VERIFICA CREDENCIAIS DE USUÁRIOS *************
$credencial_ver = 0;
$credencial_incluir = 0;
$credencial_editar = 0;
$credencial_excluir = 0;

$credencial_ver = 1;
$credencial_incluir = 1;
$credencial_editar = 1;
$credencial_excluir = 1;

$cod_empresa	= $_SESSION['cod_empresa'];


if ($credencial_ver == '1') { //VERIFICA SE USUÁRIO POSSUI ACESSO A ESSA ÁREA
	
	if (isset($_REQUEST['sucesso'])) { $sucesso = $_REQUEST['sucesso']; } else { $sucesso = ''; }
	if (isset($_REQUEST['cancelar_comanda'])) { $cancelar_comanda = $_REQUEST['cancelar_comanda']; } else { $cancelar_comanda = ''; }
	if (isset($_REQUEST['fechar_comanda'])) { $fechar_comanda = $_REQUEST['fechar_comanda']; } else { $fechar_comanda = ''; }
	if (isset($_REQUEST['abrir_comanda'])) { $abrir_comanda = $_REQUEST['abrir_comanda']; } else { $abrir_comanda = ''; }
	if (isset($_REQUEST['excluir'])) { $excluir = $_REQUEST['excluir']; } else { $excluir = ''; }
	
	$cod_comanda = $_REQUEST['cod_comanda'];
	$cod_cliente = $_REQUEST['cod_cliente'];

	if ($excluir != '') {

		$sql = "delete from comanda_pagamento where cod_comanda = ".$excluir."";

		mysql_query($sql);

		$sql = "delete from comanda_item where cod_comanda = ".$excluir."";
		mysql_query($sql);

		$sql = "delete from comanda where cod_comanda = ".$excluir."";
		mysql_query($sql);
		
		$comanda_excluida = '1';
	}

	if (isset($_REQUEST['acao'])){
		
		if($_REQUEST['acao'] == "abrir_comanda"){

			$sql = "
			update 		comanda 
			set 		situacao = 1 
			where 		cod_comanda = ".$cod_comanda."
			and 		cod_cliente = ".$cod_cliente."
			and 		cod_empresa = ".$cod_empresa."";

			mysql_query($sql);

			echo "<script language='javascript'>window.location='comanda.php?cod_comanda=".$cod_comanda."&cod_cliente=".$cod_cliente."&sucesso=3';</script>";die;

		}else if($_REQUEST['acao'] == "fechar_comanda"){

			$sql = "
			update 		comanda 
			set 		situacao = 2
			where 		cod_comanda = ".$cod_comanda."
			and 		cod_cliente = ".$cod_cliente."
			and 		cod_empresa = ".$cod_empresa."";

			mysql_query($sql);

			echo "<script language='javascript'>window.location='comanda.php?cod_comanda=".$cod_comanda."&cod_cliente=".$cod_cliente."&sucesso=4';</script>";die;

		}

	}
	
	$DataAtual  = date("Y-m-d");
	$flg_caixa_anterior = false;

	//ultimo caixa aberto
	$sql = "
	select		max(cod_caixa) as cod_caixa
				,date_format(dt_abertura,'%Y-%m-%d') as dt_caixa
				,date_format(dt_abertura,'%d/%m/%Y %H:%i:%s') as dt_abertura
	from 		caixa
	where 		situacao = 1
	and			cod_empresa = ".$cod_empresa."
	group by	dt_abertura
	";
	//echo $sql; die;
	$query = mysql_query($sql);

	$registros = mysql_num_rows($query);

	$flg_caixa_anterior = false;

	if($registros > 0)
	{
		if($rs = mysql_fetch_array($query))
		{
			$dt1 = strtotime($rs['dt_caixa']);
			$dt2 = strtotime($DataAtual);
	
			/*echo "Data Atual: ".$DataAtual."<br>";
			echo "Data Atual: ".$rs['dt_caixa']."<br>";
			echo "Data da Caixa: ".$dt1." <br> Data Atual: ".$dt2;*/
	
			if($dt2 > $dt1)
			{
				$_SESSION['cod_caixa']		= $rs['cod_caixa'];
				$_SESSION['dt_caixa'] 		= $rs['dt_caixa'];
				$_SESSION['dt_abertura'] 	= $rs['dt_abertura'];
				$flg_caixa_anterior 		= true;
			}
			else
			{
				$_SESSION['cod_caixa']		= $rs['cod_caixa'];
				$_SESSION['dt_abertura'] 	= $rs['dt_abertura'];
				$flg_caixa_anterior 		= false;
			}
		}
	}
	else
	{
		$caixa = "fechado";
	}	

	$cod_caixa			= $_SESSION['cod_caixa'];
	$dt_caixa			= DataMysqlPhp($_SESSION['dt_caixa']);
				
?>

		<script language="javascript" src="js/comanda.js"></script>

                <div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">                                
								<li><a href="#">Principal</a></li>
								<li class="active"><a href="comanda.php">Comandas (Vendas)</a></li>
                            </ol>
							
                            <div class="page-heading">     

                                <h1>Comandas (Vendas) </h1> 								
                                <div class="options">
						
						  	  <?php 
							  if ( ($credencial_incluir == '1') && ($caixa != "fechado") ) {
							  ?>
								<a class="btn btn-midnightblue btn-label" href="comanda_cliente.php"><i class="fa fa-plus-circle"></i> Nova Comanda</a>
							  <?php
							  }
							  ?>	
								</div>
                            </div>

                            <div class="container-fluid">
						
							<?php
							if ($caixa == "fechado"){
							?>
							<div class="alert alert-dismissable alert-danger">
								<i class="fa fa-fw fa-check"></i>&nbsp; <strong>É preciso abrir o caixa antes de vender.</strong>
							</div>
							<?php								
							}


							if ($sucesso == '1') {
							?>
							<div class="alert alert-dismissable alert-success">
								<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Pagamento de comanda realizado com sucesso!</strong>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							</div>
							<?php
							
							} else if ($sucesso == '2') {
							?>
							<div class="alert alert-dismissable alert-success">
								<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Dados alterados com sucesso!</strong>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							</div>				
							<?php

							} else if ($sucesso == '3') {
								?>
								<div class="alert alert-dismissable alert-success">
									<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Comanda aberta com sucesso!</strong>
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								</div>				
								<?php

							} else if ($sucesso == '4') {
								?>
								<div class="alert alert-dismissable alert-success">
									<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Comanda fechada com sucesso!</strong>
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								</div>				
								<?php
								}


							if ($cancelar_comanda != '') {
							?>
							<div class="alert alert-dismissable alert-info">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<strong>Deseja realmente cancelar a comanda número <?php echo $cancelar_comanda; ?>?</strong><br>
								<br><a class="btn btn-success" href="comanda.php?excluir=<?php echo $cancelar_comanda;?>">Sim</a>&nbsp;&nbsp;&nbsp; <a class="btn btn-danger" href="comanda.php">Não</a>
							</div>				
							<?php
							}
							elseif ($fechar_comanda != '') {
							?>
							<div class="alert alert-dismissable alert-info">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<strong>Deseja realmente fechar a comanda número <?php echo $fechar_comanda; ?>?</strong><br>
								<br><a class="btn btn-success" href="comanda.php?acao=fechar_comanda&cod_comanda=<?php echo $fechar_comanda;?>&cod_cliente=<?php echo $cod_cliente;?>">Sim</a>&nbsp;&nbsp;&nbsp; <a class="btn btn-danger" href="comanda.php">Não</a>
							</div>				
							<?php
							}
							elseif ($abrir_comanda != '') {
							?>
							<div class="alert alert-dismissable alert-info">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<strong>Deseja realmente abrir a comanda número <?php echo $fechar_comanda; ?>?</strong><br>
								<br><a class="btn btn-success" href="comanda.php?acao=abrir_comanda&cod_comanda=<?php echo $abrir_comanda;?>&cod_cliente=<?php echo $cod_cliente;?>">Sim</a>&nbsp;&nbsp;&nbsp; <a class="btn btn-danger" href="comanda.php">Não</a>
							</div>				
							<?php
							}

							if ($comanda_excluida != '') {
							?>
							<div class="alert alert-dismissable alert-danger">
								<i class="fa fa-fw fa-times"></i>&nbsp; <strong>Comanda cancelada com sucesso!</strong>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							</div>				
							<?php
							}

							if ($flg_caixa_anterior == true) {
							?>
							<div class="alert alert-dismissable alert-danger">
								<strong>O caixa que está aberto é antigo!
								<br>Se for abrir novas comandas, é aconselhável que feche o caixa e abra um novo. É aconselhável abrir um caixa por dia.
								<br>Todas as comandas cadastradas neste caixa, sairá com a data do caixa, ou seja, <?php echo $dt_caixa; ?>.
								<br>Se quiser que as comandas saiam com a data e hora atuais, feche este caixa e abra um novo.
								</strong>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							</div>				
							<?php
							}
							?>


		</div>
		
<?php 
if ($caixa != "fechado")
{ 
?>


        <div class="panel panel-sky">

            <div class="panel-heading">
                <h2>Comandas Abertas</h2>
          </div>

          <div class="panel-body">

            <div class="table-responsive">

				<?php

						//CARREGA LISTA
					$sql = "
					select		c.cod_comanda, c.cod_cliente, c.cod_empresa
								,c.dt_inclusao
								,date_format(c.dt_inclusao, '%d/%m/%Y %H:%m:%s') as dt_venda
								,c1.nome
								,c.situacao
								,ifnull((select sum(ci.valor*ci.quantidade) from comanda_item ci where ci.cod_comanda = c.cod_comanda), 0.00) as valor_total
					from 		comanda c
					left join	clientes c1 on c1.cod_cliente = c.cod_cliente
					where		c.cod_empresa = ".$cod_empresa."
					and 		c.cod_caixa = ".$cod_caixa."
					and 		c.situacao = 1
					";
					
					if (isset($_REQUEST['acao'])){

						if ($_REQUEST['acao'] == "buscar"){
						
							if ($_REQUEST['nome'] != ""){
								$sql = $sql . " and c.descricao like '%".$_REQUEST['nome']."%' ";
							}

							if (isset($_REQUEST['status']))
							{
								if($_REQUEST['status'] == "1"){
									$sql = $sql . " and c.situacao = '1' ";

								}elseif($_REQUEST['status'] == "2"){
									$sql = $sql . " and c.situacao = '2' ";
								}
							}

						}
					}
					$sql .= "
						order by 	c.dt_inclusao desc;
					";

					//echo $sql;

					$query = mysql_query($sql);

					$registros = mysql_num_rows($query);


				?>

                <table class="table" border="1" bordercolor="#EEEEEE">
                    <thead>
                        <tr>
                            <th style="width:5%;">Codigo</th>
                            <th style="width:10%;">Data/Hora</th>
							<th style="width:10%;">Cliente</th>
							<th style="width:10%;">Valor Total</th>
							<th style="width:20%;">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>

					<?php

					if ($registros > 0) {

						while (($rs = mysql_fetch_array($query))){ 
							$contador = $contador + 1; //Contador
							if ($contador>$inicio) { //Condiçao para mostrar somente os registros maiores


								$valor_total = number_format($rs['valor_total'], 2, ',', '.');


						?>
                        <tr>
                            <td align="left"><?php echo $rs['cod_comanda'];?></td>
                            <td align="left"><?php echo $rs['dt_venda'];?></td>
							<td align="left"><?php echo $rs['nome']; ?></td>
							<td align="left"><?php echo $valor_total; ?></td>
                            <td align='center'>

								<?php 
								if ( ($credencial_editar == '1') && ($rs['situacao'] == "2")) {
								?>							
								<a class="btn btn-info btn-label" href="comanda.php?abrir_comanda=<?php echo $rs['cod_comanda'];?>&cod_cliente=<?php echo $rs['cod_cliente'];?>"><i class="fa fa-edit"></i> Abrir</a>&nbsp;
								<?php 
								}elseif ($rs['situacao'] == "1"){
								?>
									<a class="btn btn-success btn-label" href="comanda_lista.php?cod_comanda=<?php echo $rs['cod_comanda'];?>&cod_cliente=<?php echo $rs['cod_cliente'];?>"><i class="fa fa-edit"></i>Editar</a>

									<a class="btn btn-danger btn-label" href="comanda.php?fechar_comanda=<?php echo $rs['cod_comanda'];?>&cod_comanda=<?php echo $rs['cod_comanda'];?>&cod_cliente=<?php echo $rs['cod_cliente'];?>"><i class="fa fa-times-circle"></i> Fechar</a>&nbsp;

								<?php	
								}
								?>							

								<?php if ($rs['situacao'] == "1") {?>

								<a class="btn btn-info btn-label" href="comanda_forma_pagamento.php?flg_divida=&cod_comanda=<?php echo $rs['cod_comanda'];?>&cod_cliente=<?php echo $rs['cod_cliente']; ?>&voltar=comanda.php"><i class="fa fa-money"></i>Receber</a>

								<?php } ?>

								

								<a class="btn btn-danger btn-label" onclick="CancelarComanda('<?php echo $rs['cod_comanda'];?>');"><i class="fa fa-times-circle"></i> Cancelar</a>
							</td>
                        </tr>
						<?php
								} // Contador
							} // while
						?>
                        <tr>
                            <td align="right" colspan="8"><b>Total de registro: <?php echo $registros; ?></b></td>
                        </tr>
						<?php
							} else { // registro
							?>
                        <tr>
                            <td align="center" colspan="7">Nenhum registro encontrado!</td>
                        </tr>
							<?php
								}
							?>		

							</tbody>

						</table>

					</div>

				</div>

			</div>



				<div class="panel panel-sky">

					<div class="panel-heading">
						<h2>Comandas Fechadas</h2>
					</div>

					<div class="panel-body">

					<div class="table-responsive">

		<?php

				//CARREGA LISTA
			$sql = "
			select		c.cod_comanda, c.cod_cliente, c.cod_empresa
						,c.dt_inclusao
						,date_format(c.dt_inclusao, '%d/%m/%Y %H:%m:%s') as dt_venda
						,c1.nome
						,c.situacao
						,ifnull((select sum(ci.valor*ci.quantidade) from comanda_item ci where ci.cod_comanda = c.cod_comanda), 0.00) as valor_total
			from 		comanda c
			left join	clientes c1 on c1.cod_cliente = c.cod_cliente
			where		c.cod_empresa = ".$cod_empresa."
			and 		c.cod_caixa = ".$cod_caixa."
			and 		c.situacao = 2
			";
			
			if (isset($_REQUEST['acao'])){

				if ($_REQUEST['acao'] == "buscar"){
				
					if ($_REQUEST['nome'] != ""){
						$sql = $sql . " and c.descricao like '%".$_REQUEST['nome']."%' ";
					}
				}
			}
			$sql .= "
				order by 	c.dt_inclusao desc
			";

			//echo $sql;

			$query = mysql_query($sql);

			$registros = mysql_num_rows($query);


		?>

		<table class="table" border="1" bordercolor="#EEEEEE">
			<thead>
				<tr>
					<th style="width:10%;">Codigo</th>
					<th style="width:10%;">Data/Hora</th>
					<th style="width:50%;">Cliente</th>
					<th style="width:10%;">Valor Total</th>
					<th style="width:20%;">&nbsp;</th>
				</tr>
			</thead>
			<tbody>

			<?php

			if ($registros > 0) {

				while (($rs = mysql_fetch_array($query))){ 
					$contador = $contador + 1; //Contador
					if ($contador>$inicio) { //Condiçao para mostrar somente os registros maiores


						$valor_total = number_format($rs['valor_total'], 2, ',', '.');


				?>
				<tr>
					<td align="left"><?php echo $rs['cod_comanda'];?></td>
					<td align="left"><?php echo $rs['dt_venda'];?></td>
					<td align="left"><?php echo $rs['nome']; ?></td>
					<td align="left"><?php echo $valor_total; ?></td>
					<td align='center'>

						<?php 
						if ( ($credencial_editar == '1') && ($rs['situacao'] == "2")) {
						?>							
						<a class="btn btn-info btn-label" href="comanda.php?abrir_comanda=<?php echo $rs['cod_comanda'];?>&cod_cliente=<?php echo $rs['cod_cliente'];?>"><i class="fa fa-edit"></i> Reabrir comanda</a>&nbsp;
						<?php 
						}elseif ($rs['situacao'] == "1"){
						?>
							<a class="btn btn-success btn-label" href="comanda_lista.php?cod_comanda=<?php echo $rs['cod_comanda'];?>&cod_cliente=<?php echo $rs['cod_cliente'];?>"><i class="fa fa-edit"></i>Editar</a>

							<a class="btn btn-danger btn-label" href="comanda.php?fechar_comanda=<?php echo $rs['cod_comanda'];?>&cod_comanda=<?php echo $rs['cod_comanda'];?>&cod_cliente=<?php echo $rs['cod_cliente'];?>"><i class="fa fa-times-circle"></i> Fechar</a>&nbsp;

						<?php	
						}
						?>							

						<?php if ($rs['situacao'] == "1") {?>

						<a class="btn btn-info btn-label" href="comanda_pagamentos.php?cod_comanda=<?php echo $rs['cod_comanda'];?>&cod_cliente=<?php echo $rs['cod_cliente']; ?>"><i class="fa fa-money"></i>Pagamentos</a>

						<?php } ?>

						

						<a class="btn btn-danger btn-label" onclick="CancelarComanda('<?php echo $rs['cod_comanda'];?>');"><i class="fa fa-times-circle"></i> Cancelar</a>
					</td>
				</tr>
				<?php
						} // Contador
					} // while
				?>
				<tr>
					<td align="right" colspan="8"><b>Total de registro: <?php echo $registros; ?></b></td>
				</tr>
				<?php
					} else { // registro
					?>
				<tr>
					<td align="center" colspan="7">Nenhum registro encontrado!</td>
				</tr>
					<?php
						}
					?>		

					</tbody>

				</table>

			</div>

	</div>





<?php

}


 } // VER 
	
include('../include/rodape_interno2.php')
?>

<script type="text/javascript">
	$(document).ready(function() {
	  $(":input[data-inputmask-mask]").inputmask();
	  $(":input[data-inputmask-alias]").inputmask();
	  $(":input[data-inputmask-regex]").inputmask("Regex");
	});
</script>