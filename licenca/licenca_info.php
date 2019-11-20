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
	
	/*for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "") {
			$credencial_excluir = 1;
			break;
		}
	}*/
	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar
	
$acao = '';


if (isset($_REQUEST['acao'])){

	if (isset($_REQUEST['nome'])) { $nome = $_REQUEST['nome']; } else { $nome = ''; }

	if (isset($_REQUEST['valor']) && ($_REQUEST['valor']!="")) { 
		$valor = ValorPhpMysql($_REQUEST['valor']);
	} 
	else { 
		$valor = 'NULL'; 
	}

	
	if ($_REQUEST['acao'] == "incluir"){
		
		$sql = "insert into licencas (descricao, valor) values ('".limpa($nome)."', ".limpa($valor).")";
		echo $sql;die;
		mysql_query($sql);
		
		echo "<script language='javascript'>window.location='licencas.php?sucesso=1';</script>";
		
	}else if ($_REQUEST['acao'] == "atualizar"){
		
		$sql = "update licencas set descricao='".limpa($nome)."', valor = ".$valor." where cod_licenca = ".$_REQUEST['id'];
		//echo $sql;die;
		mysql_query($sql);
		
		echo "<script language='javascript'>window.location='licencas.php?sucesso=2';</script>";
	
	}
	
}

if (isset($_REQUEST['acao'])){
	
	if ($_REQUEST['acao'] == "alterar"){
		
		$acao = $_REQUEST['acao'];
		
		if (isset($_REQUEST['id'])) {
			$licenca = $_REQUEST["id"];
		}
		
		$sql = "Select * from licencas where cod_licenca = " . $licenca;
		$query = mysql_query($sql);
		$registros = mysql_num_rows($query);
		if ($registros > 0) {
			if ($rs = mysql_fetch_array($query)){
				$nome = $rs['descricao'];

				if ($rs['valor'] != "") {
					$valor = ValorMysqlPhp($rs['valor']);
				} else {
					$valor = "";
				}
				

				
			}
		}
	
	}
	
}
	
?>

<script language="javascript" src="../js/mascaramoeda.js"></script>

				<div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                                
<li><a href="#">Principal</a></li>
<li class="active"><a href="licencas.php">Licenças</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Licenças</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Dados da Licença</h2>
		</div>
		<div class="panel-body">
			<form action="licenca_info.php" class="form-horizontal row-border" name='frm' method="post">
              <?php if ($acao=="alterar"){?>
              <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
              <input type="hidden" name="acao" value="atualizar">
              <?php }else{?>
              <input type="hidden" name="acao" value="incluir">
              <?php } ?>				
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Descrição</b></label>
					<div class="col-sm-4">
						<input type="text" class="form-control" <?php if ($acao == "alterar"){echo "value='". $nome ."'";}?> name="nome" maxlength="100">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Valor R$</b></label>
					<div class="col-sm-2">
						<input type="text" class="form-control" value="<?php echo $valor;?>" name="valor" maxlength="10" onKeyPress="return(moeda(this,'.',',',event));">				
					</div>
				</div>
			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Gravar</button>
						<button class="btn-default btn" onclick="javascript:window.location='licencas.php';">Voltar</button>
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

include('../include/rodape_interno2.php');
?>