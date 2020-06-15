<?php 

require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";

	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	
	
	
	
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "tipo_conta_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "tipo_conta_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "tipo_conta_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "tipo_conta_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}
	
$voltar = $_REQUEST['voltar'];

if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar
	
	$acao = '';

	if (isset($_REQUEST['nome'])) { $nome = $_REQUEST['nome']; } else { $nome = ''; }

	$cod_empresa = $_SESSION["cod_empresa"];

	if (isset($_REQUEST['acao'])){
		
		if ($_REQUEST['acao'] == "incluir"){
			
			$sql = "insert into tipo_conta (cod_empresa, descricao) values (".$cod_empresa.", '".limpa($nome)."')";
			//echo $sql;die;
			mysql_query($sql);
			
			if ($voltar != "") {
				echo "<script language='javascript'>window.location='".$voltar."';</script>";
			} else {
				echo "<script language='javascript'>window.location='tipo_contas.php?sucesso=1';</script>";
			}
			
		}else if ($_REQUEST['acao'] == "atualizar"){
			
			$sql = "update tipo_conta set descricao='".limpa($nome)."' where cod_tipo_conta = ".$_REQUEST['id'];
			//echo $sql;die;
			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='tipo_contas.php?sucesso=2';</script>";
		
		}
		
	}

	if (isset($_REQUEST['acao'])){
		
		if ($_REQUEST['acao'] == "alterar"){
			
			$acao = $_REQUEST['acao'];
			
			if (isset($_REQUEST['id'])) {
				$tipo = $_REQUEST["id"];
			}
			
			$sql = "Select * from tipo_conta where cod_tipo_conta = " . $tipo;
			$query = mysql_query($sql);
			$registros = mysql_num_rows($query);
			if ($registros > 0) {
				if ($rs = mysql_fetch_array($query)){
					$nome = $rs['descricao'];
				}
			}
		
		}
		
	}

	
	
?>
				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="tipo_contas.php">Tipos de Contas</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Tipos de Conta</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Dados do Tipos de Conta</h2>
		</div>
		<div class="panel-body">
			<form action="tipo_conta_info.php" class="form-horizontal row-border" name='frm' method="post">
				<input type="hidden" name="voltar" value="<?php echo $voltar;?>">
              <?php if ($acao=="alterar"){?>
              <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
              <input type="hidden" name="acao" value="atualizar">
              <?php }else{?>
              <input type="hidden" name="acao" value="incluir">
              <?php } ?>				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Descrição</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" <?php if ($acao == "alterar"){echo "value='". $nome ."'";}?> name="nome" maxlength="100">
					</div>
				</div>
			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Gravar</button>

					<?php if ($voltar != "") { ?>

						<button class="btn-default btn" onclick="javascript:window.location='<?php echo $voltar?>';">Voltar</button>

					<?php }else{?>

						<button class="btn-default btn" onclick="javascript:window.location='tipo_contas.php';">Voltar</button>

					<?php }?>

					</div>
				</div>
			</div>
		</div>
	</div>



                            </div> <!-- .container-fluid -->
                        </div> <!-- #page-content -->
					</div>
<?php 
}
include('../include/rodape_interno2.php');
?>