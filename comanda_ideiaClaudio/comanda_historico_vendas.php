<?php include('../include/topo_interno.php');
	
//*********** VERIFICA CREDENCIAIS DE USUÁRIOS *************





$credencial_ver = 1;
$credencial_incluir = 1;
$credencial_editar = 1;
$credencial_excluir = 1;

$cod_empresa = $_SESSION['cod_empresa'];


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


	//FUNÇÃ£O QUE RETORNA O TOTAL DE PAGINAS E QUANTIDADE DE REGISTRO POR PAGINAS
	$sql = "Select COUNT(cod_conta) as total from conta  ";
	if (isset($_REQUEST['acao'])){
		if ($_REQUEST['acao'] == "buscar"){
			if ($_REQUEST['nome'] != ""){
				$sql = $sql . " where descricao like '%".$_REQUEST['nome']."%' ";
			}
		}
	}	
	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		if ($rs = mysql_fetch_array($query)) {
			$totalregistro = $rs['total'];
		}
	}
	
	
  	// Calcula a quantidade de paginas
	$registrosPagina = 30; // Define a quantidade de registro por Paginas
	$paginas = $totalregistro / $registrosPagina; // Calcula o total de paginas
	$resto = $totalregistro % $registrosPagina; // Pega o resto da divisÃ£o
	$paginas = intval($paginas); // Converte o resultado para inteiro
	if ($resto > 0) { $paginas = $paginas + 1; } // Se o resto maior do que 0, soma a var paginas para a paginaçÃ£o ficar correta
	
	if (isset($_REQUEST['pagina'])) {
		$pagina = $_REQUEST['pagina']; // recupera a pagina
	} else { // Primeira pagina
		$pagina = 1;
	}
	
   $inicio = ( $pagina - 1 ) * $registrosPagina; //Defini o inicio da lista
   $final = $registrosPagina + $inicio; //Define o final da lista
   $contador = 0; //Seta variavel de Contador
   
   // Converte para inteiro
   $pagina = intval($pagina);	

   $dt_inicial = "01".date("/m/Y");
   $dt_final = "15".date("/m/Y");

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
                                <h1>Histórico de Vendas</h1>
	                        </div>
                            <div class="container-fluid">
							<script language="JavaScript">
								function paginacao () {
							  		document.forms[0].action = "cartao.php";
								  	document.forms[0].submit();
								}
							</script>
							
							<?php
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
							?>

		</div>
		
			<form action="comanda_historico_vendas.php" class="form-horizontal" name='frm' method="post">

				<input type='hidden' name='acao' value='buscar'>

				<div class="row">
					<div class="col-sm-12">
						<div class="panel panel-sky">
							<div class="panel-heading">
								<h2>Filtros</h2>
							</div>
							<div class="panel-body">

								<div class="form-group">
									<label class="col-sm-2 control-label">Data Inicial</label>
									<div class="col-sm-2">

										<input type="text" class="form-control mask" 
											id="dt_inicial" 
											name="dt_inicial" 
											data-inputmask-alias="dd/mm/yyyy" 
											data-inputmask="'alias': 'date'" 
											data-val="true" 
											data-val-required="Required" 
											placeholder="dd/mm/yyyy"
											value="<?php 
												if (isset($_REQUEST['dt_inicial'])){ 
													if ($_REQUEST['dt_inicial'] != ""){ 
														echo $_REQUEST['dt_inicial']; 
													}
												}else{ 
													echo $dt_inicial; 
												}
												?>"
											>

									</div>
									<label class="col-sm-2 control-label">Data Final</label>
									<div class="col-sm-2">

										<input type="text" class="form-control mask" 
											id="dt_final" 
											name="dt_final" 
											data-inputmask-alias="dd/mm/yyyy" 
											data-inputmask="'alias': 'date'" 
											data-val="true" 
											data-val-required="Required" 
											placeholder="dd/mm/yyyy"
											value="<?php 
												if (isset($_REQUEST['dt_final'])){ 
													if ($_REQUEST['dt_final'] != ""){ 
														echo $_REQUEST['dt_final']; 
													}
												}else{ 
													echo $dt_final; 
												}
												?>"
											>

									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label">Cliente</label>
									<div class="col-sm-6">
										<?php comboCLiente("", $cod_empresa); ?>
									</div>
								</div>

								<div class="panel-footer">
									<div class="row">
										<div class="col-sm-8 col-sm-offset-1">
											<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Buscar</button>
										</div>
									</div>
								</div>
							</div>
						</div>	
					</div>
				</div>

			</form>


        <div class="panel panel-sky">
            <div class="panel-heading">
                <h2>Comandas</h2>
				<p align='right'>
				<select name='pagina' class="form-control" style="width: 60px;" onChange="javascript:paginacao();">
				  	<?php for ($i=1; $i<=$paginas; $i++) {?>
					<option value="<?php echo $i; ?>" <?php if ($pagina == $i) { echo " Selected"; }?>><?php echo $i;?></option>
					<?php
						  }
					?>
				</select>
				</p>
          </div>

          <div class="panel-body">

            <div class="table-responsive">

				<?php

						//CARREGA LISTA
					$sql = "
					select		date_format(c.dt_inclusao, '%d/%m/%Y') as data_venda, c1.nome, c1.cod_cliente, c.cod_comanda
								,(
								select 		sum((ci.valor * quantidade))
								from 		comanda_item ci 
								inner join 	comanda co on co.cod_comanda = ci.cod_comanda 
								inner join 	clientes c1 on c1.cod_cliente = co.cod_cliente 
								where 		co.cod_empresa = c.cod_empresa
								and 		co.cod_cliente = c.cod_cliente
								and 		co.cod_comanda = c.cod_comanda
								) as TotalGeral
					from 		comanda c
					inner join 	clientes c1 on c1.cod_cliente = c.cod_cliente
					where 		c.cod_empresa = ".$cod_empresa."
					and 		c.situacao = 2
					";
					//echo $sql;
					if (isset($_REQUEST['acao'])){

						if ($_REQUEST['acao'] == "buscar"){
						
							if ($_REQUEST['cod_cliente'] != ""){
								$sql = $sql . " and c1.cod_cliente = ".$_REQUEST['cod_cliente']." ";
							}

							if (isset($_REQUEST['dt_inicial']) && ($_REQUEST['dt_inicial'] != ""))
							{
								$sql = $sql . " and c.dt_inclusao >= '".DataPhpMysql($_REQUEST['dt_inicial'])." 00:00:00'";
							}

							if (isset($_REQUEST['dt_final']) && ($_REQUEST['dt_final'] != ""))
							{
								$sql = $sql . " and c.dt_inclusao <= '".DataPhpMysql($_REQUEST['dt_final'])." 23:59:59'";
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
                            <th style="width:10%;">Data da Venda</th>
                            <th style="width:40%;">Cliente</th>
							<th style="width:10%;">Valor Total</th>
							<th style="width:5%;">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>

					<?php

					if ($registros > 0) {
						while (($rs = mysql_fetch_array($query)) && ($contador<$final)){ 
							$contador = $contador + 1; //Contador
							if ($contador>$inicio) { //Condiçao para mostrar somente os registros maiores
						?>
                        <tr>
                            <td align="left"><?php echo $rs['data_venda'];?></td>
                            <td align="left"><?php echo $rs['nome'];?></td>
							<td align="left"><?php echo ValorMysqlPhp($rs['TotalGeral']); ?></td>
                            <td align='center'>
								<a class="btn btn-info btn-label" href="comanda_historico_vendas_detalhes.php?cod_comanda=<?php echo $rs['cod_comanda'];?>&cod_cliente=<?php echo $rs['cod_cliente']; ?>"><i class="fa fa-eye"></i>Detalhes</a>
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

			</div> <!-- .container-fluid -->
			
<?php
 } // VER 
	
include('../include/rodape_interno.php');
?>

<script type="text/javascript">
	$(document).ready(function() {
	  $(":input[data-inputmask-mask]").inputmask();
	  $(":input[data-inputmask-alias]").inputmask();
	  $(":input[data-inputmask-regex]").inputmask("Regex");
	});
</script>