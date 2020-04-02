<?php 
	require_once "../include/topo_interno2.php";

	require_once "../include/funcoes.php";
	
	require_once "../include/ler_credencial.php";

	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "credencial_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "tipo_conta_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
if ($credencial_ver == '1') { //VERIFICA SE USU�RIO POSSUI ACESSO A ESSA �REA
	
	if (isset($_REQUEST['sucesso'])) { $sucesso = $_REQUEST['sucesso']; } else { $sucesso = ''; }
	if (isset($_REQUEST['pergunta'])) { $pergunta = $_REQUEST['pergunta']; } else { $pergunta = ''; }
	if (isset($_REQUEST['excluir'])) { $excluir = $_REQUEST['excluir']; } else { $excluir = ''; }
	
	if ($excluir != '') {
		$sql = "delete from tipo_conta where cod_usuario = ". $excluir;
		if (($excluir != 1) && ($excluir != 2) && ($excluir != 3)) { mysql_query($sql); }
		
		$excluir = '1';
	}
	

   $cod_empresa = $_SESSION["cod_empresa"];

   $voltar = "credenciais.php";
	
?>
                <div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="credenciais.php">Credenciais</a></li>

                            </ol>
							
                            <div class="page-heading">            
                                <h1>Credenciais</h1>
                                <div class="options">
								
								</div>
                            </div>
                            <div class="container-fluid">
<script language="JavaScript">
	function paginacao () {
  		document.forms[0].action = "credenciais.php";
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
				
				?>
<form action="credenciais.php" class="form-horizontal row-border" name='frm' method="post">
	<input type='hidden' name='acao' value='buscar'>
<div class="row">
    <div class="col-sm-12">

	<div class="panel panel-sky">
		<div class="panel-heading">
			<h2>Filtros</h2>
		</div>
		<div class="panel-body">
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Nome</b></label>
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

        <div class="panel panel-sky">
            <div class="panel-heading">
                <h2>Listagem de Credenciais</h2>
          </div>
          <div class="panel-body">
            <div class="table-responsive">
                <table class="table" border="1" bordercolor="#EEEEEE">
                    <thead>
                        <tr>
                            <th width="50">CÓDIGO</th>
							<th width="700">Tipo de Conta</th>
							<th width="250">Opções</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php

	$sql = "
	select 		tc.cod_tipo_conta, tc.descricao
	from 		tipo_conta tc
	where		tc.cod_empresa = ".$cod_empresa."
	";

	if (isset($_REQUEST['acao'])){
		if ($_REQUEST['acao'] == "buscar"){

			if ($_REQUEST['nome'] != ""){

				$sql = $sql . " and descricao like '%".$_REQUEST['nome']."%' ";

			}


		}
	}

	$sql .= "
	group by	tc.cod_tipo_conta, tc.descricao
	order by 	tc.descricao asc
	";

	//echo $sql;die;

	$query = mysql_query($sql);
	$registros = mysql_num_rows($query);
	if ($registros > 0) {
		while (($rs = mysql_fetch_array($query))){ 
		?>
			<tr>
				<td align="left"><?php echo $rs['cod_tipo_conta'];?></td>
				<td align="left"><?php echo $rs['descricao'];?></td>
				<td align='center'>
				<?php if ($credencial_editar == '1') {?>
				<a class="btn btn-success btn-label" href="credencial_info.php?acao=alterar&id=<?php echo $rs['cod_tipo_conta'];?>&voltar=<?php echo $voltar; ?>"><i class="fa fa-edit"></i> Editar</a>&nbsp;
				<?php } ?>
				<a class="btn btn-info btn-label" href="credencial_ver.php?id=<?php echo $rs['cod_tipo_conta'];?>"><i class="fa fa-eye"></i> Ver</a>
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
                        </div> <!-- #page-content -->
<?php 
} // VER
	
include('../include/rodape_interno2.php');
?>