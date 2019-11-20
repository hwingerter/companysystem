<?php 

	require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";
	
	//*********** VERIFICA CREDENCIAIS DE USUÃRIOS *************
	//if ($_SESSION['usuario_conta'] == '1') {
		
		$credencial_ver = 1;
		$credencial_incluir = 1;
		$credencial_editar = 1;
		$credencial_excluir = 1;
		
	//}
	
	
if ($credencial_ver == '1') { //VERIFICA SE USUÁRIO POSSUI ACESSO A ESSA ÁREA
	
	$cod_empresa = $_SESSION['cod_empresa'];

	if (isset($_REQUEST['sucesso'])) { $sucesso = $_REQUEST['sucesso']; } else { $sucesso = ''; }
	if (isset($_REQUEST['pergunta'])) { $pergunta = $_REQUEST['pergunta']; } else { $pergunta = ''; }
	if (isset($_REQUEST['excluir'])) { $excluir = $_REQUEST['excluir']; } else { $excluir = ''; }
	
	if ($excluir != '') {

		$sql = "select case when count(*) > 0 then 'sim' else 'nao' end as TemEmpresa from usuarios_grupos_empresas where cod_usuario = ".$excluir."";

		$query = mysql_query($sql);
		$rs = mysql_fetch_array($query);

		if ($rs['TemEmpresa'] == "nao") {

			$sql = "delete from usuarios where cod_usuario = ". $excluir;

			mysql_query($sql);	

			echo "<script language='javascript'>window.location='adm_usuarios.php?sucesso=3';</script>";

		}else{
			echo '<script language="javascript">
					window.location="adm_usuarios.php?sucesso=4";
					</script>
				 ';

			die;
		}


	}
	
	//FUNÃ‡ÃƒO QUE RETORNA O TOTAL DE PAGINAS E QUANTIDADE DE REGISTRO POR PAGINAS
	$sql = "Select COUNT(U.cod_usuario) as total from usuarios U, tipo_conta TP where TP.cod_tipo_conta = U.tipo_conta ";
	if (isset($_REQUEST['acao'])){
		if ($_REQUEST['acao'] == "buscar"){
			if ($_REQUEST['nome'] != ""){
				$sql = $sql . " and U.nome like '%".$_REQUEST['nome']."%' ";
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
	if ($resto > 0) { $paginas = $paginas + 1; } // Se o resto maior do que 0, soma a var paginas para a paginaÃ§Ã£o ficar correta
	
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
	
?>

<div class="page-content">

	<ol class="breadcrumb">                   
		<li><a href="#">Principal</a></li>
		<li class="active"><a href="estoque_atual.php">Estoque Atual</a></li>
	</ol>
						
    <div class="page-heading">            
        <h1>Estoque Atual</h1>
    </div>

	<script language="JavaScript">
		function paginacao () {
	  		document.forms[0].action = "usuarios.php";
		  	document.forms[0].submit();
		}
	</script>

	 <div class="container-fluid">						
								
		<?php
		if ($sucesso == '1') {
		?>
		<div class="alert alert-dismissable alert-success">
			<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Dados gravados 	com sucesso!</strong>
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
			<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Dados excluídos com sucesso!</strong>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		</div>				
		<?php
		} else if ($sucesso == '4') {
		?>
		<div class="alert alert-dismissable alert-danger">
			<i class="fa fa-fw fa-check"></i>&nbsp; 
			<strong>Erro na exclusão do registro!</strong><br>
			<p>Para excluir este usuário, tente deletar as empresas relacionadas.</p>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		</div>				
		<?php
		}
		
		if ($pergunta != '') {
		?>
		<div class="alert alert-dismissable alert-info">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<strong>Deseja realmente excluir o código número <?php echo $pergunta; ?> ?</strong><br>
			<br><a class="btn btn-success" href="adm_usuarios.php?excluir=<?php echo $pergunta;?>">Sim</a>&nbsp;&nbsp;&nbsp; <a class="btn btn-danger" href="adm_usuarios.php">Não</a>
		</div>				
		<?php
		}
		
		if ($excluir != '') {
		?>
		<div class="alert alert-dismissable alert-danger">
			<i class="fa fa-fw fa-times"></i>&nbsp; <strong>Registro excluido com sucesso!</strong>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		</div>				
		<?php
		}
		?>


		<form action="estoque_atual.php" class="form-horizontal row-border" name='frm' method="post">
		
			<input type='hidden' name='acao' value='buscar'>
								
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-sky">
						<div class="panel-heading">
							<h2>Filtros</h2>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="form-group">
									<div class="col-sm-1">
										<label class="control-label"><b>Produto</b></label>
									</div>
									<div class="col-md-4">

										<?php 
										$sql = "select cod_produto, descricao from produtos where cod_empresa = ".$cod_empresa." order by descricao asc; ";

										$query = mysql_query($sql);

										?>

										<select name='cod_produto' class="form-control">
											
											<option value="">Selecione...</option>

											<?php 

											while ($rs = mysql_fetch_array($query)){

											 ?>
											<option value="<?php echo $rs['cod_produto']; ?>"

												<?php if($_REQUEST['cod_produto'] == $rs['cod_produto']) echo " selected "; ?>
												><?php echo $rs['descricao']; ?></option>

											<?php
											}
											?>
										</select>

									</div>
									<div class="col-sm-2">
										<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Buscar</button>
									</div>										
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</form>


			<?php 
				//CARREGA LISTA
			$sql = "
			select		p.cod_produto, p.descricao
						
						,((select sum(e1.quantidade) from estoque e1 where e1.cod_produto=p.cod_produto and e1.cod_tipo_movimentacao in (1,2,3))
			                -
			                (select sum(e1.quantidade) from estoque e1 where e1.cod_produto=p.cod_produto and e1.cod_tipo_movimentacao in (4,5,6,7))
						 ) as quantidade

			            ,(select sum(e1.custo_medio_compra) from estoque e1 where e1.cod_produto=p.cod_produto) as CustoUnitarioMedio

			from 		produtos p
			where 		p.cod_empresa = ".$cod_empresa."
			";
			if (isset($_REQUEST['acao'])){
				if ($_REQUEST['acao'] == "buscar"){

					$where = 0;

					if ($_REQUEST['nome'] != ""){
						$sql = $sql . " where u.nome like '%".$_REQUEST['nome']."%' ";
						$where = 1;
					}
					if ($_REQUEST['buscar_grupo'] != ""){

						if ($where == 1)
						{
							$sql = $sql . " and g.cod_grupo = '".$_REQUEST['buscar_grupo']."' ";

						}else
						{
							$sql = $sql . " where g.cod_grupo = '".$_REQUEST['buscar_grupo']."' ";
						}

						
					}
				}
			}
			$sql .= " order by	p.descricao asc ";

			//echo $sql;

			$query = mysql_query($sql);

			$registros = mysql_num_rows($query);

			?>

				<div class="panel panel-sky">

					<div class="panel-heading">
						<h2></h2>
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
						    <table class="table" border="1" bordercolor="#EEEEEE" style="width:100%;">
						        <thead>
						            <tr>
										<th width="300">Produto</th>
										<th width="50">Qtd</th>
										<th width="20">Custo Unitário Médio</th>
										<th width="20">Custo Total</th>
										<th width="100">&nbsp;</th>
						            </tr>
						        </thead>
						        <tbody>
						        <?php 
									if ($registros > 0) {

										while (($rs = mysql_fetch_array($query)) && ($contador<$final)){ 

								    		if(($rs["cod_tipo_movimentacao"] >= 4) && ($rs["cod_tipo_movimentacao"] <= 7))
								    		{
								    			$quantidade = "-".$rs['quantidade'];
								    		}else{
								    			$quantidade = $rs['quantidade'];	
								    		}

								    		$custo_total = number_format(($rs['CustoUnitarioMedio'] * $quantidade), 2);


											$contador = $contador + 1; //Contador

									    	if ($contador>$inicio) {?>
						                        <tr>
													<td align="left"><?php echo $rs['descricao'];?></td>
													<td align="left"><?php echo $rs['quantidade'];?></td>
													<td align="left"><?php echo ValorMysqlPhp($rs['CustoUnitarioMedio']);?></td>
													<td align="left"><?php echo ValorMysqlPhp($custo_total);?></td>
						                            <td align='center'>
												  	  <a class="btn btn-success btn-label" href="extrato_estoque.php?cod_produto=<?php echo $rs['cod_produto'];?>"><i class="fa fa-edit"></i>Extrato</a>
												  	  <a class="btn btn-default btn-label" href="ajuste_saldo.php?cod_produto=<?php echo $rs['cod_produto'];?>"><i class="fa fa-edit"></i>Ajuste</a>
														
													</td>
						                        </tr>
								    		<?php
								    		}
										} // while
									?>
			                        <tr>
			                            <td align="right" colspan="7"><b>Total de registro: <?php echo $registros; ?></b></td>
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

								<tr style="text-align: center;">
									<td colspan="5">
										<a class="btn btn-success btn-label" href="lancar_compra.php"><i class="fa fa-edit"></i>Lançar Compra</a>
									</td>
								</tr>

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>


	
<?php
 } // VER 
	
include('../include/rodape_interno2.php')
?>