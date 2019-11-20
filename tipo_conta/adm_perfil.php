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
	
	
if ($credencial_ver == '1') { //VERIFICA SE USU�RIO POSSUI ACESSO A ESSA �REA
	
	if (isset($_REQUEST['sucesso'])) { $sucesso = $_REQUEST['sucesso']; } else { $sucesso = ''; }
	if (isset($_REQUEST['pergunta'])) { $pergunta = $_REQUEST['pergunta']; } else { $pergunta = ''; }
	if (isset($_REQUEST['excluir'])) { $excluir = $_REQUEST['excluir']; } else { $excluir = ''; }
	
	if ($excluir != '') {
		$sql = "delete from tipo_conta where cod_tipo_conta = ". $excluir;
		if ($excluir != 1) { mysql_query($sql); }
		
		$excluir = '1';
	}
	
	//FUN��O QUE RETORNA O TOTAL DE PAGINAS E QUANTIDADE DE REGISTRO POR PAGINAS
	$sql = "Select COUNT(cod_tipo_conta) as total from tipo_conta ";
	if (isset($_REQUEST['acao'])){
		if ($_REQUEST['acao'] == "buscar"){
			if ($_REQUEST['nome'] != ""){
				$sql = $sql . " where descricao like '%".$_REQUEST['nome']."%' ";
			}
			if ($_REQUEST['nome'] != ""){
				$sql = $sql . " and cod_grupo like '%".$_REQUEST['buscar_grupo']."%' ";
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
	
   $voltar = "adm_perfil.php";

?>
                <div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
								<li><a href="#">Principal</a></li>
								<li class="active"><a href="adm_perfil.php">Tipo de Conta</a></li>

                            </ol>
							
                            <div class="page-heading">            
                                <h1>Tipo de Conta</h1>
                                <div class="options">
						  	  <?php 
							  if ($credencial_incluir == '1') {
							  ?>								
								<a class="btn btn-default btn-label" href="adm_perfil_info.php"><i class="fa fa-plus-circle"></i> Novo</a>
							  <?php
							  }
							  ?>								
								</div>
                            </div>
                            <div class="container-fluid">
								<script language="JavaScript">
									function paginacao () {
								  		document.forms[0].action = "adm_tipo_conta.php";
									  	document.forms[0].submit();
									}
								</script>
							
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
					<strong>Deseja realmente excluir o Tipo de Conta <?php echo $_REQUEST['descricao']; ?> ?</strong><br>
					<br><a class="btn btn-success" href="adm_perfil.php?excluir=<?php echo $pergunta;?>">Sim</a>&nbsp;&nbsp;&nbsp; <a class="btn btn-danger" href="adm_perfil.php">Não</a>
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

				<form action="adm_perfil.php" class="form-horizontal row-border" name='frm' method="post">
				
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
					<label class="col-sm-2 control-label"><b>Tipo de Conta</b></label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="nome" maxlength="100" value="<?php if (isset($_REQUEST['nome'])){ if ($_REQUEST['nome'] != ""){ echo $_REQUEST['nome']; } }?>">
					</div>
				</div>
				
				<div class="form-group">
					<br><label class="col-sm-2 control-label"><b>Empresa</b></label>
					<div class="col-sm-6">
						
						<?php 
						$sql = "select cod_empresa, empresa from empresas order by empresa asc; ";

						$query = mysql_query($sql);

						?>

						<select name='buscar_empresa' class="form-control">
							
							<option value="">Selecione...</option>

							<?php 

							while ($rs = mysql_fetch_array($query)){

							 ?>
							<option value="<?php echo $rs['cod_empresa']; ?>"><?php echo $rs['empresa']; ?></option>

							<?php
							}
							?>
						</select>

					</div>
				</div>
								
				<div class="form-group">
						<br><button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Buscar</button>
				</div>												
			</div>

			<div class="row">
				<div class="col-sm-8 col-sm-offset-2">
					
				</div>
			</div>

		</div>
	</div>

			        <div class="panel panel-sky">
			            <div class="panel-heading">
			                <h2>Listagem de Tipos de Contas</h2>
							<p align='right'>
							<select name='pagina' class="form-control" style="width: 60px; margin-top: 5px;" onChange="javascript:paginacao();">
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
			                <table class="table" border="1" bordercolor="#EEEEEE" style="width: 100%;">
			                    <thead>
			                        <tr>
										<th width="300">Empresa</th>
										<th width="300">Tipo de Conta</th>
										<th width="300">Opções</th>
			                        </tr>
			                    </thead>
			                    <tbody>
								<?php
								//CARREGA LISTA
								$sql = "
									select 		t.*, g.empresa
									from 		tipo_conta t
									left join 	empresas g on g.cod_empresa = t.cod_empresa
								";

								if (isset($_REQUEST['acao'])){

									if ($_REQUEST['acao'] == "buscar"){

										if ($_REQUEST['nome'] != ""){
											$sql = $sql . " where t.descricao like '%".$_REQUEST['nome']."%' ";
										}
										if ($_REQUEST['buscar_empresa'] != ""){
											$sql = $sql . " where g.cod_empresa = '".$_REQUEST['buscar_empresa']."' ";
										}
									}

								}
								$sql .= "order by g.empresa, t.descricao asc";

								$query = mysql_query($sql);
								$registros = mysql_num_rows($query);
								if ($registros > 0) {
								while (($rs = mysql_fetch_array($query)) && ($contador<$final)){ 
								$contador = $contador + 1; //Contador
								if ($contador>$inicio) { //Condi�ao para mostrar somente os registros maiores
								?>
                        <tr>
							<td align="left"><?php echo $rs['empresa'];?></td>
                        	<td align="left"><?php echo $rs['descricao'];?></td>
                            <td align='center'>
							<?php 
						  if ($credencial_editar == '1') {
						  ?>
							<a class="btn btn-success btn-label" href="adm_perfil_info.php?acao=alterar&id=<?php echo $rs['cod_tipo_conta'];?>"><i class="fa fa-edit"></i> Editar</a>&nbsp;
<?php 
						  }
						  if ($credencial_excluir == '1') {
						  ?>							
							<a class="btn btn-danger btn-label" href="adm_perfil.php?pergunta=<?php echo $rs['cod_tipo_conta'];?>&descricao=<?php echo $rs['descricao'];?>"><i class="fa fa-times-circle"></i> Excluir</a>
						  <?php
						  }
						  ?>							
							<a class="btn btn-info btn-label" href="adm_perfil_ver.php?id=<?php echo $rs['cod_tipo_conta'];?>"><i class="fa fa-eye"></i> Ver</a>

							<a class="btn btn-info btn-inverse" href="credencial_info.php?acao=alterar&id=<?php echo $rs['cod_tipo_conta'];?>&voltar=<?php echo $voltar; ?>">
								<i class="fa fa-ticket"></i> Credenciais</a>

							</td>
                        </tr>
    <?php
			} // Contador
		} // while
	?>
                        <tr>
                            <td align="right" colspan="7"><b>Total de registro: <?php echo $totalregistro; ?></b></td>
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

include('../include/rodape_interno2.php');

?>