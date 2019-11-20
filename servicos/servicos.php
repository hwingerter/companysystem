<?php 

	require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";
	
	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	$credencial_ver = 0;
	$credencial_incluir = 0;
	$credencial_editar = 0;
	$credencial_excluir = 0;
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "servico_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "servico_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "servico_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "servico_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}
	
if ($credencial_ver == '1') { //VERIFICA SE USU�RIO POSSUI ACESSO A ESSA �REA
	
	if (isset($_REQUEST['sucesso'])) { $sucesso = $_REQUEST['sucesso']; } else { $sucesso = ''; }
	if (isset($_REQUEST['pergunta'])) { $pergunta = $_REQUEST['pergunta']; } else { $pergunta = ''; }
	if (isset($_REQUEST['excluir'])) { $excluir = $_REQUEST['excluir']; } else { $excluir = ''; }
	
	if ($excluir != '') {
		$sql = "delete from servico where cod_servico = ". $excluir;
		mysql_query($sql);
		
		$excluir = '1';
	}
	

	$cod_empresa = $_SESSION['cod_empresa'];


	//FUN��O QUE RETORNA O TOTAL DE PAGINAS E QUANTIDADE DE REGISTRO POR PAGINAS
	$sql = "Select COUNT(*) as total from servico
	where cod_empresa = ".$cod_empresa."
	";
	if (isset($_REQUEST['acao'])){
		if ($_REQUEST['acao'] == "buscar"){
			if ($_REQUEST['nome'] != ""){
				$sql = $sql . " and nome like '%".$_REQUEST['nome']."%' ";
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
	$resto = $totalregistro % $registrosPagina; // Pega o resto da divis�o
	$paginas = intval($paginas); // Converte o resultado para inteiro
	if ($resto > 0) { $paginas = $paginas + 1; } // Se o resto maior do que 0, soma a var paginas para a pagina��o ficar correta
	
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

<div class="static-content-wrapper">
	<div class="static-content">
		<div class="page-content">
			<ol class="breadcrumb">
				<li><a href="#">Principal</a></li>
				<li class="active"><a href="servicos.php">Serviços</a></li>
			</ol>
							
		    <div class="page-heading">            
				<h1>Serviços</h1>
		        <div class="options">
			  	  <?php 
				  if ($credencial_incluir == '1') {
				  ?>
					<a class="btn btn-midnightblue btn-label" href="servico_info.php"><i class="fa fa-plus-circle"></i> Novo</a>
				  <?php
				  }
				  ?>	
				</div>
			</div>

            <div class="container-fluid">

				<script language="JavaScript">
					function paginacao () {
				  		document.forms[0].action = "servicos.php";
					  	document.forms[0].submit();
					}
				</script>
				

				<?php
				if ($sucesso == '1') {
				?>
				<div class="alert alert-dismissable alert-success">
					<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Dados gravados com sucesso!</strong>
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
				}
				
				if ($pergunta != '') {
				?>
				<div class="alert alert-dismissable alert-info">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<strong>Deseja realmente excluir o código número <?php echo $pergunta; ?> ?</strong><br>
					<br><a class="btn btn-success" href="servicos.php?excluir=<?php echo $pergunta;?>">Sim</a>&nbsp;&nbsp;&nbsp; <a class="btn btn-danger" href="servicos.php">Não</a>
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


				<form action="servicos.php" class="form-horizontal row-border" name='frm' method="post">
				
					<input type='hidden' name='acao' value='buscar'>

					<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-sky">
								<div class="panel-heading">
									<h2>Filtros</h2>
								</div>
								<div class="panel-body">
									<div class="form-group">
										<label class="col-sm-2 control-label"><b>Serviços</b></label>
										<div class="col-sm-8">
											<input type="text" class="form-control" name="nome" maxlength="100" value="<?php if (isset($_REQUEST['nome'])){ if ($_REQUEST['nome'] != ""){ echo $_REQUEST['nome']; } }?>">
										</div>
									</div>
									<div class="panel-footer">
										<div class="row">
											<div class="col-sm-8 col-sm-offset-2">
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
	                <h2>Listagem dos Serviços</h2>
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
                <table class="table" border="1" bordercolor="#EEEEEE">
                    <thead>
                        <tr>
                            <th width="10">CÓDIGO</th>
							<th width="100">Serviço</th>
							<th width="100">Tipo de Serviço</th>
							<th width="60">Custo Produtos</th>
							<th width="60">Preço Venda</th>
							<th width="50">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
				    <?php
						//CARREGA LISTA
					$sql = "
					select 		s.cod_servico, s.nome, ts.descricao as tipo_servico, s.custo_produtos, s.preco_venda, s.desconto_maximo, s.desconto_promocional
								,s.duracao_aproximada, s.cod_tipo_comissao, s.comissao_percentual, s.comissao_fixa
								,case when s.descontar_custo_produtos = 1 then 'Sim' else 'Nao' end as DescontaCursoProduto
					from 		servico s
					left join 	categoria c on c.cod_categoria = s.cod_categoria
					left join 	tipo_servico ts on ts.cod_tipo_servico = s.cod_tipo_servico
					left join	tipo_comissao tc on tc.cod_tipo_comissao = s.cod_tipo_comissao
					where 		s.cod_empresa = ".$cod_empresa."
					";

					if (isset($_REQUEST['acao'])){
						if ($_REQUEST['acao'] == "buscar"){
							if ($_REQUEST['nome'] != ""){
								$sql = $sql . " and s.nome like '%".$_REQUEST['nome']."%' ";
							}
						}
					}
					$sql .= "
					order by	s.nome; 
					";
					$query = mysql_query($sql);

					$registros = mysql_num_rows($query);

				if ($registros > 0) {

					while (($rs = mysql_fetch_array($query)) && ($contador<$final)){ 
						$contador = $contador + 1; //Contador
				    	if ($contador>$inicio) { //Condi�ao para mostrar somente os registros maiores

				    		$comissao = "";

				    		if ($rs['cod_tipo_comissao'] == "1"){

				    			if(!is_null($rs['comissao_percentual']))
				    				$comissao = $rs['comissao_percentual']." %";

				    		}elseif ($rs['cod_tipo_comissao'] == "2"){

								if(!is_null($rs['comissao_fixa']))
					    			$comissao = "R$ ".number_format($rs['comissao_fixa'], 2, ',', '.');

				    		}



					?>
	            <tr>
	                <td align="left"><?php echo $rs['cod_servico'];?></td>
					<td align="left"><?php echo $rs['nome']; ?></td>
					<td align="left"><?php echo $rs['tipo_servico'];?></td>
					<td align="left"><?php echo ValorMysqlPhp($rs['custo_produtos']);?></td>
					<td align="left"><?php echo ValorMysqlPhp($rs['preco_venda']);?></td>
	                <td align='center'>
			  	  <?php 
				  if ($credencial_editar == '1') {
				  ?>							
					<a class="btn btn-success btn-label" href="servico_info.php?acao=alterar&id=<?php echo $rs['cod_servico'];?>"><i class="fa fa-edit"></i> Editar</a>&nbsp;
			  	  <?php 
				  }
				  if ($credencial_excluir == '1') {
				  ?>
					<a class="btn btn-danger btn-label" href="servicos.php?pergunta=<?php echo $rs['cod_servico'];?>"><i class="fa fa-times-circle"></i> Excluir</a>
				  <?php
				  }
				  ?>	
					<a class="btn btn-info btn-label" href="servico_ver.php?id=<?php echo $rs['cod_servico'];?>"><i class="fa fa-eye"></i> Ver</a>

					<a class="btn btn-default btn-label" href="servico_habilitados.php?id=<?php echo $rs['cod_servico'];?>"><i class="fa fa-eye"></i> Habilitados</a>
					</td>
	            </tr>
			    <?php
						} // Contador
					} // while
				?>
                <tr>
                    <td align="right" colspan="11"><b>Total de registro: <?php echo $totalregistro; ?></b></td>
                </tr>
				<?php
					} else { // registro
					?>
	                    <tr>
	                        <td align="center" colspan="11">Não tem nenhum registro!</td>
	                    </tr>
					<?php
						}
					?>		
				</tbody>
                
                </table>

            </div>
                            </div> <!-- .container-fluid -->
                        </div> <!-- #page-content -->
                    </div>

<?php
 } // VER 
	
	include('../include/rodape_interno2.php');

?>