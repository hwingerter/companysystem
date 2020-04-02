<?php 

require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";
	
	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	
if ($credencial_ver == '1') { //VERIFICA SE USU�RIO POSSUI ACESSO A ESSA �REA
	
	if (isset($_REQUEST['sucesso'])) { $sucesso = $_REQUEST['sucesso']; } else { $sucesso = ''; }
	if (isset($_REQUEST['pergunta'])) { $pergunta = $_REQUEST['pergunta']; } else { $pergunta = ''; }
	if (isset($_REQUEST['excluir'])) { $excluir = $_REQUEST['excluir']; } else { $excluir = ''; }
	
	if ($excluir != '') {
		$sql = "delete from tipo_conta where cod_tipo_conta = ". $excluir;
		if ($excluir != 1) { mysql_query($sql); }
		
		$excluir = '1';
	}
	
	
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
					<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Buscar</button>
				</div>								
			</div>

		</div>
	</div>

			        <div class="panel panel-sky">
			            <div class="panel-heading">
			                <h2>Listagem de Tipos de Contas</h2>
			          </div>
			          <div class="panel-body">
			            <div class="table-responsive">
			                <table class="table" border="1" bordercolor="#EEEEEE" style="width: 100%;">
			                    <thead>
			                        <tr>
										<th style="width:50%;">Tipo de Conta</th>
										<th style="width:50%;">Opções</th>
			                        </tr>
			                    </thead>
			                    <tbody>
								<?php
								//CARREGA LISTA
								$sql = "
									select 		t.*
									from 		tipo_conta t
									where 		t.cod_empresa = 1
								";

								if (isset($_REQUEST['acao'])){

									if ($_REQUEST['acao'] == "buscar"){

										if ($_REQUEST['nome'] != ""){
											$sql = $sql . " and t.descricao like '%".$_REQUEST['nome']."%' ";
										}
									}

								}
								$sql .= "order by t.descricao asc";

								$query = mysql_query($sql);
								$registros = mysql_num_rows($query);
								if ($registros > 0) {
								while ($rs = mysql_fetch_array($query))
								{ 
								
								?>
                        <tr>
                        	<td align="left"><?php echo $rs['descricao'];?></td>
                            <td align='left'>
							<?php 
						  if ($credencial_editar == '1') {
						  ?>
							<a class="btn btn-success btn-label" href="adm_perfil_info.php?acao=alterar&id=<?php echo $rs['cod_tipo_conta'];?>"><i class="fa fa-edit"></i> Editar</a>&nbsp;
<?php 
						  }
						  if (($credencial_excluir == '1') && ($rs['cod_tipo_conta']) != 1 && ($rs['cod_tipo_conta']) != 2)
						  {
						  ?>							
							<a class="btn btn-danger btn-label" href="adm_perfil.php?pergunta=<?php echo $rs['cod_tipo_conta'];?>&descricao=<?php echo $rs['descricao'];?>"><i class="fa fa-times-circle"></i> Excluir</a>
						  <?php
						  }
						  ?>							
							<a class="btn btn-info btn-label" href="adm_perfil_ver.php?id=<?php echo $rs['cod_tipo_conta'];?>"><i class="fa fa-eye"></i> Ver</a>

							&nbsp;<a class="btn btn-default btn" href="permissoes.php?acao=alterar&id=<?php echo $rs['cod_tipo_conta'];?>"><i class="fa fa-ticket"></i> Áreas de Acesso</a>						  							

							<!--a class="btn btn-info btn-inverse" href="credencial_info.php?acao=alterar&id=<?php echo $rs['cod_tipo_conta'];?>&cod_empresa=<?php echo $rs['cod_empresa'];?>&voltar=<?php echo $voltar; ?>">
								<i class="fa fa-ticket"></i> Credenciais</a-->

							</td>
                        </tr>
						<?php

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

include('../include/rodape_interno2.php');

?>