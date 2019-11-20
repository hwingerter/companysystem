<?php 

require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";
	
	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	if ($_SESSION['usuario_conta'] == '1') {
		
		$credencial_ver = 1;
		$credencial_incluir = 1;
		$credencial_editar = 1;
		$credencial_excluir = 1;
		
	}
	
	/*
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "usuario_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "usuario_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "usuario_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "usuario_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}

	*/
	
if ($credencial_ver == '1') { //VERIFICA SE USU�RIO POSSUI ACESSO A ESSA �REA
	
	if (isset($_REQUEST['sucesso'])) { $sucesso = $_REQUEST['sucesso']; } else { $sucesso = ''; }
	if (isset($_REQUEST['pergunta'])) { $pergunta = $_REQUEST['pergunta']; } else { $pergunta = ''; }
	if (isset($_REQUEST['excluir'])) { $excluir = $_REQUEST['excluir']; } else { $excluir = ''; }
	
	if ($excluir != '') {
	
		//apagar usuario
		$sql = "
		delete 		u
		from		grupos g
		inner join 	usuarios u on u.cod_grupo = g.cod_grupo
		where 		g.cod_grupo = ".$excluir.";
		";
		mysql_query($sql);

		//apagar credencial do tipo_conta
		$sql = "
		delete 		tcc
		from		grupos g
		inner join	tipo_conta e on e.cod_grupo = g.cod_grupo
		inner join 	tipo_conta_credencial tcc on tcc.cod_tipo_conta = e.cod_tipo_conta
		where 		g.cod_grupo = ".$excluir.";
		";
		mysql_query($sql);

		//apagar tipo_conta
		$sql = "
		delete		tc
		from		grupos g
		inner join	tipo_conta tc on tc.cod_grupo = g.cod_grupo
		where 		g.cod_grupo = ".$excluir.";
		";
		mysql_query($sql);

		//apagar empresas a empresa
		$sql = "
		delete		e
		from		grupos g
		inner join 	grupo_empresas ge on ge.cod_grupo = g.cod_grupo
		inner join	empresas e on e.cod_empresa = ge.cod_empresa
		where 		g.cod_grupo = ".$excluir.";
		";
		mysql_query($sql);


		//apagar os grupos de empresa
		$sql = "
		delete		ge
		from		grupos g
		inner join 	grupo_empresas ge on ge.cod_grupo = g.cod_grupo
		where 		g.cod_grupo = ".$excluir.";
		";
		mysql_query($sql);


		//apagar o grupo
		$sql = "
		delete
		from		grupos
		where 		cod_grupo = ". $excluir;
		mysql_query($sql);
	

		$excluir = '1';
	}
	
	//FUN��O QUE RETORNA O TOTAL DE PAGINAS E QUANTIDADE DE REGISTRO POR PAGINAS
	
	$sql = "Select COUNT(8) as total from grupos ";
	if (isset($_REQUEST['acao'])){
		if ($_REQUEST['acao'] == "buscar"){
			if ($_REQUEST['nome'] != ""){
				$sql = $sql . " where nome like '%".$_REQUEST['nome']."%' ";
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

<div class="page-content">
	<ol class="breadcrumb">
		<li><a href="#">Principal</a></li>
		<li class="active"><a href="grupos.php">Grupos</a></li>
	</ol>							
	<div class="page-heading">            
		<h1>Grupos de Empresas</h1>
		<div class="options">
		<?php 
		if ($credencial_incluir == '1') {
		?>
		<a class="btn btn-midnightblue btn-label" href="grupo_info.php"><i class="fa fa-plus-circle"></i> Novo</a>
		<?php
		}
		?>	
		</div>
	</div>

	<div class="container-fluid">

		<script language="JavaScript">
			function paginacao () {
				document.forms[0].action = "grupos.php";
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
			<br><a class="btn btn-success" href="grupos.php?excluir=<?php echo $pergunta;?>">Sim</a>&nbsp;&nbsp;&nbsp; <a class="btn btn-danger" href="grupos.php">Não</a>
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

		<form action="grupos.php" class="form-horizontal row-border" name='frm' method="post">

			<input type='hidden' name='acao' value='buscar'>

			<div class="row">
				<div class="col-sm-12">

				<div class="panel panel-sky">
					<div class="panel-heading">
						<h2>Buscar</h2>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label class="col-sm-1 col-xs-4 control-label"><b>Empresa</b></label>
							<div class="col-sm-6 col-xs-12 col-lg-8" style="padding-bottom:5px;">
								<input type="text" class="form-control" name="nome" maxlength="100" value="<?php if (isset($_REQUEST['nome'])){ if ($_REQUEST['nome'] != ""){ echo $_REQUEST['nome']; } }?>">
							</div>
							<div class="col-sm-4 col-xs-12 col-lg-2">
								<button class="btn-primary btn " onclick="javascript:document.forms['frm'].submit();">Buscar</button>
							</div>
						</div>
					</div>
				</div>	

				<div class="panel panel-sky">
					<div class="panel-heading">
						<h2>Listagem de Grupos de Empresa</h2>
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
										<th width="10">Codigo</th>
										<th width="200">Nome</th>
										<th width="100">Status</th>
										<th width="250">Opções</th>
									</tr>
								</thead>
								<tbody>

								<?php
									//CARREGA LISTA
								$sql = "select * from grupos ";
								if (isset($_REQUEST['acao'])){
									if ($_REQUEST['acao'] == "buscar"){
										if ($_REQUEST['nome'] != ""){
											$sql = $sql . " where nome like '%".$_REQUEST['nome']."%' ";
										}
									}
								}
								$sql .= "order by nome asc";
								
								$query = mysql_query($sql);

								$registros = mysql_num_rows($query);

								if ($registros > 0) {
									while (($rs = mysql_fetch_array($query)) && ($contador<$final)){ 
										$contador = $contador + 1; //Contador
										if ($contador>$inicio) { //Condi�ao para mostrar somente os registros maiores
									?>
													<tr>
														<td align="left"><?php echo $rs['cod_grupo'];?></td>
														<td align="left"><?php echo $rs['nome'];?></td>
														<td align="left">
														<?php 
														if ($rs['status'] == 'A') {
															echo "Ativo";
														} else if ($rs['status'] == 'I') {
															echo "Inativo";
														}
														?>
														</td>
														<td align='center'>
													<?php 
													if ($credencial_editar == '1') {
													?>							
														<a class="btn btn-success btn-label" href="grupo_info.php?acao=alterar&id=<?php echo $rs['cod_grupo'];?>"><i class="fa fa-edit"></i> Editar</a>&nbsp;
													<?php 
													}
													if ($credencial_excluir == '1') {
													?>
														<a class="btn btn-danger btn-label" href="grupos.php?pergunta=<?php echo $rs['cod_grupo'];?>"><i class="fa fa-times-circle"></i> Excluir</a>
													<?php
													}
													?>	
														<a class="btn btn-info btn-label" href="grupo_ver.php?id=<?php echo $rs['cod_grupo'];?>"><i class="fa fa-eye"></i> Ver</a>

														<a class="btn btn-success btn-label" href="grupo_vincular.php?id=<?php echo $rs['cod_grupo'];?>"><i class="fa fa-bank"></i>Empresas</a>

														</td>
													</tr>
								<?php
										} // Contador
									} // while
								?>
													<tr>
														<td align="right" colspan="7"><b>Total de registro: <?php echo $registros; ?></b></td>
													</tr>
							<?php
								} else { // registro
								?>
													<tr>
														<td align="center" colspan="7">Não tem nenhum registro!</td>
													</tr>
							<?php
								}
							?>		
								</tbody>
							</table>
						</div>

					</div>

				</div>
			</div>
		</form>
		
		</div> <!-- .container-fluid -->



<?php
 } // VER 
	
 include('../include/rodape_interno2.php');
?>