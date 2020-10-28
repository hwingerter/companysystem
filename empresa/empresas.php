<?php
require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";
	
	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************

	
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
		$sql = "delete from empresas_preferencias where cod_empresa = ". $excluir;
		mysql_query($sql);

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
	

	$empresa_suporte = $_SESSION['cod_empresa_suporte']; 
	$cod_usuario	= $_SESSION['cod_usuario'];
	$cod_grupo		= $_SESSION['cod_grupo'];
	$cod_empresa_principal	= 1;

?>

<div class="static-content-wrapper">
    <div class="static-content">
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
                        <strong>
                            Deseja realmente excluir o código número
                            <?php echo $pergunta; ?>
                            ?
                        </strong>
                        <br />
                        <br />
                        <a class="btn btn-success" href="empresas.php?excluir=<?php echo $pergunta;?>">Sim</a>&nbsp;&nbsp;&nbsp; <a class="btn btn-danger" href="empresas.php">Não</a>
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

                    <form action="empresas.php" class="form-horizontal row-border" name="frm" method="post">
                        <input type="hidden" name="acao" value="buscar" />

                        <div class="row">
                            <div class="panel panel-sky">
                                <div class="panel-heading">
                                    <h2>Filtros</h2>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"><b>Empresa</b></label>
                                        <div class="col-sm-6">
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

							<?php 

							//CARREGA LISTA

							$where = 0;	

							if ($empresa_suporte != "")
							{
								$sql = "
								select 		e.* 
								from 		empresas e 
								where 		e.cod_empresa in (select cod_filial from grupo_empresas where cod_empresa = ".$_SESSION['cod_empresa_suporte'].")
								";
							}
							else{

								$sql = "
								select		e.cod_empresa, e.empresa, e.endereco, e.bairro
								from 		empresas e
								inner join 	usuarios_empresas ge on ge.cod_empresa = e.cod_empresa
								where 		ge.cod_usuario = ".$cod_usuario."
								";
							}

							if ((isset($_REQUEST['acao'])) && ($_REQUEST['acao'] == "buscar"))
							{

								if ($_REQUEST['nome'] != "")
								{
									if($where == 0)
									{
										$sql = $sql . "and  empresa like '%".$_REQUEST['nome']."%' ";
									}
									else
									{
										$sql = $sql . "and empresa like '%".$_REQUEST['nome']."%' ";
									}
								}
							}

							$sql .= "
							group by	e.cod_empresa, e.empresa
							order by 	e.cod_empresa asc";
								
							//echo $sql;

							$query = mysql_query($sql);
							$registros = mysql_num_rows($query);

							?>
                            <div class="panel panel-sky">
                                <div class="panel-heading">
                                    <h2>Listagem das Empresas</h2>
                                    <p align="right"></p>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table" border="1" bordercolor="#EEEEEE">
                                            <thead>
                                                <tr>
                                                    <th width="50">CÓDIGO</th>
                                                    <th width="300">Empresa</th>
                                                    <th width="250">Endereço</th>
                                                    <th width="150">Bairro</th>
                                                    <th width="300">Opções</th>
                                                </tr>
                                            </thead>
                                            <tbody>

											<?php 
											if ($registros > 0) 
											{ 												
												while ($rs = mysql_fetch_array($query))
												{
												?>
                                                <tr>
                                                    <td align="left"><?php echo $rs['cod_empresa'];?></td>
                                                    <td align="left">
                                                        <?php echo $rs['empresa']; ?>
                                                    </td>
                                                    <td align="left"><?php echo $rs['endereco'];?></td>
                                                    <td align="left"><?php echo $rs['bairro'];?></td>
                                                    <td align="center">
                                                        <?php 
														if ($credencial_editar == '1') {
														?>
                                                        <a class="btn btn-success btn-label" href="empresa_info.php?acao=alterar&id=<?php echo $rs['cod_empresa'];?>"><i class="fa fa-edit"></i> Editar</a>&nbsp;
                                                        <?php 
														}
														if ($credencial_excluir == '1') {
														?>
                                                        <a class="btn btn-danger btn-label" href="empresas.php?pergunta=<?php echo $rs['cod_empresa'];?>"><i class="fa fa-times-circle"></i> Excluir</a>
                                                        <?php
														}
														?>
                                                        <a class="btn btn-info btn-label" href="empresa_ver.php?id=<?php echo $rs['cod_empresa'];?>"><i class="fa fa-eye"></i> Ver</a>

                                                        <a class="btn btn-default btn-label" href="empresa_licenca.php?cod_empresa=<?php echo $rs['cod_empresa'];?>"><i class="fa fa-edit"></i> Licença </a>
                                                    </td>
                                                </tr>
												<?php 
												}
												?>

                                                <tr>
                                                    <td align="right" colspan="7">
                                                        <b>
                                                            Total de registro:
                                                            <?php echo $registros; ?>
                                                        </b>
                                                    </td>
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
                </form>
            </div>
        </div>


<?php

}	
 include('../include/rodape_interno2.php');

?>