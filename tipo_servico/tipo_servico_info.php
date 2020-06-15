<?php 
	require_once "../include/topo_interno2.php";

require_once "../include/funcoes.php";

require_once "../include/ler_credencial.php";

	//*********** VERIFICA CREDENCIAIS DE USU�RIOS *************
	
	
	
	
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "tiposervico_ver") {
			$credencial_ver = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "tiposervico_incluir") {
			$credencial_incluir = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "tiposervico_editar") {
			$credencial_editar = 1;
			break;
		}
	}
	
	for ($x=0; $x<$totalcredencial;$x+=1) {
		if ($credenciais[$x] == "tiposervico_excluir") {
			$credencial_excluir = 1;
			break;
		}
	}
	
if (($credencial_incluir == '1') || ($credencial_editar == '1')) { // Verifica se o usu�rio tem a credencial de incluir ou editar
	
	$acao = '';

	$cod_empresa = $_SESSION['cod_empresa'];
	$voltar	= $_REQUEST['voltar'];

	if (isset($_REQUEST["descricao"])) { $descricao = $_REQUEST["descricao"]; } else { $descricao = ""; }

	if (isset($_REQUEST['acao'])){
		
		if ($_REQUEST['acao'] == "incluir"){
			
			$sql = "insert into tipo_servico (cod_empresa, descricao) values ('".limpa($cod_empresa)."', '".limpa($descricao)."')";
			mysql_query($sql);
			

			if($voltar != "")
			{
				echo "<script language='javascript'>window.location='".$voltar."';</script>";
			}
			else
			{
				echo "<script language='javascript'>window.location='tipo_servicos.php?sucesso=1';</script>";
			}			
			
			
		}else if ($_REQUEST['acao'] == "atualizar"){
			
			$sql = "update tipo_servico set descricao='".limpa($descricao)."' where cod_tipo_servico = ".$_REQUEST['id'];
			mysql_query($sql);
			
			echo "<script language='javascript'>window.location='tipo_servicos.php?sucesso=2';</script>";
		
		}
		
	}

if (isset($_REQUEST['acao'])){
	
	if ($_REQUEST['acao'] == "alterar"){
		
		$acao = $_REQUEST['acao'];
		
		if (isset($_REQUEST['id'])) {
			$id = $_REQUEST["id"];
		}
		
		$sql = "Select descricao from tipo_servico where cod_tipo_servico = " . $id;
		$query = mysql_query($sql);
		$registros = mysql_num_rows($query);
		if ($registros > 0) {
			if ($rs = mysql_fetch_array($query)){
				$descricao = $rs["descricao"];
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
<li class="active"><a href="tipo_servicos.php">Tipo de Serviços</a></li>

                            </ol>
                            <div class="page-heading">            
                                <h1>Tipo de Serviços</h1>
                                <div class="options">
</div>
                            </div>
                            <div class="container-fluid">
                                

<div data-widget-group="group1">

	<div class="panel panel-default" data-widget='{"draggable": "false"}'>
		<div class="panel-heading">
			<h2>Dados</h2>
		</div>
		<div class="panel-body">
			<form action="tipo_servico_info.php" class="form-horizontal row-border" name='frm' method="post">
              <?php if ($acao=="alterar"){?>
              <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
              <input type="hidden" name="acao" value="atualizar">
              <?php }else{?>
              <input type="hidden" name="acao" value="incluir">
              <?php } ?>				
              <input type="hidden" name="voltar" value="<?php echo $voltar; ?>">

				<div class="form-group">
					<label class="col-sm-2 control-label"><b>Descrição</b></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" <?php if ($acao == "alterar"){echo "value='". $descricao ."'";}?> name="descricao" maxlength="100">
					</div>
				</div>
			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button class="btn-primary btn" onclick="javascript:document.forms['frm'].submit();">Gravar</button>
						<button class="btn-default btn" onclick="javascript:window.location='tipo_servicos.php';">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>



                            </div> <!-- .container-fluid -->
<?php 
} // INCLUIR OU EDITAR

include('../include/rodape_interno.php')?>