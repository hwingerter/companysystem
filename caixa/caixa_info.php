<?php require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";

	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	$credencial_ver = 0;
	$credencial_incluir = 0;
	$credencial_editar = 0;
	$credencial_excluir = 0;
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "caixa_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "caixa_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "caixa_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "caixa_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}
	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar
	
$acao = '';

	$cod_empresa = $_SESSION['cod_empresa'];

	if (isset($_REQUEST['nome'])) { $nome = $_REQUEST['nome']; } else { $nome = ''; }

if (isset($_REQUEST['acao'])){
	
	if ($_REQUEST['acao'] == "incluir"){
		
		$sql = "insert into grupo_produtos (cod_empresa, descricao) values ('".limpa($cod_empresa)."', '".limpa($nome)."')";
		mysql_query($sql);
		
		echo "<script language='javascript'>window.location='grupo_produtos.php?sucesso=1';</script>";
		
	}else if ($_REQUEST['acao'] == "atualizar"){
		
		$sql = "update grupo_produtos set descricao='".limpa($nome)."' where cod_grupo_produto = ".$_REQUEST['id'];
		mysql_query($sql);
		
		echo "<script language='javascript'>window.location='grupo_produtos.php?sucesso=2';</script>";
	
	}
	
}

if (isset($_REQUEST['acao'])){
	
	if ($_REQUEST['acao'] == "alterar"){
		
		$acao = $_REQUEST['acao'];
		
		if (isset($_REQUEST['id'])) {
			$tipo = $_REQUEST["id"];
		}
		
		$sql = "Select descricao from grupo_produtos where cod_grupo_produto = " . $tipo;
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
        <div id="wrapper">
            <div id="layout-static">
                <?php include('menu.php');?>
				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="grupo_produtos.php">Caixa</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Grupo de Produtos</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Dados do Grupo de Produto</h2>
		</div>
		<div class="panel-body">
			<form action="grupo_produto_info.php" class="form-horizontal row-border" name='frm' method="post">
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
						<button class="btn-default btn" onclick="javascript:window.location='grupo_produtos.php';">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>



                            </div> <!-- .container-fluid -->
                        </div> <!-- #page-content -->
					</div>
<?php 
} // INCLUIR OU EDITAR
include('../include/rodape_interno2.php');?>