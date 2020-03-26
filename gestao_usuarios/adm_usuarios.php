<?php 
	
	require_once "../include/topo_interno2.php";

	require_once "../include/funcoes.php";
	
	require_once "../include/ler_credencial.php";
			
	$credencial_ver = 1;
	$credencial_incluir = 1;
	$credencial_editar = 1;
	$credencial_excluir = 1;

	$cod_empresa = 1;

	//*********** VERIFICA CREDENCIAIS DE USUÃRIOS *************
	if ($_SESSION['usuario_conta'] == '1') {
		
		$credencial_ver = 1;
		$credencial_incluir = 1;
		$credencial_editar = 1;
		$credencial_excluir = 1;
		
	}
	
	
if ($credencial_ver == '1') { //VERIFICA SE USUÁRIO POSSUI ACESSO A ESSA ÁREA
	
	if (isset($_REQUEST['sucesso'])) { $sucesso = $_REQUEST['sucesso']; } else { $sucesso = ''; }
	if (isset($_REQUEST['pergunta'])) { $pergunta = $_REQUEST['pergunta']; } else { $pergunta = ''; }
	if (isset($_REQUEST['excluir'])) { $excluir = $_REQUEST['excluir']; } else { $excluir = ''; }
	
	if ($excluir != '') {

		$sql = "select case when count(*) > 0 then 'sim' else 'nao' end as TemEmpresa from usuarios_grupos_empresas where cod_usuario = ".$excluir."";

		$query = mysql_query($sql);
		$rs = mysql_fetch_array($query);

		if ($rs['TemEmpresa'] == "nao") {

			$sql = "delete from usuarios_grupos_empresas where cod_usuario = ". $excluir;
			mysql_query($sql);	

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

	
?>

<div class="page-content">

	<ol class="breadcrumb">                  
		<li><a href="#">Principal</a></li>
		<li class="active"><a href="adm_usuario.php">Usuários</a></li>
	</ol>

	<div class="page-heading">   

		<h1>Usuários</h1>

		<div class="options">
		
		<?php if ($credencial_incluir == '1') { ?>
				<a class="btn btn-midnightblue btn-label" href="adm_usuario_info.php"><i class="fa fa-plus-circle"></i> Novo</a>
		<?php } ?>	

		</div>

	</div>


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


		<form action="adm_usuarios.php" class="form-horizontal row-border" name='frm' method="post">
		
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
								<label class="col-sm-2 control-label"><b>Nome do Usuário:</b></label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="nome" maxlength="100" value="<?php if (isset($_REQUEST['nome'])){ if ($_REQUEST['nome'] != ""){ echo $_REQUEST['nome']; } }?>">
								</div>
							</div>								
						</div>	
						<div class="row">
							<div class="form-group">
								<label class="col-sm-2 control-label"><b>E-mail:</b></label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="email" maxlength="100" value="<?php if (isset($_REQUEST['email'])){ if ($_REQUEST['email'] != ""){ echo $_REQUEST['email']; } }?>">
								</div>
								
							</div>								
						</div>				
						<div class="row">
							<div class="form-group">
								<div class="col-md-4 col-md-offset-2">
									<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Buscar</button>
								</div>
							</div>
						</div>
					</div>

				</div>
				
			</div>

		</form>
		
	</div>


			<?php 
				//CARREGA LISTA
			$sql = "
			select		u.cod_usuario, u.nome, u.email, tc.descricao as TipoConta
						,case 
							when u.status = 'A' then 'Ativo' 
							else 'Inativo' 
						end as Status
			from 		usuarios u
			left join 	usuarios_empresas ge on ge.cod_usuario = u.cod_usuario
			left join 	tipo_conta tc on tc.cod_tipo_conta = u.tipo_conta
			where 		ge.cod_empresa = ".$cod_empresa."
			";
			
			if (isset($_REQUEST['acao']))
			{

				if ($_REQUEST['acao'] == "buscar")
				{

					if ($_REQUEST['nome'] != ""){
						$sql = $sql . " and u.nome like '%".$_REQUEST['nome']."%' ";
					}
					if ($_REQUEST['email'] != ""){
						$sql = $sql . " and u.email = '".$_REQUEST['email']."' ";					
					}

			//echo $sql;

				}

			}

			$sql .= " order by 	u.nome asc, tc.descricao";
			$query = mysql_query($sql);
			$registros = mysql_num_rows($query);

			?>

				<div class="panel panel-sky">

					<div class="panel-heading">
						<h2>Listagem de Usuários</h2>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
						    <table class="table" border="1" bordercolor="#EEEEEE" style="width:100%;">
						        <thead>
						            <tr>
										<th width="200">Nome</th>
										<th width="100">E-mail</th>
										<th width="100">Tipo de Conta</th>
										<th width="10">Status</th>
										<th width="10">Opções</th>
						            </tr>
						        </thead>
						        <tbody>
						        <?php 
									if ($registros > 0) 
									{
										while (($rs = mysql_fetch_array($query))){ 
											
									    	?>
						                        <tr>
													<td align="left"><?php echo $rs['nome'];?></td>
													<td align="left"><?php echo $rs['email'];?></td>
													<td align="left"><?php echo $rs['TipoConta'];?></td>
													<td align="left">
													<?php echo $rs['Status'];?>
													</td>
						                            <td align='left'>
												  	  <?php 
													  if ($credencial_editar == '1') {
													  ?>							
														<a class="btn btn-success btn-label" href="adm_usuario_info.php?acao=alterar&id=<?php echo $rs['cod_usuario'];?>"><i class="fa fa-edit"></i> Editar &nbsp;</a>
												  	  <?php 
													  }
													  if (($credencial_excluir == '1') && ($rs['cod_usuario']) != 1 && ($rs['cod_usuario']) != 2) {
													  ?>
														<a class="btn btn-danger btn-label" href="adm_usuarios.php?pergunta=<?php echo $rs['cod_usuario'];?>"><i class="fa fa-times-circle"></i> Excluir</a>
													  <?php
													  }
													  ?>	
														<a class="btn btn-info btn-label" href="adm_usuario_ver.php?id=<?php echo $rs['cod_usuario'];?>"><i class="fa fa-eye"></i> Ver &nbsp; &nbsp; &nbsp;</a>


														<!--a class="btn btn-inverse btn-label" href="adm_usuario_grupos.php?cod_usuario=<?php echo $rs['cod_usuario'];?>&cod_grupo=<?php echo $rs['cod_grupo'];?>&nome_usuario=<?php echo $rs['nome'];?>"><i class="fa fa-building"></i> Empresas &nbsp; &nbsp; &nbsp;</a-->

													</td>
						                        </tr>
								    		<?php
										} // while
									?>
			                        <tr>
			                            <td align="right" colspan="7"><b>Total de registro: <?php echo $registros; ?></b></td>
			                        </tr>

								<?php
									} 
									else 
									{ // registro
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

				//}

			//}

?>

	
<?php
 } // VER 
	
 include('../include/rodape_interno2.php');
?>