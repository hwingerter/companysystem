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
		if ($credenciais[$x] == "empresa_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "empresa_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "empresa_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "empresa_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}
	
if ($credencial_ver == '1') { //VERIFICA SE USU�RIO POSSUI ACESSO A ESSA �REA
	
	if (isset($_REQUEST['sucesso'])) { $sucesso = $_REQUEST['sucesso']; } else { $sucesso = ''; }
	if (isset($_REQUEST['pergunta'])) { $pergunta = $_REQUEST['pergunta']; } else { $pergunta = ''; }
	if (isset($_REQUEST['excluir'])) { $excluir = $_REQUEST['excluir']; } else { $excluir = ''; }
	
	//EXCLUSAO DE EMPRESA
	if ($excluir != '') 
	{
		$sql = "delete from usuarios_grupos_empresas where cod_empresa = ". $excluir;
		mysql_query($sql);

		$sql = "delete from grupo_empresas where cod_empresa = ". $excluir;
		mysql_query($sql);

		$sql = "delete from empresas where cod_empresa = ". $excluir;
		mysql_query($sql);
		
		$excluir = '1';
	}
	
	//FUN��O QUE RETORNA O TOTAL DE PAGINAS E QUANTIDADE DE REGISTRO POR PAGINAS
	$sql = "Select COUNT(cod_empresa) as total from empresas  ";
	if (isset($_REQUEST['acao'])){
		if ($_REQUEST['acao'] == "buscar"){
			if ($_REQUEST['nome'] != ""){
				$sql = $sql . " where empresa like '%".$_REQUEST['nome']."%' ";
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
	

	$cod_usuario	= $_SESSION['usuario_id'];
	$cod_grupo		= $_SESSION['cod_grupo'];
	$cod_empresa	= $_SESSION['cod_empresa'];

?>

<div class="static-content-wrapper">

<div class="page-content">
	<ol class="breadcrumb">                               
								<li><a href="#">Principal</a></li>
								<li class="active"><a href="empresas.php">Empresas</a></li>
                            </ol>

						<div class="page-heading">            
							<h1>Empresas</h1>
							<div class="options">
							<?php 
							if ($credencial_incluir == '1') {
							?>
							<a class="btn btn-midnightblue btn-label" href="empresa_info.php"><i class="fa fa-plus-circle"></i> Novo</a>
							<?php
							}
							?>	
							</div>
						</div>

	<div class="container-fluid">
							
		<form name="form1" method="post">
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
				<br><a class="btn btn-success" href="empresas.php?excluir=<?php echo $pergunta;?>">Sim</a>&nbsp;&nbsp;&nbsp; <a class="btn btn-danger" href="empresas.php">Não</a>
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

		</form>

		<form action="empresas.php" class="form-horizontal row-border" name='frm' method="post">

				<input type='hidden' name='acao' value='buscar'>

				<div class="row">

					<div class="panel panel-sky">
						<div class="panel-heading">
							<h2>Filtros</h2>
						</div>
						<div class="panel-body">

							<div class="row">
								<div class="form-group">
									<label class="col-sm-1 control-label"><b>Empresa</b></label>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="nome" maxlength="100" value="<?php if (isset($_REQUEST['nome'])){ if ($_REQUEST['nome'] != ""){ echo $_REQUEST['nome']; } }?>">
									</div>
								</div>
								
								<div class="form-group">
									<br><label class="col-sm-1 control-label"><b>Situação</b></label>
									<div class="col-sm-4">
										
									<select name="situacao" id="situacao" class="form-control">

										<option value="A" <?php if (isset($_REQUEST['situacao'])){ if ($_REQUEST['situacao'] == "A"){ echo " selected "; } }?> > Ativa </option>
										<option value="I" <?php if (isset($_REQUEST['situacao'])){ if ($_REQUEST['situacao'] == "I"){ echo " selected "; } }?> > Bloqueada </option>

									</select>
									
									<br><button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Buscar</button>

									</div>
								</div>							
							</div>
						</div>	
					</div>


					<div class="panel panel-sky">
						<div class="panel-heading">
							<h2>Listagem das Empresas</h2>
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
							select		e.cod_empresa, e.empresa, e.telefone, e.situacao, date_format(e.dt_cadastro, '%d/%m/%Y') as dt_cadastro
							from 		empresas e
							";

							if (isset($_REQUEST['acao'])){
							if ($_REQUEST['acao'] == "buscar"){

								if ($_REQUEST['nome'] != ""){
									$sql = $sql . "where  e.empresa like '%".$_REQUEST['nome']."%' ";
									$where = 1;
								}else{
									$where = 0;
								}

								if ($_REQUEST['situacao'] != ""){
									if($where == 0){
										$sql = $sql . "where  e.situacao = '".$_REQUEST['situacao']."' ";
									}else{
										$sql = $sql . "and  e.situacao = '".$_REQUEST['situacao']."' ";
									}
								}
							}
							}
							$sql .= "
							group by	e.cod_empresa, e.empresa
							order by cod_empresa asc";
							//echo $sql;
							$query = mysql_query($sql);
							$registros = mysql_num_rows($query);

							?>

								<table class="table" border="1" bordercolor="#EEEEEE">
									<thead>
										<tr>
											<th width="300">Empresa</th>
											<th width="150">Telefone</th>
											<th width="150">Situação no Sistema</th>
											<th width="150">Data de Cadastro</th>
											<th width="300">Opções</th>
										</tr>
									</thead>
									<tbody>
									
									<?php
									if ($registros > 0) {

										while (($rs = mysql_fetch_array($query)) && ($contador<$final)){ 
											$contador = $contador + 1; //Contador
											if ($contador>$inicio) { //Condi�ao para mostrar somente os registros maiores
												
												$dt_cadastro = $rs['dt_cadastro'];

												$situacao = "";
												if($rs['situacao'] == "A"){
													$situacao = '<label class="label label-success">Ativa</label>';
												}elseif($rs['situacao'] == "I"){
													$situacao = '<label class="label label-danger">Bloqueada</label>';
												}
										?>
										<tr>
											<td align="left"><?php echo $rs['empresa']; ?></td>
											<td align="left"><?php echo $rs['telefone'];?></td>
											<td align="left"><?php echo $situacao; ?></td>
											<td align="left"><?php echo $dt_cadastro; ?></td>
											<td align='center'>
											<?php 
											if ($credencial_editar == '1') {
											?>							
												<a class="btn btn-success btn-label" href="empresa_info.php?acao=alterar&id=<?php echo $rs['cod_empresa'];?>"><i class="fa fa-edit"></i> Editar</a>&nbsp;
											<?php 
											}
											if ($credencial_excluir != '1') {
											?>
												<a class="btn btn-danger btn-label" href="empresas.php?pergunta=<?php echo $rs['cod_empresa'];?>"><i class="fa fa-times-circle"></i> Excluir</a>
											<?php
											}
											?>	
												<a class="btn btn-info btn-label" href="empresa_ver.php?id=<?php echo $rs['cod_empresa'];?>"><i class="fa fa-eye"></i> Ver</a>

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
</div>
</form>
                            </div> <!-- .container-fluid -->

<?php
 } // VER 
	
 require_once "../include/rodape_interno2.php";

?>